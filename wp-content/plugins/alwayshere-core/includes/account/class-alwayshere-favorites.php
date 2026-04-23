<?php
/**
 * Favorites (wishlist) — CRUD, AJAX, and rendering.
 *
 * Storage: user meta `alwayshere_favorites` (array of product IDs).
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Favorites {

	private const META_KEY = 'alwayshere_favorites';

	/**
	 * Boot all hooks.
	 */
	public static function init(): void {
		// AJAX toggle (logged-in users only).
		add_action( 'wp_ajax_alwayshere_toggle_favorite', [ __CLASS__, 'ajax_toggle' ] );

		// Render heart button on product loops and single product.
		add_action( 'woocommerce_before_shop_loop_item_title', [ __CLASS__, 'render_heart_button' ], 9 );
		add_action( 'woocommerce_single_product_summary', [ __CLASS__, 'render_heart_button' ], 6 );
	}

	// ── CRUD ────────────────────────────────────────────────────────────────────

	/**
	 * Get all favorite product IDs for a user.
	 *
	 * @param int $user_id WordPress user ID.
	 * @return int[]
	 */
	public static function get_all( int $user_id ): array {
		$favs = get_user_meta( $user_id, self::META_KEY, true );
		return is_array( $favs ) ? array_map( 'absint', $favs ) : [];
	}

	/**
	 * Check if a product is in the user's favorites.
	 */
	public static function is_favorite( int $user_id, int $product_id ): bool {
		return in_array( $product_id, self::get_all( $user_id ), true );
	}

	/**
	 * Get total count of favorites.
	 */
	public static function get_count( int $user_id ): int {
		return count( self::get_all( $user_id ) );
	}

	/**
	 * Add a product to favorites.
	 */
	public static function add( int $user_id, int $product_id ): bool {
		$favs = self::get_all( $user_id );
		if ( in_array( $product_id, $favs, true ) ) {
			return false;
		}
		array_unshift( $favs, $product_id );
		update_user_meta( $user_id, self::META_KEY, $favs );
		return true;
	}

	/**
	 * Remove a product from favorites.
	 */
	public static function remove( int $user_id, int $product_id ): bool {
		$favs = self::get_all( $user_id );
		$key  = array_search( $product_id, $favs, true );
		if ( false === $key ) {
			return false;
		}
		unset( $favs[ $key ] );
		update_user_meta( $user_id, self::META_KEY, array_values( $favs ) );
		return true;
	}

	/**
	 * Toggle a product in/out of favorites.
	 *
	 * @return array{status: string, count: int}
	 */
	public static function toggle( int $user_id, int $product_id ): array {
		if ( self::is_favorite( $user_id, $product_id ) ) {
			self::remove( $user_id, $product_id );
			$status = 'removed';
		} else {
			self::add( $user_id, $product_id );
			$status = 'added';
		}

		return [
			'status' => $status,
			'count'  => self::get_count( $user_id ),
		];
	}

	// ── AJAX ────────────────────────────────────────────────────────────────────

	/**
	 * Handle AJAX favorite toggle.
	 */
	public static function ajax_toggle(): void {
		check_ajax_referer( 'alwayshere_favorites', 'nonce' );

		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

		if ( ! $product_id || 'publish' !== get_post_status( $product_id ) ) {
			wp_send_json_error( [ 'message' => 'מוצר לא תקין.' ] );
		}

		$result = self::toggle( get_current_user_id(), $product_id );

		wp_send_json_success( $result );
	}

	// ── Rendering ───────────────────────────────────────────────────────────────

	/**
	 * Render the heart (favorite) button on product cards and single product.
	 */
	public static function render_heart_button(): void {
		global $product;
		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$product_id = $product->get_id();
		$is_active  = is_user_logged_in() && self::is_favorite( get_current_user_id(), $product_id );
		$classes    = 'ah-fav-btn';
		if ( $is_active ) {
			$classes .= ' ah-fav-btn--active';
		}

		// Pass product data as data attributes for the data layer.
		printf(
			'<button class="%s" data-product-id="%d" data-product-name="%s" data-product-price="%s" aria-pressed="%s" aria-label="%s" type="button">
				<svg viewBox="0 0 24 24" fill="%s" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
					<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
				</svg>
			</button>',
			esc_attr( $classes ),
			esc_attr( $product_id ),
			esc_attr( $product->get_name() ),
			esc_attr( $product->get_price() ),
			$is_active ? 'true' : 'false',
			esc_attr__( 'הוסף למועדפים', 'alwayshere-core' ),
			$is_active ? 'currentColor' : 'none'
		);
	}
}

Alwayshere_Favorites::init();
