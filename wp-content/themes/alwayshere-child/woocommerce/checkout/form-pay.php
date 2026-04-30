<?php
/**
 * Pay for order form — custom override.
 *
 * WC template override: woocommerce/templates/checkout/form-pay.php
 *
 * @package alwayshere-child
 * @version 8.2.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals();
?>

<div class="ah-order-pay">
<div class="ah-container">

	<!-- Page title -->
	<div class="ah-order-pay-title">
		<div class="ah-order-pay-title__icon" aria-hidden="true">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
				<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
				<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
			</svg>
		</div>
		<h1><?php esc_html_e( 'השלמת תשלום', 'alwayshere-child' ); ?></h1>
		<p>
			<?php esc_html_e( 'סיום הרכישה עבור הזמנה מספר', 'alwayshere-child' ); ?>
			<strong>#<?php echo esc_html( $order->get_order_number() ); ?></strong>
		</p>
	</div>

	<!-- Order summary card -->
	<div class="ah-order-pay__card">

		<div class="ah-order-pay__meta">
			<div class="ah-order-pay__meta-item">
				<span class="ah-order-pay__meta-label"><?php esc_html_e( 'מספר הזמנה', 'alwayshere-child' ); ?></span>
				<span class="ah-order-pay__meta-value"><?php echo esc_html( $order->get_order_number() ); ?></span>
			</div>
			<div class="ah-order-pay__meta-item">
				<span class="ah-order-pay__meta-label"><?php esc_html_e( 'תאריך', 'alwayshere-child' ); ?></span>
				<span class="ah-order-pay__meta-value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
			</div>
			<div class="ah-order-pay__meta-item ah-order-pay__meta-item--total">
				<span class="ah-order-pay__meta-label"><?php esc_html_e( 'סך הכל לתשלום', 'alwayshere-child' ); ?></span>
				<span class="ah-order-pay__meta-value"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
			</div>
		</div>

		<?php if ( $order->get_items() ) : ?>
		<table class="ah-order-pay__items">
			<thead>
				<tr>
					<th><?php esc_html_e( 'מוצר', 'alwayshere-child' ); ?></th>
					<th class="ah-order-pay__qty"><?php esc_html_e( 'כמות', 'alwayshere-child' ); ?></th>
					<th class="ah-order-pay__price"><?php esc_html_e( 'מחיר', 'alwayshere-child' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $order->get_items() as $item_id => $item ) : ?>
					<?php if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) { continue; } ?>
					<tr>
						<td>
							<?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) ); ?>
							<?php do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false ); ?>
							<?php wc_display_item_meta( $item ); ?>
							<?php do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false ); ?>
						</td>
						<td class="ah-order-pay__qty"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', '&times;&nbsp;' . esc_html( $item->get_quantity() ), $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<td class="ah-order-pay__price"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>

	</div><!-- .ah-order-pay__card -->

	<!-- Payment form -->
	<form id="order_review" method="post" class="ah-order-pay__form">

		<?php do_action( 'woocommerce_pay_order_before_payment' ); ?>

		<div id="payment">
			<?php if ( $order->needs_payment() ) : ?>
				<ul class="wc_payment_methods payment_methods methods">
					<?php
					if ( ! empty( $available_gateways ) ) {
						foreach ( $available_gateways as $gateway ) {
							wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
						}
					} else {
						echo '<li>';
						wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ), 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
						echo '</li>';
					}
					?>
				</ul>
			<?php endif; ?>

			<div class="form-row">
				<input type="hidden" name="woocommerce_pay" value="1" />
				<?php wc_get_template( 'checkout/terms.php' ); ?>
				<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>
				<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt ah-btn--primary" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>
				<?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
			</div>
		</div>

	</form><!-- .ah-order-pay__form -->

	<!-- Trust / security badges -->
	<div class="ah-order-pay__trust" role="complementary" aria-label="<?php esc_attr_e( 'אמצעי אבטחה', 'alwayshere-child' ); ?>">
		<div class="ah-order-pay__trust-badges">
			<div class="ah-order-pay__trust-badge">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
					<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
				</svg>
				<span><?php esc_html_e( 'תשלום מאובטח', 'alwayshere-child' ); ?></span>
			</div>
			<div class="ah-order-pay__trust-badge">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
					<polyline points="9 12 11 14 15 10"></polyline>
				</svg>
				<span><?php esc_html_e( 'הצפנת SSL 256-bit', 'alwayshere-child' ); ?></span>
			</div>
			<div class="ah-order-pay__trust-badge">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<circle cx="12" cy="12" r="10"></circle>
					<polyline points="9 12 11 14 15 10"></polyline>
				</svg>
				<span><?php esc_html_e( 'פרטיך מוגנים', 'alwayshere-child' ); ?></span>
			</div>
		</div>
		<div class="ah-order-pay__trust-cards">
			<span class="ah-order-pay__trust-card ah-order-pay__trust-card--visa">VISA</span>
			<span class="ah-order-pay__trust-card ah-order-pay__trust-card--mc">MC</span>
			<span class="ah-order-pay__trust-card ah-order-pay__trust-card--amex">AMEX</span>
			<span class="ah-order-pay__trust-card ah-order-pay__trust-card--bit">bit</span>
		</div>
	</div><!-- .ah-order-pay__trust -->

</div><!-- .ah-container -->
</div><!-- .ah-order-pay -->
