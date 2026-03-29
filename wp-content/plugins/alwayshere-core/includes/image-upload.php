<?php
/**
 * AJAX handler for personalization image uploads.
 *
 * Accepts a file upload from the product page, validates MIME type and size,
 * stores via wp_handle_upload(), and returns the attachment ID + URL.
 *
 * @package alwayshere-core
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_ajax_nopriv_alwayshere_upload_personalization_image', 'alwayshere_handle_personalization_image_upload' );
add_action( 'wp_ajax_alwayshere_upload_personalization_image', 'alwayshere_handle_personalization_image_upload' );

function alwayshere_handle_personalization_image_upload(): void {
	check_ajax_referer( 'alwayshere_personalization_upload', 'nonce' );

	if ( empty( $_FILES['file'] ) || ! is_array( $_FILES['file'] ) ) {
		wp_send_json_error( [ 'message' => 'לא נבחר קובץ' ] );
	}

	$file = $_FILES['file']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

	// 5 MB limit.
	$max_bytes = 5 * 1024 * 1024;
	if ( (int) $file['size'] > $max_bytes ) {
		wp_send_json_error( [ 'message' => 'הקובץ גדול מדי. גודל מקסימום: 5MB' ] );
	}

	// Validate MIME type from actual file content, not just extension.
	$allowed_mime = [ 'image/jpeg', 'image/png', 'image/webp', 'image/gif' ];
	$file_info    = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );

	if ( empty( $file_info['type'] ) || ! in_array( $file_info['type'], $allowed_mime, true ) ) {
		wp_send_json_error( [ 'message' => 'סוג קובץ לא נתמך. יש להעלות JPG, PNG, WEBP או GIF' ] );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Store uploads in a dedicated sub-directory to keep things organised.
	add_filter( 'upload_dir', 'alwayshere_personalization_upload_dir' );
	$uploaded = wp_handle_upload( $file, [ 'test_form' => false ] );
	remove_filter( 'upload_dir', 'alwayshere_personalization_upload_dir' );

	if ( isset( $uploaded['error'] ) ) {
		wp_send_json_error( [ 'message' => $uploaded['error'] ] );
	}

	$attachment_id = wp_insert_attachment(
		[
			'post_mime_type' => $uploaded['type'],
			'post_title'     => sanitize_file_name( pathinfo( $uploaded['file'], PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		],
		$uploaded['file']
	);

	if ( is_wp_error( $attachment_id ) ) {
		wp_send_json_error( [ 'message' => 'שגיאה בשמירת הקובץ' ] );
	}

	wp_generate_attachment_metadata( $attachment_id, $uploaded['file'] );

	wp_send_json_success( [
		'attachment_id' => $attachment_id,
		'url'           => $uploaded['url'],
	] );
}

/**
 * Redirect personalization uploads to their own sub-directory.
 */
function alwayshere_personalization_upload_dir( array $dirs ): array {
	$dirs['subdir'] = '/personalization-uploads' . $dirs['subdir'];
	$dirs['path']   = $dirs['basedir'] . $dirs['subdir'];
	$dirs['url']    = $dirs['baseurl'] . $dirs['subdir'];
	return $dirs;
}
