<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$products = wc_get_products( [
	'status'   => 'publish',
	'featured' => true,
	'limit'    => 8,
	'orderby'  => 'date',
	'order'    => 'DESC',
] );

if ( empty( $products ) ) return;
?>

<section class="ah-products ah-products--featured" aria-label="<?php esc_attr_e( 'הצעות מיוחדות', 'alwayshere-child' ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php esc_html_e( 'בחירות העורכים', 'alwayshere-child' ); ?></span>
			<h2 class="ah-section-header__title"><?php esc_html_e( 'הצעות מיוחדות', 'alwayshere-child' ); ?></h2>
			<p class="ah-section-header__sub"><?php esc_html_e( 'מתנות שאנחנו הכי אוהבים — אישיות, יפות ומרגשות', 'alwayshere-child' ); ?></p>
		</div>

		<ul class="ah-products__grid" role="list">
			<?php foreach ( $products as $product ) :
				$product_id  = $product->get_id();
				$img_id      = $product->get_image_id();
				$img_url     = $img_id ? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
				$img_alt     = $img_id ? get_post_meta( $img_id, '_wp_attachment_image_alt', true ) : $product->get_name();
				$product_url = get_permalink( $product_id );
			?>
				<li class="ah-product-card" role="listitem">
					<a href="<?php echo esc_url( $product_url ); ?>" class="ah-product-card__link" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
						<figure class="ah-product-card__image-wrap">
							<img
								src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $img_alt ); ?>"
								width="300"
								height="300"
								loading="lazy"
								class="ah-product-card__image"
							>
							<?php if ( $product->is_on_sale() ) : ?>
								<span class="ah-product-card__badge ah-product-card__badge--sale"><?php esc_html_e( 'מבצע', 'alwayshere-child' ); ?></span>
							<?php endif; ?>
						</figure>
						<div class="ah-product-card__body">
							<h3 class="ah-product-card__name"><?php echo esc_html( $product->get_name() ); ?></h3>
							<div class="ah-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
						</div>
					</a>
					<div class="ah-product-card__footer">
						<?php
						woocommerce_template_loop_add_to_cart( [ 'product' => $product ] );
						?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="ah-section-footer">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-btn ah-btn--outline">
				<?php esc_html_e( 'לכל המוצרים', 'alwayshere-child' ); ?>
			</a>
		</div>
	</div>
</section>
