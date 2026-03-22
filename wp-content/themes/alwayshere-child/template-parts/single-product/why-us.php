<?php
/**
 * Single product — "Why our customers return" section.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

$features = [
	[
		'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.15"/><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'title' => __( 'איכות פרסים', 'alwayshere-child' ),
		'sub'   => __( 'כל מוצר עובר בקרת איכות קפדנית לפני המשלוח', 'alwayshere-child' ),
	],
	[
		'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" stroke="currentColor" stroke-width="1.5" fill="currentColor" opacity="0.15"/><path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" stroke="currentColor" stroke-width="1.5"/></svg>',
		'title' => __( 'עיצוב אישי מהיר', 'alwayshere-child' ),
		'sub'   => __( 'מדפיסים עם אהבה — כל פריט מותאם אישית לכם', 'alwayshere-child' ),
	],
	[
		'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 6V12L16 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'title' => __( 'הבנה תוך 24 שעות', 'alwayshere-child' ),
		'sub'   => __( 'הזמינו היום — נשלח מחר, מהיר כמו שמגיע לכם', 'alwayshere-child' ),
	],
	[
		'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.15"/><path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'title' => __( 'שירות 5 כוכבים', 'alwayshere-child' ),
		'sub'   => __( 'אנחנו כאן בשבילכם — לפני, במהלך ואחרי ההזמנה', 'alwayshere-child' ),
	],
];
?>

<section class="ah-why ah--fade-in" aria-label="<?php esc_attr_e( 'למה לקנות מאיתנו', 'alwayshere-child' ); ?>">
	<div class="ah-container">

		<header class="ah-section-header">
			<span class="ah-section-header__eyebrow">ALWAYS HERE HAS</span>
			<h2 class="ah-section-header__title"><?php esc_html_e( 'הסיבות שהלקוחות שלנו חוזרים', 'alwayshere-child' ); ?></h2>
			<span class="ah-section-header__line" aria-hidden="true"></span>
		</header>

		<div class="ah-why__grid">
			<?php foreach ( $features as $feature ) : ?>
				<article class="ah-why__card">
					<span class="ah-why__icon" aria-hidden="true">
						<?php echo $feature['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<h3 class="ah-why__title"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="ah-why__sub"><?php echo esc_html( $feature['sub'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
