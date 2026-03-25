<?php
/**
 * Cart page — full redesign.
 *
 * WC template override: woocommerce/templates/cart/cart.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<div class="ah-cart-page">
<div class="ah-container">

	<header class="ah-cart-page__header">
		<h1 class="ah-cart-page__title">
			<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
				<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
				<path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
			</svg>
			<?php esc_html_e( 'עגלת הקניות', 'alwayshere-child' ); ?>
		</h1>
		<?php
		$count = WC()->cart->get_cart_contents_count();
		if ( $count > 0 ) :
			echo '<span class="ah-cart-page__count">';
			echo esc_html( sprintf(
				_n( 'פריט אחד', '%d פריטים', $count, 'alwayshere-child' ),
				$count
			) );
			echo '</span>';
		endif;
		?>
	</header>

	<?php if ( WC()->cart->is_empty() ) : ?>

		<div class="ah-cart-empty">
			<span class="ah-cart-empty__icon" aria-hidden="true">🛒</span>
			<h2 class="ah-cart-empty__title"><?php esc_html_e( 'העגלה שלך ריקה', 'alwayshere-child' ); ?></h2>
			<p class="ah-cart-empty__sub"><?php esc_html_e( 'נראה שעדיין לא הוספת מוצרים לעגלה.', 'alwayshere-child' ); ?></p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-btn ah-btn--primary">
				<?php esc_html_e( 'חזרה לחנות', 'alwayshere-child' ); ?>
			</a>
			<?php do_action( 'woocommerce_cart_is_empty' ); ?>
		</div>

	<?php else : ?>

	<div class="ah-cart-page__layout">

		<!-- ── Cart items column ─────────────────────────────────── -->
		<div class="ah-cart-page__items-col">

			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<div class="ah-cart-items" role="list" aria-label="<?php esc_attr_e( 'פריטים בעגלה', 'alwayshere-child' ); ?>">

					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :

						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( ! $_product || ! $_product->exists() || 0 >= $cart_item['quantity'] ) continue;
						if ( ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) continue;

						$permalink      = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						$thumbnail      = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
						$price          = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						$subtotal       = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						$product_name   = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
						$row_class      = esc_attr( apply_filters( 'woocommerce_cart_item_class', 'ah-cart-item', $cart_item, $cart_item_key ) );

						$is_hidden = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ? '' : 'style="display:none"';
					?>

					<div class="<?php echo $row_class; ?>" role="listitem" data-key="<?php echo esc_attr( $cart_item_key ); ?>" <?php echo $is_hidden; ?>>

						<!-- Product image -->
						<div class="ah-cart-item__img">
							<?php if ( $permalink ) : ?>
								<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
									<?php echo wp_kses_post( $thumbnail ); ?>
								</a>
							<?php else : ?>
								<?php echo wp_kses_post( $thumbnail ); ?>
							<?php endif; ?>
						</div>

						<!-- Product details -->
						<div class="ah-cart-item__details">

							<div class="ah-cart-item__name-row">
								<h3 class="ah-cart-item__name">
									<?php if ( $permalink ) : ?>
										<a href="<?php echo esc_url( $permalink ); ?>"><?php echo wp_kses_post( $product_name ); ?></a>
									<?php else : ?>
										<?php echo wp_kses_post( $product_name ); ?>
									<?php endif; ?>
								</h3>

								<!-- Remove button -->
								<?php
								$remove_link = apply_filters(
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="ah-cart-item__remove remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">
											<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
												<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
											</svg>
										</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s = product name */
										esc_attr( sprintf( __( 'הסר %s מהעגלה', 'alwayshere-child' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
								echo $remove_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>

							<!-- Variation / meta -->
							<?php
							$item_data = wc_get_formatted_cart_item_data( $cart_item );
							if ( $item_data ) :
							?>
								<dl class="ah-cart-item__meta">
									<?php echo wp_kses_post( $item_data ); ?>
								</dl>
							<?php endif; ?>

							<!-- Personalization data -->
							<?php if ( ! empty( $cart_item['alwayshere_personalization'] ) ) : ?>
								<dl class="ah-cart-item__personalization">
									<?php foreach ( $cart_item['alwayshere_personalization'] as $pf ) : ?>
										<div class="ah-cart-item__personalization-row">
											<dt><?php echo esc_html( $pf['label'] ); ?>:</dt>
											<dd><?php echo esc_html( $pf['value'] ); ?></dd>
										</div>
									<?php endforeach; ?>
								</dl>
							<?php endif; ?>

							<!-- Price + qty row (mobile: stacked; desktop: flex) -->
							<div class="ah-cart-item__bottom">

								<div class="ah-cart-item__qty-wrap">
									<label class="ah-cart-item__qty-label screen-reader-text" for="qty-<?php echo esc_attr( $cart_item_key ); ?>">
										<?php esc_html_e( 'כמות', 'alwayshere-child' ); ?>
									</label>
									<?php
									if ( $_product->is_sold_individually() ) {
										printf(
											'<div class="ah-cart-item__qty-solo">%s</div>',
											'1'
										);
									} else {
										woocommerce_quantity_input( [
											'input_id'   => 'qty-' . esc_attr( $cart_item_key ),
											'input_name' => "cart[{$cart_item_key}][qty]",
											'input_value'=> $cart_item['quantity'],
											'max_value'  => $_product->get_max_purchase_quantity(),
											'min_value'  => '1',
											'classes'    => [ 'input-text', 'qty', 'text' ],
										], $_product );
									}
									?>
								</div>

								<div class="ah-cart-item__prices">
									<span class="ah-cart-item__unit-price">
										<?php esc_html_e( 'מחיר יחידה', 'alwayshere-child' ); ?>:
										<?php echo wp_kses_post( $price ); ?>
									</span>
									<span class="ah-cart-item__subtotal">
										<?php echo wp_kses_post( $subtotal ); ?>
									</span>
								</div>

							</div><!-- .ah-cart-item__bottom -->

						</div><!-- .ah-cart-item__details -->

					</div><!-- .ah-cart-item -->

					<?php endforeach; ?>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>

				</div><!-- .ah-cart-items -->

				<!-- ── Coupon + update row ───────────────────────── -->
				<div class="ah-cart-actions">

					<?php if ( wc_coupons_enabled() ) : ?>
						<div class="ah-cart-coupon">
							<label for="coupon_code" class="screen-reader-text">
								<?php esc_html_e( 'קוד קופון', 'alwayshere-child' ); ?>
							</label>
							<input
								type="text"
								name="coupon_code"
								class="input-text ah-cart-coupon__input"
								id="coupon_code"
								value=""
								placeholder="<?php esc_attr_e( 'יש לך קוד קופון?', 'alwayshere-child' ); ?>"
							>
							<button type="submit" class="button ah-btn ah-btn--outline ah-cart-coupon__btn" name="apply_coupon" value="<?php esc_attr_e( 'החל קופון', 'alwayshere-child' ); ?>">
								<?php esc_html_e( 'החל קופון', 'alwayshere-child' ); ?>
							</button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php endif; ?>

					<button type="submit" class="button ah-btn ah-btn--ghost ah-cart-update-btn" name="update_cart" value="<?php esc_attr_e( 'עדכן עגלה', 'alwayshere-child' ); ?>">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
							<path d="M23 4v6h-6M1 20v-6h6"/>
							<path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
						</svg>
						<?php esc_html_e( 'עדכן עגלה', 'alwayshere-child' ); ?>
					</button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

				</div><!-- .ah-cart-actions -->

				<?php do_action( 'woocommerce_after_cart_table' ); ?>

			</form><!-- .woocommerce-cart-form -->

			<!-- Continue shopping -->
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-cart-continue">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
					<path d="M19 12H5M12 5l7 7-7 7"/>
				</svg>
				<?php esc_html_e( 'המשך לקנות', 'alwayshere-child' ); ?>
			</a>

		</div><!-- .ah-cart-page__items-col -->

		<!-- ── Order summary column ──────────────────────────────── -->
		<div class="ah-cart-page__summary-col">
			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>

	</div><!-- .ah-cart-page__layout -->

	<?php endif; // cart not empty ?>

</div><!-- .ah-container -->
</div><!-- .ah-cart-page -->

<?php do_action( 'woocommerce_after_cart' ); ?>
