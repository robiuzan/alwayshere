<?php
/**
 * Recently Viewed products — cookie tracking + user meta sync.
 *
 * Tracks product views in a cookie (works for guests and logged-in users).
 * On login, syncs cookie data into user meta for persistence.
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Recently_Viewed {

	private const COOKIE_NAME = 'alwayshere_recently_viewed';
	private const META_KEY    = 'alwayshere_recently_viewed';
	private const MAX_ITEMS   = 20;
	private const COOKIE_DAYS = 30;

	/**
	 * Boot all hooks.
	 */
	public static function init(): void {
		// Record product view on single product pages.
		add_action( 'template_redirect', [ __CLASS__, 'record_view' ] );

		// Sync cookie → user meta on login.
		add_action( 'wp_login', [ __CLASS__, 'sync_on_login' ], 10, 2 );

		// Render data layer event on single product pages.
		add_action( 'wp_footer', [ __CLASS__, 'render_data_layer' ] );
	}

	// ── Read ────────────────────────────────────────────────────────────────────

	/**
	 * Get recently viewed product IDs.
	 *
	 * @param int $limit Number of items to return.
	 * @return int[]
	 */
	public static function get( int $limit = 20 ): array {
		$ids = [];

		// Prefer user meta for logged-in users (more persistent).
		if ( is_user_logged_in() ) {
			$ids = get_user_meta( get_current_user_id(), self::META_KEY, true );
		}

		// Fall back to cookie.
		if ( empty( $ids ) ) {
			$ids = self::get_from_cookie();
		}

		$ids = is_array( $ids ) ? array_map( 'absint', $ids ) : [];
		$ids = array_filter( $ids );

		return array_slice( $ids, 0, $limit );
	}

	// ── Write ───────────────────────────────────────────────────────────────────

	/**
	 * Record a product view on single product pages.
	 */
	public static function record_view(): void {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}

		$product_id = get_the_ID();
		if ( ! $product_id ) {
			return;
		}

		$ids = self::get_from_cookie();

		// Remove if already exists (will be re-added at front).
		$ids = array_diff( $ids, [ $product_id ] );

		// Add to front.
		array_unshift( $ids, $product_id );

		// Trim to max.
		$ids = array_slice( $ids, 0, self::MAX_ITEMS );

		self::set_cookie( $ids );

		// Also update user meta if logged in.
		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), self::META_KEY, $ids );
		}
	}

	/**
	 * Sync cookie data into user meta on login.
	 *
	 * @param string   $user_login Username.
	 * @param \WP_User $user       User object.
	 */
	public static function sync_on_login( string $user_login, $user ): void {
		$cookie_ids = self::get_from_cookie();
		if ( empty( $cookie_ids ) ) {
			return;
		}

		$meta_ids = get_user_meta( $user->ID, self::META_KEY, true );
		$meta_ids = is_array( $meta_ids ) ? array_map( 'absint', $meta_ids ) : [];

		// Merge: cookie items first (most recent), then existing meta items.
		$merged = array_unique( array_merge( $cookie_ids, $meta_ids ) );
		$merged = array_slice( $merged, 0, self::MAX_ITEMS );

		update_user_meta( $user->ID, self::META_KEY, $merged );
	}

	// ── Data Layer ──────────────────────────────────────────────────────────────

	/**
	 * Output data layer push on single product pages.
	 */
	public static function render_data_layer(): void {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}

		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return;
		}

		$categories = [];
		$terms      = get_the_terms( $product->get_id(), 'product_cat' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$categories = wp_list_pluck( $terms, 'name' );
		}

		$data = [
			'product_id'       => $product->get_id(),
			'product_name'     => $product->get_name(),
			'product_price'    => $product->get_price(),
			'product_category' => implode( ', ', $categories ),
		];
		?>
		<script>
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({
			event: 'alwayshere_product_view',
			product_id: <?php echo wp_json_encode( $data['product_id'] ); ?>,
			product_name: <?php echo wp_json_encode( $data['product_name'] ); ?>,
			product_price: <?php echo wp_json_encode( $data['product_price'] ); ?>,
			product_category: <?php echo wp_json_encode( $data['product_category'] ); ?>
		});
		</script>
		<?php
	}

	// ── Cookie Helpers ──────────────────────────────────────────────────────────

	/**
	 * Read product IDs from the cookie.
	 *
	 * @return int[]
	 */
	private static function get_from_cookie(): array {
		if ( ! isset( $_COOKIE[ self::COOKIE_NAME ] ) ) {
			return [];
		}

		$raw = sanitize_text_field( wp_unslash( $_COOKIE[ self::COOKIE_NAME ] ) );
		$ids = json_decode( $raw, true );

		if ( ! is_array( $ids ) ) {
			return [];
		}

		return array_map( 'absint', $ids );
	}

	/**
	 * Write product IDs to the cookie.
	 *
	 * @param int[] $ids Product IDs.
	 */
	private static function set_cookie( array $ids ): void {
		$value  = wp_json_encode( array_map( 'absint', $ids ) );
		$expiry = time() + ( self::COOKIE_DAYS * DAY_IN_SECONDS );

		setcookie(
			self::COOKIE_NAME,
			$value,
			[
				'expires'  => $expiry,
				'path'     => COOKIEPATH,
				'domain'   => COOKIE_DOMAIN,
				'secure'   => is_ssl(),
				'httponly'  => false,
				'samesite' => 'Lax',
			]
		);

		// Also set in $_COOKIE so it's available on the same request.
		$_COOKIE[ self::COOKIE_NAME ] = $value;
	}
}

Alwayshere_Recently_Viewed::init();
