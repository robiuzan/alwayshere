<?php
/**
 * Checkout order review — Hebrew redesign.
 *
 * WC template override: woocommerce/templates/checkout/review-order.php
 *
 * @package alwayshere-child
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="ah-checkout-review">

	<!-- Items list -->
	<ul class="ah-checkout-review__items">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) continue;
			if ( ! apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) continue;

			$thumbnail = $_product->get_image( 'thumbnail' );
			$permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
		?>
		<li class="ah-checkout-review__item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
			<div class="ah-checkout-review__img">
				<?php if ( $permalink ) : ?>
					<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true"><?php echo wp_kses_post( $thumbnail ); ?></a>
				<?php else : ?>
					<?php echo wp_kses_post( $thumbnail ); ?>
				<?php endif; ?>
				<span class="ah-checkout-review__qty"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
			</div>
			<div class="ah-checkout-review__details">
				<span class="ah-checkout-review__name">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
				</span>
				<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php if ( ! empty( $cart_item['alwayshere_personalization'] ) ) : ?>
					<ul class="ah-checkout-review__personalization">
						<?php foreach ( $cart_item['alwayshere_personalization'] as $pf ) : ?>
							<li><strong><?php echo esc_html( $pf['label'] ); ?>:</strong> <?php echo esc_html( $pf['value'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<div class="ah-checkout-review__subtotal">
				<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</li>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
	</ul>

	<!-- Totals -->
	<dl class="ah-checkout-review__totals">

		<div class="ah-checkout-review__row">
			<dt><?php esc_html_e( 'סכום ביניים', 'alwayshere-child' ); ?></dt>
			<dd><?php wc_cart_totals_subtotal_html(); ?></dd>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="ah-checkout-review__row ah-checkout-review__row--discount">
				<dt>
					<?php esc_html_e( 'קופון:', 'alwayshere-child' ); ?>
					<span class="ah-checkout-review__coupon-code"><?php echo esc_html( wc_cart_totals_coupon_label( $coupon, false ) ); ?></span>
				</dt>
				<dd class="ah-checkout-review__discount"><?php wc_cart_totals_coupon_html( $coupon ); ?></dd>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<div class="ah-checkout-review__row">
				<dt><?php esc_html_e( 'משלוח', 'alwayshere-child' ); ?></dt>
				<dd><?php wc_cart_totals_shipping_html(); ?></dd>
			</div>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="ah-checkout-review__row">
				<dt><?php echo esc_html( $fee->name ); ?></dt>
				<dd><?php wc_cart_totals_fee_html( $fee ); ?></dd>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="ah-checkout-review__row">
						<dt><?php echo esc_html( $tax->label ); ?></dt>
						<dd><?php echo wp_kses_post( $tax->formatted_amount ); ?></dd>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="ah-checkout-review__row">
					<dt><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></dt>
					<dd><?php wc_cart_totals_taxes_total_html(); ?></dd>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="ah-checkout-review__row ah-checkout-review__row--total">
			<dt><?php esc_html_e( 'סה"כ לתשלום', 'alwayshere-child' ); ?></dt>
			<dd><?php wc_cart_totals_order_total_html(); ?></dd>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</dl>

</div><!-- .ah-checkout-review -->
