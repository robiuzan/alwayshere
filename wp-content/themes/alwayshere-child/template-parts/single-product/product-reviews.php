<?php
/**
 * Single product — customer reviews section.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! wc_reviews_enabled() ) {
	return;
}

$avg_rating    = $product->get_average_rating();
$review_count  = $product->get_review_count();
$rating_counts = $product->get_rating_counts(); // [ '5' => n, '4' => n, ... ]

$reviews = get_comments( [
	'post_id' => get_the_ID(),
	'status'  => 'approve',
	'type'    => 'review',
	'number'  => 4,
	'orderby' => 'comment_date_gmt',
	'order'   => 'DESC',
] );

if ( ! $reviews && ! $avg_rating ) {
	return;
}
?>

<section class="ah-reviews ah--fade-in" id="reviews" aria-label="<?php esc_attr_e( 'ביקורות לקוחות', 'alwayshere-child' ); ?>">
	<div class="ah-container">

		<header class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php esc_html_e( 'ביקורות לקוחות', 'alwayshere-child' ); ?></span>
			<h2 class="ah-section-header__title"><?php esc_html_e( 'מה הלקוחות שלנו אומרים', 'alwayshere-child' ); ?></h2>
			<span class="ah-section-header__line" aria-hidden="true"></span>
		</header>

		<div class="ah-reviews__layout">

			<?php /* ── Score + rating bars ── */ ?>
			<aside class="ah-reviews__score" aria-label="<?php esc_attr_e( 'סיכום דירוגים', 'alwayshere-child' ); ?>">

				<p class="ah-reviews__score-number"><?php echo esc_html( number_format( (float) $avg_rating, 1 ) ); ?></p>

				<div class="ah-reviews__score-stars" aria-label="<?php echo esc_attr( sprintf( __( '%s מתוך 5 כוכבים', 'alwayshere-child' ), $avg_rating ) ); ?>">
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<span aria-hidden="true"><?php echo $i <= round( (float) $avg_rating ) ? '★' : '☆'; ?></span>
					<?php endfor; ?>
				</div>

				<p class="ah-reviews__score-total">
					<?php echo esc_html( sprintf( _n( '%d ביקורת', '%d ביקורות', $review_count, 'alwayshere-child' ), $review_count ) ); ?>
				</p>

				<?php if ( ! empty( $rating_counts ) ) : ?>
					<div class="ah-reviews__bars" role="list">
						<?php for ( $star = 5; $star >= 1; $star-- ) :
							$count = isset( $rating_counts[ $star ] ) ? (int) $rating_counts[ $star ] : 0;
							$pct   = $review_count > 0 ? round( ( $count / $review_count ) * 100 ) : 0;
						?>
							<div class="ah-reviews__bar-row" role="listitem">
								<span class="ah-reviews__bar-label"><?php echo esc_html( $star ); ?> ★</span>
								<div class="ah-reviews__bar-track" role="progressbar" aria-valuenow="<?php echo esc_attr( $pct ); ?>" aria-valuemin="0" aria-valuemax="100">
									<div class="ah-reviews__bar-fill" style="width: <?php echo esc_attr( $pct ); ?>%"></div>
								</div>
								<span class="ah-reviews__bar-count"><?php echo esc_html( $count ); ?></span>
							</div>
						<?php endfor; ?>
					</div>
				<?php endif; ?>

			</aside>

			<?php /* ── Review cards grid ── */ ?>
			<?php if ( $reviews ) : ?>
				<div class="ah-reviews__grid">
					<?php foreach ( $reviews as $review ) :
						$rating  = (int) get_comment_meta( $review->comment_ID, 'rating', true );
						$author  = $review->comment_author;
						$initial = mb_strtoupper( mb_substr( $author, 0, 1, 'UTF-8' ), 'UTF-8' );
						$date    = get_comment_date( 'j בF, Y', $review );
						$content = $review->comment_content;
						$excerpt = mb_strlen( $content, 'UTF-8' ) > 160
							? mb_substr( $content, 0, 160, 'UTF-8' ) . '...'
							: '';
					?>
						<article class="ah-reviews__card">

							<div class="ah-reviews__card-header">
								<span class="ah-reviews__avatar" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
								<div class="ah-reviews__reviewer">
									<strong><?php echo esc_html( $author ); ?></strong>
									<time datetime="<?php echo esc_attr( get_comment_date( 'c', $review ) ); ?>">
										<?php echo esc_html( $date ); ?>
									</time>
								</div>
							</div>

							<?php if ( $rating ) : ?>
								<div class="ah-reviews__card-stars" aria-label="<?php echo esc_attr( sprintf( __( '%d מתוך 5 כוכבים', 'alwayshere-child' ), $rating ) ); ?>">
									<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
										<span aria-hidden="true"><?php echo $i <= $rating ? '★' : '☆'; ?></span>
									<?php endfor; ?>
								</div>
							<?php endif; ?>

							<p class="ah-reviews__card-text">
								<?php echo esc_html( $excerpt ?: $content ); ?>
							</p>

							<?php if ( $excerpt ) : ?>
								<a href="<?php echo esc_url( get_comment_link( $review ) ); ?>" class="ah-reviews__read-more">
									<?php esc_html_e( 'קרא עוד', 'alwayshere-child' ); ?>
								</a>
							<?php endif; ?>

						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

	</div>
</section>
