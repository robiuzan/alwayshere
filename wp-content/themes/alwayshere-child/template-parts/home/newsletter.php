<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$heading = get_field( 'nl_heading' ) ?: __( 'קבל מבצעים בלעדיים ישר למייל', 'alwayshere-child' );
$subtext = get_field( 'nl_subtext' ) ?: __( 'הצטרף לאלפי לקוחות מרוצים וקבל השראה ומבצעים', 'alwayshere-child' );
?>

<section class="ah-newsletter" aria-label="<?php esc_attr_e( 'הרשמה לניוזלטר', 'alwayshere-child' ); ?>">
	<div class="ah-container ah-newsletter__inner">
		<div class="ah-newsletter__text">
			<h2 class="ah-newsletter__heading"><?php echo esc_html( $heading ); ?></h2>
			<p class="ah-newsletter__sub"><?php echo esc_html( $subtext ); ?></p>
		</div>

		<form class="ah-newsletter__form" id="ah-newsletter-form" novalidate>
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
			<button type="submit" class="ah-btn ah-btn--white ah-newsletter__submit">
				<?php esc_html_e( 'הרשמה', 'alwayshere-child' ); ?>
			</button>
			<p class="ah-newsletter__status" aria-live="polite" hidden></p>
		</form>
	</div>
</section>
