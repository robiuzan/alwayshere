<?php
/**
 * Force RTL direction on all WooCommerce emails.
 *
 * WC 10.7.0 templates already contain is_rtl() checks, but they can fail
 * when emails are sent via Action Scheduler / WP-Cron. Additionally, Gmail
 * strips <style> blocks, so inline dir="rtl" attributes are required.
 *
 * Three hooks provide layered coverage:
 *  1. woocommerce_email_setup_locale  — ensure is_rtl() returns true
 *  2. woocommerce_email_styles        — inject RTL CSS
 *  3. woocommerce_mail_content        — post-process HTML with inline dir/style
 *
 * @package AlwaysHere_Core
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Alwayshere_Email_RTL {

	public static function init(): void {
		add_action( 'woocommerce_email_setup_locale', [ __CLASS__, 'force_rtl_locale' ] );
		add_action( 'woocommerce_email_restore_locale', [ __CLASS__, 'restore_locale' ] );
		add_filter( 'woocommerce_email_styles', [ __CLASS__, 'add_rtl_styles' ], 99 );
		add_filter( 'woocommerce_mail_content', [ __CLASS__, 'enforce_rtl_attributes' ], 99 );
	}

	/**
	 * Guarantee he_IL locale during email rendering so WC's own
	 * is_rtl() checks produce the correct output.
	 */
	public static function force_rtl_locale(): void {
		if ( function_exists( 'switch_to_locale' ) && ! is_rtl() ) {
			switch_to_locale( 'he_IL' );
		}
	}

	/**
	 * Restore the previous locale after email rendering.
	 * Prevents locale leak in batched emails or cron runs.
	 */
	public static function restore_locale(): void {
		if ( function_exists( 'restore_previous_locale' ) ) {
			restore_previous_locale();
		}
	}

	/**
	 * Append RTL CSS rules to the WC email stylesheet.
	 *
	 * !important is justified here: email clients inject their own LTR
	 * defaults, and this CSS only runs inside WC emails.
	 */
	public static function add_rtl_styles( string $css ): string {
		$rtl = '
/* ── AlwaysHere Email RTL ─────────────────────────────────── */

body,
#wrapper,
#template_container,
#body_content,
#body_content_inner {
	direction: rtl !important;
	text-align: right !important;
}

h1, h2, h3 {
	text-align: right !important;
}

#template_header_image,
#template_header_image p {
	text-align: right !important;
}

#header_wrapper,
#header_wrapper h1 {
	text-align: right !important;
}

/* Order details table */
.td,
#body_content table td,
#body_content table th {
	text-align: right !important;
}

/* Address blocks */
.address,
#addresses .address {
	text-align: right !important;
}

/* Item meta labels — directional (not logical) properties required for email client compat. */
#body_content .wc-item-meta-label {
	float: right !important;
	margin-left: 0.25em !important;
	margin-right: 0 !important;
}

/* Footer */
#template_footer #credit {
	text-align: right !important;
}

/* Additional content */
.email-additional-content p,
.email-additional-content-aligned p {
	text-align: right !important;
}
';

		return $css . $rtl;
	}

	/**
	 * Post-process final email HTML to add inline RTL attributes.
	 *
	 * Critical for Gmail (strips <style>) and Outlook (Word renderer).
	 * Guards against duplicates when is_rtl() already produced them.
	 */
	public static function enforce_rtl_attributes( string $html ): string {
		// 1. Ensure <html> has dir="rtl".
		if ( false === stripos( $html, 'dir="rtl"' ) && false === stripos( $html, "dir='rtl'" ) ) {
			$html = preg_replace( '/<html\b/i', '<html dir="rtl"', $html, 1 );
		}

		// 2. Inject inline direction on <body> for Gmail.
		$html = preg_replace_callback(
			'/<body\b([^>]*)>/i',
			function ( array $m ): string {
				$attrs = $m[1];
				// Skip if direction:rtl is already present.
				if ( false !== stripos( $attrs, 'direction:rtl' ) || false !== stripos( $attrs, 'direction: rtl' ) ) {
					return $m[0];
				}
				// Append to existing style or add new one.
				if ( preg_match( '/style\s*=\s*["\']/', $attrs ) ) {
					$attrs = preg_replace(
						'/style\s*=\s*(["\'])/',
						'style=$1direction:rtl;text-align:right;',
						$attrs,
						1
					);
				} else {
					$attrs .= ' style="direction:rtl;text-align:right;"';
				}
				return '<body' . $attrs . '>';
			},
			$html,
			1
		);

		// 3. Ensure #wrapper div has dir="rtl" (belt-and-suspenders).
		if ( preg_match( '/<div[^>]*id=["\']wrapper["\'][^>]*>/i', $html, $m ) ) {
			$original = $m[0];
			if ( false === stripos( $original, 'dir=' ) ) {
				$patched = str_replace( '>', ' dir="rtl">', $original );
				$html    = str_replace( $original, $patched, $html );
			}
		}

		return $html;
	}
}
