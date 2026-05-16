<?php
/**
 * Cross-category filter chips on product category archive pages.
 *
 * Admin: adds a "קטגוריות סינון" ACF checkbox to the product_cat edit screen.
 * The admin selects which other categories should appear as filter chips.
 *
 * Frontend: renders a chip strip above the product grid. Clicking a chip
 * narrows the listing to products that are also in the selected category.
 * Single-select; pagination and sort order are preserved.
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Alwayshere_Category_Filters {

	private const FIELD_KEY   = 'cat_filter_categories';
	private const ACF_KEY     = 'field_alwayshere_cat_filter_categories';
	private const QUERY_PARAM = 'ah_filter';

	public static function init(): void {
		// Populate ACF checkbox choices server-side (avoids AJAX taxonomy loading).
		add_filter( 'acf/load_field/key=' . self::ACF_KEY, [ __CLASS__, 'load_acf_choices' ] );

		// Modify the main product-category query when a filter is active.
		add_action( 'pre_get_posts', [ __CLASS__, 'apply_to_query' ] );

		// Preserve the active filter across WooCommerce pagination pages.
		add_filter( 'woocommerce_pagination_args', [ __CLASS__, 'preserve_in_pagination' ] );

		// Preserve the active filter when the WooCommerce sort-by form is submitted.
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_sort_preservation_script' ] );
	}

	// ── ACF field choices ─────────────────────────────────────────────────────────

	/**
	 * Populate the filter-categories checkbox with all product_cat terms,
	 * excluding the term currently being edited.
	 */
	public static function load_acf_choices( array $field ): array {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$current_term_id = isset( $_GET['tag_ID'] ) ? absint( $_GET['tag_ID'] ) : 0;

		$terms = get_terms( [
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'exclude'    => $current_term_id ? [ $current_term_id ] : [],
		] );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return $field;
		}

		$choices = [];
		foreach ( $terms as $term ) {
			// Use term_id as key so get_field() returns integer IDs directly.
			$choices[ $term->term_id ] = $term->name;
		}

		$field['choices'] = $choices;
		return $field;
	}

	// ── Frontend query ────────────────────────────────────────────────────────────

	/**
	 * Append a tax_query clause to intersect with the active filter category.
	 * Runs on pre_get_posts — safe to call before the query executes.
	 */
	public static function apply_to_query( WP_Query $query ): void {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_tax( 'product_cat' ) ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$filter_id = isset( $_GET[ self::QUERY_PARAM ] ) ? absint( $_GET[ self::QUERY_PARAM ] ) : 0;
		if ( ! $filter_id ) {
			return;
		}

		// Guard 1: the filter term must exist in product_cat.
		$filter_term = get_term( $filter_id, 'product_cat' );
		if ( ! $filter_term instanceof WP_Term ) {
			return;
		}

		// Guard 2: the filter term must be in the admin-configured allowed list.
		$current_term = get_queried_object();
		if ( ! $current_term instanceof WP_Term ) {
			return;
		}

		$allowed = function_exists( 'get_field' )
			? (array) get_field( self::FIELD_KEY, 'product_cat_' . $current_term->term_id )
			: [];

		if ( ! in_array( $filter_id, array_map( 'intval', $allowed ), true ) ) {
			return;
		}

		// Add the intersection clause. The existing clause for the current category
		// (added automatically by WP's taxonomy query) stays intact.
		$tq             = (array) $query->get( 'tax_query' );
		$tq[]           = [
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $filter_id,
		];
		$tq['relation'] = 'AND';
		$query->set( 'tax_query', $tq );
	}

	// ── Pagination + sort preservation ───────────────────────────────────────────

	/**
	 * Inject ah_filter into WooCommerce pagination link args so the filter
	 * is preserved when navigating between pages.
	 */
	public static function preserve_in_pagination( array $args ): array {
		if ( ! is_tax( 'product_cat' ) ) {
			return $args;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$filter_id = isset( $_GET[ self::QUERY_PARAM ] ) ? absint( $_GET[ self::QUERY_PARAM ] ) : 0;
		if ( ! $filter_id ) {
			return $args;
		}

		if ( ! isset( $args['add_args'] ) || ! is_array( $args['add_args'] ) ) {
			$args['add_args'] = [];
		}
		$args['add_args'][ self::QUERY_PARAM ] = $filter_id;
		return $args;
	}

	/**
	 * Add a tiny inline script so the WooCommerce ordering form carries the
	 * active filter when the visitor changes the sort-by dropdown.
	 */
	public static function enqueue_sort_preservation_script(): void {
		if ( ! is_tax( 'product_cat' ) ) {
			return;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( empty( $_GET[ self::QUERY_PARAM ] ) ) {
			return;
		}

		// Append after jQuery (always present on WC pages).
		wp_add_inline_script( 'jquery', '
			(function(){
				var form = document.querySelector(".woocommerce-ordering");
				if (!form) return;
				form.addEventListener("submit", function() {
					var filterId = new URLSearchParams(window.location.search).get("ah_filter");
					if (!filterId) return;
					var inp = document.createElement("input");
					inp.type = "hidden";
					inp.name = "ah_filter";
					inp.value = filterId;
					form.appendChild(inp);
				});
			})();
		' );
	}

	// ── Template helper ───────────────────────────────────────────────────────────

	/**
	 * Render the filter chip strip for a category page.
	 * Outputs nothing if no filter categories are configured for this term.
	 *
	 * @param int $term_id The current product_cat term ID.
	 */
	public static function render_chips( int $term_id ): void {
		if ( ! function_exists( 'get_field' ) ) {
			return;
		}

		$saved_ids = (array) get_field( self::FIELD_KEY, 'product_cat_' . $term_id );
		$saved_ids = array_filter( array_map( 'intval', $saved_ids ) );

		if ( empty( $saved_ids ) ) {
			return;
		}

		// Resolve term objects — skip any that no longer exist.
		$filter_terms = [];
		foreach ( $saved_ids as $id ) {
			$term = get_term( $id, 'product_cat' );
			if ( $term instanceof WP_Term ) {
				$filter_terms[] = $term;
			}
		}

		if ( empty( $filter_terms ) ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$active_id = isset( $_GET[ self::QUERY_PARAM ] ) ? absint( $_GET[ self::QUERY_PARAM ] ) : 0;

		// Total count for the "הכל" chip — WP's built-in term count (published products).
		$current_term  = get_term( $term_id, 'product_cat' );
		$total_count   = $current_term instanceof WP_Term ? (int) $current_term->count : 0;

		// Chip URLs: preserve sort order, reset page number, swap/clear the filter.
		$base_no_filter = esc_url( remove_query_arg( [ self::QUERY_PARAM, 'paged' ] ) );
		?>
		<nav
			class="ah-cat-filters"
			aria-label="<?php esc_attr_e( 'סינון מוצרים', 'alwayshere-core' ); ?>"
		>
			<div class="ah-container">
				<ul class="ah-cat-filters__list" role="list">

					<li class="ah-cat-filters__item">
						<a
							href="<?php echo $base_no_filter; // Already escaped above. ?>"
							class="ah-cat-filters__chip<?php echo ! $active_id ? ' is-active' : ''; ?>"
							<?php echo ! $active_id ? 'aria-current="page"' : ''; ?>
						>
							<?php esc_html_e( 'הכל', 'alwayshere-core' ); ?>
							<span class="ah-cat-filters__count"><?php echo esc_html( $total_count ); ?></span>
						</a>
					</li>

					<?php foreach ( $filter_terms as $ft ) :
						$is_active       = ( $active_id === $ft->term_id );
						$intersect_count = self::get_intersection_count( $term_id, $ft->term_id );
						$chip_url        = esc_url(
							add_query_arg(
								self::QUERY_PARAM,
								$ft->term_id,
								remove_query_arg( [ self::QUERY_PARAM, 'paged' ] )
							)
						);
					?>
					<li class="ah-cat-filters__item">
						<a
							href="<?php echo $chip_url; // Already escaped above. ?>"
							class="ah-cat-filters__chip<?php echo $is_active ? ' is-active' : ''; ?>"
							<?php echo $is_active ? 'aria-current="page"' : ''; ?>
						>
							<?php echo esc_html( $ft->name ); ?>
							<span class="ah-cat-filters__count"><?php echo esc_html( $intersect_count ); ?></span>
						</a>
					</li>
					<?php endforeach; ?>

				</ul>
			</div>
		</nav>
		<?php
	}

	/**
	 * Count published products that belong to both category A and category B.
	 * Result is cached in a transient (1 hour) to avoid repeated DB hits.
	 */
	private static function get_intersection_count( int $term_a_id, int $term_b_id ): int {
		$cache_key = 'ah_count_' . min( $term_a_id, $term_b_id ) . '_' . max( $term_a_id, $term_b_id );
		$cached    = get_transient( $cache_key );

		if ( false !== $cached ) {
			return (int) $cached;
		}

		$ids = get_posts( [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'fields'         => 'ids',
			'posts_per_page' => -1,
			'tax_query'      => [
				'relation' => 'AND',
				[
					'taxonomy'         => 'product_cat',
					'field'            => 'term_id',
					'terms'            => $term_a_id,
					'include_children' => true,
				],
				[
					'taxonomy'         => 'product_cat',
					'field'            => 'term_id',
					'terms'            => $term_b_id,
					'include_children' => true,
				],
			],
		] );

		$count = is_array( $ids ) ? count( $ids ) : 0;
		set_transient( $cache_key, $count, HOUR_IN_SECONDS );
		return $count;
	}
}
