<?php
/**
 * Custom Walker for the desktop nav bar.
 *
 * Outputs the ah-nav-item / ah-nav-link / ah-mega-menu structure:
 *  - Top-level items without children → plain <a class="ah-nav-link">
 *  - Top-level items with children → <a> + mega-menu dropdown with child links
 *    + auto-populated "recommended products" column from WooCommerce
 *
 * Supports CSS classes added in wp-admin:
 *  - "sale"       → ah-nav-link--sale modifier (fire-colored link)
 *  - "no-products"→ hides the recommended-products column for that dropdown
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

class Alwayshere_Desktop_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Current top-level item being processed.
	 *
	 * @var WP_Post|null
	 */
	private ?object $current_parent = null;

	/**
	 * Buffer for child <li> items.
	 *
	 * @var string
	 */
	private string $children_buffer = '';

	/**
	 * Whether we are inside a sub-level.
	 *
	 * @var bool
	 */
	private bool $in_submenu = false;

	/**
	 * Whether the current parent has the "no-products" class.
	 *
	 * @var bool
	 */
	private bool $hide_products = false;

	/**
	 * Cached recommended-products HTML (shared across all mega-menus on the page).
	 *
	 * @var string|null
	 */
	private static ?string $products_cache = null;

	/**
	 * Start a sub-level.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		if ( 0 !== $depth ) {
			return;
		}

		$this->in_submenu      = true;
		$this->children_buffer = '';
	}

	/**
	 * End a sub-level — assemble the mega-menu.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		if ( 0 !== $depth || ! $this->in_submenu ) {
			return;
		}

		// Determine column heading from the parent title.
		$heading = $this->current_parent
			? esc_html( apply_filters( 'the_title', $this->current_parent->title, $this->current_parent->ID ) )
			: '';

		$output .= '<div class="ah-mega-menu">' . "\n";

		// ── Left column: category links ────────────────────────────────
		$output .= '<div class="ah-mega-col ah-mega-col--cats">' . "\n";
		if ( $heading ) {
			$output .= '<h5>' . $heading . '</h5>' . "\n";
		}
		$output .= '<ul>' . "\n";
		$output .= $this->children_buffer;
		$output .= '</ul>' . "\n";
		$output .= '</div>' . "\n";

		// ── Right column: recommended products (auto-populated) ────────
		if ( ! $this->hide_products ) {
			$products_html = self::get_recommended_products_html();
			if ( $products_html ) {
				$output .= '<div class="ah-mega-divider"></div>' . "\n";
				$output .= '<div class="ah-mega-col ah-mega-col--prods">' . "\n";
				$output .= '<h5>' . esc_html__( 'מוצרים מומלצים', 'alwayshere-child' ) . '</h5>' . "\n";
				$output .= '<div class="ah-mega-products">' . "\n";
				$output .= $products_html;
				$output .= '</div>' . "\n";
				$output .= '</div>' . "\n";
			}
		}

		$output .= '</div>' . "\n";

		// Close the .ah-nav-item wrapper opened in start_el.
		$output .= '</div>' . "\n";

		$this->in_submenu      = false;
		$this->children_buffer = '';
		$this->current_parent  = null;
		$this->hide_products   = false;
	}

	/**
	 * Render a single menu item.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$classes       = array_map( 'trim', (array) $item->classes );
		$has_children  = in_array( 'menu-item-has-children', $classes, true );
		$is_sale       = in_array( 'sale', $classes, true );
		$title         = apply_filters( 'the_title', $item->title, $item->ID );
		$url           = $item->url;

		if ( 0 === $depth ) {
			$output .= '<div class="ah-nav-item">' . "\n";

			$link_class = 'ah-nav-link';
			if ( $is_sale ) {
				$link_class .= ' ah-nav-link--sale';
			}

			$output .= sprintf(
				'<a class="%s" href="%s">%s',
				esc_attr( $link_class ),
				esc_url( $url ),
				esc_html( $title )
			);

			if ( $has_children ) {
				$output .= '<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>';
				$this->current_parent = $item;
				$this->hide_products  = in_array( 'no-products', $classes, true );
			}

			$output .= '</a>' . "\n";

			if ( ! $has_children ) {
				$output .= '</div>' . "\n";
			}

		} elseif ( 1 === $depth && $this->in_submenu ) {
			$this->children_buffer .= sprintf(
				'<li><a href="%s">%s</a></li>' . "\n",
				esc_url( $url ),
				esc_html( $title )
			);
		}
	}

	/**
	 * End a single menu item.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		// No-op.
	}

	/**
	 * Build the recommended-products HTML from WooCommerce.
	 *
	 * Pulls 3 featured products (falls back to newest on-sale, then newest).
	 * Result is cached for the page request so DB is hit only once.
	 *
	 * @return string HTML for the product cards, or empty string if WC unavailable.
	 */
	private static function get_recommended_products_html(): string {
		if ( null !== self::$products_cache ) {
			return self::$products_cache;
		}

		if ( ! function_exists( 'wc_get_products' ) ) {
			self::$products_cache = '';
			return '';
		}

		// Try featured products first.
		$products = wc_get_products( [
			'status'   => 'publish',
			'limit'    => 3,
			'featured' => true,
			'orderby'  => 'rand',
		] );

		// Fallback: on-sale products.
		if ( empty( $products ) ) {
			$products = wc_get_products( [
				'status'   => 'publish',
				'limit'    => 3,
				'on_sale'  => true,
				'orderby'  => 'date',
				'order'    => 'DESC',
			] );
		}

		// Fallback: newest products.
		if ( empty( $products ) ) {
			$products = wc_get_products( [
				'status'  => 'publish',
				'limit'   => 3,
				'orderby' => 'date',
				'order'   => 'DESC',
			] );
		}

		if ( empty( $products ) ) {
			self::$products_cache = '';
			return '';
		}

		ob_start();
		foreach ( $products as $product ) {
			$thumb_id  = $product->get_image_id();
			$thumb_url = $thumb_id
				? wp_get_attachment_image_url( $thumb_id, 'medium' )
				: wc_placeholder_img_src( 'medium' );
			$name      = $product->get_name();
			$permalink = $product->get_permalink();
			$desc      = $product->get_short_description();
			// Strip tags and truncate for the mega-menu card.
			$desc      = wp_trim_words( wp_strip_all_tags( $desc ), 8, '…' );

			// Determine tag label.
			$tag = '';
			if ( $product->is_on_sale() ) {
				$tag = __( 'מבצע', 'alwayshere-child' );
			} elseif ( $product->is_featured() ) {
				$tag = __( 'רב מכר', 'alwayshere-child' );
			}

			// Price breakdown.
			$is_on_sale    = $product->is_on_sale();
			$sale_price    = '';
			$regular_price = '';

			if ( $is_on_sale ) {
				$regular_price = wc_price( (float) $product->get_regular_price() );
				$sale_price    = wc_price( (float) $product->get_price() );
			} else {
				$sale_price = wc_price( (float) $product->get_price() );
			}
			?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="ah-mega-prod">
				<div class="ah-mega-prod__img">
					<?php if ( $tag ) : ?>
						<span class="ah-mega-prod__tag"><?php echo esc_html( $tag ); ?></span>
					<?php endif; ?>
					<img src="<?php echo esc_url( $thumb_url ); ?>"
						 alt="<?php echo esc_attr( $name ); ?>"
						 loading="lazy" />
				</div>
				<div class="ah-mega-prod__body">
					<span class="ah-mega-prod__name"><?php echo esc_html( $name ); ?></span>
					<?php if ( $desc ) : ?>
						<span class="ah-mega-prod__desc"><?php echo esc_html( $desc ); ?></span>
					<?php endif; ?>
					<span class="ah-mega-prod__price">
						<?php if ( $is_on_sale && $regular_price ) : ?>
							<del><?php echo wp_kses_post( $regular_price ); ?></del>
						<?php endif; ?>
						<?php echo wp_kses_post( $sale_price ); ?>
					</span>
				</div>
			</a>
			<?php
		}
		self::$products_cache = ob_get_clean();

		return self::$products_cache;
	}
}
