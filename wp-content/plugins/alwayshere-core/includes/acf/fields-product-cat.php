<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ACF field groups for the product_cat taxonomy.
 * Editable via WP Admin → Products → Categories → Edit Category.
 */
function alwayshere_register_product_cat_fields(): void {

	acf_add_local_field_group( [
		'key'        => 'group_alwayshere_product_cat',
		'title'      => 'הגדרות קטגוריה — Hero',
		'location'   => [ [ [
			'param'    => 'taxonomy',
			'operator' => '==',
			'value'    => 'product_cat',
		] ] ],
		'menu_order' => 0,
		'fields'     => [
			[
				'key'           => 'field_alwayshere_cat_hero_bg',
				'label'         => 'תמונת רקע — Hero',
				'name'          => 'cat_hero_bg',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'instructions'  => 'תמונת רקע לבנר הקטגוריה. גודל מומלץ: 1920×600 פיקסלים (יחס 3.2:1). פורמט: JPG או WebP.',
			],
		],
	] );
}
alwayshere_register_product_cat_fields();
