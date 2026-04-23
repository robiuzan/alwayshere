<?php
/**
 * My Account dashboard — welcome, stats, previews.
 *
 * WC template override: woocommerce/templates/myaccount/dashboard.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
$first_name   = $current_user->first_name ?: $current_user->display_name;

// Time-of-day greeting.
$hour = (int) current_time( 'G' );
if ( $hour >= 5 && $hour < 12 ) {
	$greeting = 'בוקר טוב';
} elseif ( $hour >= 12 && $hour < 17 ) {
	$greeting = 'צהריים טובים';
} elseif ( $hour >= 17 && $hour < 21 ) {
	$greeting = 'ערב טוב';
} else {
	$greeting = 'לילה טוב';
}

// Quick stats.
$customer_orders = wc_get_orders( [
	'customer' => $current_user->ID,
	'status'   => array_map( 'esc_attr', wc_get_is_paid_statuses() ),
	'limit'    => -1,
	'return'   => 'ids',
] );
$total_orders = count( $customer_orders );

$total_spent = 0;
foreach ( $customer_orders as $order_id ) {
	$order = wc_get_order( $order_id );
	if ( $order ) {
		$total_spent += (float) $order->get_total();
	}
}

$member_since = date_i18n( 'F Y', strtotime( $current_user->user_registered ) );

// Recent orders (last 3).
$recent_orders = wc_get_orders( [
	'customer' => $current_user->ID,
	'limit'    => 3,
	'orderby'  => 'date',
	'order'    => 'DESC',
] );

// Favorites preview (last 4).
$favorite_ids = [];
if ( class_exists( 'Alwayshere_Favorites' ) ) {
	$all_favs     = Alwayshere_Favorites::get_all( $current_user->ID );
	$favorite_ids = array_slice( $all_favs, 0, 4 );
}

// Recently viewed preview (last 4).
$recently_viewed_ids = [];
if ( class_exists( 'Alwayshere_Recently_Viewed' ) ) {
	$recently_viewed_ids = Alwayshere_Recently_Viewed::get( 4 );
}
?>

<div class="ah-dashboard">

	<!-- ─── Greeting ────────────────────────────────────────────────── -->
	<div class="ah-dashboard__greeting">
		<h2><?php echo esc_html( $greeting . ', ' . $first_name . '!' ); ?></h2>
		<p><?php esc_html_e( 'ברוכים הבאים ללוח הבקרה שלך. כאן תוכלו לנהל את ההזמנות, המועדפים ופרטי החשבון.', 'alwayshere-child' ); ?></p>
	</div>

	<!-- ─── Stats ───────────────────────────────────────────────────── -->
	<div class="ah-dashboard__stats">
		<div class="ah-dashboard__stat">
			<span class="ah-dashboard__stat-value"><?php echo esc_html( $total_orders ); ?></span>
			<span class="ah-dashboard__stat-label"><?php esc_html_e( 'הזמנות', 'alwayshere-child' ); ?></span>
		</div>
		<div class="ah-dashboard__stat">
			<span class="ah-dashboard__stat-value"><?php echo wp_kses_post( wc_price( $total_spent ) ); ?></span>
			<span class="ah-dashboard__stat-label"><?php esc_html_e( 'סה"כ קניות', 'alwayshere-child' ); ?></span>
		</div>
		<div class="ah-dashboard__stat">
			<span class="ah-dashboard__stat-value"><?php echo esc_html( $member_since ); ?></span>
			<span class="ah-dashboard__stat-label"><?php esc_html_e( 'חבר/ה מאז', 'alwayshere-child' ); ?></span>
		</div>
	</div>

	<!-- ─── Recent Orders Preview ──────────────────────────────────── -->
	<section class="ah-dashboard__section">
		<div class="ah-dashboard__section-header">
			<h3><?php esc_html_e( 'הזמנות אחרונות', 'alwayshere-child' ); ?></h3>
			<?php if ( $total_orders > 0 ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="ah-dashboard__view-all">
					<?php esc_html_e( 'הצג הכל', 'alwayshere-child' ); ?> &larr;
				</a>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $recent_orders ) ) : ?>
			<div class="ah-dashboard__orders-preview">
				<?php foreach ( $recent_orders as $order ) : ?>
					<div class="ah-order-mini">
						<div class="ah-order-mini__info">
							<span class="ah-order-mini__number">
								<?php
								/* translators: %s: order number */
								echo esc_html( sprintf( 'הזמנה #%s', $order->get_order_number() ) );
								?>
							</span>
							<span class="ah-order-mini__date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
						</div>
						<div class="ah-order-mini__meta">
							<?php
							$status_label = wc_get_order_status_name( $order->get_status() );
							?>
							<span class="ah-order-mini__status ah-order-mini__status--<?php echo esc_attr( $order->get_status() ); ?>">
								<?php echo esc_html( $status_label ); ?>
							</span>
							<span class="ah-order-mini__total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="ah-dashboard__empty"><?php esc_html_e( 'עדיין אין הזמנות. הגיע הזמן למצוא מתנה מושלמת!', 'alwayshere-child' ); ?></p>
		<?php endif; ?>
	</section>

	<!-- ─── Favorites Preview ──────────────────────────────────────── -->
	<section class="ah-dashboard__section">
		<div class="ah-dashboard__section-header">
			<h3><?php esc_html_e( 'מועדפים', 'alwayshere-child' ); ?></h3>
			<?php if ( ! empty( $favorite_ids ) ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'favorites' ) ); ?>" class="ah-dashboard__view-all">
					<?php esc_html_e( 'הצג הכל', 'alwayshere-child' ); ?> &larr;
				</a>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $favorite_ids ) ) : ?>
			<div class="ah-dashboard__product-grid">
				<?php foreach ( $favorite_ids as $pid ) :
					$product = wc_get_product( $pid );
					if ( ! $product ) continue;
					?>
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="ah-product-mini">
						<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'ah-product-mini__img' ] ); ?>
						<span class="ah-product-mini__name"><?php echo esc_html( $product->get_name() ); ?></span>
						<span class="ah-product-mini__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="ah-dashboard__empty"><?php esc_html_e( 'עדיין לא שמרת מועדפים. לחצו על ❤ ליד מוצרים שאהבתם!', 'alwayshere-child' ); ?></p>
		<?php endif; ?>
	</section>

	<!-- ─── Recently Viewed Preview ────────────────────────────────── -->
	<section class="ah-dashboard__section">
		<div class="ah-dashboard__section-header">
			<h3><?php esc_html_e( 'נצפו לאחרונה', 'alwayshere-child' ); ?></h3>
			<?php if ( ! empty( $recently_viewed_ids ) ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'recently-viewed' ) ); ?>" class="ah-dashboard__view-all">
					<?php esc_html_e( 'הצג הכל', 'alwayshere-child' ); ?> &larr;
				</a>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $recently_viewed_ids ) ) : ?>
			<div class="ah-dashboard__product-grid">
				<?php foreach ( $recently_viewed_ids as $pid ) :
					$product = wc_get_product( $pid );
					if ( ! $product ) continue;
					?>
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="ah-product-mini">
						<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'ah-product-mini__img' ] ); ?>
						<span class="ah-product-mini__name"><?php echo esc_html( $product->get_name() ); ?></span>
						<span class="ah-product-mini__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="ah-dashboard__empty"><?php esc_html_e( 'עדיין לא צפיתם במוצרים. גלו את המתנות שלנו!', 'alwayshere-child' ); ?></p>
		<?php endif; ?>
	</section>

</div>
