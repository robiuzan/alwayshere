<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Force Hebrew RTL on all pages.
add_filter( 'locale', fn() => 'he_IL' );

// Disable user registration — guests checkout only.
add_filter( 'woocommerce_checkout_registration_enabled',  '__return_false' );
add_filter( 'woocommerce_checkout_registration_required', '__return_false' );
add_filter( 'option_users_can_register',                  '__return_zero'  );

// Force full-width layout (no sidebar) on all pages.
add_filter( 'generate_sidebar_layout', fn() => 'no-sidebar' );
add_filter( 'generate_get_layout',     fn() => 'no-sidebar' );

// Remove default WC coupon form above checkout — we include it inside our template.
add_action( 'wp', function(): void {
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
} );

// ── Hide specific nav menu items by title ────────────────────────────────────

add_filter( 'wp_nav_menu_objects', function( array $items ): array {
	$hidden = [ 'AI Studio', 'צרו קשר', 'אודות' ];
	return array_filter( $items, fn( $item ) => ! in_array( $item->title, $hidden, true ) );
} );

// ── Header hooks ─────────────────────────────────────────────────────────────

add_action( 'generate_before_header', 'alwayshere_render_topbar', 5 );
function alwayshere_render_topbar(): void {
	get_template_part( 'template-parts/header/topbar' );
}

add_action( 'generate_before_header', 'alwayshere_render_main_header', 10 );
function alwayshere_render_main_header(): void {
	get_template_part( 'template-parts/header/main-header' );
}

add_action( 'generate_before_header', 'alwayshere_render_nav_bar', 15 );
function alwayshere_render_nav_bar(): void {
	get_template_part( 'template-parts/header/nav-bar' );
}

add_action( 'generate_before_header', 'alwayshere_render_mobile_menu', 20 );
function alwayshere_render_mobile_menu(): void {
	get_template_part( 'template-parts/header/mobile-menu' );
}

// ── Enqueue scripts & styles ──────────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'alwayshere_enqueue_styles' );
function alwayshere_enqueue_styles(): void {
	wp_enqueue_style(
		'alwayshere-fonts',
		'https://fonts.googleapis.com/css2?family=Varela+Round&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'parent-style',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme( get_template() )->get( 'Version' )
	);

	wp_enqueue_style(
		'alwayshere-child-style',
		get_stylesheet_directory_uri() . '/assets/css/style.css',
		[ 'parent-style' ],
		wp_get_theme()->get( 'Version' )
	);

	// Global — loaded on every page.
	wp_enqueue_script(
		'alwayshere-header',
		get_stylesheet_directory_uri() . '/assets/js/header.js',
		[],
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Newsletter bar appears in footer on every non-homepage page — needs AJAX data.
	if ( ! is_front_page() ) {
		wp_localize_script( 'alwayshere-header', 'alwayshere', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'alwayshere_newsletter' ),
		] );
	}

	if ( is_front_page() ) {
		wp_enqueue_script(
			'alwayshere-home',
			get_stylesheet_directory_uri() . '/assets/js/home.js',
			[],
			wp_get_theme()->get( 'Version' ),
			true
		);

		wp_localize_script( 'alwayshere-home', 'alwayshere', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'alwayshere_newsletter' ),
		] );
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_script(
			'alwayshere-single-product',
			get_stylesheet_directory_uri() . '/assets/js/single-product.js',
			[ 'jquery' ],
			wp_get_theme()->get( 'Version' ),
			true
		);

		wp_localize_script( 'alwayshere-single-product', 'alwayshere', [
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'nonce'       => wp_create_nonce( 'alwayshere_product' ),
			'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '/checkout/',
		] );
	}

	if ( function_exists( 'is_cart' ) && is_cart() ) {
		wp_enqueue_script(
			'alwayshere-cart',
			get_stylesheet_directory_uri() . '/assets/js/cart.js',
			[],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		wp_enqueue_script(
			'alwayshere-checkout',
			get_stylesheet_directory_uri() . '/assets/js/checkout.js',
			[],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	if ( is_product_category() ) {
		wp_enqueue_style(
			'alwayshere-category',
			get_stylesheet_directory_uri() . '/assets/css/category.css',
			[ 'alwayshere-child-style' ],
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_script(
			'alwayshere-category',
			get_stylesheet_directory_uri() . '/assets/js/category.js',
			[],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
}

// ── Single product page hooks ─────────────────────────────────────────────────

add_action( 'wp', 'alwayshere_single_product_hooks' );
function alwayshere_single_product_hooks(): void {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}

	// Remove WC default meta + sharing — we render categories our way.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

	// Remove default after-summary sections — we render custom versions.
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	// Add category tags above the title.
	add_action( 'woocommerce_single_product_summary', 'alwayshere_render_product_cats', 4 );

	// Add discount percentage badge below the price.
	add_action( 'woocommerce_single_product_summary', 'alwayshere_render_discount_badge', 11 );

	// Buy Now button removed.
}

function alwayshere_render_product_cats(): void {
	$terms = get_the_terms( get_the_ID(), 'product_cat' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}

	echo '<div class="ah-sp-cats">';
	$last = end( $terms );
	foreach ( $terms as $term ) {
		echo '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
		if ( $term !== $last ) {
			echo '<span aria-hidden="true"> | </span>';
		}
	}
	echo '</div>';
}

function alwayshere_render_discount_badge(): void {
	global $product;
	if ( ! $product instanceof WC_Product || ! $product->is_on_sale() ) {
		return;
	}

	$regular = (float) $product->get_regular_price();
	$sale    = (float) $product->get_price();
	if ( $regular <= 0 ) {
		return;
	}

	$pct = round( ( ( $regular - $sale ) / $regular ) * 100 );
	if ( $pct <= 0 ) {
		return;
	}

	echo '<div class="ah-discount-badge-wrap">';
	echo '<span class="ah-discount-badge">';
	echo esc_html( $pct ) . '% ';
	esc_html_e( 'הנחה', 'alwayshere-child' );
	echo '</span>';
	echo '</div>';
}

function alwayshere_render_buy_now_button(): void {
	$checkout_url = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '/checkout/';

	echo '<button type="button" class="ah-btn-buy-now" data-checkout-url="' . esc_url( $checkout_url ) . '">';
	esc_html_e( 'קנה עכשיו – תשלום מהיר', 'alwayshere-child' );
	echo '</button>';
}
