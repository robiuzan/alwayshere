<?php
/**
 * Template: Product Category Archive (taxonomy-product_cat)
 *
 * Override WooCommerce's default category template with full design control.
 * Sections: hero → sub-category strip → toolbar → product grid → pagination.
 *
 * To activate: place this file at themes/alwayshere-child/woocommerce/taxonomy-product_cat.php
 *
 * @package AlwaysHere_Child
 * @version 9.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$term      = get_queried_object();
$term_id   = $term instanceof WP_Term ? $term->term_id    : 0;
$term_name = $term instanceof WP_Term ? $term->name       : '';
$term_desc = $term instanceof WP_Term ? $term->description : '';

// Fetch direct child sub-categories for the navigation strip.
// hide_empty: true — no dead-end clicks for visitors.
$child_terms = [];
if ( $term_id ) {
	$raw         = get_terms( [
		'taxonomy'   => 'product_cat',
		'parent'     => $term_id,
		'hide_empty' => true,
		'orderby'    => 'menu_order',
		'order'      => 'ASC',
	] );
	$child_terms = is_wp_error( $raw ) ? [] : $raw;
}
?>

<?php /* ── Category Hero ─────────────────────────────────────── */ ?>
<section class="ah-cat-hero" aria-label="<?php echo esc_attr( $term_name ); ?>">
	<div class="ah-container">

		<nav class="ah-cat-hero__breadcrumb" aria-label="<?php esc_attr_e( 'נתיב ניווט', 'alwayshere-child' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'דף הבית', 'alwayshere-child' ); ?></a>
			<span class="ah-cat-hero__sep" aria-hidden="true">›</span>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'חנות', 'alwayshere-child' ); ?></a>
			<span class="ah-cat-hero__sep" aria-hidden="true">›</span>
			<span aria-current="page"><?php echo esc_html( $term_name ); ?></span>
		</nav>

		<h1 class="ah-cat-hero__title"><?php echo esc_html( $term_name ); ?></h1>

		<?php if ( $term_desc ) : ?>
			<p class="ah-cat-hero__desc"><?php echo wp_kses_post( $term_desc ); ?></p>
		<?php endif; ?>

	</div>
</section>

<?php /* ── Sub-category Strip ───────────────────────────────── */ ?>
<?php if ( ! empty( $child_terms ) ) : ?>
<section
	class="ah-cat-subcats"
	aria-label="<?php esc_attr_e( 'קטגוריות משנה', 'alwayshere-child' ); ?>"
>
	<div class="ah-container">
		<ul class="ah-cat-subcats__list" role="list">
			<?php foreach ( $child_terms as $child ) :
				$thumb_id  = get_term_meta( $child->term_id, 'thumbnail_id', true );
				$thumb_url = $thumb_id
					? wp_get_attachment_image_url( $thumb_id, 'thumbnail' )
					: wc_placeholder_img_src( 'thumbnail' );
				// Sanitize at the DB-read boundary (W4).
				$thumb_alt = $thumb_id
					? sanitize_text_field( (string) get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) )
					: $child->name;
			?>
				<li role="listitem">
					<a
						href="<?php echo esc_url( get_term_link( $child ) ); ?>"
						class="ah-subcat-card"
						aria-label="<?php echo esc_attr( $child->name ); ?>"
					>
						<figure class="ah-subcat-card__figure">
							<img
								src="<?php echo esc_url( $thumb_url ); ?>"
								alt="<?php echo esc_attr( $thumb_alt ); ?>"
								width="110"
								height="110"
								loading="lazy"
								class="ah-subcat-card__img"
							>
						</figure>
						<span class="ah-subcat-card__label"><?php echo esc_html( $child->name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php /* ── Toolbar: count + sort ─────────────────────────────── */ ?>
<div
	class="ah-cat-toolbar"
	role="region"
	aria-label="<?php esc_attr_e( 'מיון מוצרים', 'alwayshere-child' ); ?>"
>
	<div class="ah-container">
		<div class="ah-cat-toolbar__inner">

			<p class="ah-cat-toolbar__count">
				<?php
				global $wp_query;
				$found = absint( $wp_query->found_posts );
				/* translators: %d: total number of products in category */
				printf(
					esc_html( _n( 'מוצר אחד', '%d מוצרים', $found, 'alwayshere-child' ) ),
					$found
				);
				?>
			</p>

			<div class="ah-cat-toolbar__sort">
				<?php woocommerce_catalog_ordering(); ?>
			</div>

		</div>
	</div>
</div>

<?php /* ── Product Grid ─────────────────────────────────────── */ ?>
<main
	id="main-content"
	class="ah-cat-main"
	tabindex="-1"
	aria-label="<?php esc_attr_e( 'רשימת מוצרים', 'alwayshere-child' ); ?>"
>
	<div class="ah-container">

		<?php if ( have_posts() ) : ?>

			<ul class="ah-cat-grid" role="list">
				<?php
				global $post;

				while ( have_posts() ) :
					the_post();

					$p = wc_get_product( get_the_ID() );
					if ( ! $p ) {
						continue;
					}

					// Set up WC's global $product so loop template functions work correctly.
					wc_setup_product_data( $post );

					$img_id  = $p->get_image_id();
					$img_url = $img_id
						? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' )
						: wc_placeholder_img_src();
					// Sanitize at the DB-read boundary (W4).
					$img_alt = $img_id
						? sanitize_text_field( (string) get_post_meta( $img_id, '_wp_attachment_image_alt', true ) )
						: $p->get_name();
				?>
					<li class="ah-product-card" role="listitem">

						<?php if ( $p->is_on_sale() ) : ?>
							<span class="ah-product-card__badge">
								<?php esc_html_e( 'מבצע', 'alwayshere-child' ); ?>
							</span>
						<?php endif; ?>

						<a
							href="<?php echo esc_url( get_permalink() ); ?>"
							class="ah-product-card__link"
							aria-label="<?php echo esc_attr( $p->get_name() ); ?>"
						>
							<figure class="ah-product-card__figure">
								<img
									src="<?php echo esc_url( $img_url ); ?>"
									alt="<?php echo esc_attr( $img_alt ); ?>"
									width="300"
									height="300"
									loading="lazy"
									class="ah-product-card__img"
								>
							</figure>

							<div class="ah-product-card__body">
								<h2 class="ah-product-card__name">
									<?php echo esc_html( $p->get_name() ); ?>
								</h2>
								<div class="ah-product-card__price">
									<?php echo wp_kses_post( $p->get_price_html() ); ?>
								</div>
							</div>
						</a>

						<div class="ah-product-card__footer">
							<?php woocommerce_template_loop_add_to_cart(); ?>
						</div>

					</li>
				<?php endwhile; ?>
			</ul>

			<?php woocommerce_pagination(); ?>

		<?php else : ?>

			<div class="ah-cat-empty">
				<p class="ah-cat-empty__msg">
					<?php esc_html_e( 'לא נמצאו מוצרים בקטגוריה זו.', 'alwayshere-child' ); ?>
				</p>
				<a
					href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
					class="ah-btn ah-btn--primary"
				>
					<?php esc_html_e( 'לכל המוצרים', 'alwayshere-child' ); ?>
				</a>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php get_footer();
