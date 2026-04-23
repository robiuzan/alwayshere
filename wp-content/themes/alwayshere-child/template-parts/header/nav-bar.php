<?php
/**
 * Desktop navigation bar with mega-menu dropdowns.
 *
 * Menu items are managed in wp-admin → Appearance → Menus → "תפריט ראשי (דסקטופ)".
 * Top-level items with children become hover-triggered mega-menu dropdowns.
 * Add the CSS class "sale" to a menu item to style it as a promo link.
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<nav class="ah-nav-bar" aria-label="<?php esc_attr_e( 'ניווט ראשי', 'alwayshere-child' ); ?>">
	<div class="ah-nav-bar__inner">
		<?php
		if ( has_nav_menu( 'desktop-menu' ) ) {
			wp_nav_menu( [
				'theme_location' => 'desktop-menu',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new Alwayshere_Desktop_Menu_Walker(),
				'depth'          => 2,
				'fallback_cb'    => false,
			] );
		} else {
			echo '<p style="padding:14px 16px;color:var(--gray-mid);font-size:14px;">';
			esc_html_e( 'הגדירו תפריט ראשי בלוח הבקרה → תפריטים', 'alwayshere-child' );
			echo '</p>';
		}
		?>
	</div>
</nav>
