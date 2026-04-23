<?php
/**
 * Account tab: Favorites grid.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

$user_id      = get_current_user_id();
$favorite_ids = class_exists( 'Alwayshere_Favorites' ) ? Alwayshere_Favorites::get_all( $user_id ) : [];
?>

<div class="ah-favorites">

	<h2 class="ah-favorites__title"><?php esc_html_e( 'המועדפים שלי', 'alwayshere-child' ); ?></h2>

	<?php if ( ! empty( $favorite_ids ) ) : ?>

		<div class="ah-favorites__grid">
			<?php foreach ( $favorite_ids as $pid ) :
				$product = wc_get_product( $pid );
				if ( ! $product || 'publish' !== $product->get_status() ) continue;
				?>
				<div class="ah-favorites__card">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="ah-favorites__card-link">
						<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'ah-favorites__card-img' ] ); ?>
						<h3 class="ah-favorites__card-name"><?php echo esc_html( $product->get_name() ); ?></h3>
						<span class="ah-favorites__card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					</a>
					<button
						class="ah-fav-btn ah-fav-btn--active ah-fav-btn--in-grid"
						data-product-id="<?php echo esc_attr( $pid ); ?>"
						data-product-name="<?php echo esc_attr( $product->get_name() ); ?>"
						data-product-price="<?php echo esc_attr( $product->get_price() ); ?>"
						aria-pressed="true"
						aria-label="<?php esc_attr_e( 'הסר ממועדפים', 'alwayshere-child' ); ?>"
						type="button"
					>
						<svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
							<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
						</svg>
					</button>
				</div>
			<?php endforeach; ?>
		</div>

	<?php else : ?>

		<div class="ah-favorites__empty">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64" aria-hidden="true">
				<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
			</svg>
			<h3><?php esc_html_e( 'עדיין לא שמרת מועדפים', 'alwayshere-child' ); ?></h3>
			<p><?php esc_html_e( 'לחצו על ❤ ליד מוצרים שאהבתם כדי לשמור אותם כאן.', 'alwayshere-child' ); ?></p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-btn ah-btn--primary">
				<?php esc_html_e( 'לחנות', 'alwayshere-child' ); ?>
			</a>
		</div>

	<?php endif; ?>

</div>
