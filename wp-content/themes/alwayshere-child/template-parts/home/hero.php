<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$tag        = get_field( 'hero_badge' )      ?: '';
$headline   = get_field( 'hero_headline' )   ?: '';
$highlight  = get_field( 'hero_headline_highlight' ) ?: '';
$subtext    = get_field( 'hero_subtext' )    ?: '';
$cta1_label = get_field( 'hero_cta1_label' ) ?: '';
$cta1_url   = get_field( 'hero_cta1_url' )   ?: '';
$cta2_label = get_field( 'hero_cta2_label' ) ?: '';
$cta2_url   = get_field( 'hero_cta2_url' )   ?: '';
$images     = get_field( 'hero_images' )     ?: [];
$trust      = get_field( 'hero_trust_items' ) ?: [];
$float_top  = get_field( 'hero_floating_tag_top' )    ?: '';
$float_bot  = get_field( 'hero_floating_tag_bottom' ) ?: '';

// Wrap the highlighted phrase in a <span> for colour.
if ( $headline && $highlight ) {
	$safe_headline  = nl2br( esc_html( $headline ) );
	$safe_highlight = esc_html( $highlight );
	$headline_html  = str_replace(
		$safe_highlight,
		'<span>' . $safe_highlight . '</span>',
		$safe_headline
	);
} else {
	$headline_html = nl2br( esc_html( $headline ) );
}
?>

<section class="ah-hero" aria-label="<?php esc_attr_e( 'דף הבית — מבוא', 'alwayshere-child' ); ?>">
	<div class="ah-hero__inner">

		<div class="ah-hero__content">

			<?php if ( $tag ) : ?>
				<div class="ah-hero__tag"><?php echo esc_html( $tag ); ?></div>
			<?php endif; ?>

			<?php if ( $headline ) : ?>
				<h1 class="ah-hero__headline"><?php echo wp_kses( $headline_html, [ 'span' => [], 'br' => [] ] ); ?></h1>
			<?php endif; ?>

			<?php if ( $subtext ) : ?>
				<p class="ah-hero__sub"><?php echo esc_html( $subtext ); ?></p>
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
					<?php foreach ( $trust as $item ) :
						$icon_url = ! empty( $item['icon_url'] ) ? $item['icon_url'] : '';
						$icon_txt = ! empty( $item['icon'] )     ? $item['icon']     : '';
						$label    = ! empty( $item['label'] )    ? $item['label']    : '';
						$subtitle = ! empty( $item['subtitle'] ) ? $item['subtitle'] : '';
					?>
						<li class="ah-hero__trust-item">
							<div class="ah-hero__trust-icon" aria-hidden="true">
								<?php if ( $icon_url ) : ?>
									<img src="<?php echo esc_url( $icon_url ); ?>" alt="" width="22" height="22">
								<?php elseif ( $icon_txt ) : ?>
									<?php echo esc_html( $icon_txt ); ?>
								<?php endif; ?>
							</div>
							<div class="ah-hero__trust-text">
								<strong><?php echo esc_html( $label ); ?></strong>
								<?php if ( $subtitle ) : ?>
									<span><?php echo esc_html( $subtitle ); ?></span>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ( $images ) : ?>
			<div class="ah-hero__visual" aria-hidden="true">
				<div class="ah-hero__image-grid">
					<?php foreach ( $images as $row ) :
						$img = ! empty( $row['image'] ) ? $row['image'] : null;
						if ( ! $img ) continue;
						$src = $img['sizes']['large'] ?? $img['url'];
						$alt = $img['alt'] ?? '';
					?>
						<div class="ah-hero__img-card">
							<img
								src="<?php echo esc_url( $src ); ?>"
								alt="<?php echo esc_attr( $alt ); ?>"
								loading="lazy"
							>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( $float_top ) : ?>
					<div class="ah-hero__floating-tag ah-hero__floating-tag--top">
						<?php echo esc_html( $float_top ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $float_bot ) : ?>
					<div class="ah-hero__floating-tag ah-hero__floating-tag--bottom">
						<?php echo esc_html( $float_bot ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
