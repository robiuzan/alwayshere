<?php
/**
 * Account registration, endpoints, and menu customization.
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Account {

	/**
	 * Custom endpoint slugs for My Account tabs.
	 */
	private const ENDPOINTS = [
		'favorites'       => 'favorites',
		'recently-viewed' => 'recently-viewed',
	];

	/**
	 * Boot all hooks.
	 */
	public static function init(): void {
		// Enable registration on My Account page.
		add_filter( 'option_users_can_register', '__return_true' );
		add_filter( 'option_woocommerce_enable_myaccount_registration', fn() => 'yes' );

		// Let users set their own password during registration.
		add_filter( 'option_woocommerce_registration_generate_password', fn() => 'no' );

		// Allow optional account creation at checkout.
		add_filter( 'woocommerce_checkout_registration_enabled', '__return_true' );

		// Registration is not required — guests can still check out.
		add_filter( 'woocommerce_checkout_registration_required', '__return_false' );

		// Override the "My Account" page title to Hebrew.
		add_filter( 'the_title', [ __CLASS__, 'translate_account_title' ], 10, 2 );

		// Register custom endpoints.
		add_action( 'init', [ __CLASS__, 'register_endpoints' ] );

		// Customize My Account menu items.
		add_filter( 'woocommerce_account_menu_items', [ __CLASS__, 'menu_items' ] );

		// Render content for custom endpoints.
		add_action( 'woocommerce_account_favorites_endpoint', [ __CLASS__, 'render_favorites' ] );
		add_action( 'woocommerce_account_recently-viewed_endpoint', [ __CLASS__, 'render_recently_viewed' ] );

		// Set default role for new registrations.
		add_filter( 'woocommerce_new_customer_data', [ __CLASS__, 'set_customer_role' ] );

		// Flush rewrite rules once after plugin activation.
		add_action( 'admin_init', [ __CLASS__, 'maybe_flush_rewrite' ] );
	}

	/**
	 * Register custom WC account endpoints.
	 */
	public static function register_endpoints(): void {
		foreach ( self::ENDPOINTS as $key => $slug ) {
			add_rewrite_endpoint( $slug, EP_ROOT | EP_PAGES );
		}
	}

	/**
	 * Customize My Account navigation menu items.
	 *
	 * @param array<string, string> $items Default menu items.
	 * @return array<string, string>
	 */
	public static function menu_items( array $items ): array {
		$new_items = [];

		// Dashboard stays first.
		if ( isset( $items['dashboard'] ) ) {
			$new_items['dashboard'] = 'לוח בקרה';
		}

		// Orders.
		if ( isset( $items['orders'] ) ) {
			$new_items['orders'] = 'הזמנות';
		}

		// Custom: Favorites.
		$new_items['favorites'] = 'מועדפים';

		// Custom: Recently Viewed.
		$new_items['recently-viewed'] = 'נצפו לאחרונה';

		// Edit account.
		if ( isset( $items['edit-account'] ) ) {
			$new_items['edit-account'] = 'פרטי חשבון';
		}

		// Logout at the end.
		if ( isset( $items['customer-logout'] ) ) {
			$new_items['customer-logout'] = 'התנתקות';
		}

		return $new_items;
	}

	/**
	 * Render the Favorites endpoint content.
	 */
	public static function render_favorites(): void {
		get_template_part( 'template-parts/account/favorites-grid' );
	}

	/**
	 * Render the Recently Viewed endpoint content.
	 */
	public static function render_recently_viewed(): void {
		get_template_part( 'template-parts/account/recently-viewed-grid' );
	}

	/**
	 * Ensure new customers get the 'customer' role.
	 *
	 * @param array<string, mixed> $data Customer data.
	 * @return array<string, mixed>
	 */
	public static function set_customer_role( array $data ): array {
		$data['role'] = 'customer';
		return $data;
	}

	/**
	 * Translate the "My Account" page title to Hebrew.
	 *
	 * @param string $title Post title.
	 * @param int    $id    Post ID.
	 * @return string
	 */
	public static function translate_account_title( string $title, $id = 0 ): string {
		if ( ! function_exists( 'wc_get_page_id' ) ) {
			return $title;
		}

		if ( (int) $id === wc_get_page_id( 'myaccount' ) && 'My account' === $title ) {
			return 'החשבון שלי';
		}

		return $title;
	}

	/**
	 * Flush rewrite rules once after plugin activation.
	 */
	public static function maybe_flush_rewrite(): void {
		if ( 'yes' === get_option( 'alwayshere_account_flush_done' ) ) {
			return;
		}

		self::register_endpoints();
		flush_rewrite_rules();
		update_option( 'alwayshere_account_flush_done', 'yes' );
	}
}

Alwayshere_Account::init();
