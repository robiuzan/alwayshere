<?php
/**
 * Single product — custom image gallery.
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

global $product;

$main_id = $product->get_image_id();
$gallery = $product->get_gallery_image_ids();
$all_ids = array_filter( array_merge( [ $main_id ], $gallery ) );

$sale_pct = '';
if ( $product->is_on_sale() ) {
	$regular = (float) $product->get_regular_price();
	$sale    = (float) $product->get_price();
	if ( $regular > 0 ) {
		$sale_pct = round( ( ( $regular - $sale ) / $regular ) * 100 );
	}
}
?>

<div class="ah-gallery" data-ah-gallery>

	<?php if ( $sale_pct ) : ?>
		<span class="ah-gallery__badge" aria-hidden="true">-<?php echo esc_html( $sale_pct ); ?>%</span>
	<?php endif; ?>

	<figure class="ah-gallery__main" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<?php if ( $main_id ) : ?>
			<img
				src="<?php echo esc_url( wp_get_attachment_image_url( $main_id, 'large' ) ); ?>"
				alt="<?php echo esc_attr( get_post_meta( $main_id, '_wp_attachment_image_alt', true ) ?: get_the_title() ); ?>"
				class="ah-gallery__main-img"
				id="ah-gallery-main"
				loading="eager"
			>
		<?php else : ?>
			<img
				src="<?php echo esc_url( wc_placeholder_img_src( 'large' ) ); ?>"
				alt="<?php esc_attr_e( 'תמונת מוצר', 'alwayshere-child' ); ?>"
				class="ah-gallery__main-img"
				id="ah-gallery-main"
				loading="eager"
			>
		<?php endif; ?>
	</figure>

	<?php if ( count( $all_ids ) > 1 ) : ?>
		<div class="ah-gallery__thumbs" role="list" aria-label="<?php esc_attr_e( 'גלריה', 'alwayshere-child' ); ?>">
			<?php foreach ( $all_ids as $i => $img_id ) :
				$thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
				$large_url = wp_get_attachment_image_url( $img_id, 'large' );
				$alt       = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: get_the_title();
				if ( ! $thumb_url ) continue;
				$active = ( 0 === $i );
			?>
				<button
					class="ah-gallery__thumb<?php echo $active ? ' is-active' : ''; ?>"
					role="listitem"
					data-large="<?php echo esc_url( $large_url ); ?>"
					data-alt="<?php echo esc_attr( $alt ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'הצג תמונה %d', 'alwayshere-child' ), $i + 1 ) ); ?>"
					aria-pressed="<?php echo $active ? 'true' : 'false'; ?>"
				>
					<img
						src="<?php echo esc_url( $thumb_url ); ?>"
						alt="<?php echo esc_attr( $alt ); ?>"
						loading="lazy"
					>
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
