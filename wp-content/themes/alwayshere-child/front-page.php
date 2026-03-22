<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// Read enabled sections from ACF. Fall back to all sections if field not yet set.
$enabled_raw = get_field( 'homepage_sections' );
$enabled     = array_flip( is_array( $enabled_raw ) && count( $enabled_raw ) > 0
	? $enabled_raw
	: [ 'hero', 'recipients', 'promo_banner', 'featured_products', 'best_sellers', 'occasions', 'product_types', 'trust', 'newsletter' ]
);
?>

<main id="ah-homepage" class="ah-homepage" role="main">
	<?php if ( isset( $enabled['hero'] ) )              : ?><?php get_template_part( 'template-parts/home/hero' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['recipients'] ) )        : ?><?php get_template_part( 'template-parts/home/recipients' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['promo_banner'] ) )      : ?><?php get_template_part( 'template-parts/home/promo-banner' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['featured_products'] ) ) : ?><?php get_template_part( 'template-parts/home/featured-products' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['best_sellers'] ) )      : ?><?php get_template_part( 'template-parts/home/best-sellers' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['occasions'] ) )         : ?><?php get_template_part( 'template-parts/home/occasions' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['product_types'] ) )     : ?><?php get_template_part( 'template-parts/home/product-types' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['trust'] ) )             : ?><?php get_template_part( 'template-parts/home/trust' ); ?><?php endif; ?>
	<?php if ( isset( $enabled['newsletter'] ) )        : ?><?php get_template_part( 'template-parts/home/newsletter' ); ?><?php endif; ?>
</main>

<?php get_footer();
