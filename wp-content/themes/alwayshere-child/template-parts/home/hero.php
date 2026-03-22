<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$badge      = get_field( 'hero_badge' );
$headline   = get_field( 'hero_headline' );
$subtext    = get_field( 'hero_subtext' );
$cta1_label = get_field( 'hero_cta1_label' );
$cta1_url   = get_field( 'hero_cta1_url' );
$cta2_label = get_field( 'hero_cta2_label' );
$cta2_url   = get_field( 'hero_cta2_url' );
$images     = get_field( 'hero_images' );
$trust      = get_field( 'hero_trust_items' );
?>

<section class="ah-hero" aria-label="<?php esc_attr_e( 'דף הבית — מבוא', 'alwayshere-child' ); ?>">
	<div class="ah-hero__inner ah-container">

		<div class="ah-hero__content">
			<?php if ( $badge ) : ?>
				<span class="ah-hero__badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>

			<?php if ( $headline ) : ?>
				<h1 class="ah-hero__headline"><?php echo nl2br( esc_html( $headline ) ); ?></h1>
			<?php endif; ?>

			<?php if ( $subtext ) : ?>
				<p class="ah-hero__subtext"><?php echo esc_html( $subtext ); ?></p>
			<?php endif; ?>

			<div class="ah-hero__ctas">
				<?php if ( $cta1_label && $cta1_url ) : ?>
					<a href="<?php echo esc_url( $cta1_url ); ?>" class="ah-btn ah-btn--primary">
						<?php echo esc_html( $cta1_label ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $cta2_label && $cta2_url ) : ?>
					<a href="<?php echo esc_url( $cta2_url ); ?>" class="ah-btn ah-btn--outline">
						<?php echo esc_html( $cta2_label ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( $trust ) : ?>
				<ul class="ah-hero__trust" aria-label="<?php esc_attr_e( 'יתרונות', 'alwayshere-child' ); ?>">
					<?php foreach ( $trust as $item ) : ?>
						<li class="ah-hero__trust-item">
							<span class="ah-hero__trust-icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></span>
							<span class="ah-hero__trust-label"><?php echo esc_html( $item['label'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ( $images ) : ?>
			<div class="ah-hero__collage" aria-hidden="true">
				<?php foreach ( $images as $index => $row ) :
					$img = $row['image'];
					if ( ! $img ) continue;
				?>
					<figure class="ah-hero__collage-item ah-hero__collage-item--<?php echo esc_attr( $index + 1 ); ?>">
						<img
							src="<?php echo esc_url( $img['sizes']['large'] ?? $img['url'] ); ?>"
							alt="<?php echo esc_attr( $img['alt'] ); ?>"
							width="<?php echo esc_attr( $img['sizes']['large-width'] ?? $img['width'] ); ?>"
							height="<?php echo esc_attr( $img['sizes']['large-height'] ?? $img['height'] ); ?>"
							loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
						>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
