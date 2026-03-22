<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$type_slugs = [
	'nerot', 'kovaimb', 'bakbukim', 'kosot', 'machbarot',
	'tmunot', 'atim', 'tikim', 'mchazikei-maftechot',
	'hdpasa-al-zkhukhit', 'hdpasa-al-etz', 'pazal',
	'pad-ikhbar', 'cholazot', 'magavot', 'tachtit-kosot',
];

$terms = get_terms( [
	'taxonomy'   => 'product_cat',
	'slug'       => $type_slugs,
	'hide_empty' => false,
	'number'     => 12,
] );

if ( is_wp_error( $terms ) || empty( $terms ) ) return;
?>

<section class="ah-product-types" aria-label="<?php esc_attr_e( 'מה תרצו לעצב היום?', 'alwayshere-child' ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php esc_html_e( 'קולקציה מלאה', 'alwayshere-child' ); ?></span>
			<h2 class="ah-section-header__title"><?php esc_html_e( 'מה תרצו לעצב היום?', 'alwayshere-child' ); ?></h2>
		</div>

		<ul class="ah-product-types__grid" role="list">
			<?php foreach ( $terms as $term ) :
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$img_url      = $thumbnail_id
					? wp_get_attachment_image_url( $thumbnail_id, 'medium' )
					: wc_placeholder_img_src( 'medium' );
				$img_alt      = $thumbnail_id
					? get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true )
					: $term->name;
			?>
				<li class="ah-product-types__item" role="listitem">
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="ah-product-types__tile">
						<figure class="ah-product-types__image-wrap">
							<img
								src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $img_alt ); ?>"
								width="200"
								height="200"
								loading="lazy"
							>
						</figure>
						<span class="ah-product-types__label"><?php echo esc_html( $term->name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
