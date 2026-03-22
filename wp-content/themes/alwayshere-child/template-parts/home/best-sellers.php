<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$products = wc_get_products( [
	'status'  => 'publish',
	'limit'   => 4,
	'orderby' => 'popularity',
	'order'   => 'DESC',
] );

if ( empty( $products ) ) return;

$eyebrow = get_field( 'bestsellers_eyebrow' ) ?: __( 'הנמכרים ביותר', 'alwayshere-child' );
$title   = get_field( 'bestsellers_title' )   ?: __( 'המוצרים הכי אהובים', 'alwayshere-child' );
$sub     = get_field( 'bestsellers_sub' )     ?: __( 'הלקוחות שלנו כבר בחרו — מוצרים שתמיד פוגעים בנקודה', 'alwayshere-child' );
?>

<section class="ah-section" aria-label="<?php echo esc_attr( $title ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="ah-section-header__title"><?php echo esc_html( $title ); ?></h2>
			<p class="ah-section-header__sub"><?php echo esc_html( $sub ); ?></p>
		</div>

		<div class="ah-products-grid">
			<?php foreach ( $products as $product ) :
				$product_id   = $product->get_id();
				$product_url  = get_permalink( $product_id );
				$main_img_id  = $product->get_image_id();
				$gallery_ids  = $product->get_gallery_image_ids();
				$hover_img_id = ! empty( $gallery_ids ) ? $gallery_ids[0] : null;
				$main_url     = $main_img_id
					? wp_get_attachment_image_url( $main_img_id, 'woocommerce_thumbnail' )
					: wc_placeholder_img_src();
				$hover_url    = $hover_img_id
					? wp_get_attachment_image_url( $hover_img_id, 'woocommerce_thumbnail' )
					: null;
			?>
				<a href="<?php echo esc_url( $product_url ); ?>" class="ah-card">
					<div class="ah-card__img">
						<img
							class="ah-card__img-main"
							src="<?php echo esc_url( $main_url ); ?>"
							alt="<?php echo esc_attr( $product->get_name() ); ?>"
							width="500"
							height="240"
							loading="lazy"
						>
						<?php if ( $hover_url ) : ?>
							<img
								class="ah-card__img-hover"
								src="<?php echo esc_url( $hover_url ); ?>"
								alt=""
								width="500"
								height="240"
								loading="lazy"
								aria-hidden="true"
							>
						<?php endif; ?>
						<div class="ah-card__overlay">
							<span class="ah-card__overlay-btn">
								<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
								<?php esc_html_e( 'לעמוד מוצר', 'alwayshere-child' ); ?>
							</span>
						</div>
					</div>
					<div class="ah-card__body">
						<div class="ah-card__name"><?php echo esc_html( $product->get_name() ); ?></div>
						<div class="ah-card__price-row">
							<span class="ah-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
