<?php
/**
 * Content for a single product.
 *
 * WC template override: woocommerce/templates/content-single-product.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'ah-sp-wrap', $product ); ?>>

	<?php /* ── Main 2-col product area ──────────────────────────────────── */ ?>
	<section class="ah-sp" aria-label="<?php esc_attr_e( 'פרטי המוצר', 'alwayshere-child' ); ?>">
		<div class="ah-container">
			<div class="ah-sp__layout">

				<?php /* Left column: product info + form */ ?>
				<div class="ah-sp__col-summary">
					<?php do_action( 'woocommerce_single_product_summary' ); ?>
					<hr class="ah-sp__divider" aria-hidden="true">
					<?php get_template_part( 'template-parts/single-product/trust-badges' ); ?>
				</div>

				<?php /* Right column: image gallery */ ?>
				<div class="ah-sp__col-gallery">
					<?php get_template_part( 'template-parts/single-product/gallery' ); ?>
				</div>

			</div>
		</div>
	</section>

	<?php /* ── Below-fold sections ─────────────────────────────────────── */ ?>
	<?php get_template_part( 'template-parts/single-product/why-us' ); ?>
	<?php get_template_part( 'template-parts/single-product/related-products' ); ?>

	<?php if ( comments_open() ) : ?>
		<?php get_template_part( 'template-parts/single-product/product-reviews' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_single_product' ); ?>

</div>
