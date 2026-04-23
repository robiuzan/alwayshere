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

// ── Account & dashboard ─────────────────────────────────────────────────────

require_once ALWAYSHERE_CORE_DIR . 'includes/account/class-alwayshere-account.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/account/class-alwayshere-favorites.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/account/class-alwayshere-recently-viewed.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/account/class-alwayshere-google-login.php';

// ── Product personalization ───────────────────────────────────────────────────

require_once ALWAYSHERE_CORE_DIR . 'includes/personalization.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/image-upload.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/setup-terms-page.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/setup-content-pages.php';
require_once ALWAYSHERE_CORE_DIR . 'includes/hebrew-strings.php';

// ── Meta Pixel (Facebook/Instagram conversion tracking) ──────────────────────

require_once ALWAYSHERE_CORE_DIR . 'includes/meta-pixel.php';

// ── Email RTL ────────────────────────────────────────────────────────────────

require_once ALWAYSHERE_CORE_DIR . 'includes/email/class-alwayshere-email-rtl.php';
add_action( 'plugins_loaded', [ 'Alwayshere_Email_RTL', 'init' ] );

// ── One-time product setup ───────────────────────────────────────────────────
// Runs once when an admin visits the dashboard, then self-disables via option.

if ( 'yes' !== get_option( 'alwayshere_cup1_created' ) ) {
	add_action( 'admin_init', 'alwayshere_setup_cup1_product' );
}

function alwayshere_setup_cup1_product(): void {
	// Guard: only admins, only once.
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	if ( 'yes' === get_option( 'alwayshere_cup1_created' ) ) {
		return;
	}

	// Mark as done immediately so a redirect loop doesn't double-create.
	update_option( 'alwayshere_cup1_created', 'yes' );

	$existing = get_page_by_path( 'cup-1', OBJECT, 'product' );
	$product  = $existing ? wc_get_product( $existing->ID ) : new WC_Product_Simple();

	$product->set_name( 'ספל קרמיקה מודפס בעיצוב אישי' );
	$product->set_slug( 'cup-1' );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_regular_price( '119' );
	$product->set_sale_price( '89' );
	$product->set_manage_stock( false );
	$product->set_stock_status( 'instock' );
	$product->set_sold_individually( false );
	$product->set_reviews_allowed( true );
	$product->set_category_ids( [ 18, 20 ] );

	$product->set_short_description(
		'ספל קרמיקה איכותי עם הדפסה בהתאמה אישית — תמונה, שם, ציטוט או כל עיצוב שתרצו. ' .
		'מתנה מושלמת לאיש העסקים, לחובב הקפה, ולכל אחד שאוהב להתחיל את הבוקר בסגנון.'
	);

	$product->set_description(
		'<p>ספל הקרמיקה המודפס שלנו הוא הדרך המושלמת לשלב פונקציונליות עם עיצוב אישי. ' .
		'כל ספל מודפס בטכנולוגיית סאבלימציה ברזולוציה גבוהה — ההדפסה לא דוהה גם אחרי מאות כביסות במדיח.</p>' .
		'<p><strong>פרטי המוצר:</strong></p>' .
		'<ul>' .
		'<li>ספל קרמיקה לבן בנפח 330 מ"ל</li>' .
		'<li>הדפסה מלאה על כל היקף הספל</li>' .
		'<li>עמיד למדיח כלים</li>' .
		'<li>מוצר מוכן תוך 1-2 ימי עסקים</li>' .
		'</ul>' .
		'<p><strong>אפשרויות הגדרה:</strong> שלחו תמונה, שם, לוגו או ציטוט — ' .
		'צוות העיצוב שלנו יעזור לכם ליצור עיצוב מושלם ללא עלות נוספת.</p>'
	);

	$product_id = $product->save();

	if ( ! $product_id || is_wp_error( $product_id ) ) {
		return;
	}

	// Featured image: prefer the mug photo already in the library.
	if ( ! get_post_thumbnail_id( $product_id ) ) {
		$mug = get_posts( [
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
			'post_status'    => 'inherit',
			's'              => 'photo-1514228742587',
			'fields'         => 'ids',
		] );

		$img_id = ! empty( $mug ) ? $mug[0] : 0;

		if ( ! $img_id ) {
			$any = get_posts( [
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'posts_per_page' => 1,
				'post_status'    => 'inherit',
				'fields'         => 'ids',
			] );
			$img_id = ! empty( $any ) ? $any[0] : 0;
		}

		if ( $img_id ) {
			set_post_thumbnail( $product_id, $img_id );
		}
	}

	// Sample reviews.
	$reviews = [
		[ 'author' => 'דנה כ.',  'rating' => 5, 'days_ago' => 36,
		  'comment' => 'הזמנתי ספל עם השם של בן הזוג שלי כמתנה ליום הולדת — הוא פשוט התלהב! האיכות מעולה, ההדפסה חדה וברורה. בהחלט אזמין שוב.' ],
		[ 'author' => 'אבי ל.',  'rating' => 5, 'days_ago' => 49,
		  'comment' => 'הזמנתי 20 ספלים מותאמים אישית לצוות שלי בעבודה. כולם היו מרוצים! השירות היה מעולה והמשלוח הגיע מהר. ממליץ בחום.' ],
		[ 'author' => 'מיכל ש.', 'rating' => 4, 'days_ago' => 54,
		  'comment' => 'ספל יפה ואיכותי. הצבע קצת שונה ממה שנראה במסך אבל עדיין מאוד יפה. העיצוב האישי יצא מושלם.' ],
		[ 'author' => 'רון ג.',  'rating' => 5, 'days_ago' => 62,
		  'comment' => 'מתנה מקורית! הספל עשוי מחומר נעים. ההדפסה לא דוהה גם אחרי כביסות. שווה כל שקל.' ],
	];

	foreach ( $reviews as $review ) {
		$email = sanitize_email( str_replace( [ ' ', '.' ], '', strtolower( $review['author'] ) ) . '@example.com' );
		if ( ! empty( get_comments( [ 'post_id' => $product_id, 'author_email' => $email, 'number' => 1 ] ) ) ) {
			continue;
		}
		$cid = wp_insert_comment( [
			'comment_post_ID'      => $product_id,
			'comment_author'       => $review['author'],
			'comment_author_email' => $email,
			'comment_content'      => $review['comment'],
			'comment_type'         => 'review',
			'comment_approved'     => 1,
			'comment_date'         => date( 'Y-m-d H:i:s', strtotime( '-' . $review['days_ago'] . ' days' ) ),
		] );
		if ( $cid ) {
			update_comment_meta( $cid, 'rating', $review['rating'] );
		}
	}

	$ratings = array_column( $reviews, 'rating' );
	update_post_meta( $product_id, '_wc_average_rating', round( array_sum( $ratings ) / count( $ratings ), 2 ) );
	update_post_meta( $product_id, '_wc_review_count', count( $reviews ) );

	// Store the product ID for reference.
	update_option( 'alwayshere_cup1_product_id', $product_id );
}

// ── Newsletter ────────────────────────────────────────────────────────────────

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
