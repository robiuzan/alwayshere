<?php
/**
 * My Account — Order history (card-based layout).
 *
 * WC template override: woocommerce/templates/myaccount/orders.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders );

if ( $has_orders ) : ?>

<div class="ah-orders">

	<h2 class="ah-orders__title"><?php esc_html_e( 'היסטוריית הזמנות', 'alwayshere-child' ); ?></h2>

	<div class="ah-orders__list">
		<?php foreach ( $customer_orders->orders as $customer_order ) :
			$order      = wc_get_order( $customer_order );
			$order_id   = $order->get_id();
			$item_count = $order->get_item_count();
			$items      = $order->get_items();
			?>
			<div class="ah-order-card">

				<div class="ah-order-card__header">
					<div class="ah-order-card__id">
						<?php
						/* translators: %s: order number */
						echo esc_html( sprintf( 'הזמנה #%s', $order->get_order_number() ) );
						?>
					</div>
					<?php
					$status_label = wc_get_order_status_name( $order->get_status() );
					?>
					<span class="ah-order-card__status ah-order-card__status--<?php echo esc_attr( $order->get_status() ); ?>">
						<?php echo esc_html( $status_label ); ?>
					</span>
				</div>

				<div class="ah-order-card__meta">
					<span class="ah-order-card__date">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" width="16" height="16" aria-hidden="true">
							<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
						</svg>
						<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
					</span>
					<span class="ah-order-card__total">
						<?php
						/* translators: %s: formatted order total */
						echo wp_kses_post( sprintf( 'סה"כ: %s', $order->get_formatted_order_total() ) );
						?>
					</span>
					<span class="ah-order-card__items-count">
						<?php
						/* translators: %d: item count */
						echo esc_html( sprintf( '%d פריטים', $item_count ) );
						?>
					</span>
				</div>

				<!-- Item thumbnails -->
				<div class="ah-order-card__thumbs">
					<?php
					$shown = 0;
					foreach ( $items as $item ) :
						if ( $shown >= 4 ) break;
						$product = $item->get_product();
						if ( ! $product ) continue;
						?>
						<div class="ah-order-card__thumb">
							<?php echo $product->get_image( 'woocommerce_gallery_thumbnail', [ 'class' => 'ah-order-card__thumb-img' ] ); ?>
						</div>
						<?php
						$shown++;
					endforeach;

					$remaining = $item_count - $shown;
					if ( $remaining > 0 ) :
						?>
						<div class="ah-order-card__thumb ah-order-card__thumb--more">
							<?php
							/* translators: %d: number of additional items */
							echo esc_html( sprintf( '+%d', $remaining ) );
							?>
						</div>
					<?php endif; ?>
				</div>

				<div class="ah-order-card__actions">
					<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="ah-btn ah-btn--outline ah-btn--sm">
						<?php esc_html_e( 'צפה בהזמנה', 'alwayshere-child' ); ?>
					</a>
					<?php if ( $order->has_status( 'completed' ) ) : ?>
						<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order_id, wc_get_cart_url() ), 'woocommerce-order_again' ) ); ?>" class="ah-btn ah-btn--primary ah-btn--sm">
							<?php esc_html_e( 'הזמן שוב', 'alwayshere-child' ); ?>
						</a>
					<?php endif; ?>
				</div>

			</div>
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="ah-orders__pagination">
			<?php
			echo paginate_links( [ // phpcs:ignore WordPress.Security.EscapeOutput
				'base'    => esc_url( wc_get_endpoint_url( 'orders', '%_%' ) ),
				'format'  => '%#%',
				'current' => max( 1, $current_page ),
				'total'   => $customer_orders->max_num_pages,
				'type'    => 'list',
			] );
			?>
		</div>
	<?php endif; ?>

</div>

<?php else : ?>

<div class="ah-orders ah-orders--empty">
	<div class="ah-orders__empty-state">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64" aria-hidden="true">
			<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
		</svg>
		<h3><?php esc_html_e( 'אין הזמנות עדיין', 'alwayshere-child' ); ?></h3>
		<p><?php esc_html_e( 'עוד לא ביצעתם הזמנות. הגיע הזמן למצוא מתנה מושלמת!', 'alwayshere-child' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-btn ah-btn--primary">
			<?php esc_html_e( 'לחנות', 'alwayshere-child' ); ?>
		</a>
	</div>
</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
