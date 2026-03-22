<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$image    = get_field( 'trust_image' );
$heading  = get_field( 'trust_heading' );
$body     = get_field( 'trust_body' );
$icons    = get_field( 'trust_icons' );
$cta_l    = get_field( 'trust_cta_label' );
$cta_url  = get_field( 'trust_cta_url' );
?>

<section class="ah-trust" aria-label="<?php esc_attr_e( 'למה לקנות מאיתנו', 'alwayshere-child' ); ?>">
	<div class="ah-container ah-trust__inner">

		<?php if ( $image ) : ?>
			<figure class="ah-trust__image-wrap">
				<img
					src="<?php echo esc_url( $image['sizes']['large'] ?? $image['url'] ); ?>"
					alt="<?php echo esc_attr( $image['alt'] ); ?>"
					width="<?php echo esc_attr( $image['sizes']['large-width'] ?? $image['width'] ); ?>"
					height="<?php echo esc_attr( $image['sizes']['large-height'] ?? $image['height'] ); ?>"
					loading="lazy"
				>
			</figure>
		<?php endif; ?>

		<div class="ah-trust__content">
			<?php if ( $heading ) : ?>
				<h2 class="ah-trust__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<p class="ah-trust__body"><?php echo esc_html( $body ); ?></p>
			<?php endif; ?>

			<?php if ( $icons ) : ?>
				<ul class="ah-trust__icons" aria-label="<?php esc_attr_e( 'יתרונות', 'alwayshere-child' ); ?>">
					<?php foreach ( $icons as $item ) : ?>
						<li class="ah-trust__icon-item">
							<span class="ah-trust__icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></span>
							<div class="ah-trust__icon-text">
								<strong class="ah-trust__icon-label"><?php echo esc_html( $item['label'] ); ?></strong>
								<?php if ( $item['sub'] ) : ?>
									<span class="ah-trust__icon-sub"><?php echo esc_html( $item['sub'] ); ?></span>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $cta_l && $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="ah-btn ah-btn--primary">
					<?php echo esc_html( $cta_l ); ?>
				</a>
			<?php endif; ?>
		</div>

	</div>
</section>
