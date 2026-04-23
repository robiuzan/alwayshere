<?php
/**
 * Google OAuth login integration.
 *
 * Configuration via wp-config.php constants:
 *   define( 'ALWAYSHERE_GOOGLE_CLIENT_ID',     'your-client-id' );
 *   define( 'ALWAYSHERE_GOOGLE_CLIENT_SECRET', 'your-client-secret' );
 *
 * Google Cloud Console setup:
 *   - Create OAuth 2.0 credentials (Web application).
 *   - Authorized redirect URI: https://alwayshere.co.il/?alwayshere_google_callback=1
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Google_Login {

	private const AUTH_URL  = 'https://accounts.google.com/o/oauth2/v2/auth';
	private const TOKEN_URL = 'https://oauth2.googleapis.com/token';
	private const USER_URL  = 'https://www.googleapis.com/oauth2/v2/userinfo';

	/**
	 * Boot hooks only if Google credentials are configured.
	 */
	public static function init(): void {
		if ( ! self::is_configured() ) {
			return;
		}

		// Handle OAuth callback.
		add_action( 'init', [ __CLASS__, 'handle_callback' ] );

		// Render Google login button on the login form.
		add_action( 'alwayshere_login_form_social_buttons', [ __CLASS__, 'render_button' ] );
	}

	/**
	 * Check if Google credentials are set.
	 */
	public static function is_configured(): bool {
		return defined( 'ALWAYSHERE_GOOGLE_CLIENT_ID' )
			&& defined( 'ALWAYSHERE_GOOGLE_CLIENT_SECRET' )
			&& '' !== ALWAYSHERE_GOOGLE_CLIENT_ID
			&& '' !== ALWAYSHERE_GOOGLE_CLIENT_SECRET;
	}

	/**
	 * Get the redirect URI for the OAuth callback.
	 */
	private static function get_redirect_uri(): string {
		return home_url( '/' ) . '?alwayshere_google_callback=1';
	}

	/**
	 * Build the Google OAuth consent URL with CSRF state param.
	 */
	public static function get_auth_url(): string {
		// Generate state parameter for CSRF protection.
		$state = wp_generate_password( 32, false );
		set_transient( 'alwayshere_google_state_' . $state, '1', 10 * MINUTE_IN_SECONDS );

		$params = [
			'client_id'     => ALWAYSHERE_GOOGLE_CLIENT_ID,
			'redirect_uri'  => self::get_redirect_uri(),
			'response_type' => 'code',
			'scope'         => 'openid email profile',
			'state'         => $state,
			'access_type'   => 'online',
			'prompt'        => 'select_account',
		];

		return self::AUTH_URL . '?' . http_build_query( $params, '', '&' );
	}

	/**
	 * Handle the OAuth callback from Google.
	 */
	public static function handle_callback(): void {
		if ( ! isset( $_GET['alwayshere_google_callback'] ) ) {
			return;
		}

		$account_url = function_exists( 'wc_get_page_permalink' )
			? wc_get_page_permalink( 'myaccount' )
			: home_url( '/my-account/' );

		// Validate state parameter (CSRF protection).
		$state = isset( $_GET['state'] ) ? sanitize_text_field( wp_unslash( $_GET['state'] ) ) : '';
		if ( ! $state || ! get_transient( 'alwayshere_google_state_' . $state ) ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'csrf', $account_url ) );
			exit;
		}
		delete_transient( 'alwayshere_google_state_' . $state );

		// Check for error from Google.
		if ( isset( $_GET['error'] ) ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'denied', $account_url ) );
			exit;
		}

		// Exchange authorization code for tokens.
		$code = isset( $_GET['code'] ) ? sanitize_text_field( wp_unslash( $_GET['code'] ) ) : '';
		if ( ! $code ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'no-code', $account_url ) );
			exit;
		}

		$token_response = wp_remote_post( self::TOKEN_URL, [
			'body' => [
				'code'          => $code,
				'client_id'     => ALWAYSHERE_GOOGLE_CLIENT_ID,
				'client_secret' => ALWAYSHERE_GOOGLE_CLIENT_SECRET,
				'redirect_uri'  => self::get_redirect_uri(),
				'grant_type'    => 'authorization_code',
			],
			'timeout' => 15,
		] );

		if ( is_wp_error( $token_response ) ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'token-error', $account_url ) );
			exit;
		}

		$token_data = json_decode( wp_remote_retrieve_body( $token_response ), true );
		$access_token = $token_data['access_token'] ?? '';

		if ( ! $access_token ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'no-token', $account_url ) );
			exit;
		}

		// Fetch user profile from Google.
		$user_response = wp_remote_get( self::USER_URL, [
			'headers' => [ 'Authorization' => 'Bearer ' . $access_token ],
			'timeout' => 15,
		] );

		if ( is_wp_error( $user_response ) ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'profile-error', $account_url ) );
			exit;
		}

		$profile = json_decode( wp_remote_retrieve_body( $user_response ), true );
		$email   = isset( $profile['email'] ) ? sanitize_email( $profile['email'] ) : '';

		if ( ! $email || ! is_email( $email ) ) {
			wp_safe_redirect( add_query_arg( 'login-error', 'no-email', $account_url ) );
			exit;
		}

		// Find or create WordPress user.
		$user = get_user_by( 'email', $email );

		if ( ! $user ) {
			$name       = sanitize_text_field( $profile['name'] ?? '' );
			$first_name = sanitize_text_field( $profile['given_name'] ?? '' );
			$last_name  = sanitize_text_field( $profile['family_name'] ?? '' );

			$user_id = wp_insert_user( [
				'user_login'   => $email,
				'user_email'   => $email,
				'user_pass'    => wp_generate_password( 24, true, true ),
				'display_name' => $name ?: $email,
				'first_name'   => $first_name,
				'last_name'    => $last_name,
				'role'         => 'customer',
			] );

			if ( is_wp_error( $user_id ) ) {
				wp_safe_redirect( add_query_arg( 'login-error', 'create-failed', $account_url ) );
				exit;
			}

			$user = get_user_by( 'id', $user_id );
		}

		// Store Google avatar URL.
		$picture = isset( $profile['picture'] ) ? esc_url_raw( $profile['picture'] ) : '';
		if ( $picture ) {
			update_user_meta( $user->ID, 'alwayshere_google_avatar', $picture );
		}

		// Log the user in.
		wp_clear_auth_cookie();
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID, true );
		do_action( 'wp_login', $user->user_login, $user );

		wp_safe_redirect( $account_url );
		exit;
	}

	/**
	 * Render the Google login button and divider on the login form.
	 */
	public static function render_button(): void {
		$auth_url = self::get_auth_url();
		?>
		<a href="<?php echo esc_url( $auth_url ); ?>" class="ah-auth__google-btn">
			<svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
				<path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
				<path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
				<path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
				<path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
			</svg>
			<?php esc_html_e( 'כניסה עם Google', 'alwayshere-core' ); ?>
		</a>
		<div class="ah-auth__divider"><?php esc_html_e( 'או', 'alwayshere-core' ); ?></div>
		<?php
	}
}

Alwayshere_Google_Login::init();
