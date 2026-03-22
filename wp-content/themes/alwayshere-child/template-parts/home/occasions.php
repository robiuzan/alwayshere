<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$occasion_slugs = [
	'yom-huledet',
	'chatuna',
	'leida-ubrita',
	'bar-bat-mitzva',
	'yom-nisuin',
	'yom-ahava',
	'chagim',
	'stam-ki-ba-lecha',
];

$terms = get_terms( [
	'taxonomy'   => 'product_cat',
	'slug'       => $occasion_slugs,
	'hide_empty' => false,
] );

if ( is_wp_error( $terms ) || empty( $terms ) ) return;

// Re-order by the slug array order.
usort( $terms, function( $a, $b ) use ( $occasion_slugs ) {
	return array_search( $a->slug, $occasion_slugs, true ) - array_search( $b->slug, $occasion_slugs, true );
} );
?>

<section class="ah-occasions" aria-label="<?php esc_attr_e( 'לאיזה אירוע המתנה?', 'alwayshere-child' ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php esc_html_e( 'מתנה לכל רגע', 'alwayshere-child' ); ?></span>
			<h2 class="ah-section-header__title"><?php esc_html_e( 'לאיזה אירוע המתנה?', 'alwayshere-child' ); ?></h2>
		</div>

		<ul class="ah-occasions__grid" role="list">
			<?php foreach ( $terms as $term ) :
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$img_url      = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';
				$term_link    = get_term_link( $term );
			?>
				<li class="ah-occasions__item" role="listitem">
					<a
						href="<?php echo esc_url( $term_link ); ?>"
						class="ah-occasions__tile"
						aria-label="<?php echo esc_attr( $term->name ); ?>"
						<?php if ( $img_url ) : ?>
							style="--bg-image: url('<?php echo esc_url( $img_url ); ?>')"
						<?php endif; ?>
					>
						<span class="ah-occasions__overlay" aria-hidden="true"></span>
						<span class="ah-occasions__name"><?php echo esc_html( $term->name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
