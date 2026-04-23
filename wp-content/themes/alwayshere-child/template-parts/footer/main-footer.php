<?php
/**
 * Footer — main dark footer (brand + nav columns + trust row + bottom bar).
 *
 * Columns are powered by widget areas (footer-1 to footer-4).
 * Trust badges & payment methods are managed from Site Settings.
 * Bottom bar legal links come from the "footer-bottom" menu location.
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$home_url     = home_url( '/' );
$current_year = gmdate( 'Y' );

$trust_badges    = Alwayshere_Site_Settings::get_trust_badges();
$payment_methods = Alwayshere_Site_Settings::get_payment_methods();
?>

<footer class="ah-footer" role="contentinfo">

	<!-- ── Main columns ─────────────────────────────────────────── -->
	<div class="ah-footer__main">

		<!-- Brand column — always rendered (not a widget area) -->
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

		<!-- Products column (widget area 1) -->
		<div class="ah-footer__col">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<?php dynamic_sidebar( 'footer-1' ); ?>
			<?php endif; ?>
		</div>

		<!-- Recipients column (widget area 2) -->
		<div class="ah-footer__col">
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<?php dynamic_sidebar( 'footer-2' ); ?>
			<?php endif; ?>
		</div>

		<!-- Company column (widget area 3) -->
		<div class="ah-footer__col">
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<?php dynamic_sidebar( 'footer-3' ); ?>
			<?php endif; ?>
		</div>

	</div><!-- .ah-footer__main -->

	<?php if ( ! empty( $trust_badges ) ) : ?>
		<!-- ── Trust badges ─────────────────────────────────────────── -->
		<div class="ah-footer__trust-row">
			<?php foreach ( $trust_badges as $badge ) : ?>
				<div class="ah-trust-chip">
					<?php if ( ! empty( $badge['icon'] ) ) : ?>
						<span aria-hidden="true"><?php echo esc_html( $badge['icon'] ); ?></span>
					<?php endif; ?>
					<?php echo esc_html( $badge['text'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<!-- ── Bottom bar ────────────────────────────────────────────── -->
	<div class="ah-footer__bottom">

		<p class="ah-footer__copy">
			&copy; <?php echo esc_html( $current_year ); ?>
			<a href="<?php echo esc_url( $home_url ); ?>">Always Here</a>.
			<?php esc_html_e( 'כל הזכויות שמורות. עוצב באהבה', 'alwayshere-child' ); ?> &#x1F90D;
		</p>

		<?php if ( has_nav_menu( 'footer-bottom' ) ) : ?>
			<nav class="ah-footer__legal" aria-label="<?php esc_attr_e( 'קישורים משפטיים', 'alwayshere-child' ); ?>">
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer-bottom',
					'container'      => false,
					'menu_class'     => 'ah-footer__legal-list',
					'depth'          => 1,
				] );
				?>
			</nav>
		<?php endif; ?>

		<?php if ( ! empty( $payment_methods ) ) : ?>
			<div class="ah-footer__payments" aria-label="<?php esc_attr_e( 'אמצעי תשלום', 'alwayshere-child' ); ?>">
				<?php foreach ( $payment_methods as $method ) : ?>
					<span class="ah-pay-chip"><?php echo esc_html( $method ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div><!-- .ah-footer__bottom -->

</footer><!-- .ah-footer -->
