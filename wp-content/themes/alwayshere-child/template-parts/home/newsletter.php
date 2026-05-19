<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$badge      = get_sub_field( 'nl_badge' )      ?: __( '🎁 10% הנחה למצטרפים חדשים', 'alwayshere-child' );
$heading    = get_sub_field( 'nl_heading' )    ?: __( 'קבל מבצעים בלעדיים ישר למייל', 'alwayshere-child' );
$subtext    = get_sub_field( 'nl_subtext' )    ?: __( 'הצטרף לאלפי לקוחות מרוצים וקבל השראה ומבצעים', 'alwayshere-child' );
$cta_label  = get_sub_field( 'nl_cta_label' ) ?: __( 'קבלו 10% הנחה ←', 'alwayshere-child' );
$disclaimer = get_sub_field( 'nl_disclaimer' ) ?: __( 'אנחנו לא שולחים ספאם. בטל בכל רגע.', 'alwayshere-child' );
?>

<section class="ah-newsletter" aria-label="<?php esc_attr_e( 'הרשמה לניוזלטר', 'alwayshere-child' ); ?>">
	<div class="ah-container ah-newsletter__inner">

		<?php if ( $badge ) : ?>
			<span class="ah-newsletter__badge"><?php echo esc_html( $badge ); ?></span>
		<?php endif; ?>

		<h2 class="ah-newsletter__heading"><?php echo esc_html( $heading ); ?></h2>
		<p class="ah-newsletter__sub"><?php echo esc_html( $subtext ); ?></p>

		<form class="ah-newsletter__form" id="ah-newsletter-form" novalidate>
			<div class="ah-newsletter__row">
				<label for="ah-newsletter-email" class="screen-reader-text">
					<?php esc_html_e( 'כתובת דוא"ל', 'alwayshere-child' ); ?>
				</label>
				<input
					type="email"
					id="ah-newsletter-email"
					name="email"
					class="ah-newsletter__input"
					placeholder="<?php esc_attr_e( 'הכניסו את כתובת המייל שלכם', 'alwayshere-child' ); ?>"
					required
					autocomplete="email"
				>
				<button type="submit" class="ah-btn ah-btn--yellow ah-newsletter__submit">
					<?php echo esc_html( $cta_label ); ?>
				</button>
			</div>
			<p class="ah-newsletter__status" aria-live="polite" hidden></p>
		</form>

		<?php if ( $disclaimer ) : ?>
			<p class="ah-newsletter__disclaimer"><?php echo esc_html( $disclaimer ); ?></p>
		<?php endif; ?>

	</div>
</section>
