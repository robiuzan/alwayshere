import { defineConfig } from 'vite';
import { resolve } from 'path';

/**
 * Vite build config for alwayshere-child WordPress theme.
 *
 * Inputs  → assets/scss/*.scss + assets/js/*.js
 * Outputs → assets/css/*.css   + assets/js/*.js  (no hashing — WP handles cache busting)
 *
 * Dev:  npm run dev   (watch mode, rebuilds on save)
 * Prod: npm run build
 */
export default defineConfig( {
	build: {
		// Output directly into the theme assets folder — no separate dist/.
		outDir:    '.',
		emptyOutDir: false,

		rollupOptions: {
			input: {
				// CSS entry points (SCSS compiled per page context)
				'assets/css/style':          resolve( __dirname, 'assets/scss/style.scss' ),
				'assets/css/category':       resolve( __dirname, 'assets/scss/category.scss' ),

				// JS entry points (one per page context, loaded conditionally in functions.php)
				'assets/js/header':          resolve( __dirname, 'assets/js/header.js' ),
				'assets/js/home':            resolve( __dirname, 'assets/js/home.js' ),
				'assets/js/single-product':  resolve( __dirname, 'assets/js/single-product.js' ),
				'assets/js/category':        resolve( __dirname, 'assets/js/category.js' ),
			},

			output: {
				// Keep file names predictable (no content hash) — WP version string handles cache busting.
				entryFileNames: '[name].js',
				chunkFileNames: '[name].js',
				assetFileNames: ( assetInfo ) => {
					// CSS files: assets/css/<name>.css
					if ( assetInfo.name?.endsWith( '.css' ) ) {
						return '[name][extname]';
					}
					// Images / fonts (if any imported via SCSS)
					return 'assets/images/[name][extname]';
				},
			},
		},

		// Keep readable output in dev; minify only for production.
		minify: process.env.NODE_ENV === 'production' ? 'esbuild' : false,

		// Generate sourcemaps in dev for easy debugging.
		sourcemap: process.env.NODE_ENV !== 'production',

		// Silence the 500kB chunk warning for SCSS output.
		chunkSizeWarningLimit: 600,
	},

	css: {
		preprocessorOptions: {
			scss: {
				// Make SCSS variables available in all files without manual import.
				// This prepends the import to every .scss file automatically.
				additionalData: `@import "assets/scss/base/variables";`,
			},
		},
	},
} );
