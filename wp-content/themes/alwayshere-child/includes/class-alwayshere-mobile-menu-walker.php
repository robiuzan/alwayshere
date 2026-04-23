<?php
/**
 * Custom Walker for the mobile slide-out menu.
 *
 * Outputs flat HTML (no <ul>/<li>) matching the existing ah-mobile-menu
 * CSS/JS structure:
 *  - Top-level items with children → <button data-submenu> + <div class="ah-mobile-submenu">
 *  - Top-level items without children → <a class="ah-mobile-menu__link">
 *  - Child items → <a> inside the submenu div
 *
 * Supports a custom CSS class "highlight" on menu items in wp-admin
 * to apply the ah-mobile-menu__link--highlight modifier.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

class Alwayshere_Mobile_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Track whether we are inside an open submenu div.
	 *
	 * @var bool
	 */
	private bool $in_submenu = false;

	/**
	 * Start a sub-level: open the submenu <div>.
	 *
	 * @param string $output HTML output.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   Menu arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		// Only handle depth 0 → 1 (one level of submenus).
		if ( 0 !== $depth ) {
			return;
		}
		// The submenu div is opened in start_el for the parent item.
		// This method intentionally does nothing — the div was already opened.
	}

	/**
	 * End a sub-level: close the submenu <div>.
	 *
	 * @param string $output HTML output.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   Menu arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		if ( 0 !== $depth ) {
			return;
		}

		if ( $this->in_submenu ) {
			$output          .= '</div>' . "\n";
			$this->in_submenu = false;
		}
	}

	/**
	 * Render a single menu item.
	 *
	 * @param string   $output HTML output.
	 * @param WP_Post  $item   Menu item data.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   Menu arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$classes   = (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_highlight = in_array( 'highlight', $classes, true );
		$title     = apply_filters( 'the_title', $item->title, $item->ID );
		$url       = $item->url;

		if ( 0 === $depth ) {
			// Top-level item.
			if ( $has_children ) {
				$submenu_id = 'ah-sub-' . $item->ID;
				$link_class = 'ah-mobile-menu__link';
				if ( $is_highlight ) {
					$link_class .= ' ah-mobile-menu__link--highlight';
				}

				$output .= sprintf(
					'<button class="%s" data-submenu="%d" aria-expanded="false">%s'
					. '<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>'
					. '</button>' . "\n",
					esc_attr( $link_class ),
					(int) $item->ID,
					esc_html( $title )
				);

				// Open the submenu div — end_lvl() will close it.
				$output          .= sprintf(
					'<div class="ah-mobile-submenu" id="%s" hidden>' . "\n",
					esc_attr( $submenu_id )
				);
				$this->in_submenu = true;

			} else {
				$link_class = 'ah-mobile-menu__link';
				if ( $is_highlight ) {
					$link_class .= ' ah-mobile-menu__link--highlight';
				}

				$output .= sprintf(
					'<a href="%s" class="%s">%s</a>' . "\n",
					esc_url( $url ),
					esc_attr( $link_class ),
					esc_html( $title )
				);
			}
		} elseif ( 1 === $depth ) {
			// Child item inside a submenu.
			$output .= sprintf(
				'<a href="%s">%s</a>' . "\n",
				esc_url( $url ),
				esc_html( $title )
			);
		}
		// Deeper levels are ignored (design only supports one level).
	}

	/**
	 * End a single menu item — no closing tag needed for our flat structure.
	 *
	 * @param string   $output HTML output.
	 * @param WP_Post  $item   Menu item data.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   Menu arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		// No-op — no <li> to close.
	}
}
