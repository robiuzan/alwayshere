<?php
/**
 * Mobile slide-out menu.
 *
 * Menu items are managed in wp-admin → Appearance → Menus → "תפריט מובייל".
 * Items with children become accordion toggles; top-level items are flat links.
 * Add the CSS class "highlight" to a menu item to style it as a promo link.
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$logo_url = content_url( 'uploads/2026/03/Always-here-logo.webp' );
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
		<?php
		if ( has_nav_menu( 'mobile-menu' ) ) {
			wp_nav_menu( [
				'theme_location' => 'mobile-menu',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new Alwayshere_Mobile_Menu_Walker(),
				'depth'          => 2,
				'fallback_cb'    => false,
			] );
		} else {
			// Fallback: prompt admin to assign a menu.
			echo '<p class="ah-mobile-menu__link" style="opacity:.6">';
			esc_html_e( 'הגדירו תפריט מובייל בלוח הבקרה → תפריטים', 'alwayshere-child' );
			echo '</p>';
		}
		?>
	</nav>

	<div class="ah-mobile-menu__account">
		<?php $account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '/my-account/'; ?>
		<a href="<?php echo esc_url( $account_url ); ?>" class="ah-mobile-menu__account-link">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
				<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
				<circle cx="12" cy="7" r="4"/>
			</svg>
			<?php echo esc_html( is_user_logged_in() ? 'החשבון שלי' : 'כניסה / הרשמה' ); ?>
		</a>
	</div>

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
