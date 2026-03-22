<?php
/**
 * One-time homepage setup script.
 * Run via: wp eval-file setup-homepage.php
 * Delete this file after running.
 */

// ── 1. Create or find the front page ─────────────────────────────────────────

$front_page_id = (int) get_option( 'page_on_front' );

if ( ! $front_page_id || 'page' !== get_post_type( $front_page_id ) ) {
	$front_page_id = wp_insert_post( [
		'post_title'  => 'דף הבית',
		'post_status' => 'publish',
		'post_type'   => 'page',
	] );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id );
	echo "✅ Created front page (ID: $front_page_id)\n";
} else {
	echo "ℹ️  Front page already exists (ID: $front_page_id)\n";
}

// ── 2. Hero ───────────────────────────────────────────────────────────────────

update_field( 'hero_badge',      'מתנות אישיות שמגיעות מהלב ❤️', $front_page_id );
update_field( 'hero_headline',   "מתנות שהם\nלא ישכחו לעולם", $front_page_id );
update_field( 'hero_subtext',    'כל מתנה מעוצבת בידיים, עם חריטה אישית — בשבילם בדיוק.', $front_page_id );
update_field( 'hero_cta1_label', 'קנו עכשיו', $front_page_id );
update_field( 'hero_cta1_url',   home_url( '/shop/' ), $front_page_id );
update_field( 'hero_cta2_label', 'ראו את הקולקציה', $front_page_id );
update_field( 'hero_cta2_url',   home_url( '/shop/' ), $front_page_id );

update_field( 'hero_trust_items', [
	[ 'icon' => '✍️', 'label' => 'חריטה אישית' ],
	[ 'icon' => '🚚', 'label' => 'משלוח מהיר' ],
	[ 'icon' => '⭐', 'label' => 'אלפי לקוחות מרוצים' ],
	[ 'icon' => '🎁', 'label' => 'אריזת מתנה מפנקת' ],
], $front_page_id );

echo "✅ Hero fields set\n";

// ── 3. Promo Banner ───────────────────────────────────────────────────────────

update_field( 'promo_badge',     '🔥 מבצע השקה', $front_page_id );
update_field( 'promo_headline',  '10% הנחה על ההזמנה הראשונה שלך', $front_page_id );
update_field( 'promo_subtext',   'השתמשו בקוד הקופון בעת הרכישה', $front_page_id );
update_field( 'promo_coupon',    'WELCOME10', $front_page_id );
update_field( 'promo_cta_label', 'לקניה עכשיו', $front_page_id );
update_field( 'promo_cta_url',   home_url( '/shop/' ), $front_page_id );

echo "✅ Promo banner fields set\n";

// ── 4. Trust Section ──────────────────────────────────────────────────────────

update_field( 'trust_heading', 'למה אלפי לקוחות בוחרים בנו?', $front_page_id );
update_field( 'trust_body',    'אנחנו מאמינים שמתנה אמיתית היא כזו שמגיעה מהלב — ולכן כל פריט מעוצב בקפידה, עם תשומת לב לכל פרט.', $front_page_id );

update_field( 'trust_icons', [
	[
		'icon'  => '✍️',
		'label' => 'חריטה אישית על כל מוצר',
		'sub'   => 'שם, תאריך, ציטוט — כל מה שתבחרו',
	],
	[
		'icon'  => '🎨',
		'label' => 'עיצוב מקצועי',
		'sub'   => 'הצוות שלנו מעצב כל מתנה בנפרד',
	],
	[
		'icon'  => '🚚',
		'label' => 'משלוח לכל הארץ',
		'sub'   => 'אספקה מהירה ובטוחה עד לדלת',
	],
	[
		'icon'  => '💬',
		'label' => 'שירות לקוחות אישי',
		'sub'   => 'צוות מסור שכאן בשבילכם',
	],
], $front_page_id );

update_field( 'trust_cta_label', 'קראו עוד עלינו', $front_page_id );
update_field( 'trust_cta_url',   home_url( '/about/' ), $front_page_id );

echo "✅ Trust fields set\n";

// ── 5. Newsletter ─────────────────────────────────────────────────────────────

update_field( 'nl_heading', 'קבלו השראה ומבצעים בלעדיים', $front_page_id );
update_field( 'nl_subtext', 'הצטרפו לקהילה שלנו — רעיונות למתנות, מבצעים מיוחדים וחידושים ישר אליכם', $front_page_id );

echo "✅ Newsletter fields set\n";
echo "\n🎉 Done! Visit your homepage to see the result.\n";
echo "⚠️  Delete setup-homepage.php from your project root when done.\n";
