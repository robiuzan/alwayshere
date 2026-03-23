<?php
/**
 * Footer — compact newsletter bar (shown on all pages except front page).
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<section class="ah-nl-bar" aria-label="<?php esc_attr_e( 'הרשמה לניוזלטר', 'alwayshere-child' ); ?>">
	<div class="ah-nl-bar__inner">

		<div class="ah-nl-bar__text">
			<span class="ah-nl-bar__tag"><?php esc_html_e( '✉️ הירשם לניוזלטר', 'alwayshere-child' ); ?></span>
			<h2 class="ah-nl-bar__title"><?php esc_html_e( 'קבל מבצעים בלעדיים ישר למייל', 'alwayshere-child' ); ?></h2>
			<p class="ah-nl-bar__sub"><?php esc_html_e( 'הצטרף ל-5,000+ שכבר נהנים מהנחות, השראה ועדכונים ראשונים', 'alwayshere-child' ); ?></p>
		</div>

		<form class="ah-nl-bar__form" novalidate>
			<input
				class="ah-nl-bar__input"
				type="email"
				name="email"
				placeholder="<?php esc_attr_e( 'הכנס כתובת מייל...', 'alwayshere-child' ); ?>"
				aria-label="<?php esc_attr_e( 'כתובת מייל', 'alwayshere-child' ); ?>"
				required
			>
			<button type="submit" class="ah-nl-bar__btn">
				<?php esc_html_e( 'הצטרף חינם', 'alwayshere-child' ); ?>
			</button>
			<p class="ah-nl-bar__status" role="status" aria-live="polite" hidden></p>
		</form>

	</div>
</section>
