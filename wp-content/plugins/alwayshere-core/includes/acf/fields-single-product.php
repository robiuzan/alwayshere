<?php
/**
 * ACF field groups — single product personalization.
 *
 * Registers two field groups:
 *  1. Personalization Options (per-product config — shown in WP Admin product edit screen)
 *     - enable_personalization  (true_false) — gates all other fields
 *     - personalization_fields  (repeater)   — each row = one input the customer fills in
 *
 * The customer-facing form is rendered at woocommerce_before_add_to_cart_button (priority 5)
 * by alwayshere_render_personalization_form() in the core plugin.
 *
 * @package alwayshere-core
 */

defined( 'ABSPATH' ) || exit;

// ── Field Group: Personalization Options ─────────────────────────────────────

acf_add_local_field_group( [
	'key'      => 'group_alwayshere_personalization',
	'title'    => 'התאמה אישית של המוצר',
	'fields'   => [

		// Master toggle — hides all other fields when off.
		[
			'key'           => 'field_alwayshere_enable_personalization',
			'label'         => 'אפשר התאמה אישית',
			'name'          => 'alwayshere_enable_personalization',
			'type'          => 'true_false',
			'default_value' => 0,
			'ui'            => 1,
			'ui_on_text'    => 'כן',
			'ui_off_text'   => 'לא',
			'instructions'  => 'הפעל כדי להציג טופס התאמה אישית בדף המוצר.',
		],

		// Repeater — each row defines one customer-facing input.
		[
			'key'               => 'field_alwayshere_personalization_fields',
			'label'             => 'שדות הגדרה',
			'name'              => 'alwayshere_personalization_fields',
			'type'              => 'repeater',
			'instructions'      => 'הוסף שדות שהלקוח ימלא. הסדר משפיע על הצגה.',
			'min'               => 0,
			'max'               => 10,
			'layout'            => 'row',
			'button_label'      => 'הוסף שדה',
			'conditional_logic' => [
				[
					[
						'field'    => 'field_alwayshere_enable_personalization',
						'operator' => '==',
						'value'    => '1',
					],
				],
			],
			'sub_fields' => [

				// Field label shown to customer (e.g. "טקסט לחריטה")
				[
					'key'       => 'field_alwayshere_pf_label',
					'label'     => 'תווית השדה',
					'name'      => 'label',
					'type'      => 'text',
					'required'  => 1,
					'placeholder' => 'לדוגמה: טקסט לחריטה',
				],

				// Input type: text | textarea | select | image | color
				[
					'key'     => 'field_alwayshere_pf_type',
					'label'   => 'סוג שדה',
					'name'    => 'type',
					'type'    => 'select',
					'choices' => [
						'text'     => 'שורה אחת (text)',
						'textarea' => 'פסקה (textarea)',
						'select'   => 'רשימת בחירה (select)',
						'image'    => 'העלאת תמונה (image)',
						'color'    => 'בחירת צבע (color)',
					],
					'default_value' => 'text',
					'return_format' => 'value',
				],

				// Placeholder text shown inside the input.
				[
					'key'         => 'field_alwayshere_pf_placeholder',
					'label'       => 'טקסט עזר (placeholder)',
					'name'        => 'placeholder',
					'type'        => 'text',
					'placeholder' => 'לדוגמה: הכנס שם...',
				],

				// Options for select type (one per line: value|Label).
				[
					'key'               => 'field_alwayshere_pf_options',
					'label'             => 'אפשרויות (לרשימת בחירה)',
					'name'              => 'options',
					'type'              => 'textarea',
					'rows'              => 4,
					'placeholder'       => "שורה אחת לכל אפשרות\nלדוגמה:\nזהב|זהב\nכסף|כסף\nרוז גולד|רוז גולד",
					'instructions'      => 'רשימת בחירה בלבד. פורמט: ערך|תווית — ערך ותווית ניתן לרשום זהה.',
					'conditional_logic' => [
						[
							[
								'field'    => 'field_alwayshere_pf_type',
								'operator' => '==',
								'value'    => 'select',
							],
						],
					],
				],

				// Whether this field is required before add-to-cart.
				[
					'key'           => 'field_alwayshere_pf_required',
					'label'         => 'שדה חובה',
					'name'          => 'required',
					'type'          => 'true_false',
					'default_value' => 1,
					'ui'            => 1,
					'ui_on_text'    => 'כן',
					'ui_off_text'   => 'לא',
				],

				// Aspect ratio hint (image type only).
				[
					'key'               => 'field_alwayshere_pf_image_ratio',
					'label'             => 'יחס גובה-רוחב מומלץ',
					'name'              => 'image_ratio',
					'type'              => 'select',
					'choices'           => [
						'free' => 'חופשי',
						'1:1'  => 'מרובע (1:1)',
						'3:2'  => 'אופקי (3:2)',
						'4:1'  => 'רחב מאוד (4:1)',
						'16:9' => 'פנורמי (16:9)',
					],
					'default_value'     => 'free',
					'return_format'     => 'value',
					'instructions'      => 'מוצג ללקוח כהמלצה. לא אוכף חיתוך.',
					'conditional_logic' => [
						[
							[
								'field'    => 'field_alwayshere_pf_type',
								'operator' => '==',
								'value'    => 'image',
							],
						],
					],
				],

				// Minimum pixel width (image type only).
				[
					'key'               => 'field_alwayshere_pf_image_min_width',
					'label'             => 'רוחב מינימלי (פיקסלים)',
					'name'              => 'image_min_width',
					'type'              => 'number',
					'default_value'     => 800,
					'min'               => 0,
					'max'               => 6000,
					'step'              => 100,
					'instructions'      => 'JS יזהיר לקוח אם התמונה קטנה מדי. 0 = ללא הגבלה.',
					'conditional_logic' => [
						[
							[
								'field'    => 'field_alwayshere_pf_type',
								'operator' => '==',
								'value'    => 'image',
							],
						],
					],
				],

				// Max character limit (for text/textarea only).
				[
					'key'               => 'field_alwayshere_pf_maxlength',
					'label'             => 'מקסימום תווים',
					'name'              => 'maxlength',
					'type'              => 'number',
					'default_value'     => 50,
					'min'               => 1,
					'max'               => 500,
					'step'              => 1,
					'instructions'      => '0 = ללא הגבלה.',
					'conditional_logic' => [
						[
							[
								'field'    => 'field_alwayshere_pf_type',
								'operator' => '==',
								'value'    => 'text',
							],
						],
						[
							[
								'field'    => 'field_alwayshere_pf_type',
								'operator' => '==',
								'value'    => 'textarea',
							],
						],
					],
				],

			], // end sub_fields
		], // end repeater

	],

	'location' => [
		[
			[
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'product',
			],
		],
	],

	'menu_order'            => 10,
	'position'              => 'normal',
	'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'label',
	'active'                => true,
] );

// ── Field Group: Live Preview Canvas ─────────────────────────────────────────

acf_add_local_field_group( [
	'key'      => 'group_alwayshere_preview',
	'title'    => 'תצוגה מקדימה חיה',
	'fields'   => [

		[
			'key'          => 'field_alwayshere_preview_image',
			'label'        => 'תמונת בסיס לתצוגה מקדימה',
			'name'         => 'alwayshere_preview_image',
			'type'         => 'image',
			'return_format'=> 'array',
			'preview_size' => 'medium',
			'instructions' => 'העלה תמונת מוצר "ריקה" (ללא הדפסה) שתשמש כרקע לתצוגה המקדימה. אם ריק — אין תצוגה מקדימה.',
		],

		[
			'key'               => 'field_alwayshere_preview_zone_x',
			'label'             => 'אזור הדפסה — X (% משמאל)',
			'name'              => 'alwayshere_preview_zone_x',
			'type'              => 'number',
			'default_value'     => 20,
			'min'               => 0,
			'max'               => 100,
			'step'              => 1,
			'append'            => '%',
			'instructions'      => 'מרחק השוליים השמאליים של אזור ההדפסה מקצה התמונה (0-100%).',
			'conditional_logic' => [
				[ [ 'field' => 'field_alwayshere_preview_image', 'operator' => '!=empty' ] ],
			],
		],

		[
			'key'               => 'field_alwayshere_preview_zone_y',
			'label'             => 'אזור הדפסה — Y (% מלמעלה)',
			'name'              => 'alwayshere_preview_zone_y',
			'type'              => 'number',
			'default_value'     => 20,
			'min'               => 0,
			'max'               => 100,
			'step'              => 1,
			'append'            => '%',
			'instructions'      => 'מרחק השוליים העליונים של אזור ההדפסה מקצה התמונה (0-100%).',
			'conditional_logic' => [
				[ [ 'field' => 'field_alwayshere_preview_image', 'operator' => '!=empty' ] ],
			],
		],

		[
			'key'               => 'field_alwayshere_preview_zone_w',
			'label'             => 'אזור הדפסה — רוחב (%)',
			'name'              => 'alwayshere_preview_zone_w',
			'type'              => 'number',
			'default_value'     => 60,
			'min'               => 1,
			'max'               => 100,
			'step'              => 1,
			'append'            => '%',
			'instructions'      => 'רוחב אזור ההדפסה כאחוז מרוחב התמונה.',
			'conditional_logic' => [
				[ [ 'field' => 'field_alwayshere_preview_image', 'operator' => '!=empty' ] ],
			],
		],

		[
			'key'               => 'field_alwayshere_preview_zone_h',
			'label'             => 'אזור הדפסה — גובה (%)',
			'name'              => 'alwayshere_preview_zone_h',
			'type'              => 'number',
			'default_value'     => 60,
			'min'               => 1,
			'max'               => 100,
			'step'              => 1,
			'append'            => '%',
			'instructions'      => 'גובה אזור ההדפסה כאחוז מגובה התמונה.',
			'conditional_logic' => [
				[ [ 'field' => 'field_alwayshere_preview_image', 'operator' => '!=empty' ] ],
			],
		],

	],

	'location' => [
		[
			[
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'product',
			],
		],
	],

	'menu_order'            => 11,
	'position'              => 'normal',
	'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'label',
	'active'                => true,
] );
