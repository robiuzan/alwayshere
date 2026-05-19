<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$tag        = get_field( 'trust_tag' )               ?: __( 'אודות Always Here', 'alwayshere-child' );
$heading    = get_field( 'trust_heading' )            ?: '';
$highlight  = get_field( 'trust_heading_highlight' )  ?: '';
$body       = get_field( 'trust_body' )               ?: '';
$features   = get_field( 'trust_icons' )              ?: [];
$cta_label  = get_field( 'trust_cta_label' )          ?: __( 'קרא עוד עלינו', 'alwayshere-child' );
$cta_url    = get_field( 'trust_cta_url' )            ?: '';
$image      = get_field( 'trust_image' )              ?: null;

// Build heading HTML — wrap highlighted phrase in <span>.
if ( $heading && $highlight ) {
	$safe_heading   = nl2br( esc_html( $heading ) );
	$safe_highlight = esc_html( $highlight );
	$heading_html   = str_replace(
		$safe_highlight,
		'<span>' . $safe_highlight . '</span>',
		$safe_heading
	);
} else {
	$heading_html = nl2br( esc_html( $heading ) );
}
?>

<section class="ah-about" aria-label="<?php esc_attr_e( 'אודות', 'alwayshere-child' ); ?>">
	<div class="ah-about__inner">

		<div class="ah-about__content">
			<?php if ( $tag ) : ?>
				<span class="ah-about__tag"><?php echo esc_html( $tag ); ?></span>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="ah-about__title">
					<?php echo wp_kses( $heading_html, [ 'span' => [], 'br' => [] ] ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<p class="ah-about__text"><?php echo esc_html( $body ); ?></p>
			<?php endif; ?>

			<?php if ( $features ) : ?>
				<ul class="ah-about__features" aria-label="<?php esc_attr_e( 'יתרונות', 'alwayshere-child' ); ?>">
					<?php foreach ( $features as $feat ) :
						$icon_url = ! empty( $feat['icon_url'] ) ? $feat['icon_url'] : '';
						$icon_txt = ! empty( $feat['icon'] )     ? $feat['icon']     : '';
						$label    = ! empty( $feat['label'] )    ? $feat['label']    : '';
						$sub      = ! empty( $feat['sub'] )      ? $feat['sub']      : '';
					?>
						<li class="ah-about__feature">
							<div class="ah-about__feature-icon" aria-hidden="true">
								<?php if ( $icon_url ) : ?>
									<img src="<?php echo esc_url( $icon_url ); ?>" alt="" width="22" height="22">
								<?php elseif ( $icon_txt ) : ?>
									<?php echo esc_html( $icon_txt ); ?>
								<?php endif; ?>
							</div>
							<div class="ah-about__feature-info">
								<strong><?php echo esc_html( $label ); ?></strong>
								<?php if ( $sub ) : ?>
									<span><?php echo esc_html( $sub ); ?></span>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $cta_label && $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="ah-btn ah-btn--primary">
					<?php echo esc_html( $cta_label ); ?>
				</a>
			<?php endif; ?>
		</div>

		<?php if ( $image ) : ?>
			<div class="ah-about__visual">
				<img
					src="<?php echo esc_url( $image['sizes']['large'] ?? $image['url'] ); ?>"
					alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>"
					width="<?php echo esc_attr( $image['sizes']['large-width'] ?? $image['width'] ); ?>"
					height="<?php echo esc_attr( $image['sizes']['large-height'] ?? $image['height'] ); ?>"
					loading="lazy"
				>
			</div>
		<?php endif; ?>

	</div>
</section>
