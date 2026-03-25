<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ACF field groups for the homepage.
 * All content editable via WP Admin → Pages → דף הבית.
 */
function alwayshere_register_homepage_fields(): void {

	// ── Section Visibility Control ─────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_sections',
		'title'      => 'הום — ניהול מדורים',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 0,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_homepage_sections',
				'label'         => 'מדורים פעילים',
				'name'          => 'homepage_sections',
				'type'          => 'checkbox',
				'instructions'  => 'בחרו אילו מדורים יופיעו בדף הבית. בטלו סימון כדי להסתיר מדור.',
				'choices'       => [
					'hero'              => '🦸 Hero — כותרת ראשית',
					'recipients'        => '👥 מי מקבל — קטגוריות',
					'promo_banner'      => '🔥 בנר מבצע',
					'featured_products' => '⭐ מוצרים מומלצים',
					'best_sellers'      => '🏆 הנמכרים ביותר',
					'occasions'         => '🎉 לפי אירוע',
					'product_types'     => '📦 סוגי מוצרים',
					'trust'             => '💙 אמון — מי אנחנו',
					'newsletter'        => '📧 ניוזלטר',
				],
				'default_value' => [
					'hero', 'recipients', 'promo_banner', 'featured_products',
					'best_sellers', 'occasions', 'product_types', 'trust', 'newsletter',
				],
				'layout'        => 'vertical',
				'toggle'        => 1,
			],
		],
	] );

	// ── Hero ──────────────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'      => 'group_alwayshere_home_hero',
		'title'    => 'הום — Hero',
		'location' => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 10,
		'fields'   => [
			[
				'key'   => 'field_alwayshere_hero_badge',
				'label' => 'תגית מעל הכותרת',
				'name'  => 'hero_badge',
				'type'  => 'text',
			],
			[
				'key'   => 'field_alwayshere_hero_headline',
				'label' => 'כותרת ראשית',
				'name'  => 'hero_headline',
				'type'  => 'textarea',
				'rows'  => 3,
			],
			[
				'key'          => 'field_alwayshere_hero_headline_highlight',
				'label'        => 'מילה/צירוף לצביעה בכותרת',
				'name'         => 'hero_headline_highlight',
				'type'         => 'text',
				'instructions' => 'הקלידו את הצירוף המדויק מהכותרת שברצונכם לצבוע',
			],
			[
				'key'   => 'field_alwayshere_hero_subtext',
				'label' => 'טקסט משני',
				'name'  => 'hero_subtext',
				'type'  => 'textarea',
				'rows'  => 2,
			],
			[
				'key'         => 'field_alwayshere_hero_cta1_label',
				'label'       => 'כפתור ראשי — טקסט',
				'name'        => 'hero_cta1_label',
				'type'        => 'text',
				'default_value' => 'קנו עכשיו',
			],
			[
				'key'   => 'field_alwayshere_hero_cta1_url',
				'label' => 'כפתור ראשי — קישור',
				'name'  => 'hero_cta1_url',
				'type'  => 'url',
			],
			[
				'key'         => 'field_alwayshere_hero_cta2_label',
				'label'       => 'כפתור משני — טקסט',
				'name'        => 'hero_cta2_label',
				'type'        => 'text',
				'default_value' => 'ראו את הקולקציה',
			],
			[
				'key'   => 'field_alwayshere_hero_cta2_url',
				'label' => 'כפתור משני — קישור',
				'name'  => 'hero_cta2_url',
				'type'  => 'url',
			],
			[
				'key'           => 'field_alwayshere_hero_floating_tag_top',
				'label'         => 'תג צף — עליון',
				'name'          => 'hero_floating_tag_top',
				'type'          => 'text',
				'default_value' => '⭐ 4.9 ב-Google',
			],
			[
				'key'           => 'field_alwayshere_hero_floating_tag_bottom',
				'label'         => 'תג צף — תחתון',
				'name'          => 'hero_floating_tag_bottom',
				'type'          => 'text',
				'default_value' => '🎁 10,000+ מתנות נמסרו',
			],
			[
				'key'          => 'field_alwayshere_hero_images',
				'label'        => 'תמונות קולאז׳ (5 תמונות)',
				'name'         => 'hero_images',
				'type'         => 'repeater',
				'min'          => 5,
				'max'          => 5,
				'button_label' => 'הוסף תמונה',
				'sub_fields'   => [
					[
						'key'           => 'field_alwayshere_hero_image_item',
						'label'         => 'תמונה',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					],
				],
			],
			[
				'key'          => 'field_alwayshere_hero_trust_items',
				'label'        => 'תגי אמון',
				'name'         => 'hero_trust_items',
				'type'         => 'repeater',
				'min'          => 3,
				'max'          => 4,
				'button_label' => 'הוסף תג',
				'sub_fields'   => [
					[
						'key'   => 'field_alwayshere_hero_trust_icon_url',
						'label' => 'תמונת אייקון (URL)',
						'name'  => 'icon_url',
						'type'  => 'url',
					],
					[
						'key'   => 'field_alwayshere_trust_icon',
						'label' => 'אייקון (dashicon class או SVG)',
						'name'  => 'icon',
						'type'  => 'text',
					],
					[
						'key'   => 'field_alwayshere_trust_label',
						'label' => 'טקסט',
						'name'  => 'label',
						'type'  => 'text',
					],
					[
						'key'   => 'field_alwayshere_hero_trust_subtitle',
						'label' => 'תת-טקסט',
						'name'  => 'subtitle',
						'type'  => 'text',
					],
				],
			],
		],
	] );

	// ── Promo Banner ──────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_promo',
		'title'      => 'הום — בנר מבצע',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 20,
		'fields'     => [
			[
				'key'   => 'field_alwayshere_promo_badge',
				'label' => 'תגית',
				'name'  => 'promo_badge',
				'type'  => 'text',
				'default_value' => '🔥 מבצע',
			],
			[
				'key'   => 'field_alwayshere_promo_headline',
				'label' => 'כותרת',
				'name'  => 'promo_headline',
				'type'  => 'text',
			],
			[
				'key'   => 'field_alwayshere_promo_subtext',
				'label' => 'טקסט משני',
				'name'  => 'promo_subtext',
				'type'  => 'text',
			],
			[
				'key'   => 'field_alwayshere_promo_coupon',
				'label' => 'קוד קופון',
				'name'  => 'promo_coupon',
				'type'  => 'text',
			],
			[
				'key'         => 'field_alwayshere_promo_cta_label',
				'label'       => 'טקסט כפתור',
				'name'        => 'promo_cta_label',
				'type'        => 'text',
				'default_value' => 'למימוש המבצע',
			],
			[
				'key'   => 'field_alwayshere_promo_cta_url',
				'label' => 'קישור כפתור',
				'name'  => 'promo_cta_url',
				'type'  => 'url',
			],
		],
	] );

	// ── Trust Section ─────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_trust',
		'title'      => 'הום — אמון',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 30,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_trust_tag',
				'label'         => 'תגית מעל הכותרת',
				'name'          => 'trust_tag',
				'type'          => 'text',
				'default_value' => 'אודות Always Here',
			],
			[
				'key'           => 'field_alwayshere_trust_heading_highlight',
				'label'         => 'מילה/צירוף לצביעה בכותרת',
				'name'          => 'trust_heading_highlight',
				'type'          => 'text',
				'instructions'  => 'הקלידו את הצירוף המדויק מהכותרת שברצונכם לצבוע',
			],
			[
				'key'           => 'field_alwayshere_trust_image',
				'label'         => 'תמונה',
				'name'          => 'trust_image',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			],
			[
				'key'   => 'field_alwayshere_trust_heading',
				'label' => 'כותרת',
				'name'  => 'trust_heading',
				'type'  => 'text',
			],
			[
				'key'   => 'field_alwayshere_trust_body',
				'label' => 'טקסט',
				'name'  => 'trust_body',
				'type'  => 'textarea',
				'rows'  => 3,
			],
			[
				'key'          => 'field_alwayshere_trust_icons',
				'label'        => 'נקודות אמון',
				'name'         => 'trust_icons',
				'type'         => 'repeater',
				'min'          => 3,
				'max'          => 4,
				'button_label' => 'הוסף נקודה',
				'sub_fields'   => [
					[
						'key'   => 'field_alwayshere_trust_feat_icon_url',
						'label' => 'תמונת אייקון (URL)',
						'name'  => 'icon_url',
						'type'  => 'url',
					],
					[
						'key'   => 'field_alwayshere_trust_icon_item',
						'label' => 'אייקון (SVG/dashicon)',
						'name'  => 'icon',
						'type'  => 'text',
					],
					[
						'key'   => 'field_alwayshere_trust_icon_label',
						'label' => 'כותרת',
						'name'  => 'label',
						'type'  => 'text',
					],
					[
						'key'   => 'field_alwayshere_trust_icon_sub',
						'label' => 'תת-טקסט',
						'name'  => 'sub',
						'type'  => 'text',
					],
				],
			],
			[
				'key'         => 'field_alwayshere_trust_cta_label',
				'label'       => 'טקסט כפתור',
				'name'        => 'trust_cta_label',
				'type'        => 'text',
				'default_value' => 'קרא עוד עלינו',
			],
			[
				'key'   => 'field_alwayshere_trust_cta_url',
				'label' => 'קישור כפתור',
				'name'  => 'trust_cta_url',
				'type'  => 'url',
			],
		],
	] );

	// ── Recipients ────────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_recipients',
		'title'      => 'הום — למי המתנה?',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 25,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_recip_title',
				'label'         => 'כותרת',
				'name'          => 'recipients_title',
				'type'          => 'text',
				'default_value' => 'למי המתנה?',
			],
			[
				'key'           => 'field_alwayshere_recip_sub',
				'label'         => 'טקסט משני',
				'name'          => 'recipients_sub',
				'type'          => 'text',
				'default_value' => 'בחרו את הנמען ומצאו מתנה שיאהבו',
			],
		],
	] );

	// ── Featured Products ──────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_featured',
		'title'      => 'הום — הצעות מיוחדות',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 35,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_feat_eyebrow',
				'label'         => 'תת-כותרת עליונה',
				'name'          => 'featured_eyebrow',
				'type'          => 'text',
				'default_value' => 'בחירות העורכים',
			],
			[
				'key'           => 'field_alwayshere_feat_title',
				'label'         => 'כותרת',
				'name'          => 'featured_title',
				'type'          => 'text',
				'default_value' => 'הצעות מיוחדות',
			],
			[
				'key'           => 'field_alwayshere_feat_sub',
				'label'         => 'טקסט משני',
				'name'          => 'featured_sub',
				'type'          => 'text',
				'default_value' => 'מתנות שאנחנו הכי אוהבים — אישיות, יפות ומרגשות',
			],
			[
				'key'           => 'field_alwayshere_feat_cta_label',
				'label'         => 'טקסט כפתור',
				'name'          => 'featured_cta_label',
				'type'          => 'text',
				'default_value' => 'לכל המוצרים',
			],
			[
				'key'          => 'field_alwayshere_feat_category',
				'label'        => 'קטגוריה להצגה',
				'name'         => 'featured_category',
				'type'         => 'select',
				'choices'      => [],
				'allow_null'   => 1,
				'instructions' => 'בחרו קטגוריה כדי להציג מוצרים ממנה. ריק = מוצרים מומלצים מכל הקטגוריות.',
			],
		],
	] );

	// ── Best Sellers ───────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_bestsellers',
		'title'      => 'הום — הנמכרים ביותר',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 36,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_bs_eyebrow',
				'label'         => 'תת-כותרת עליונה',
				'name'          => 'bestsellers_eyebrow',
				'type'          => 'text',
				'default_value' => 'הלקוחות בחרו',
			],
			[
				'key'           => 'field_alwayshere_bs_title',
				'label'         => 'כותרת',
				'name'          => 'bestsellers_title',
				'type'          => 'text',
				'default_value' => 'המוצרים הכי אהובים',
			],
			[
				'key'           => 'field_alwayshere_bs_sub',
				'label'         => 'טקסט משני',
				'name'          => 'bestsellers_sub',
				'type'          => 'text',
				'default_value' => 'המתנות שאלפי לקוחות כבר אהבו',
			],
			[
				'key'          => 'field_alwayshere_bs_category',
				'label'        => 'קטגוריה להצגה',
				'name'         => 'bestsellers_category',
				'type'         => 'select',
				'choices'      => [],
				'allow_null'   => 1,
				'instructions' => 'בחרו קטגוריה כדי להציג מוצרים ממנה. ריק = הנמכרים ביותר מכל הקטגוריות.',
			],
		],
	] );

	// ── Occasions ─────────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_occasions',
		'title'      => 'הום — לפי אירוע',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 37,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_occ_eyebrow',
				'label'         => 'תת-כותרת עליונה',
				'name'          => 'occasions_eyebrow',
				'type'          => 'text',
				'default_value' => 'מתנה לכל רגע',
			],
			[
				'key'           => 'field_alwayshere_occ_title',
				'label'         => 'כותרת',
				'name'          => 'occasions_title',
				'type'          => 'text',
				'default_value' => 'לאיזה אירוע המתנה?',
			],
			[
				'key'          => 'field_alwayshere_occ_categories',
				'label'        => 'קטגוריות להצגה',
				'name'         => 'occasions_categories',
				'type'         => 'checkbox',
				'choices'      => [],
				'instructions' => 'בחרו את קטגוריות האירועים שיופיעו בסעיף זה. אם לא נבחרו — תוצג רשימת ברירת המחדל.',
			],
		],
	] );

	// ── Product Types ──────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_product_types',
		'title'      => 'הום — סוגי מוצרים',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 38,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_pt_eyebrow',
				'label'         => 'תת-כותרת עליונה',
				'name'          => 'product_types_eyebrow',
				'type'          => 'text',
				'default_value' => 'קולקציה מלאה',
			],
			[
				'key'           => 'field_alwayshere_pt_title',
				'label'         => 'כותרת',
				'name'          => 'product_types_title',
				'type'          => 'text',
				'default_value' => 'מה תרצו לעצב היום?',
			],
			[
				'key'          => 'field_alwayshere_pt_categories',
				'label'        => 'קטגוריות להצגה',
				'name'         => 'product_types_categories',
				'type'         => 'checkbox',
				'choices'      => [],
				'instructions' => 'בחרו את הקטגוריות שיופיעו בסעיף זה. אם לא נבחרו — תוצג רשימת ברירת המחדל.',
			],
		],
	] );

	// ── Newsletter ────────────────────────────────────────────────────────
	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_home_newsletter',
		'title'      => 'הום — ניוזלטר',
		'location'   => [ [ [
			'param'    => 'page_type',
			'operator' => '==',
			'value'    => 'front_page',
		] ] ],
		'menu_order' => 40,
		'fields'     => [
			[
				'key'         => 'field_alwayshere_nl_heading',
				'label'       => 'כותרת',
				'name'        => 'nl_heading',
				'type'        => 'text',
				'default_value' => 'קבל מבצעים בלעדיים ישר למייל',
			],
			[
				'key'         => 'field_alwayshere_nl_subtext',
				'label'       => 'טקסט משני',
				'name'        => 'nl_subtext',
				'type'        => 'text',
				'default_value' => 'הצטרף לאלפי לקוחות מרוצים וקבל השראה ומבצעים',
			],
		],
	] );
}
// Always register as local field groups — ACF merges local + DB, local takes priority.
alwayshere_register_homepage_fields();

// Populate product category choices for all homepage category pickers.
// Using acf/load_field (server-side) avoids ACF's AJAX taxonomy loading entirely.
function alwayshere_get_product_cat_choices(): array {
	$terms = get_terms( [
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	] );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return [];
	}
	$choices = [];
	foreach ( $terms as $term ) {
		$choices[ $term->slug ] = $term->name;
	}
	return $choices;
}

$alwayshere_cat_field_keys = [
	'field_alwayshere_occ_categories',
	'field_alwayshere_pt_categories',
	'field_alwayshere_feat_category',
	'field_alwayshere_bs_category',
];
foreach ( $alwayshere_cat_field_keys as $alwayshere_cat_key ) {
	add_filter(
		'acf/load_field/key=' . $alwayshere_cat_key,
		function( array $field ): array {
			$field['choices'] = alwayshere_get_product_cat_choices();
			return $field;
		}
	);
}
unset( $alwayshere_cat_field_keys, $alwayshere_cat_key );
