<?php
/**
 * Meta Pixel — conversion tracking for Facebook/Instagram ads.
 *
 * Fires: PageView, ViewContent, AddToCart, InitiateCheckout, Purchase.
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

const ALWAYSHERE_META_PIXEL_ID = '4374601092751521';

/**
 * Base pixel — fires PageView on every page.
 * Priority 1 so it loads before other scripts.
 */
add_action( 'wp_head', 'alwayshere_meta_pixel_base', 1 );
function alwayshere_meta_pixel_base(): void {
	if ( is_admin() ) {
		return;
	}
	?>
	<!-- Meta Pixel — base -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', <?php echo wp_json_encode( ALWAYSHERE_META_PIXEL_ID ); ?>);
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none" alt=""
		src="https://www.facebook.com/tr?id=<?php echo esc_attr( ALWAYSHERE_META_PIXEL_ID ); ?>&ev=PageView&noscript=1"/></noscript>
	<!-- End Meta Pixel -->
	<?php
}

/**
 * ViewContent — fires on single product pages (in footer so product data is loaded).
 */
add_action( 'wp_footer', 'alwayshere_meta_pixel_view_content' );
function alwayshere_meta_pixel_view_content(): void {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}

	global $product;
	if ( ! $product instanceof WC_Product ) {
		$product = wc_get_product( get_queried_object_id() );
	}
	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$categories = wp_get_post_terms( $product->get_id(), 'product_cat', [ 'fields' => 'names' ] );
	?>
	<script>
	if ( typeof fbq !== 'undefined' ) {
		fbq( 'track', 'ViewContent', {
			content_ids: [ <?php echo wp_json_encode( (string) $product->get_id() ); ?> ],
			content_name: <?php echo wp_json_encode( $product->get_name() ); ?>,
			content_type: 'product',
			content_category: <?php echo wp_json_encode( implode( ', ', $categories ) ); ?>,
			value: <?php echo wp_json_encode( (float) $product->get_price() ); ?>,
			currency: 'ILS'
		} );
	}
	</script>
	<?php
}

/**
 * AddToCart — fires when a product is added to cart.
 * Uses a transient flag so the event fires on the next page load (covers both AJAX and form submits).
 */
add_action( 'woocommerce_add_to_cart', 'alwayshere_meta_pixel_flag_add_to_cart', 10, 6 );
function alwayshere_meta_pixel_flag_add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ): void {
	$product = wc_get_product( $variation_id ?: $product_id );
	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$payload = [
		'content_ids'  => [ (string) $product->get_id() ],
		'content_name' => $product->get_name(),
		'content_type' => 'product',
		'value'        => (float) $product->get_price() * (int) $quantity,
		'currency'     => 'ILS',
	];

	// Store per-session so we can fire the event on the next page render.
	if ( ! WC()->session ) {
		return;
	}
	$queue = WC()->session->get( 'alwayshere_pixel_queue', [] );
	$queue[] = [ 'event' => 'AddToCart', 'data' => $payload ];
	WC()->session->set( 'alwayshere_pixel_queue', $queue );
}

/**
 * Flush queued pixel events (e.g. AddToCart) on the next page render.
 */
add_action( 'wp_footer', 'alwayshere_meta_pixel_flush_queue', 5 );
function alwayshere_meta_pixel_flush_queue(): void {
	if ( ! function_exists( 'WC' ) || ! WC()->session ) {
		return;
	}
	$queue = WC()->session->get( 'alwayshere_pixel_queue', [] );
	if ( empty( $queue ) ) {
		return;
	}
	WC()->session->set( 'alwayshere_pixel_queue', [] );
	?>
	<script>
	if ( typeof fbq !== 'undefined' ) {
		<?php foreach ( $queue as $item ) : ?>
			fbq( 'track', <?php echo wp_json_encode( $item['event'] ); ?>, <?php echo wp_json_encode( $item['data'] ); ?> );
		<?php endforeach; ?>
	}
	</script>
	<?php
}

/**
 * InitiateCheckout — fires on the checkout page.
 */
add_action( 'wp_footer', 'alwayshere_meta_pixel_initiate_checkout' );
function alwayshere_meta_pixel_initiate_checkout(): void {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() ) {
		return;
	}
	if ( ! function_exists( 'WC' ) || ! WC()->cart || WC()->cart->is_empty() ) {
		return;
	}

	$ids   = [];
	$names = [];
	foreach ( WC()->cart->get_cart() as $item ) {
		$product = $item['data'];
		if ( $product instanceof WC_Product ) {
			$ids[]   = (string) $product->get_id();
			$names[] = $product->get_name();
		}
	}
	?>
	<script>
	if ( typeof fbq !== 'undefined' ) {
		fbq( 'track', 'InitiateCheckout', {
			content_ids: <?php echo wp_json_encode( $ids ); ?>,
			content_type: 'product',
			num_items: <?php echo (int) WC()->cart->get_cart_contents_count(); ?>,
			value: <?php echo wp_json_encode( (float) WC()->cart->get_total( 'edit' ) ); ?>,
			currency: 'ILS'
		} );
	}
	</script>
	<?php
}

/**
 * Purchase — fires on the order-received (thank you) page.
 * Uses order meta to prevent duplicate firing on refresh.
 */
add_action( 'woocommerce_thankyou', 'alwayshere_meta_pixel_purchase', 10, 1 );
function alwayshere_meta_pixel_purchase( $order_id ): void {
	if ( ! $order_id ) {
		return;
	}
	$order = wc_get_order( $order_id );
	if ( ! $order instanceof WC_Order ) {
		return;
	}

	// Don't double-fire if the user refreshes the thank-you page.
	if ( $order->get_meta( '_alwayshere_pixel_purchase_fired' ) === 'yes' ) {
		return;
	}
	$order->update_meta_data( '_alwayshere_pixel_purchase_fired', 'yes' );
	$order->save();

	$ids = [];
	foreach ( $order->get_items() as $item ) {
		$ids[] = (string) $item->get_product_id();
	}
	?>
	<script>
	if ( typeof fbq !== 'undefined' ) {
		fbq( 'track', 'Purchase', {
			content_ids: <?php echo wp_json_encode( $ids ); ?>,
			content_type: 'product',
			num_items: <?php echo (int) $order->get_item_count(); ?>,
			value: <?php echo wp_json_encode( (float) $order->get_total() ); ?>,
			currency: <?php echo wp_json_encode( $order->get_currency() ); ?>,
			order_id: <?php echo wp_json_encode( (string) $order_id ); ?>
		} );
	}
	</script>
	<?php
}
