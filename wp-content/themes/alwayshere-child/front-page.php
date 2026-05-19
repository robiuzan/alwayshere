<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$layout_map = [
	'hero'             => 'template-parts/home/hero',
	'marquee'          => 'template-parts/home/marquee',
	'recipients'       => 'template-parts/home/recipients',
	'promo_banner'     => 'template-parts/home/promo-banner',
	'featured_products'=> 'template-parts/home/featured-products',
	'best_sellers'     => 'template-parts/home/best-sellers',
	'reviews'          => 'template-parts/home/reviews',
	'occasions'        => 'template-parts/home/occasions',
	'product_types'    => 'template-parts/home/product-types',
	'trust'            => 'template-parts/home/trust',
	'newsletter'       => 'template-parts/home/newsletter',
];
?>

<main id="ah-homepage" class="ah-homepage" role="main">
	<?php if ( have_rows( 'home_sections' ) ) :
		while ( have_rows( 'home_sections' ) ) : the_row();
			$layout = get_row_layout();
			if ( isset( $layout_map[ $layout ] ) ) {
				get_template_part( $layout_map[ $layout ] );
			}
		endwhile;
	else :
		// Fallback: render all sections in default order when no flexible content is configured.
		foreach ( $layout_map as $template ) {
			get_template_part( $template );
		}
	endif; ?>
</main>

<?php get_footer();
