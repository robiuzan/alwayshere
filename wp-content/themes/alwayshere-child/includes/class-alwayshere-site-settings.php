<?php
/**
 * Site Settings admin page — tabbed settings for Header & Footer.
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Site_Settings {

	/** Option keys. */
	private const TRUST_OPTION      = 'alwayshere_trust_badges';
	private const PAYMENTS_OPTION   = 'alwayshere_payment_methods';
	private const TOPBAR_CONTACTS   = 'alwayshere_topbar_contacts';
	private const TOPBAR_PROMO      = 'alwayshere_topbar_promo';
	private const TOPBAR_SOCIAL     = 'alwayshere_topbar_social';

	/** Menu slug. */
	private const MENU_SLUG = 'alwayshere-site-settings';

	/**
	 * Boot — call once from functions.php.
	 */
	public static function init(): void {
		$instance = new self();
		add_action( 'admin_menu', [ $instance, 'add_menu_page' ] );
		add_action( 'admin_init', [ $instance, 'register_settings' ] );
		add_action( 'admin_enqueue_scripts', [ $instance, 'enqueue_admin_assets' ] );
		add_filter( 'wp_redirect', [ $instance, 'redirect_to_active_tab' ] );
	}

	/**
	 * Redirect back to the active tab after saving settings.
	 */
	public function redirect_to_active_tab( string $location ): string {
		if ( false === strpos( $location, 'page=' . self::MENU_SLUG ) ) {
			return $location;
		}

		if ( ! isset( $_POST['alwayshere_active_tab'] ) ) {
			return $location;
		}

		$tab = sanitize_text_field( wp_unslash( $_POST['alwayshere_active_tab'] ) );
		if ( in_array( $tab, [ 'header', 'footer' ], true ) ) {
			$location = add_query_arg( 'tab', $tab, $location );
		}

		return $location;
	}

	/**
	 * Add top-level menu page.
	 */
	public function add_menu_page(): void {
		add_menu_page(
			__( 'Site Settings', 'alwayshere-child' ),
			__( 'Site Settings', 'alwayshere-child' ),
			'manage_options',
			self::MENU_SLUG,
			[ $this, 'render_page' ],
			'dashicons-admin-settings',
			59
		);
	}

	/**
	 * Register settings with the Settings API.
	 */
	public function register_settings(): void {
		// Footer settings.
		register_setting( self::MENU_SLUG, self::TRUST_OPTION, [
			'type'              => 'array',
			'sanitize_callback' => [ $this, 'sanitize_trust_badges' ],
			'default'           => self::default_trust_badges(),
		] );

		register_setting( self::MENU_SLUG, self::PAYMENTS_OPTION, [
			'type'              => 'array',
			'sanitize_callback' => [ $this, 'sanitize_payment_methods' ],
			'default'           => self::default_payment_methods(),
		] );

		// Header / topbar settings.
		register_setting( self::MENU_SLUG, self::TOPBAR_CONTACTS, [
			'type'              => 'array',
			'sanitize_callback' => [ $this, 'sanitize_topbar_contacts' ],
			'default'           => self::default_topbar_contacts(),
		] );

		register_setting( self::MENU_SLUG, self::TOPBAR_PROMO, [
			'type'              => 'array',
			'sanitize_callback' => [ $this, 'sanitize_topbar_promo' ],
			'default'           => self::default_topbar_promo(),
		] );

		register_setting( self::MENU_SLUG, self::TOPBAR_SOCIAL, [
			'type'              => 'array',
			'sanitize_callback' => [ $this, 'sanitize_topbar_social' ],
			'default'           => self::default_topbar_social(),
		] );
	}

	/**
	 * Enqueue admin JS & CSS for the settings page.
	 */
	public function enqueue_admin_assets( string $hook ): void {
		if ( 'toplevel_page_' . self::MENU_SLUG !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'alwayshere-site-settings',
			get_stylesheet_directory_uri() . '/assets/css/admin-site-settings.css',
			[],
			(string) filemtime( get_stylesheet_directory() . '/assets/css/admin-site-settings.css' )
		);

		wp_enqueue_script(
			'alwayshere-site-settings',
			get_stylesheet_directory_uri() . '/assets/js/admin-site-settings.js',
			[],
			(string) filemtime( get_stylesheet_directory() . '/assets/js/admin-site-settings.js' ),
			true
		);
	}

	/**
	 * Render the settings page.
	 */
	public function render_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$trust_badges    = self::get_trust_badges();
		$payment_methods = self::get_payment_methods();
		$contacts        = self::get_topbar_contacts();
		$promo           = self::get_topbar_promo();
		$social          = self::get_topbar_social();

		// Determine active tab from URL param (read-only, no state change).
		$allowed_tabs = [ 'header', 'footer' ];
		$active_tab   = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'header';
		if ( ! in_array( $active_tab, $allowed_tabs, true ) ) {
			$active_tab = 'header';
		}
		?>
		<div class="wrap ah-settings">
			<h1><?php esc_html_e( 'Site Settings', 'alwayshere-child' ); ?></h1>

			<!-- Tab navigation -->
			<nav class="ah-settings__tabs nav-tab-wrapper">
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'header', admin_url( 'admin.php?page=' . self::MENU_SLUG ) ) ); ?>"
				   class="nav-tab <?php echo 'header' === $active_tab ? 'nav-tab-active' : ''; ?>">
					<?php esc_html_e( 'Header', 'alwayshere-child' ); ?>
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'footer', admin_url( 'admin.php?page=' . self::MENU_SLUG ) ) ); ?>"
				   class="nav-tab <?php echo 'footer' === $active_tab ? 'nav-tab-active' : ''; ?>">
					<?php esc_html_e( 'Footer', 'alwayshere-child' ); ?>
				</a>
			</nav>

			<form method="post" action="options.php">
				<?php settings_fields( self::MENU_SLUG ); ?>
				<input type="hidden" name="alwayshere_active_tab" value="<?php echo esc_attr( $active_tab ); ?>">

				<?php if ( 'header' === $active_tab ) : ?>
					<?php $this->render_header_tab( $contacts, $promo, $social ); ?>
				<?php elseif ( 'footer' === $active_tab ) : ?>
					<?php $this->render_footer_tab( $trust_badges, $payment_methods ); ?>
				<?php endif; ?>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render the Header tab content.
	 *
	 * @param array $contacts Topbar contacts.
	 * @param array $promo    Topbar promo.
	 * @param array $social   Topbar social.
	 */
	private function render_header_tab( array $contacts, array $promo, array $social ): void {
		?>
		<!-- Topbar Contacts -->
		<div class="ah-settings__section">
			<h2><?php esc_html_e( 'Top Bar — Contacts', 'alwayshere-child' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Contact information displayed on the right side of the top bar.', 'alwayshere-child' ); ?></p>

			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="ah-contacts-phone"><?php esc_html_e( 'Phone', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-contacts-phone"
							name="<?php echo esc_attr( self::TOPBAR_CONTACTS ); ?>[phone]"
							value="<?php echo esc_attr( $contacts['phone'] ); ?>"
							class="regular-text"
							dir="ltr"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-contacts-email"><?php esc_html_e( 'Email', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="email"
							id="ah-contacts-email"
							name="<?php echo esc_attr( self::TOPBAR_CONTACTS ); ?>[email]"
							value="<?php echo esc_attr( $contacts['email'] ); ?>"
							class="regular-text"
							dir="ltr"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-contacts-location"><?php esc_html_e( 'Location Text', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-contacts-location"
							name="<?php echo esc_attr( self::TOPBAR_CONTACTS ); ?>[location_text]"
							value="<?php echo esc_attr( $contacts['location_text'] ); ?>"
							class="regular-text"
						>
					</td>
				</tr>
			</table>
		</div>

		<!-- Topbar Promo -->
		<div class="ah-settings__section">
			<h2><?php esc_html_e( 'Top Bar — Promo', 'alwayshere-child' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Promotional message displayed in the center of the top bar.', 'alwayshere-child' ); ?></p>

			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="ah-promo-emoji"><?php esc_html_e( 'Emoji', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-promo-emoji"
							name="<?php echo esc_attr( self::TOPBAR_PROMO ); ?>[emoji]"
							value="<?php echo esc_attr( $promo['emoji'] ); ?>"
							class="small-text ah-settings__emoji-input"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-promo-text"><?php esc_html_e( 'Promo Text', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-promo-text"
							name="<?php echo esc_attr( self::TOPBAR_PROMO ); ?>[text]"
							value="<?php echo esc_attr( $promo['text'] ); ?>"
							class="regular-text"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-promo-highlight"><?php esc_html_e( 'Highlight Text', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-promo-highlight"
							name="<?php echo esc_attr( self::TOPBAR_PROMO ); ?>[highlight]"
							value="<?php echo esc_attr( $promo['highlight'] ); ?>"
							class="regular-text"
						>
						<p class="description"><?php esc_html_e( 'Bold text shown after the promo text.', 'alwayshere-child' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-promo-cta"><?php esc_html_e( 'CTA Text', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-promo-cta"
							name="<?php echo esc_attr( self::TOPBAR_PROMO ); ?>[cta_text]"
							value="<?php echo esc_attr( $promo['cta_text'] ); ?>"
							class="regular-text"
						>
						<p class="description"><?php esc_html_e( 'Call-to-action link text (links to the shop page).', 'alwayshere-child' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-promo-shipping"><?php esc_html_e( 'Shipping Text', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="ah-promo-shipping"
							name="<?php echo esc_attr( self::TOPBAR_PROMO ); ?>[shipping_text]"
							value="<?php echo esc_attr( $promo['shipping_text'] ); ?>"
							class="regular-text"
						>
					</td>
				</tr>
			</table>
		</div>

		<!-- Topbar Social Links -->
		<div class="ah-settings__section">
			<h2><?php esc_html_e( 'Top Bar — Social Links', 'alwayshere-child' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Social media links displayed on the left side of the top bar. Leave empty to hide a link.', 'alwayshere-child' ); ?></p>

			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="ah-social-instagram"><?php esc_html_e( 'Instagram URL', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="url"
							id="ah-social-instagram"
							name="<?php echo esc_attr( self::TOPBAR_SOCIAL ); ?>[instagram]"
							value="<?php echo esc_url( $social['instagram'] ); ?>"
							class="regular-text"
							dir="ltr"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-social-facebook"><?php esc_html_e( 'Facebook URL', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="url"
							id="ah-social-facebook"
							name="<?php echo esc_attr( self::TOPBAR_SOCIAL ); ?>[facebook]"
							value="<?php echo esc_url( $social['facebook'] ); ?>"
							class="regular-text"
							dir="ltr"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ah-social-tiktok"><?php esc_html_e( 'TikTok URL', 'alwayshere-child' ); ?></label>
					</th>
					<td>
						<input
							type="url"
							id="ah-social-tiktok"
							name="<?php echo esc_attr( self::TOPBAR_SOCIAL ); ?>[tiktok]"
							value="<?php echo esc_url( $social['tiktok'] ); ?>"
							class="regular-text"
							dir="ltr"
						>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Render the Footer tab content.
	 *
	 * @param array    $trust_badges    Trust badges array.
	 * @param string[] $payment_methods Payment methods array.
	 */
	private function render_footer_tab( array $trust_badges, array $payment_methods ): void {
		?>
		<!-- Trust Badges -->
		<div class="ah-settings__section">
			<h2><?php esc_html_e( 'Trust Badges', 'alwayshere-child' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Trust badges displayed above the bottom bar in the footer.', 'alwayshere-child' ); ?></p>

			<table class="ah-settings__repeater" id="ah-trust-repeater">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Icon (emoji)', 'alwayshere-child' ); ?></th>
						<th><?php esc_html_e( 'Text', 'alwayshere-child' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $trust_badges as $i => $badge ) : ?>
						<tr class="ah-settings__row">
							<td>
								<input
									type="text"
									name="<?php echo esc_attr( self::TRUST_OPTION ); ?>[<?php echo (int) $i; ?>][icon]"
									value="<?php echo esc_attr( $badge['icon'] ); ?>"
									class="small-text"
									style="text-align:center;font-size:1.25rem;"
								>
							</td>
							<td>
								<input
									type="text"
									name="<?php echo esc_attr( self::TRUST_OPTION ); ?>[<?php echo (int) $i; ?>][text]"
									value="<?php echo esc_attr( $badge['text'] ); ?>"
									class="regular-text"
								>
							</td>
							<td>
								<button type="button" class="button ah-settings__remove-row">&times;</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<button type="button" class="button ah-settings__add-row" data-target="ah-trust-repeater" data-option="<?php echo esc_attr( self::TRUST_OPTION ); ?>">
				<?php esc_html_e( '+ Add Badge', 'alwayshere-child' ); ?>
			</button>
		</div>

		<!-- Payment Methods -->
		<div class="ah-settings__section">
			<h2><?php esc_html_e( 'Payment Methods', 'alwayshere-child' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Payment method chips displayed in the footer bottom bar.', 'alwayshere-child' ); ?></p>

			<table class="ah-settings__repeater" id="ah-payments-repeater">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Label', 'alwayshere-child' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $payment_methods as $i => $method ) : ?>
						<tr class="ah-settings__row">
							<td>
								<input
									type="text"
									name="<?php echo esc_attr( self::PAYMENTS_OPTION ); ?>[<?php echo (int) $i; ?>]"
									value="<?php echo esc_attr( $method ); ?>"
									class="regular-text"
								>
							</td>
							<td>
								<button type="button" class="button ah-settings__remove-row">&times;</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<button type="button" class="button ah-settings__add-row" data-target="ah-payments-repeater" data-option="<?php echo esc_attr( self::PAYMENTS_OPTION ); ?>">
				<?php esc_html_e( '+ Add Payment Method', 'alwayshere-child' ); ?>
			</button>
		</div>
		<?php
	}

	// ── Public getters (used in templates) ───────────────────────────────────────

	/**
	 * Get trust badges.
	 *
	 * @return array<int, array{icon: string, text: string}>
	 */
	public static function get_trust_badges(): array {
		$badges = get_option( self::TRUST_OPTION, self::default_trust_badges() );
		return is_array( $badges ) ? $badges : self::default_trust_badges();
	}

	/**
	 * Get payment methods.
	 *
	 * @return string[]
	 */
	public static function get_payment_methods(): array {
		$methods = get_option( self::PAYMENTS_OPTION, self::default_payment_methods() );
		return is_array( $methods ) ? $methods : self::default_payment_methods();
	}

	/**
	 * Get topbar contacts.
	 *
	 * @return array{phone: string, email: string, location_text: string}
	 */
	public static function get_topbar_contacts(): array {
		$contacts = get_option( self::TOPBAR_CONTACTS, self::default_topbar_contacts() );
		return is_array( $contacts ) ? wp_parse_args( $contacts, self::default_topbar_contacts() ) : self::default_topbar_contacts();
	}

	/**
	 * Get topbar promo.
	 *
	 * @return array{emoji: string, text: string, highlight: string, cta_text: string, shipping_text: string}
	 */
	public static function get_topbar_promo(): array {
		$promo = get_option( self::TOPBAR_PROMO, self::default_topbar_promo() );
		return is_array( $promo ) ? wp_parse_args( $promo, self::default_topbar_promo() ) : self::default_topbar_promo();
	}

	/**
	 * Get topbar social links.
	 *
	 * @return array{instagram: string, facebook: string, tiktok: string}
	 */
	public static function get_topbar_social(): array {
		$social = get_option( self::TOPBAR_SOCIAL, self::default_topbar_social() );
		return is_array( $social ) ? wp_parse_args( $social, self::default_topbar_social() ) : self::default_topbar_social();
	}

	// ── Sanitization ─────────────────────────────────────────────────────────────

	/**
	 * @param mixed $input
	 * @return array<int, array{icon: string, text: string}>
	 */
	public function sanitize_trust_badges( $input ): array {
		if ( ! is_array( $input ) ) {
			return self::default_trust_badges();
		}

		$clean = [];
		foreach ( $input as $badge ) {
			if ( ! is_array( $badge ) ) {
				continue;
			}
			$icon = isset( $badge['icon'] ) ? sanitize_text_field( $badge['icon'] ) : '';
			$text = isset( $badge['text'] ) ? sanitize_text_field( $badge['text'] ) : '';
			if ( '' !== $text ) {
				$clean[] = [ 'icon' => $icon, 'text' => $text ];
			}
		}

		return $clean;
	}

	/**
	 * @param mixed $input
	 * @return string[]
	 */
	public function sanitize_payment_methods( $input ): array {
		if ( ! is_array( $input ) ) {
			return self::default_payment_methods();
		}

		$clean = [];
		foreach ( $input as $method ) {
			$method = sanitize_text_field( $method );
			if ( '' !== $method ) {
				$clean[] = $method;
			}
		}

		return $clean;
	}

	/**
	 * @param mixed $input
	 * @return array{phone: string, email: string, location_text: string}
	 */
	public function sanitize_topbar_contacts( $input ): array {
		if ( ! is_array( $input ) ) {
			return self::default_topbar_contacts();
		}

		return [
			'phone'         => isset( $input['phone'] ) ? sanitize_text_field( $input['phone'] ) : '',
			'email'         => isset( $input['email'] ) ? sanitize_email( $input['email'] ) : '',
			'location_text' => isset( $input['location_text'] ) ? sanitize_text_field( $input['location_text'] ) : '',
		];
	}

	/**
	 * @param mixed $input
	 * @return array{emoji: string, text: string, highlight: string, cta_text: string, shipping_text: string}
	 */
	public function sanitize_topbar_promo( $input ): array {
		if ( ! is_array( $input ) ) {
			return self::default_topbar_promo();
		}

		return [
			'emoji'         => isset( $input['emoji'] ) ? sanitize_text_field( $input['emoji'] ) : '',
			'text'          => isset( $input['text'] ) ? sanitize_text_field( $input['text'] ) : '',
			'highlight'     => isset( $input['highlight'] ) ? sanitize_text_field( $input['highlight'] ) : '',
			'cta_text'      => isset( $input['cta_text'] ) ? sanitize_text_field( $input['cta_text'] ) : '',
			'shipping_text' => isset( $input['shipping_text'] ) ? sanitize_text_field( $input['shipping_text'] ) : '',
		];
	}

	/**
	 * @param mixed $input
	 * @return array{instagram: string, facebook: string, tiktok: string}
	 */
	public function sanitize_topbar_social( $input ): array {
		if ( ! is_array( $input ) ) {
			return self::default_topbar_social();
		}

		return [
			'instagram' => isset( $input['instagram'] ) ? esc_url_raw( $input['instagram'] ) : '',
			'facebook'  => isset( $input['facebook'] ) ? esc_url_raw( $input['facebook'] ) : '',
			'tiktok'    => isset( $input['tiktok'] ) ? esc_url_raw( $input['tiktok'] ) : '',
		];
	}

	// ── Defaults ─────────────────────────────────────────────────────────────────

	/**
	 * @return array<int, array{icon: string, text: string}>
	 */
	private static function default_trust_badges(): array {
		return [
			[ 'icon' => "\xF0\x9F\x94\x92", 'text' => 'תשלום מאובטח SSL' ],
			[ 'icon' => "\xE2\x9C\x85",     'text' => 'איכות מובטחת' ],
			[ 'icon' => "\xF0\x9F\x94\x84", 'text' => 'החזרה קלה' ],
			[ 'icon' => "\xF0\x9F\x9A\x9A", 'text' => 'משלוח מהיר לכל הארץ' ],
			[ 'icon' => "\xF0\x9F\x8E\x81", 'text' => 'אריזת מתנה כלולה' ],
			[ 'icon' => "\xE2\xAD\x90",     'text' => 'דירוג 4.9 מ-5' ],
		];
	}

	/**
	 * @return string[]
	 */
	private static function default_payment_methods(): array {
		return [ 'VISA', 'MC', 'PayPal', 'BIT' ];
	}

	/**
	 * @return array{phone: string, email: string, location_text: string}
	 */
	private static function default_topbar_contacts(): array {
		return [
			'phone'         => '055-6601006',
			'email'         => 'info@alwayshere.co.il',
			'location_text' => 'משלוח לכל הארץ',
		];
	}

	/**
	 * @return array{emoji: string, text: string, highlight: string, cta_text: string, shipping_text: string}
	 */
	private static function default_topbar_promo(): array {
		return [
			'emoji'         => '🎁',
			'text'          => 'מבצע מוגבל —',
			'highlight'     => '30% הנחה על הכל!',
			'cta_text'      => 'קנה עכשיו',
			'shipping_text' => 'משלוח חינם בהזמנות מעל ₪199',
		];
	}

	/**
	 * @return array{instagram: string, facebook: string, tiktok: string}
	 */
	private static function default_topbar_social(): array {
		return [
			'instagram' => '',
			'facebook'  => '',
			'tiktok'    => '',
		];
	}
}
