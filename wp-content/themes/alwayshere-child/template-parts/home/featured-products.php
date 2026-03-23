<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$products = wc_get_products( [
	'status'   => 'publish',
	'featured' => true,
	'limit'    => 4,
	'orderby'  => 'date',
	'order'    => 'DESC',
] );

// Use dummy cards when no featured products are set yet.
$use_dummy = empty( $products );

$eyebrow   = get_field( 'featured_eyebrow' )   ?: __( 'מבצעי היום', 'alwayshere-child' );
$title     = get_field( 'featured_title' )     ?: __( 'הצעות מיוחדות', 'alwayshere-child' );
$sub       = get_field( 'featured_sub' )       ?: __( 'מבצעים מוגבלים בזמן — אל תפספסו!', 'alwayshere-child' );
$cta_label = get_field( 'featured_cta_label' ) ?: __( 'לכל המוצרים', 'alwayshere-child' );
?>

<section class="ah-section ah-section--gray" aria-label="<?php echo esc_attr( $title ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="ah-section-header__title"><?php echo esc_html( $title ); ?></h2>
			<p class="ah-section-header__sub"><?php echo esc_html( $sub ); ?></p>
		</div>

		<div class="ah-products-grid">
			<?php if ( $use_dummy ) :
				$dummy_products = [
					[ 'name' => 'ספל קרמיקה מודפס', 'desc' => 'הדפסה אישית עם שם, תאריך או ציטוט', 'price' => '₪89', 'sale' => '₪119' ],
					[ 'name' => 'כרית רקומה בהתאמה אישית', 'desc' => 'רקמה מיוחדת על בד איכותי לפי בחירתכם', 'price' => '₪149', 'sale' => '₪199' ],
					[ 'name' => 'פנס עץ חרוט', 'desc' => 'חריטת לייזר עם הקדשה אישית', 'price' => '₪69', 'sale' => '₪99' ],
					[ 'name' => 'לוח שעם אישי', 'desc' => 'עיצוב אישי עם שמות ותאריכים', 'price' => '₪109', 'sale' => '' ],
				];
				$placeholder = wc_placeholder_img_src( 'woocommerce_thumbnail' );
				foreach ( $dummy_products as $dummy ) : ?>
					<div class="ah-card">
						<div class="ah-card__img">
							<img class="ah-card__img-main" src="<?php echo esc_url( $placeholder ); ?>" alt="<?php echo esc_attr( $dummy['name'] ); ?>" width="500" height="240" loading="lazy">
							<div class="ah-card__overlay">
								<span class="ah-card__overlay-btn">
									<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
									<?php esc_html_e( 'לעמוד מוצר', 'alwayshere-child' ); ?>
								</span>
							</div>
						</div>
						<div class="ah-card__body">
							<div class="ah-card__name"><?php echo esc_html( $dummy['name'] ); ?></div>
							<div class="ah-card__desc"><?php echo esc_html( $dummy['desc'] ); ?></div>
							<div class="ah-card__price-row">
								<span class="ah-card__price">
									<?php if ( $dummy['sale'] ) : ?>
										<del><?php echo esc_html( $dummy['sale'] ); ?></del>
									<?php endif; ?>
									<?php echo esc_html( $dummy['price'] ); ?>
								</span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
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
					$desc = wp_trim_words( $product->get_short_description() ?: $product->get_description(), 10, '...' );
				?>
					<a href="<?php echo esc_url( $product_url ); ?>" class="ah-card">
						<div class="ah-card__img">
							<img class="ah-card__img-main" src="<?php echo esc_url( $main_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" width="500" height="240" loading="lazy">
							<?php if ( $hover_url ) : ?>
								<img class="ah-card__img-hover" src="<?php echo esc_url( $hover_url ); ?>" alt="" width="500" height="240" loading="lazy" aria-hidden="true">
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
							<?php if ( $desc ) : ?>
								<div class="ah-card__desc"><?php echo esc_html( $desc ); ?></div>
							<?php endif; ?>
							<div class="ah-card__price-row">
								<span class="ah-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="ah-section-footer">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ah-btn ah-btn--outline">
				<?php echo esc_html( $cta_label ); ?>
			</a>
		</div>
	</div>
</section>
