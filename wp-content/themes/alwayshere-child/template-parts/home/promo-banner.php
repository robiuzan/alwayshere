<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$headline = get_field( 'promo_headline' ) ?: __( '🎁 מבצע מוגבל — 30% הנחה על כל הסטור', 'alwayshere-child' );
$subtext  = get_field( 'promo_subtext' )  ?: __( 'השתמשו בקוד ALWAYS30 בסיום הרכישה', 'alwayshere-child' );
$coupon   = get_field( 'promo_coupon' )   ?: 'ALWAYS30';
$cta_l    = get_field( 'promo_cta_label' ) ?: __( 'קנה עכשיו וחסוך', 'alwayshere-child' );
$cta_url  = get_field( 'promo_cta_url' )  ?: ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '/' );
?>

<div class="ah-promo-banner" aria-label="<?php esc_attr_e( 'מבצע מיוחד', 'alwayshere-child' ); ?>">
	<div class="ah-promo-banner__inner">
		<div class="ah-promo-banner__text">
			<h3><?php echo esc_html( $headline ); ?></h3>
			<?php if ( $subtext ) : ?>
				<p>
					<?php if ( $coupon ) : ?>
						<?php
						// Split subtext on coupon code to wrap it in <strong>.
						$parts = explode( $coupon, $subtext, 2 );
						echo esc_html( $parts[0] );
						echo '<strong>' . esc_html( $coupon ) . '</strong>';
						echo esc_html( $parts[1] ?? '' );
						?>
					<?php else : ?>
						<?php echo esc_html( $subtext ); ?>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $cta_l && $cta_url ) : ?>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="ah-btn ah-btn--yellow">
				<?php echo esc_html( $cta_l ); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
