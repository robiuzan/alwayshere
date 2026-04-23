<?php
/**
 * Account tab: Recently Viewed products grid.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

$recently_viewed_ids = class_exists( 'Alwayshere_Recently_Viewed' ) ? Alwayshere_Recently_Viewed::get( 20 ) : [];
?>

<div class="ah-recently-viewed">

	<h2 class="ah-recently-viewed__title"><?php esc_html_e( 'נצפו לאחרונה', 'alwayshere-child' ); ?></h2>

	<?php if ( ! empty( $recently_viewed_ids ) ) : ?>

		<div class="ah-recently-viewed__grid">
			<?php foreach ( $recently_viewed_ids as $pid ) :
				$product = wc_get_product( $pid );
				if ( ! $product || 'publish' !== $product->get_status() ) continue;
				?>
				<div class="ah-recently-viewed__card">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="ah-recently-viewed__card-link">
						<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'ah-recently-viewed__card-img' ] ); ?>
						<h3 class="ah-recently-viewed__card-name"><?php echo esc_html( $product->get_name() ); ?></h3>
						<span class="ah-recently-viewed__card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					</a>
				</div>
			<?php endforeach; ?>
		</div>

	<?php else : ?>

		<div class="ah-recently-viewed__empty">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64" aria-hidden="true">
				<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
			</svg>
			<h3><?php esc_html_e( 'עדיין לא צפיתם במוצרים', 'alwayshere-child' ); ?></h3>
			<p><?php esc_html_e( 'גלו את המתנות האישיות שלנו — הם יופיעו כאן.', 'alwayshere-child' ); ?></p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-btn ah-btn--primary">
				<?php esc_html_e( 'לחנות', 'alwayshere-child' ); ?>
			</a>
		</div>

	<?php endif; ?>

</div>
