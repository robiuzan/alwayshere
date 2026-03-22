<?php
/**
 * Single product — trust badges strip.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;
?>

<ul class="ah-trust-badges" aria-label="<?php esc_attr_e( 'יתרונות קנייה', 'alwayshere-child' ); ?>">

	<li class="ah-trust-badges__item">
		<span class="ah-trust-badges__icon" aria-hidden="true">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 2L3 7V12C3 16.55 6.84 20.74 12 22C17.16 20.74 21 16.55 21 12V7L12 2Z" fill="currentColor" opacity="0.15"/>
				<path d="M12 2L3 7V12C3 16.55 6.84 20.74 12 22C17.16 20.74 21 16.55 21 12V7L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
				<path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</span>
		<div class="ah-trust-badges__text">
			<strong><?php esc_html_e( 'משלוח עם אחריות', 'alwayshere-child' ); ?></strong>
		</div>
	</li>

	<li class="ah-trust-badges__item">
		<span class="ah-trust-badges__icon" aria-hidden="true">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M23 4V10H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M1 20V14H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M3.51 9C4.15 7.18 5.31 5.57 6.84 4.36C8.37 3.16 10.22 2.4 12.17 2.18C14.12 1.96 16.09 2.28 17.86 3.1C19.63 3.93 21.13 5.23 22.18 6.87L23 10M1 14L1.82 17.13C2.87 18.77 4.37 20.07 6.14 20.9C7.91 21.72 9.88 22.04 11.83 21.82C13.78 21.6 15.63 20.84 17.16 19.64C18.69 18.43 19.85 16.82 20.49 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</span>
		<div class="ah-trust-badges__text">
			<strong><?php esc_html_e( 'החזרה קלה', 'alwayshere-child' ); ?></strong>
		</div>
	</li>

	<li class="ah-trust-badges__item">
		<span class="ah-trust-badges__icon" aria-hidden="true">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M5 12H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M12 5C12 5 8 8.5 8 12C8 15.5 12 19 12 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M3 17L5.5 19.5L8 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/>
			</svg>
		</span>
		<div class="ah-trust-badges__text">
			<strong><?php esc_html_e( 'משלוח חינם', 'alwayshere-child' ); ?></strong>
			<small><?php esc_html_e( 'מעל ₪199', 'alwayshere-child' ); ?></small>
		</div>
	</li>

</ul>
