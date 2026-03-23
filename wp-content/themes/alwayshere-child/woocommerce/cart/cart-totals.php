<?php
/**
 * Cart totals — Hebrew redesign.
 *
 * WC template override: woocommerce/templates/cart/cart-totals.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="ah-cart-summary cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<h2 class="ah-cart-summary__title"><?php esc_html_e( 'סיכום הזמנה', 'alwayshere-child' ); ?></h2>

	<dl class="ah-cart-summary__rows">

		<!-- Subtotal -->
		<div class="ah-cart-summary__row">
			<dt><?php esc_html_e( 'סכום ביניים', 'alwayshere-child' ); ?></dt>
			<dd><?php wc_cart_totals_subtotal_html(); ?></dd>
		</div>

		<!-- Coupons -->
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="ah-cart-summary__row ah-cart-summary__row--coupon">
				<dt>
					<?php esc_html_e( 'קופון:', 'alwayshere-child' ); ?>
					<span class="ah-cart-summary__coupon-code"><?php echo esc_html( wc_cart_totals_coupon_label( $coupon, false ) ); ?></span>
					<a href="<?php echo esc_url( add_query_arg( 'remove_coupon', rawurlencode( $code ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ); ?>" class="ah-cart-summary__remove-coupon" aria-label="<?php esc_attr_e( 'הסר קופון', 'alwayshere-child' ); ?>">✕</a>
				</dt>
				<dd class="ah-cart-summary__discount"><?php wc_cart_totals_coupon_html( $coupon ); ?></dd>
			</div>
		<?php endforeach; ?>

		<!-- Shipping -->
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<div class="ah-cart-summary__row ah-cart-summary__row--shipping">
				<dt><?php esc_html_e( 'משלוח', 'alwayshere-child' ); ?></dt>
				<dd>
					<?php wc_cart_totals_shipping_html(); ?>
				</dd>
			</div>
		<?php elseif ( WC()->cart->needs_shipping() ) : ?>
			<div class="ah-cart-summary__row ah-cart-summary__row--shipping">
				<dt><?php esc_html_e( 'משלוח', 'alwayshere-child' ); ?></dt>
				<dd>
					<span class="ah-cart-summary__shipping-note">
						<?php esc_html_e( 'יחושב בסיום הרכישה', 'alwayshere-child' ); ?>
					</span>
					<?php wc_cart_totals_shipping_html(); ?>
				</dd>
			</div>
		<?php endif; ?>

		<!-- Fees -->
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="ah-cart-summary__row">
				<dt><?php echo esc_html( $fee->name ); ?></dt>
				<dd><?php wc_cart_totals_fee_html( $fee ); ?></dd>
			</div>
		<?php endforeach; ?>

		<!-- Tax (if shown separately) -->
		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->get_tax_price_display_mode() ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'single' ) : ?>
				<div class="ah-cart-summary__row">
					<dt><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></dt>
					<dd><?php wc_cart_totals_taxes_total_html(); ?></dd>
				</div>
			<?php elseif ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="ah-cart-summary__row">
						<dt><?php echo esc_html( $tax->label ); ?></dt>
						<dd><?php echo wp_kses_post( $tax->formatted_amount ); ?></dd>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<!-- Total -->
		<div class="ah-cart-summary__row ah-cart-summary__row--total">
			<dt><?php esc_html_e( 'סה"כ לתשלום', 'alwayshere-child' ); ?></dt>
			<dd><?php wc_cart_totals_order_total_html(); ?></dd>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</dl>

	<!-- Free shipping progress bar -->
	<?php
	$free_shipping_threshold = 199;
	$cart_total = WC()->cart->get_subtotal();
	$remaining  = $free_shipping_threshold - $cart_total;
	?>
	<?php if ( $remaining > 0 ) : ?>
		<div class="ah-cart-shipping-bar">
			<p class="ah-cart-shipping-bar__text">
				<?php
				echo wp_kses_post( sprintf(
					/* translators: %s = amount remaining for free shipping */
					__( 'הוסף עוד <strong>₪%s</strong> לקבלת משלוח חינם', 'alwayshere-child' ),
					number_format( $remaining, 0 )
				) );
				?>
			</p>
			<div class="ah-cart-shipping-bar__track">
				<div class="ah-cart-shipping-bar__fill" style="width: <?php echo esc_attr( min( 100, round( ( $cart_total / $free_shipping_threshold ) * 100 ) ) ); ?>%"></div>
			</div>
		</div>
	<?php else : ?>
		<div class="ah-cart-shipping-bar ah-cart-shipping-bar--reached">
			<p class="ah-cart-shipping-bar__text">
				🎉 <?php esc_html_e( 'כל הכבוד — מגיע לך משלוח חינם!', 'alwayshere-child' ); ?>
			</p>
		</div>
	<?php endif; ?>

	<!-- Checkout button -->
	<div class="ah-cart-summary__checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<!-- Trust micro-badges -->
	<ul class="ah-cart-summary__trust">
		<li>🔒 <?php esc_html_e( 'תשלום מאובטח', 'alwayshere-child' ); ?></li>
		<li>🔄 <?php esc_html_e( 'החזרה תוך 30 יום', 'alwayshere-child' ); ?></li>
		<li>🚚 <?php esc_html_e( 'משלוח עד 3 ימי עסקים', 'alwayshere-child' ); ?></li>
	</ul>

</div><!-- .ah-cart-summary -->
