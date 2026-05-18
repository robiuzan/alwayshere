<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$eyebrow = get_field( 'reviews_eyebrow' )        ?: __( 'מה אומרים עלינו', 'alwayshere-child' );
$title   = get_field( 'reviews_title' )          ?: __( '1,832 לקוחות לא יכולים לטעות', 'alwayshere-child' );
$score   = get_field( 'reviews_summary_score' )  ?: '4.9';
$count   = get_field( 'reviews_summary_count' )  ?: '1,832';
$items   = get_field( 'reviews_items' );

if ( empty( $items ) ) {
	return;
}

$star_full = '<svg viewBox="0 0 24 24" width="14" height="14" fill="#f5c518" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
$star_empty = '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#f5c518" stroke-width="1.5" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
?>

<section class="ah-reviews" aria-label="<?php esc_attr_e( 'ביקורות לקוחות', 'alwayshere-child' ); ?>">
	<div class="ah-container ah-reviews__inner">

		<!-- Section header -->
		<div class="ah-reviews__header">
			<p class="ah-reviews__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<div class="ah-reviews__heading-row">
				<h2 class="ah-reviews__title"><?php echo esc_html( $title ); ?></h2>
				<div class="ah-reviews__summary">
					<span class="ah-reviews__summary-score"><?php echo esc_html( $score ); ?></span>
					<div class="ah-reviews__summary-stars" aria-label="<?php echo esc_attr( sprintf( __( 'דירוג %s מתוך 5', 'alwayshere-child' ), $score ) ); ?>">
						<?php for ( $s = 0; $s < 5; $s++ ) : ?>
							<?php echo wp_kses( $star_full, [ 'svg' => [ 'viewbox' => [], 'width' => [], 'height' => [], 'fill' => [], 'aria-hidden' => [] ], 'path' => [ 'd' => [] ] ] ); ?>
						<?php endfor; ?>
					</div>
					<span class="ah-reviews__summary-count"><?php echo esc_html( sprintf( __( 'מ-%s ביקורות', 'alwayshere-child' ), $count ) ); ?></span>
				</div>
			</div>
		</div>

		<!-- Cards row -->
		<div class="ah-reviews__track" role="list">
			<?php foreach ( $items as $review ) :
				$initials      = esc_html( $review['initials'] ?? '' );
				$avatar_color  = esc_attr( $review['avatar_color'] ?? '#1a4a6b' );
				$name          = esc_html( $review['name'] ?? '' );
				$meta          = esc_html( $review['meta'] ?? '' );
				$rating        = (int) ( $review['rating'] ?? 5 );
				$rating        = max( 1, min( 5, $rating ) );
				$text          = esc_html( $review['text'] ?? '' );
				$verified      = ! empty( $review['verified'] );
			?>
				<article class="ah-reviews__card" role="listitem">
					<header class="ah-reviews__card-header">
						<span
							class="ah-reviews__avatar"
							style="background: <?php echo $avatar_color; ?>;"
							aria-hidden="true"
						><?php echo $initials; ?></span>
						<div class="ah-reviews__card-meta">
							<span class="ah-reviews__card-name"><?php echo $name; ?></span>
							<?php if ( $meta ) : ?>
								<span class="ah-reviews__card-product"><?php echo $meta; ?></span>
							<?php endif; ?>
						</div>
						<?php if ( $verified ) : ?>
							<span class="ah-reviews__verified" aria-label="<?php esc_attr_e( 'לקוח מאומת', 'alwayshere-child' ); ?>">
								<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
								<?php esc_html_e( 'מאומת', 'alwayshere-child' ); ?>
							</span>
						<?php endif; ?>
					</header>

					<div class="ah-reviews__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d מתוך 5 כוכבים', 'alwayshere-child' ), $rating ) ); ?>">
						<?php for ( $s = 1; $s <= 5; $s++ ) :
							$svg_src = ( $s <= $rating ) ? $star_full : $star_empty;
							echo wp_kses( $svg_src, [ 'svg' => [ 'viewbox' => [], 'width' => [], 'height' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => [], 'aria-hidden' => [] ], 'path' => [ 'd' => [] ] ] );
						endfor; ?>
					</div>

					<blockquote class="ah-reviews__text">
						<p><?php echo $text; ?></p>
					</blockquote>
				</article>
			<?php endforeach; ?>
		</div>

		<!-- Dot navigation for mobile scroll -->
		<div class="ah-reviews__dots" aria-hidden="true">
			<?php foreach ( $items as $i => $_ ) : ?>
				<span class="ah-reviews__dot <?php echo 0 === $i ? 'is-active' : ''; ?>"></span>
			<?php endforeach; ?>
		</div>

	</div>
</section>
