<?php
/**
 * Per-category product ordering.
 *
 * Admin: adds a drag-and-drop product list to the product_cat edit screen.
 * Frontend: applies a custom SQL ORDER BY so pagination works correctly.
 *
 * Order is stored as term meta `alwayshere_product_order` (array of product IDs).
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Category_Order {

	private const META_KEY = 'alwayshere_product_order';

	public static function init(): void {
		// Admin: inject sortable UI into the category edit screen.
		add_action( 'product_cat_edit_form_fields', [ __CLASS__, 'render_order_field' ], 20 );
		add_action( 'edited_product_cat',           [ __CLASS__, 'save_order' ] );
		add_action( 'admin_enqueue_scripts',        [ __CLASS__, 'enqueue_admin_assets' ] );

		// Frontend: apply saved order to the main product-category query.
		add_action( 'pre_get_posts', [ __CLASS__, 'apply_to_query' ] );
		add_filter( 'posts_clauses',  [ __CLASS__, 'inject_orderby' ], 10, 2 );
	}

	// ── Admin UI ─────────────────────────────────────────────────────────────────

	/**
	 * Render the sortable product list on the category edit screen.
	 */
	public static function render_order_field( WP_Term $term ): void {
		$product_ids = self::get_category_product_ids( $term->term_id );

		if ( empty( $product_ids ) ) {
			?>
			<tr class="form-field">
				<th scope="row"><?php esc_html_e( 'סדר מוצרים', 'alwayshere-core' ); ?></th>
				<td><p class="description"><?php esc_html_e( 'אין מוצרים בקטגוריה זו.', 'alwayshere-core' ); ?></p></td>
			</tr>
			<?php
			return;
		}

		$saved_order = self::get_ordered_ids( $term->term_id );

		// Merge: saved order first, then any new products not yet in the list.
		if ( ! empty( $saved_order ) ) {
			$ordered = array_values( array_intersect( $saved_order, $product_ids ) );
			$ordered = array_merge( $ordered, array_diff( $product_ids, $ordered ) );
		} else {
			$ordered = $product_ids;
		}

		wp_nonce_field( 'alwayshere_category_order_' . $term->term_id, 'alwayshere_order_nonce' );
		?>
		<tr class="form-field ah-cat-order-row">
			<th scope="row">
				<label><?php esc_html_e( 'סדר מוצרים', 'alwayshere-core' ); ?></label>
				<p class="description"><?php esc_html_e( 'גרור מוצרים לסידור הרצוי. השינויים יישמרו עם לחיצה על "עדכן".', 'alwayshere-core' ); ?></p>
			</th>
			<td>
				<input
					type="hidden"
					name="alwayshere_product_order"
					id="alwayshere_product_order"
					value="<?php echo esc_attr( implode( ',', $ordered ) ); ?>"
				>
				<ul id="ah-sortable-products" class="ah-sortable-list">
					<?php foreach ( $ordered as $product_id ) :
						$product = wc_get_product( $product_id );
						if ( ! $product ) continue;
						$thumb = get_the_post_thumbnail( $product_id, [ 48, 48 ] );
					?>
					<li class="ah-sortable-item" data-id="<?php echo esc_attr( $product_id ); ?>">
						<span class="ah-sortable-handle dashicons dashicons-menu" aria-hidden="true"></span>
						<span class="ah-sortable-thumb"><?php echo $thumb ?: '<span class="ah-sortable-no-thumb"></span>'; ?></span>
						<span class="ah-sortable-name"><?php echo esc_html( $product->get_name() ); ?></span>
						<span class="ah-sortable-pos"></span>
					</li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
		<?php
	}

	/**
	 * Persist the order when the category edit form is submitted.
	 */
	public static function save_order( int $term_id ): void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		if ( ! isset( $_POST['alwayshere_order_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alwayshere_order_nonce'] ) ), 'alwayshere_category_order_' . $term_id ) ) {
			return;
		}
		if ( ! isset( $_POST['alwayshere_product_order'] ) ) {
			return;
		}

		$raw     = sanitize_text_field( wp_unslash( $_POST['alwayshere_product_order'] ) );
		$ordered = array_filter( array_map( 'absint', explode( ',', $raw ) ) );

		if ( ! empty( $ordered ) ) {
			update_term_meta( $term_id, self::META_KEY, array_values( $ordered ) );
		}
	}

	/**
	 * Enqueue jQuery UI Sortable + inline styles/script on the category edit page.
	 */
	public static function enqueue_admin_assets( string $hook ): void {
		if ( 'term.php' !== $hook ) {
			return;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_GET['taxonomy'] ) || 'product_cat' !== $_GET['taxonomy'] ) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-sortable' );

		// Inline styles for the sortable list.
		wp_add_inline_style( 'wp-admin', '
			.ah-cat-order-row th { padding-top: 1.5rem; }
			.ah-cat-order-row th .description { font-weight: 400; font-style: italic; margin-top: 0.35rem; }
			.ah-sortable-list { list-style: none; margin: 0; padding: 0; max-height: 480px; overflow-y: auto; border: 1px solid #dcdcde; border-radius: 4px; background: #fff; }
			.ah-sortable-item { display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-bottom: 1px solid #f0f0f1; cursor: grab; user-select: none; transition: background .15s; }
			.ah-sortable-item:last-child { border-bottom: none; }
			.ah-sortable-item:hover { background: #f6f7f7; }
			.ah-sortable-item.ui-sortable-helper { box-shadow: 0 4px 12px rgba(0,0,0,.15); background: #fff; cursor: grabbing; border-radius: 4px; }
			.ah-sortable-item.ui-sortable-placeholder { background: #e8f0fe; border: 2px dashed #2271b1; visibility: visible !important; }
			.ah-sortable-handle { color: #999; font-size: 20px; flex-shrink: 0; }
			.ah-sortable-thumb img, .ah-sortable-no-thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 4px; display: block; background: #f0f0f1; flex-shrink: 0; }
			.ah-sortable-name { flex: 1; font-size: 13px; color: #1d2327; direction: rtl; }
			.ah-sortable-pos { font-size: 11px; color: #999; min-width: 24px; text-align: center; flex-shrink: 0; }
		' );

		// Inline JS: init Sortable and keep the hidden input in sync.
		wp_add_inline_script( 'jquery-ui-sortable', '
			jQuery(function($) {
				var $list  = $("#ah-sortable-products");
				var $input = $("#alwayshere_product_order");

				function syncOrder() {
					var ids = $list.find(".ah-sortable-item").map(function(i, el) {
						$(el).find(".ah-sortable-pos").text(i + 1);
						return $(el).data("id");
					}).get();
					$input.val(ids.join(","));
				}

				$list.sortable({
					axis: "y",
					handle: ".ah-sortable-handle",
					placeholder: "ah-sortable-item ui-sortable-placeholder",
					forcePlaceholderSize: true,
					update: syncOrder
				});

				// Set initial position numbers.
				syncOrder();
			});
		' );
	}

	// ── Frontend query ────────────────────────────────────────────────────────────

	/**
	 * Flag the query so our posts_clauses filter knows which query to modify.
	 */
	public static function apply_to_query( WP_Query $query ): void {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}
		if ( ! $query->is_tax( 'product_cat' ) ) {
			return;
		}

		$term = get_queried_object();
		if ( ! $term instanceof WP_Term ) {
			return;
		}

		$ordered = self::get_ordered_ids( $term->term_id );
		if ( empty( $ordered ) ) {
			return;
		}

		// Store on the query so posts_clauses can read it without re-fetching term meta.
		$query->set( 'alwayshere_custom_order', $ordered );
	}

	/**
	 * Inject a FIELD()-based ORDER BY into the SQL for queries that have a saved order.
	 *
	 * Products in the saved list come first, in saved sequence.
	 * Products added to the category later are appended, sorted by newest first.
	 *
	 * @param array    $clauses SQL clause fragments.
	 * @param WP_Query $query   The current query.
	 * @return array Modified clauses.
	 */
	public static function inject_orderby( array $clauses, WP_Query $query ): array {
		$ordered = $query->get( 'alwayshere_custom_order' );
		if ( empty( $ordered ) || ! is_array( $ordered ) ) {
			return $clauses;
		}

		global $wpdb;

		$ids_escaped = implode( ',', array_map( 'intval', $ordered ) );

		$clauses['orderby'] = "
			CASE WHEN {$wpdb->posts}.ID IN ({$ids_escaped}) THEN 0 ELSE 1 END ASC,
			FIELD({$wpdb->posts}.ID, {$ids_escaped}) ASC,
			{$wpdb->posts}.post_date DESC
		";

		return $clauses;
	}

	// ── Helpers ───────────────────────────────────────────────────────────────────

	/**
	 * Get the saved custom order for a category.
	 *
	 * @return int[]
	 */
	public static function get_ordered_ids( int $term_id ): array {
		$order = get_term_meta( $term_id, self::META_KEY, true );
		return is_array( $order ) ? array_map( 'absint', $order ) : [];
	}

	/**
	 * Get all published product IDs in a category (unordered, for building the admin list).
	 *
	 * @return int[]
	 */
	private static function get_category_product_ids( int $term_id ): array {
		$products = wc_get_products( [
			'status'   => 'publish',
			'limit'    => -1,
			'return'   => 'ids',
			'category' => [ get_term( $term_id )->slug ],
		] );

		return is_array( $products ) ? $products : [];
	}
}
