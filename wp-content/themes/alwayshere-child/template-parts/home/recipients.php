<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$section_title = get_field( 'recipients_title' ) ?: __( 'למי המתנה?', 'alwayshere-child' );
$section_sub   = get_field( 'recipients_sub' )   ?: __( 'בחר את הנמען ומצא את המתנה המושלמת', 'alwayshere-child' );
$section_tag   = __( 'קנה לפי נמען', 'alwayshere-child' );

// Pull recipient WC categories by slug (8 bubbles).
$recipient_slugs = [
	'matana-leisha',
	'matana-legever',
	'matana-lechayyal',
	'labayit',
	'lamisrad',
	'hdpasot-al-muazarim',
	'matana-lachaver',
	'matana-lesaba',
];

$terms = get_terms( [
	'taxonomy'   => 'product_cat',
	'slug'       => $recipient_slugs,
	'hide_empty' => false,
] );

if ( is_wp_error( $terms ) || empty( $terms ) ) return;

// Preserve slug order.
usort( $terms, function ( $a, $b ) use ( $recipient_slugs ) {
	return array_search( $a->slug, $recipient_slugs, true ) - array_search( $b->slug, $recipient_slugs, true );
} );
?>

<section class="ah-recipients" aria-label="<?php echo esc_attr( $section_title ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php echo esc_html( $section_tag ); ?></span>
			<h2 class="ah-section-header__title"><?php echo esc_html( $section_title ); ?></h2>
			<p class="ah-section-header__sub"><?php echo esc_html( $section_sub ); ?></p>
		</div>

		<div class="ah-recipients__grid">
			<?php foreach ( $terms as $term ) :
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$img_url      = $thumbnail_id
					? wp_get_attachment_image_url( $thumbnail_id, 'medium' )
					: wc_placeholder_img_src( 'medium' );
			?>
				<a class="ah-recipients__item" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<figure class="ah-recipients__circle">
						<img
							src="<?php echo esc_url( $img_url ); ?>"
							alt="<?php echo esc_attr( $term->name ); ?>"
							width="150"
							height="150"
							loading="lazy"
						>
					</figure>
					<span class="ah-recipients__label"><?php echo esc_html( $term->name ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
