<?php
/**
 * Checkout form — Hebrew redesign.
 *
 * WC template override: woocommerce/templates/checkout/form-checkout.php
 *
 * @package alwayshere-child
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'יש להתחבר לחשבון כדי להמשיך לתשלום.', 'alwayshere-child' ) ) );
	return;
}
?>

<div class="ah-checkout-page">
<div class="ah-container">

	<!-- Breadcrumb / progress steps -->
	<div class="ah-checkout-steps" aria-label="<?php esc_attr_e( 'שלבי הרכישה', 'alwayshere-child' ); ?>">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="ah-checkout-steps__step ah-checkout-steps__step--done">
			<span class="ah-checkout-steps__num">1</span>
			<span class="ah-checkout-steps__label"><?php esc_html_e( 'עגלה', 'alwayshere-child' ); ?></span>
		</a>
		<span class="ah-checkout-steps__divider" aria-hidden="true"></span>
		<span class="ah-checkout-steps__step ah-checkout-steps__step--active" aria-current="step">
			<span class="ah-checkout-steps__num">2</span>
			<span class="ah-checkout-steps__label"><?php esc_html_e( 'פרטים ותשלום', 'alwayshere-child' ); ?></span>
		</span>
		<span class="ah-checkout-steps__divider" aria-hidden="true"></span>
		<span class="ah-checkout-steps__step">
			<span class="ah-checkout-steps__num">3</span>
			<span class="ah-checkout-steps__label"><?php esc_html_e( 'אישור הזמנה', 'alwayshere-child' ); ?></span>
		</span>
	</div>

	<form
		name="checkout"
		method="post"
		class="ah-checkout woocommerce-checkout"
		action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
		enctype="multipart/form-data"
		aria-label="<?php esc_attr_e( 'טופס תשלום', 'alwayshere-child' ); ?>"
	>

		<div class="ah-checkout__layout">

			<!-- ── Left column: customer details ─────────────────────────── -->
			<div class="ah-checkout__main">

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<!-- Login notice (if any) -->
				<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<!-- Billing section -->
					<section class="ah-checkout-section" id="customer_details">
						<h2 class="ah-checkout-section__title">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
							</svg>
							<?php esc_html_e( 'פרטי לקוח', 'alwayshere-child' ); ?>
						</h2>
						<div class="ah-checkout-section__body">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					</section>

					<!-- Shipping section -->
					<?php if ( WC()->cart->needs_shipping_address() ) : ?>
					<section class="ah-checkout-section" id="shipping_details">
						<h2 class="ah-checkout-section__title">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
								<rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
							</svg>
							<?php esc_html_e( 'כתובת משלוח', 'alwayshere-child' ); ?>
						</h2>
						<div class="ah-checkout-section__body">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</section>
					<?php endif; ?>

				<?php endif; ?>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<!-- Coupon -->
				<?php if ( wc_coupons_enabled() && ! WC()->cart->get_coupons() ) : ?>
				<section class="ah-checkout-section ah-checkout-section--coupon">
					<button type="button" class="ah-checkout-coupon-toggle" aria-expanded="false" aria-controls="ah-checkout-coupon-form">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
							<path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
						</svg>
						<?php esc_html_e( 'יש לך קוד קופון?', 'alwayshere-child' ); ?>
						<span class="ah-checkout-coupon-toggle__arrow" aria-hidden="true">›</span>
					</button>
					<div id="ah-checkout-coupon-form" class="ah-checkout-coupon-form" hidden>
						<div class="ah-checkout-coupon-form__row">
							<input
								type="text"
								id="ah_coupon_code"
								name="coupon_code"
								class="input-text"
								placeholder="<?php esc_attr_e( 'הכנס קוד קופון', 'alwayshere-child' ); ?>"
							>
							<button type="submit" class="button ah-btn ah-btn--outline" name="apply_coupon" value="<?php esc_attr_e( 'החל', 'alwayshere-child' ); ?>">
								<?php esc_html_e( 'החל', 'alwayshere-child' ); ?>
							</button>
						</div>
					</div>
				</section>
				<?php endif; ?>

				<!-- Order notes -->
				<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
					<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
						<section class="ah-checkout-section ah-checkout-section--notes" id="order_notes_section">
							<h2 class="ah-checkout-section__title">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
									<path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
								</svg>
								<?php esc_html_e( 'הערות להזמנה', 'alwayshere-child' ); ?>
							</h2>
							<div class="ah-checkout-section__body">
								<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
									<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>
				<?php endif; ?>

			</div><!-- .ah-checkout__main -->

			<!-- ── Right column: order summary + payment ─────────────────── -->
			<div class="ah-checkout__sidebar">

				<div class="ah-checkout-summary">

					<!-- Order review heading -->
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<h2 class="ah-checkout-summary__title" id="order_review_heading">
						<?php esc_html_e( 'סיכום הזמנה', 'alwayshere-child' ); ?>
					</h2>
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

					<!-- Trust micro-badges -->
					<ul class="ah-checkout-trust">
						<li>🔒 <?php esc_html_e( 'תשלום מאובטח 100%', 'alwayshere-child' ); ?></li>
						<li>🔄 <?php esc_html_e( 'החזרה תוך 30 יום', 'alwayshere-child' ); ?></li>
						<li>🚚 <?php esc_html_e( 'משלוח מהיר עד 3 ימי עסקים', 'alwayshere-child' ); ?></li>
					</ul>

				</div><!-- .ah-checkout-summary -->

			</div><!-- .ah-checkout__sidebar -->

		</div><!-- .ah-checkout__layout -->

	</form>

</div><!-- .ah-container -->
</div><!-- .ah-checkout-page -->

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
