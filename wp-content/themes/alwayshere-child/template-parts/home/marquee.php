<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$badges = class_exists( 'Alwayshere_Site_Settings' )
	? Alwayshere_Site_Settings::get_trust_badges()
	: [];

if ( empty( $badges ) ) {
	return;
}
?>
<div class="ah-marquee" role="region" aria-label="<?php esc_attr_e( 'יתרונות הקנייה', 'alwayshere-child' ); ?>">
	<div class="ah-marquee__track">
		<?php
		// Items rendered twice so translateX(-50%) loops seamlessly.
		for ( $i = 0; $i < 2; $i++ ) :
			foreach ( $badges as $badge ) :
		?>
			<span class="ah-marquee__item" <?php echo 0 === $i ? '' : 'aria-hidden="true"'; ?>>
				<?php if ( ! empty( $badge['icon'] ) ) : ?>
					<span class="ah-marquee__icon" aria-hidden="true"><?php echo esc_html( $badge['icon'] ); ?></span>
				<?php endif; ?>
				<span class="ah-marquee__text"><?php echo esc_html( $badge['text'] ); ?></span>
			</span>
		<?php
			endforeach;
		endfor;
		?>
	</div>
</div>
