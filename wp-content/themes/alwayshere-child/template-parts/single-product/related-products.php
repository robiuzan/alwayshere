<?php
/**
 * Single product — related products section.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

$related_ids = wc_get_related_products( get_the_ID(), 4 );

if ( empty( $related_ids ) ) {
	return;
}
?>

<section class="ah-related ah--fade-in" aria-label="<?php esc_attr_e( 'מוצרים דומים', 'alwayshere-child' ); ?>">
	<div class="ah-container">

		<header class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php esc_html_e( 'אולי יעניין אותך גם', 'alwayshere-child' ); ?></span>
			<h2 class="ah-section-header__title"><?php esc_html_e( 'מוצרים דומים', 'alwayshere-child' ); ?></h2>
			<span class="ah-section-header__line" aria-hidden="true"></span>
		</header>

		<div class="ah-related__grid">
			<?php foreach ( $related_ids as $related_id ) :
				$related = wc_get_product( $related_id );
				if ( ! $related || ! $related->is_visible() ) continue;

				$thumb_url   = get_the_post_thumbnail_url( $related_id, 'medium' );
				$permalink   = get_permalink( $related_id );
				$title       = $related->get_name();
				$price_html  = $related->get_price_html();
				$avg_rating  = $related->get_average_rating();
				$is_on_sale  = $related->is_on_sale();
				$sale_pct    = '';

				if ( $is_on_sale ) {
					$regular = (float) $related->get_regular_price();
					$sale    = (float) $related->get_price();
					if ( $regular > 0 ) {
						$sale_pct = round( ( ( $regular - $sale ) / $regular ) * 100 );
					}
				}
			?>
				<article class="ah-related__card">

					<a href="<?php echo esc_url( $permalink ); ?>" class="ah-related__img-wrap" tabindex="-1" aria-hidden="true">
						<?php if ( $sale_pct ) : ?>
							<span class="ah-related__badge">-<?php echo esc_html( $sale_pct ); ?>%</span>
						<?php endif; ?>
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
						<?php else : ?>
							<img src="<?php echo esc_url( wc_placeholder_img_src( 'medium' ) ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
						<?php endif; ?>
					</a>

					<div class="ah-related__info">
						<h3 class="ah-related__title">
							<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
						</h3>

						<div class="ah-related__price">
							<?php echo wp_kses_post( $price_html ); ?>
						</div>

						<?php if ( $avg_rating ) : ?>
							<div class="ah-related__stars" aria-label="<?php echo esc_attr( sprintf( __( 'דירוג %s מתוך 5', 'alwayshere-child' ), $avg_rating ) ); ?>">
								<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
									<span aria-hidden="true"><?php echo $i <= round( (float) $avg_rating ) ? '★' : '☆'; ?></span>
								<?php endfor; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
