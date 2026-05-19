<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$eyebrow = get_field( 'occasions_eyebrow' ) ?: __( 'מתנות לפי אירוע', 'alwayshere-child' );
$title   = get_field( 'occasions_title' )   ?: __( 'לאיזה אירוע המתנה?', 'alwayshere-child' );
$sub     = __( 'בחרו את האירוע ומצאו את המתנה המושלמת', 'alwayshere-child' );

// Subtitle per slug — used for both ACF-selected and default terms.
$subtitles = [
	'yom-huledet'      => 'מתנות שיגרמו לחיוך',
	'chatuna'          => 'לרגע הכי מיוחד',
	'leida-ubrita'     => 'ברוך הבא לעולם',
	'bar-bat-mitzva'   => 'מזל טוב!',
	'yom-nisuin'       => 'חוגגים אהבה',
	'yom-ahava'        => 'מהלב שלך ללב שלו/ה',
	'chagim'           => 'מתנות לכל חג',
	'stam-ki-ba-lecha' => 'בלי סיבה, עם הרבה אהבה',
];

// Use ACF-selected categories when set; fall back to hardcoded slugs.
$acf_slugs = get_field( 'occasions_categories' );

if ( ! empty( $acf_slugs ) && is_array( $acf_slugs ) ) {
	$raw   = get_terms( [
		'taxonomy'   => 'product_cat',
		'slug'       => $acf_slugs,
		'hide_empty' => false,
	] );
	$terms = is_wp_error( $raw ) ? [] : array_values( $raw );
	usort( $terms, fn( $a, $b ) =>
		array_search( $a->slug, $acf_slugs, true ) - array_search( $b->slug, $acf_slugs, true )
	);
} else {
	$occasion_slugs = [
		'yom-huledet', 'chatuna', 'leida-ubrita', 'bar-bat-mitzva',
		'yom-nisuin', 'yom-ahava', 'chagim', 'stam-ki-ba-lecha',
	];
	$terms = get_terms( [
		'taxonomy'   => 'product_cat',
		'slug'       => $occasion_slugs,
		'hide_empty' => false,
	] );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		usort( $terms, fn( $a, $b ) =>
			array_search( $a->slug, $occasion_slugs, true ) - array_search( $b->slug, $occasion_slugs, true )
		);
	}
}

$use_dummy = is_wp_error( $terms ) || empty( $terms );

$dummy_occasions = [
	[ 'name' => 'יום הולדת', 'sub' => 'מתנות שיגרמו לחיוך' ],
	[ 'name' => 'חתונה',     'sub' => 'לרגע הכי מיוחד' ],
	[ 'name' => 'לידה וברית','sub' => 'ברוך הבא לעולם' ],
	[ 'name' => 'בר/בת מצווה','sub' => 'מזל טוב!' ],
	[ 'name' => 'יום נישואים','sub' => 'חוגגים אהבה' ],
	[ 'name' => 'ולנטיין',   'sub' => 'מהלב שלך ללב שלו/ה' ],
	[ 'name' => 'חגים',      'sub' => 'מתנות לכל חג' ],
	[ 'name' => 'סתם כי בא לך','sub' => 'בלי סיבה, עם הרבה אהבה' ],
];
?>

<section class="ah-occasions ah-occasions--gray" aria-label="<?php echo esc_attr( $title ); ?>">
	<div class="ah-container">
		<div class="ah-section-header">
			<span class="ah-section-header__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="ah-section-header__title"><?php echo esc_html( $title ); ?></h2>
			<p class="ah-section-header__sub"><?php echo esc_html( $sub ); ?></p>
		</div>

		<div class="ah-occasions__grid">
			<?php if ( $use_dummy ) :
				foreach ( $dummy_occasions as $dummy ) : ?>
					<div class="ah-occasions__tile">
						<div class="ah-occasions__bg"></div>
						<div class="ah-occasions__overlay" aria-hidden="true"></div>
						<div class="ah-occasions__text">
							<span class="ah-occasions__name"><?php echo esc_html( $dummy['name'] ); ?></span>
							<span class="ah-occasions__sub"><?php echo esc_html( $dummy['sub'] ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
			<?php foreach ( $terms as $term ) :
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$img_url      = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';
				$term_link    = get_term_link( $term );
				$sub_text     = $subtitles[ $term->slug ] ?? '';
			?>
				<a
					href="<?php echo esc_url( $term_link ); ?>"
					class="ah-occasions__tile"
					aria-label="<?php echo esc_attr( $term->name ); ?>"
				>
					<div class="ah-occasions__bg">
						<?php if ( $img_url ) : ?>
							<img src="<?php echo esc_url( $img_url ); ?>" alt="" loading="lazy">
						<?php endif; ?>
					</div>
					<div class="ah-occasions__overlay" aria-hidden="true"></div>
					<div class="ah-occasions__text">
						<span class="ah-occasions__name"><?php echo esc_html( $term->name ); ?></span>
						<?php if ( $sub_text ) : ?>
							<span class="ah-occasions__sub"><?php echo esc_html( $sub_text ); ?></span>
						<?php endif; ?>
					</div>
				</a>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
