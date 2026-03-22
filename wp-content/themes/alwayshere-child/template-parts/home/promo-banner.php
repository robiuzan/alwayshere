<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$badge    = get_field( 'promo_badge' );
$headline = get_field( 'promo_headline' );
$subtext  = get_field( 'promo_subtext' );
$coupon   = get_field( 'promo_coupon' );
$cta_l    = get_field( 'promo_cta_label' );
$cta_url  = get_field( 'promo_cta_url' );

if ( ! $headline ) return;
?>

<section class="ah-promo-banner" aria-label="<?php esc_attr_e( 'מבצע מיוחד', 'alwayshere-child' ); ?>">
	<div class="ah-container ah-promo-banner__inner">
		<div class="ah-promo-banner__text">
			<?php if ( $badge ) : ?>
				<span class="ah-promo-banner__badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>
			<p class="ah-promo-banner__headline"><?php echo esc_html( $headline ); ?></p>
			<?php if ( $subtext ) : ?>
				<p class="ah-promo-banner__sub"><?php echo esc_html( $subtext ); ?></p>
			<?php endif; ?>
		</div>

		<div class="ah-promo-banner__actions">
			<?php if ( $coupon ) : ?>
				<button
					class="ah-promo-banner__coupon"
					data-coupon="<?php echo esc_attr( $coupon ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'העתק קוד קופון: %s', 'alwayshere-child' ), $coupon ) ); ?>"
				>
					<span class="ah-promo-banner__coupon-code"><?php echo esc_html( $coupon ); ?></span>
					<span class="ah-promo-banner__coupon-copy" aria-hidden="true">📋</span>
				</button>
			<?php endif; ?>
			<?php if ( $cta_l && $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="ah-btn ah-btn--white">
					<?php echo esc_html( $cta_l ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
