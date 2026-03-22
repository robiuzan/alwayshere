<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$logo_url    = content_url( 'uploads/2026/03/Always-here-logo.webp' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '/my-account/';
$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '/shop/';
?>
<div class="ah-mobile-overlay" id="ah-mobile-overlay" aria-hidden="true"></div>

<div class="ah-mobile-menu" id="ah-mobile-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'alwayshere-child' ); ?>">

	<div class="ah-mobile-menu__header">
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
		<button class="ah-mobile-menu__close" id="ah-menu-close" aria-label="<?php esc_attr_e( 'סגור תפריט', 'alwayshere-child' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>

	<div class="ah-mobile-menu__search">
		<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
		<input type="search" placeholder="<?php esc_attr_e( 'חפש מתנות, הדפסות...', 'alwayshere-child' ); ?>" aria-label="<?php esc_attr_e( 'חיפוש', 'alwayshere-child' ); ?>" />
	</div>

	<nav class="ah-mobile-menu__nav">
		<div class="ah-mobile-menu__section-title"><?php esc_html_e( 'ניווט מהיר', 'alwayshere-child' ); ?></div>

		<button class="ah-mobile-menu__link" data-submenu="cats" aria-expanded="false">
			<?php esc_html_e( 'קטגוריות', 'alwayshere-child' ); ?>
			<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
		</button>
		<div class="ah-mobile-submenu" id="ah-sub-cats" hidden>
			<a href="#"><?php esc_html_e( 'לגבר', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'לאישה', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'לחייל / חיילת', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'ליום הולדת', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'לאירועים', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'לבית', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'ליום אהבה', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'ליום נישואין', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'למשרד', 'alwayshere-child' ); ?></a>
		</div>

		<button class="ah-mobile-menu__link" data-submenu="prods" aria-expanded="false">
			<?php esc_html_e( 'מוצרים', 'alwayshere-child' ); ?>
			<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
		</button>
		<div class="ah-mobile-submenu" id="ah-sub-prods" hidden>
			<a href="#"><?php esc_html_e( 'הדפסה על עץ', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'הדפסה על זכוכית', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'ספלים מודפסים', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'כריות פאזל', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'חולצות מודפסות', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'מחזיקי מפתחות', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'כובעים מודפסים', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'תכשיטים מעוצבים', 'alwayshere-child' ); ?></a>
		</div>

		<button class="ah-mobile-menu__link" data-submenu="events" aria-expanded="false">
			<?php esc_html_e( 'לפי אירוע', 'alwayshere-child' ); ?>
			<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
		</button>
		<div class="ah-mobile-submenu" id="ah-sub-events" hidden>
			<a href="#"><?php esc_html_e( 'יום הולדת', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'חתונה ואירוסין', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'לידה ובריתות', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'בר / בת מצווה', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'ימי נישואין', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'ימי אהבה', 'alwayshere-child' ); ?></a>
			<a href="#"><?php esc_html_e( 'חגים', 'alwayshere-child' ); ?></a>
		</div>

		<a href="#" class="ah-mobile-menu__link ah-mobile-menu__link--highlight"><?php esc_html_e( 'מבצעים 🔥', 'alwayshere-child' ); ?></a>

		<div class="ah-mobile-menu__section-title"><?php esc_html_e( 'עוד', 'alwayshere-child' ); ?></div>
		<a href="#" class="ah-mobile-menu__link"><?php esc_html_e( 'AI Studio ✨', 'alwayshere-child' ); ?></a>
		<a href="#" class="ah-mobile-menu__link"><?php esc_html_e( 'הנמכרים ביותר', 'alwayshere-child' ); ?></a>
		<a href="#" class="ah-mobile-menu__link"><?php esc_html_e( 'אודות', 'alwayshere-child' ); ?></a>
		<a href="#" class="ah-mobile-menu__link"><?php esc_html_e( 'צרו קשר', 'alwayshere-child' ); ?></a>
	</nav>

	<div class="ah-mobile-menu__footer">
		<a href="tel:0556601006" class="ah-mobile-menu__contact">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
			055-6601006
		</a>
		<a href="mailto:info@alwayshere.co.il" class="ah-mobile-menu__contact">
			<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/></svg>
			info@alwayshere.co.il
		</a>
		<div class="ah-mobile-menu__social">
			<a href="#" aria-label="Instagram">📸</a>
			<a href="#" aria-label="Facebook">👍</a>
			<a href="#" aria-label="TikTok">🎵</a>
			<a href="#" aria-label="WhatsApp">💬</a>
		</div>
	</div>

</div>
