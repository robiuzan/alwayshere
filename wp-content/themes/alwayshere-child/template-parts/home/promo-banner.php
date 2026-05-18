<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$badge      = get_field( 'promo_badge' )     ?: '🔥 מבצע';
$headline   = get_field( 'promo_headline' )  ?: __( '30% הנחה על כל הסטור', 'alwayshere-child' );
$subtext    = get_field( 'promo_subtext' )   ?: '';
$coupon     = get_field( 'promo_coupon' )    ?: 'ALWAYS30';
$cta_l      = get_field( 'promo_cta_label' ) ?: __( 'למימוש המבצע', 'alwayshere-child' );
$cta_url    = get_field( 'promo_cta_url' )   ?: ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '/' );
$bg_color   = get_field( 'promo_bg_color' )  ?: '#2C4FE0';

// Timer fields.
$timer_enabled  = (bool) get_field( 'promo_timer_enabled' );
$timer_duration = (int) ( get_field( 'promo_timer_duration_hours' ) ?: 72 );
$timer_anchor   = get_field( 'promo_timer_anchor' ) ?: '';
$timer_label    = get_field( 'promo_timer_label' )  ?: __( 'נגמר בעוד', 'alwayshere-child' );

// Auto-set anchor on first ACF save if enabled but empty.
if ( $timer_enabled && '' === $timer_anchor ) {
	$page_id = get_queried_object_id();
	if ( $page_id ) {
		$now = current_time( 'Y-m-d H:i:s' );
		update_field( 'promo_timer_anchor', $now, $page_id );
		$timer_anchor = $now;
	}
}

$show_timer = $timer_enabled && $timer_duration > 0 && '' !== $timer_anchor;

if ( $show_timer ) {
	$anchor_ts   = strtotime( $timer_anchor );
	$duration_ms = $timer_duration * 3600 * 1000;
	$anchor_utc  = gmdate( 'c', $anchor_ts );

	$elapsed    = ( time() - $anchor_ts ) * 1000;
	$into_cycle = ( ( $elapsed % $duration_ms ) + $duration_ms ) % $duration_ms;
	$rem_s      = (int) floor( ( $duration_ms - $into_cycle ) / 1000 );
	$init_h     = str_pad( (string) floor( $rem_s / 3600 ), 2, '0', STR_PAD_LEFT );
	$init_m     = str_pad( (string) floor( ( $rem_s % 3600 ) / 60 ), 2, '0', STR_PAD_LEFT );
	$init_s     = str_pad( (string) ( $rem_s % 60 ), 2, '0', STR_PAD_LEFT );
}
?>

<div class="ah-promo-banner" style="--ah-promo-bg: <?php echo esc_attr( $bg_color ); ?>;"
     aria-label="<?php esc_attr_e( 'מבצע מיוחד', 'alwayshere-child' ); ?>">
	<div class="ah-promo-banner__inner">

		<!-- Col 1 (RTL right): text + coupon chip -->
		<div class="ah-promo-banner__text">
			<?php if ( $badge ) : ?>
				<span class="ah-promo-banner__badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>
			<h3 class="ah-promo-banner__headline"><?php echo esc_html( $headline ); ?></h3>
			<?php if ( $subtext ) : ?>
				<p class="ah-promo-banner__sub"><?php echo esc_html( $subtext ); ?></p>
			<?php endif; ?>
			<?php if ( $coupon ) : ?>
				<button
					type="button"
					class="ah-promo-banner__coupon"
					data-coupon="<?php echo esc_attr( $coupon ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'העתק קוד קופון %s', 'alwayshere-child' ), $coupon ) ); ?>"
				>
					<span class="ah-promo-banner__coupon-label"><?php esc_html_e( 'קוד:', 'alwayshere-child' ); ?></span>
					<span class="ah-promo-banner__coupon-code"><?php echo esc_html( $coupon ); ?></span>
					<svg class="ah-promo-banner__coupon-icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
					</svg>
				</button>
			<?php endif; ?>
		</div>

		<!-- Col 2 (center): countdown timer (when enabled) -->
		<?php if ( $show_timer ) : ?>
			<div class="ah-promo-banner__timer-wrap">
				<p class="ah-promo-banner__timer-label"><?php echo esc_html( $timer_label ); ?></p>
				<span class="ah-promo-banner__timer"
				      data-ah-countdown
				      data-anchor="<?php echo esc_attr( $anchor_utc ); ?>"
				      data-duration-ms="<?php echo esc_attr( (string) $duration_ms ); ?>"
				      aria-label="<?php echo esc_attr( $timer_label ); ?>">
					<span class="ah-promo-banner__timer-block">
						<span class="ah-promo-banner__timer-pill" data-ah-countdown-hours><?php echo esc_html( $init_h ); ?></span>
						<span class="ah-promo-banner__timer-unit"><?php esc_html_e( 'שע׳', 'alwayshere-child' ); ?></span>
					</span>
					<span class="ah-promo-banner__timer-sep" aria-hidden="true">:</span>
					<span class="ah-promo-banner__timer-block">
						<span class="ah-promo-banner__timer-pill" data-ah-countdown-minutes><?php echo esc_html( $init_m ); ?></span>
						<span class="ah-promo-banner__timer-unit"><?php esc_html_e( 'דק׳', 'alwayshere-child' ); ?></span>
					</span>
					<span class="ah-promo-banner__timer-sep" aria-hidden="true">:</span>
					<span class="ah-promo-banner__timer-block">
						<span class="ah-promo-banner__timer-pill" data-ah-countdown-seconds><?php echo esc_html( $init_s ); ?></span>
						<span class="ah-promo-banner__timer-unit"><?php esc_html_e( 'שנ׳', 'alwayshere-child' ); ?></span>
					</span>
				</span>
			</div>
		<?php endif; ?>

		<!-- Col 3 (RTL left): CTA button -->
		<?php if ( $cta_l && $cta_url ) : ?>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="ah-btn ah-btn--yellow ah-promo-banner__cta">
				<?php echo esc_html( $cta_l ); ?>
			</a>
		<?php endif; ?>

	</div>
</div>
