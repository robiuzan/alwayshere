<?php
/**
 * Plugin Name: AlwaysHere Core
 * Plugin URI:  https://alwayshere.co.il
 * Description: Core business logic for AlwaysHere personal gifts store.
 * Version:     1.0.0
 * Author:      AlwaysHere
 * Text Domain: alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ALWAYSHERE_CORE_VERSION', '1.0.0' );
define( 'ALWAYSHERE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'ALWAYSHERE_CORE_URL', plugin_dir_url( __FILE__ ) );

add_action( 'acf/init', 'alwayshere_load_acf_fields' );
function alwayshere_load_acf_fields(): void {
	$fields_dir = ALWAYSHERE_CORE_DIR . 'includes/acf/';
	foreach ( glob( $fields_dir . 'fields-*.php' ) as $file ) {
		require_once $file;
	}
}

add_action( 'wp_ajax_nopriv_alwayshere_newsletter', 'alwayshere_handle_newsletter' );
add_action( 'wp_ajax_alwayshere_newsletter', 'alwayshere_handle_newsletter' );
function alwayshere_handle_newsletter(): void {
	check_ajax_referer( 'alwayshere_newsletter', 'nonce' );

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => 'כתובת דוא"ל לא תקינה' ] );
	}

	// TODO: integrate with email provider (Mailchimp / Klaviyo / ActiveCampaign)
	// For now, store as a WP option array until integration is set.
	$subscribers   = get_option( 'alwayshere_newsletter_subscribers', [] );
	$subscribers[] = [
		'email' => $email,
		'date'  => current_time( 'mysql' ),
	];
	update_option( 'alwayshere_newsletter_subscribers', $subscribers );

	wp_send_json_success( [ 'message' => 'תודה! נרשמת בהצלחה.' ] );
}
