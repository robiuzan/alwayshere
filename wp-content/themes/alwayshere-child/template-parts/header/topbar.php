<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$contacts = Alwayshere_Site_Settings::get_topbar_contacts();
$promo    = Alwayshere_Site_Settings::get_topbar_promo();
$social   = Alwayshere_Site_Settings::get_topbar_social();

$phone_raw = preg_replace( '/[^0-9+]/', '', $contacts['phone'] );
?>
<div class="ah-topbar" role="region" aria-label="<?php esc_attr_e( 'מידע כללי', 'alwayshere-child' ); ?>">

	<!-- Right (RTL: appears right) — contact links -->
	<div class="ah-topbar__contacts">
		<?php if ( '' !== $contacts['phone'] ) : ?>
			<a href="tel:<?php echo esc_attr( $phone_raw ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
				<?php echo esc_html( $contacts['phone'] ); ?>
			</a>
		<?php endif; ?>
		<?php if ( '' !== $contacts['email'] ) : ?>
			<a href="mailto:<?php echo esc_attr( $contacts['email'] ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-8.97 5.7a1.94 1.94 0 01-2.06 0L2 7"/></svg>
				<?php echo esc_html( $contacts['email'] ); ?>
			</a>
		<?php endif; ?>
		<?php if ( '' !== $contacts['location_text'] ) : ?>
			<span>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
				<?php echo esc_html( $contacts['location_text'] ); ?>
			</span>
		<?php endif; ?>
	</div>

	<!-- Center — promo -->
	<div class="ah-topbar__promo">
		<?php if ( '' !== $promo['emoji'] ) : ?>
			<?php echo esc_html( $promo['emoji'] ); ?>
		<?php endif; ?>
		<?php if ( '' !== $promo['text'] ) : ?>
			<?php echo esc_html( $promo['text'] ); ?>
		<?php endif; ?>
		<?php if ( '' !== $promo['highlight'] ) : ?>
			<strong><?php echo esc_html( $promo['highlight'] ); ?></strong>
		<?php endif; ?>
		<?php if ( '' !== $promo['cta_text'] ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php echo esc_html( $promo['cta_text'] ); ?></a>
		<?php endif; ?>
		<?php if ( '' !== $promo['shipping_text'] ) : ?>
			&nbsp;|&nbsp;
			<?php echo esc_html( $promo['shipping_text'] ); ?>
		<?php endif; ?>
	</div>

	<!-- Left (RTL: appears left) — social -->
	<div class="ah-topbar__social">
		<?php if ( '' !== $social['instagram'] ) : ?>
			<a href="<?php echo esc_url( $social['instagram'] ); ?>" aria-label="Instagram" target="_blank" rel="noopener">
				<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
			</a>
		<?php endif; ?>
		<?php if ( '' !== $social['facebook'] ) : ?>
			<a href="<?php echo esc_url( $social['facebook'] ); ?>" aria-label="Facebook" target="_blank" rel="noopener">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
			</a>
		<?php endif; ?>
		<?php if ( '' !== $social['tiktok'] ) : ?>
			<a href="<?php echo esc_url( $social['tiktok'] ); ?>" aria-label="TikTok" target="_blank" rel="noopener">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 12a4 4 0 104 4V4a5 5 0 005 5"/></svg>
			</a>
		<?php endif; ?>
	</div>

</div>
