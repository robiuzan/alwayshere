<?php
/**
 * Footer — main dark footer (brand + nav columns + trust row + bottom bar).
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$shop_url     = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' )      : '/shop/';
$cart_url     = function_exists( 'wc_get_cart_url' )       ? wc_get_cart_url()                    : '/cart/';
$account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '/my-account/';
$home_url     = home_url( '/' );
$current_year = gmdate( 'Y' );
?>

<footer class="ah-footer" role="contentinfo">

	<!-- ── Main columns ─────────────────────────────────────────── -->
	<div class="ah-footer__main">

		<!-- Brand column -->
		<div class="ah-footer__brand">
			<?php if ( has_custom_logo() ) : ?>
				<a href="<?php echo esc_url( $home_url ); ?>" class="ah-footer__logo" rel="home">
					<?php echo get_custom_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( $home_url ); ?>" class="ah-footer__logo ah-footer__logo--fallback" rel="home">
					<img
						src="<?php echo esc_url( content_url( 'uploads/2026/03/Always-here-logo.webp' ) ); ?>"
						alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
						width="160"
						height="68"
						loading="lazy"
					>
				</a>
			<?php endif; ?>

			<p class="ah-footer__desc">
				<?php esc_html_e( 'מתנות אישיות שמגיעות ישר מהלב. מאות מוצרים עם עיצוב מותאם אישית לכל אירוע ולכל נמען.', 'alwayshere-child' ); ?>
			</p>

			<address class="ah-footer__contacts">
				<a href="tel:0556601006" class="ah-footer__contact">
					<svg viewBox="0 0 24 24" aria-hidden="true" width="15" height="15">
						<path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.58.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.6 21 3 13.4 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.24 1.01L6.6 10.8z"/>
					</svg>
					055-6601006
				</a>
				<a href="mailto:info@alwayshere.co.il" class="ah-footer__contact">
					<svg viewBox="0 0 24 24" aria-hidden="true" width="15" height="15">
						<path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
					</svg>
					info@alwayshere.co.il
				</a>
				<a href="<?php echo esc_url( $home_url ); ?>" class="ah-footer__contact">
					<svg viewBox="0 0 24 24" aria-hidden="true" width="15" height="15">
						<circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/>
						<line x1="2" y1="12" x2="22" y2="12" stroke="currentColor" stroke-width="2"/>
						<path d="M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" fill="none" stroke="currentColor" stroke-width="2"/>
					</svg>
					alwayshere.co.il
				</a>
				<address class="ah-footer__contact ah-footer__address">
					<svg viewBox="0 0 24 24" aria-hidden="true" width="15" height="15">
						<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
					</svg>
					<?php esc_html_e( 'דרך שרה 25/2, זכרון יעקב', 'alwayshere-child' ); ?>
				</address>
			</address>

			</div>

		<!-- Products column -->
		<nav class="ah-footer__col" aria-label="<?php esc_attr_e( 'מוצרים', 'alwayshere-child' ); ?>">
			<h4 class="ah-footer__col-title"><?php esc_html_e( 'מוצרים', 'alwayshere-child' ); ?></h4>
			<ul>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'הדפסה על עץ', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'הדפסה על זכוכית', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'ספלים מודפסים', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'כריות פאזל', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'חולצות מודפסות', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'מחזיקי מפתחות', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'נרות ריחניים', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'תכשיטים מעוצבים', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'מסגרות תמונות', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>" class="ah-footer__col-link--accent"><?php esc_html_e( '← כל המוצרים', 'alwayshere-child' ); ?></a></li>
			</ul>
		</nav>

		<!-- Recipients column -->
		<nav class="ah-footer__col" aria-label="<?php esc_attr_e( 'לפי נמען', 'alwayshere-child' ); ?>">
			<h4 class="ah-footer__col-title"><?php esc_html_e( 'לפי נמען', 'alwayshere-child' ); ?></h4>
			<ul>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'לגבר', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'לאישה', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'לחייל / חיילת', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'ליום הולדת', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'לאירועים', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'לבית', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'ליום אהבה', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'ליום נישואין', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'למשרד', 'alwayshere-child' ); ?></a></li>
			</ul>
		</nav>

		<!-- Company column -->
		<nav class="ah-footer__col" aria-label="<?php esc_attr_e( 'Always Here', 'alwayshere-child' ); ?>">
			<h4 class="ah-footer__col-title">ALWAYS HERE</h4>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'אודות', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>">AI Print Studio</a></li>
				<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'מבצעים', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'בלוג השראה', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'צרו קשר', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'שאלות נפוצות', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>"><?php esc_html_e( 'מדיניות משלוחים', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/returns-policy/' ) ); ?>"><?php esc_html_e( 'מדיניות החזרות', 'alwayshere-child' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'הגנת פרטיות', 'alwayshere-child' ); ?></a></li>
			</ul>
		</nav>

	</div><!-- .ah-footer__main -->

	<!-- ── Trust badges ─────────────────────────────────────────── -->
	<div class="ah-footer__trust-row">
		<div class="ah-trust-chip"><span aria-hidden="true">🔒</span> <?php esc_html_e( 'תשלום מאובטח SSL', 'alwayshere-child' ); ?></div>
		<div class="ah-trust-chip"><span aria-hidden="true">✅</span> <?php esc_html_e( 'איכות מובטחת', 'alwayshere-child' ); ?></div>
		<div class="ah-trust-chip"><span aria-hidden="true">🔄</span> <?php esc_html_e( 'החזרה קלה', 'alwayshere-child' ); ?></div>
		<div class="ah-trust-chip"><span aria-hidden="true">🚚</span> <?php esc_html_e( 'משלוח מהיר לכל הארץ', 'alwayshere-child' ); ?></div>
		<div class="ah-trust-chip"><span aria-hidden="true">🎁</span> <?php esc_html_e( 'אריזת מתנה כלולה', 'alwayshere-child' ); ?></div>
		<div class="ah-trust-chip"><span aria-hidden="true">⭐</span> <?php esc_html_e( 'דירוג 4.9 מ-5', 'alwayshere-child' ); ?></div>
	</div>

	<!-- ── Bottom bar ────────────────────────────────────────────── -->
	<div class="ah-footer__bottom">

		<p class="ah-footer__copy">
			© <?php echo esc_html( $current_year ); ?>
			<a href="<?php echo esc_url( $home_url ); ?>">Always Here</a>.
			<?php esc_html_e( 'כל הזכויות שמורות. עוצב באהבה 🤍', 'alwayshere-child' ); ?>
		</p>

		<nav class="ah-footer__legal" aria-label="<?php esc_attr_e( 'קישורים משפטיים', 'alwayshere-child' ); ?>">
			<a href="<?php echo esc_url( home_url( '/תקנון-אתר/' ) ); ?>"><?php esc_html_e( 'תקנון אתר', 'alwayshere-child' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'פרטיות', 'alwayshere-child' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/accessibility/' ) ); ?>"><?php esc_html_e( 'נגישות', 'alwayshere-child' ); ?></a>
		</nav>

		<div class="ah-footer__payments" aria-label="<?php esc_attr_e( 'אמצעי תשלום', 'alwayshere-child' ); ?>">
			<span class="ah-pay-chip">VISA</span>
			<span class="ah-pay-chip">MC</span>
			<span class="ah-pay-chip">PayPal</span>
			<span class="ah-pay-chip">BIT</span>
		</div>

	</div><!-- .ah-footer__bottom -->

</footer><!-- .ah-footer -->
