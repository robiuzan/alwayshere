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
				'key'          => 'field_alwayshere_hero_images',
				'label'        => 'תמונות קולאז׳ (4 תמונות)',
				'name'         => 'hero_images',
				'type'         => 'repeater',
				'min'          => 4,
				'max'          => 4,
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
// Field groups are saved to the database via migrate-acf-fields.php.
// Call directly only on fresh installs where DB groups don't exist yet.
if ( ! acf_get_field_group( 'group_alwayshere_home_hero' ) ) {
	alwayshere_register_homepage_fields();
}
