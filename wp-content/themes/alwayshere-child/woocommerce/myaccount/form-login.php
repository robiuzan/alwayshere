<?php
/**
 * Login / Register form — full redesign.
 *
 * WC template override: woocommerce/templates/myaccount/form-login.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="ah-auth">
<div class="ah-container">

	<h1 class="ah-auth__page-title"><?php esc_html_e( 'החשבון שלי', 'alwayshere-child' ); ?></h1>

	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
	<div class="ah-auth__cols">
	<?php endif; ?>

	<!-- ─── Login ──────────────────────────────────────────────────────── -->
	<div class="ah-auth__panel ah-auth__panel--login">
		<h2 class="ah-auth__title"><?php esc_html_e( 'כניסה לחשבון', 'alwayshere-child' ); ?></h2>

		<?php
		/**
		 * Google login button slot — rendered by Alwayshere_Google_Login if active.
		 */
		do_action( 'alwayshere_login_form_social_buttons' );
		?>

		<form method="post" class="ah-auth__form">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<div class="ah-auth__field">
				<label for="username"><?php esc_html_e( 'אימייל או שם משתמש', 'alwayshere-child' ); ?></label>
				<input
					type="text"
					id="username"
					name="username"
					autocomplete="username"
					value="<?php echo isset( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
					required
				/>
			</div>

			<div class="ah-auth__field">
				<label for="password"><?php esc_html_e( 'סיסמה', 'alwayshere-child' ); ?></label>
				<input
					type="password"
					id="password"
					name="password"
					autocomplete="current-password"
					required
				/>
			</div>

			<div class="ah-auth__row">
				<label class="ah-auth__remember">
					<input type="checkbox" name="rememberme" value="forever" />
					<?php esc_html_e( 'זכור אותי', 'alwayshere-child' ); ?>
				</label>
				<a class="ah-auth__forgot" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
					<?php esc_html_e( 'שכחת סיסמה?', 'alwayshere-child' ); ?>
				</a>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

			<button type="submit" class="ah-auth__submit" name="login" value="<?php esc_attr_e( 'כניסה', 'alwayshere-child' ); ?>">
				<?php esc_html_e( 'כניסה', 'alwayshere-child' ); ?>
			</button>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
	</div>

	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	<!-- ─── Register ───────────────────────────────────────────────────── -->
	<div class="ah-auth__panel ah-auth__panel--register">
		<h2 class="ah-auth__title"><?php esc_html_e( 'יצירת חשבון', 'alwayshere-child' ); ?></h2>

		<form method="post" class="ah-auth__form" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<div class="ah-auth__field">
				<label for="reg_email"><?php esc_html_e( 'אימייל', 'alwayshere-child' ); ?> <span class="ah-auth__required">*</span></label>
				<input
					type="email"
					id="reg_email"
					name="email"
					autocomplete="email"
					value="<?php echo isset( $_POST['email'] ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"
					required
				/>
			</div>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
			<div class="ah-auth__field">
				<label for="reg_password"><?php esc_html_e( 'סיסמה', 'alwayshere-child' ); ?> <span class="ah-auth__required">*</span></label>
				<input
					type="password"
					id="reg_password"
					name="password"
					autocomplete="new-password"
					required
				/>
			</div>
			<?php else : ?>
			<p class="ah-auth__hint"><?php esc_html_e( 'קישור ליצירת סיסמה יישלח לאימייל שלך.', 'alwayshere-child' ); ?></p>
			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="ah-auth__privacy">
				<?php
				/* translators: %s: privacy policy link */
				printf(
					esc_html__( 'ביצירת חשבון הינך מסכימ/ה ל%s.', 'alwayshere-child' ),
					'<a href="' . esc_url( get_privacy_policy_url() ) . '">' . esc_html__( 'מדיניות הפרטיות', 'alwayshere-child' ) . '</a>'
				);
				?>
			</p>

			<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

			<button type="submit" class="ah-auth__submit" name="register" value="<?php esc_attr_e( 'הרשמה', 'alwayshere-child' ); ?>">
				<?php esc_html_e( 'יצירת חשבון', 'alwayshere-child' ); ?>
			</button>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
	</div>

	</div><!-- .ah-auth__cols -->
	<?php endif; ?>

</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
