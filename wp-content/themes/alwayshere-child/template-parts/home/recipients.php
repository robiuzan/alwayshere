<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Recipient categories — top row by slug.
$recipient_slugs = [
	'matana-leisha',
	'matana-legever',
	'matana-lechayyal',
	'labayit',
	'lamisrad',
	'hdpasot-al-muazarim',
];

$recipient_terms = get_terms( [
	'taxonomy'   => 'product_cat',
	'slug'       => $recipient_slugs,
	'hide_empty' => false,
] );

// Occasion categories — bottom row.
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

$occasion_terms = get_terms( [
	'taxonomy'   => 'product_cat',
	'slug'       => $occasion_slugs,
	'hide_empty' => false,
] );
?>

<section class="ah-recipients" aria-label="<?php esc_attr_e( 'למי המתנה?', 'alwayshere-child' ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<h2 class="ah-section-header__title"><?php esc_html_e( 'למי המתנה?', 'alwayshere-child' ); ?></h2>
			<p class="ah-section-header__sub"><?php esc_html_e( 'בחרו את הנמען ומצאו מתנה שיאהבו', 'alwayshere-child' ); ?></p>
		</div>

		<?php if ( ! is_wp_error( $recipient_terms ) && $recipient_terms ) : ?>
			<div class="ah-recipients__track" role="list">
				<?php foreach ( $recipient_terms as $term ) :
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$img_url      = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' ) : wc_placeholder_img_src( 'thumbnail' );
				?>
					<a class="ah-recipients__item" href="<?php echo esc_url( get_term_link( $term ) ); ?>" role="listitem">
						<figure class="ah-recipients__circle">
							<img
								src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $term->name ); ?>"
								width="110"
								height="110"
								loading="lazy"
							>
						</figure>
						<span class="ah-recipients__label"><?php echo esc_html( $term->name ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! is_wp_error( $occasion_terms ) && $occasion_terms ) : ?>
			<div class="ah-recipients__track ah-recipients__track--occasions" role="list">
				<?php foreach ( $occasion_terms as $term ) :
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$img_url      = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' ) : wc_placeholder_img_src( 'thumbnail' );
				?>
					<a class="ah-recipients__item" href="<?php echo esc_url( get_term_link( $term ) ); ?>" role="listitem">
						<figure class="ah-recipients__circle">
							<img
								src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $term->name ); ?>"
								width="110"
								height="110"
								loading="lazy"
							>
						</figure>
						<span class="ah-recipients__label"><?php echo esc_html( $term->name ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
