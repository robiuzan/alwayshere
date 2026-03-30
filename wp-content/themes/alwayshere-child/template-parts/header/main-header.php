<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$cart_count  = function_exists( 'WC' ) ? WC()->cart->get_cart_contents_count() : 0;
$cart_url    = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '/cart/';
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '/my-account/';
$logo_url    = content_url( 'uploads/2026/03/Always-here-logo.webp' );
?>
<header class="ah-main-header" id="ah-main-header" role="banner">
	<div class="ah-main-header__inner">

		<!-- Column 1 (RTL: right side) — action buttons -->
		<div class="ah-header-actions">

			<button class="ah-mobile-search-btn" aria-label="<?php esc_attr_e( 'חיפוש', 'alwayshere-child' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
					<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
				</svg>
			</button>

<a class="ah-hdr-btn ah-hdr-btn--cart" title="<?php esc_attr_e( 'עגלת קניות', 'alwayshere-child' ); ?>" href="<?php echo esc_url( $cart_url ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
					<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
					<path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
				</svg>
				<span class="ah-hdr-btn__label"><?php esc_html_e( 'עגלה', 'alwayshere-child' ); ?></span>
				<span class="ah-cart-count" data-count="<?php echo esc_attr( $cart_count ); ?>"
					  <?php echo 0 === $cart_count ? 'hidden' : ''; ?>>
					<?php echo esc_html( $cart_count ); ?>
				</span>
			</a>

		</div>

		<!-- Column 2 (center) — logo -->
		<a class="ah-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img
				src="<?php echo esc_url( $logo_url ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> – <?php esc_attr_e( 'מתנות אישיות', 'alwayshere-child' ); ?>"
			/>
		</a>

		<!-- Column 3 (RTL: left side) — search + hamburger -->
		<div class="ah-header-search-zone">
			<form class="ah-header-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" aria-hidden="true">
					<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
				</svg>
				<input
					type="search"
					name="s"
					placeholder="<?php esc_attr_e( 'חפש מתנות אישיות, הדפסות...', 'alwayshere-child' ); ?>"
					aria-label="<?php esc_attr_e( 'חיפוש', 'alwayshere-child' ); ?>"
				/>
				<button type="submit" class="ah-header-search__btn">
					<?php esc_html_e( 'חפש', 'alwayshere-child' ); ?>
				</button>
			</form>

			<button
				class="ah-hamburger"
				aria-label="<?php esc_attr_e( 'תפריט', 'alwayshere-child' ); ?>"
				aria-expanded="false"
				aria-controls="ah-mobile-menu"
			>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
					<line x1="3" y1="6" x2="21" y2="6"/>
					<line x1="3" y1="12" x2="21" y2="12"/>
					<line x1="3" y1="18" x2="15" y2="18"/>
				</svg>
			</button>
		</div>

	</div>
</header>
