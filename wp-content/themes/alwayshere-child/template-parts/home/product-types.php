<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$eyebrow = get_field( 'product_types_eyebrow' ) ?: __( 'קטגוריות מוצרים', 'alwayshere-child' );
$title   = get_field( 'product_types_title' )   ?: __( 'מה תרצו לעצב היום?', 'alwayshere-child' );
$sub     = __( 'בחרו קטגוריה וגלו את כל המוצרים שניתן להתאים אישית', 'alwayshere-child' );

$type_slugs = [
	'nerot', 'kosot', 'bakbukim', 'tikim', 'pad-ikhbar',
	'mchazikei-maftechot', 'tachtit-kosot', 'kovaimb', 'machbarot',
	'hdpasa-al-etz',
];

$terms = get_terms( [
	'taxonomy'   => 'product_cat',
	'slug'       => $type_slugs,
	'hide_empty' => false,
	'number'     => 10,
] );

$use_dummy = is_wp_error( $terms ) || empty( $terms );

if ( ! $use_dummy ) {
	usort( $terms, function ( $a, $b ) use ( $type_slugs ) {
		return array_search( $a->slug, $type_slugs, true ) - array_search( $b->slug, $type_slugs, true );
	} );
}

$dummy_types = [
	'נרות', 'כוסות', 'בקבוקים', 'תיקים', 'פד עכבר',
	'מחזיקי מפתחות', 'תחתיות', 'כובעים', 'מחברות', 'הדפסה על עץ',
];
?>

<section class="ah-product-types" aria-label="<?php echo esc_attr( $title ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="ah-section-header__title"><?php echo esc_html( $title ); ?></h2>
			<p class="ah-section-header__sub"><?php echo esc_html( $sub ); ?></p>
		</div>

		<ul class="ah-product-types__grid" role="list">
			<?php if ( $use_dummy ) :
				$placeholder = wc_placeholder_img_src( 'medium' );
				foreach ( $dummy_types as $dummy_name ) : ?>
					<li class="ah-product-types__item" role="listitem">
						<div class="ah-product-types__tile">
							<div class="ah-product-types__bg">
								<img src="<?php echo esc_url( $placeholder ); ?>" alt="<?php echo esc_attr( $dummy_name ); ?>" width="400" height="350" loading="lazy">
							</div>
							<div class="ah-product-types__overlay" aria-hidden="true"></div>
							<div class="ah-product-types__label">
								<span class="ah-product-types__name"><?php echo esc_html( $dummy_name ); ?></span>
								<div class="ah-product-types__arrow" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg></div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			<?php else : ?>
				<?php foreach ( $terms as $term ) :
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$img_url      = $thumbnail_id
						? wp_get_attachment_image_url( $thumbnail_id, 'medium' )
						: wc_placeholder_img_src( 'medium' );
				?>
					<li class="ah-product-types__item" role="listitem">
						<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="ah-product-types__tile">
							<div class="ah-product-types__bg">
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" width="400" height="350" loading="lazy">
							</div>
							<div class="ah-product-types__overlay" aria-hidden="true"></div>
							<div class="ah-product-types__label">
								<span class="ah-product-types__name"><?php echo esc_html( $term->name ); ?></span>
								<div class="ah-product-types__arrow" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg></div>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</section>
