<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="ah-homepage" class="ah-homepage" role="main">
	<?php get_template_part( 'template-parts/home/hero' ); ?>
	<?php get_template_part( 'template-parts/home/recipients' ); ?>
	<?php get_template_part( 'template-parts/home/promo-banner' ); ?>
	<?php get_template_part( 'template-parts/home/featured-products' ); ?>
	<?php get_template_part( 'template-parts/home/best-sellers' ); ?>
	<?php get_template_part( 'template-parts/home/occasions' ); ?>
	<?php get_template_part( 'template-parts/home/product-types' ); ?>
	<?php get_template_part( 'template-parts/home/trust' ); ?>
	<?php get_template_part( 'template-parts/home/newsletter' ); ?>
</main>

<?php get_footer();
