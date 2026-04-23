<?php
/**
 * My Account navigation — sidebar tabs with icons.
 *
 * WC template override: woocommerce/templates/myaccount/navigation.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_navigation' );

/**
 * Map endpoint slugs to SVG icon markup.
 */
$icons = [
	'dashboard'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>',
	'orders'          => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>',
	'favorites'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
	'recently-viewed' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
	'edit-account'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
	'customer-logout' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
];
?>

<nav class="ah-account-nav" aria-label="<?php esc_attr_e( 'ניווט חשבון', 'alwayshere-child' ); ?>">
	<ul class="ah-account-nav__list">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<?php
			$is_active = wc_is_current_account_menu_item( $endpoint );
			$classes   = 'ah-account-nav__item';
			if ( $is_active ) {
				$classes .= ' is-active';
			}
			if ( 'customer-logout' === $endpoint ) {
				$classes .= ' ah-account-nav__item--logout';
			}
			?>
			<li class="<?php echo esc_attr( $classes ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
				   <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
					<?php
					if ( isset( $icons[ $endpoint ] ) ) {
						echo $icons[ $endpoint ]; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG markup
					}
					?>
					<span><?php echo esc_html( $label ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
