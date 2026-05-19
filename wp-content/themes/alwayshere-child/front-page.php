<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$active = (array) ( get_field( 'homepage_sections' ) ?: [
	'hero', 'marquee', 'recipients', 'promo_banner', 'featured_products',
	'best_sellers', 'reviews', 'occasions', 'product_types', 'trust', 'newsletter',
] );

$show = static function ( string $key, string $part ) use ( $active ): void {
	if ( in_array( $key, $active, true ) ) {
		get_template_part( $part );
	}
};
?>

<main id="ah-homepage" class="ah-homepage" role="main">
	<?php $show( 'hero',              'template-parts/home/hero' ); ?>
	<?php $show( 'marquee',           'template-parts/home/marquee' ); ?>
	<?php $show( 'recipients',        'template-parts/home/recipients' ); ?>
	<?php $show( 'promo_banner',      'template-parts/home/promo-banner' ); ?>
	<?php $show( 'featured_products', 'template-parts/home/featured-products' ); ?>
	<?php $show( 'best_sellers',      'template-parts/home/best-sellers' ); ?>
	<?php $show( 'reviews',           'template-parts/home/reviews' ); ?>
	<?php $show( 'occasions',         'template-parts/home/occasions' ); ?>
	<?php $show( 'product_types',     'template-parts/home/product-types' ); ?>
	<?php $show( 'trust',             'template-parts/home/trust' ); ?>
	<?php $show( 'newsletter',        'template-parts/home/newsletter' ); ?>
</main>

<?php get_footer();
