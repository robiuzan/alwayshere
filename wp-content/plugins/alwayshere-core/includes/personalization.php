<?php
/**
 * Product personalization — form render, cart meta, order meta.
 *
 * Flow:
 *  1. Admin configures personalization fields per product via ACF.
 *  2. Customer fills in the form on the product page (rendered below).
 *  3. Submitted values are validated + attached to the cart item.
 *  4. On order placement, values are copied to order item meta.
 *  5. Values display in: cart, checkout, order emails, admin order screen.
 *
 * @package alwayshere-core
 */

defined( 'ABSPATH' ) || exit;

// ── 1. Render customer-facing form ───────────────────────────────────────────

add_action( 'woocommerce_before_add_to_cart_button', 'alwayshere_render_personalization_form', 5 );

function alwayshere_render_personalization_form(): void {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$enabled = get_field( 'alwayshere_enable_personalization', $product->get_id() );
	if ( ! $enabled ) {
		return;
	}

	$fields = get_field( 'alwayshere_personalization_fields', $product->get_id() );
	if ( empty( $fields ) || ! is_array( $fields ) ) {
		return;
	}
	?>

	<div class="ah-personalization" data-ah-personalization>
		<h3 class="ah-personalization__heading">
			<?php esc_html_e( 'התאמה אישית', 'alwayshere-core' ); ?>
		</h3>

		<?php foreach ( $fields as $index => $field ) :
			$id          = 'ah_pf_' . $index;
			$name        = 'alwayshere_personalization[' . $index . ']';
			$label       = isset( $field['label'] ) ? $field['label'] : '';
			$type        = isset( $field['type'] )  ? $field['type']  : 'text';
			$placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
			$required    = ! empty( $field['required'] );
			$maxlength   = isset( $field['maxlength'] ) ? (int) $field['maxlength'] : 0;
			$options_raw = isset( $field['options'] ) ? $field['options'] : '';
		?>

			<div class="ah-personalization__field">
				<label class="ah-personalization__label" for="<?php echo esc_attr( $id ); ?>">
					<?php echo esc_html( $label ); ?>
					<?php if ( $required ) : ?>
						<span class="ah-personalization__required" aria-hidden="true"> *</span>
					<?php endif; ?>
				</label>

				<?php if ( 'textarea' === $type ) : ?>

					<textarea
						id="<?php echo esc_attr( $id ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						class="ah-personalization__input ah-personalization__input--textarea"
						placeholder="<?php echo esc_attr( $placeholder ); ?>"
						<?php echo $required ? 'required' : ''; ?>
						<?php echo $maxlength > 0 ? 'maxlength="' . esc_attr( $maxlength ) . '"' : ''; ?>
						rows="3"
					></textarea>

				<?php elseif ( 'select' === $type ) :
					// Parse options — one per line: value|Label or just value.
					$lines = array_filter( array_map( 'trim', explode( "\n", $options_raw ) ) );
				?>

					<select
						id="<?php echo esc_attr( $id ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						class="ah-personalization__input ah-personalization__input--select"
						<?php echo $required ? 'required' : ''; ?>
					>
						<option value=""><?php esc_html_e( 'בחר...', 'alwayshere-core' ); ?></option>
						<?php foreach ( $lines as $line ) :
							$parts = explode( '|', $line, 2 );
							$val   = trim( $parts[0] );
							$lbl   = isset( $parts[1] ) ? trim( $parts[1] ) : $val;
						?>
							<option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $lbl ); ?></option>
						<?php endforeach; ?>
					</select>

				<?php else : // text (default) ?>

					<input
						type="text"
						id="<?php echo esc_attr( $id ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						class="ah-personalization__input"
						placeholder="<?php echo esc_attr( $placeholder ); ?>"
						<?php echo $required ? 'required' : ''; ?>
						<?php echo $maxlength > 0 ? 'maxlength="' . esc_attr( $maxlength ) . '"' : ''; ?>
					>

				<?php endif; ?>

				<?php if ( $maxlength > 0 && 'select' !== $type ) : ?>
					<span class="ah-personalization__counter" aria-live="polite" data-max="<?php echo esc_attr( $maxlength ); ?>">
						0 / <?php echo esc_html( $maxlength ); ?>
					</span>
				<?php endif; ?>

			</div>

		<?php endforeach; ?>
	</div>

	<?php
}

// ── 2. Validate on add-to-cart ────────────────────────────────────────────────

add_filter( 'woocommerce_add_to_cart_validation', 'alwayshere_validate_personalization', 10, 2 );

function alwayshere_validate_personalization( bool $passed, int $product_id ): bool {
	if ( ! function_exists( 'get_field' ) ) {
		return $passed;
	}

	$enabled = get_field( 'alwayshere_enable_personalization', $product_id );
	if ( ! $enabled ) {
		return $passed;
	}

	$defined_fields = get_field( 'alwayshere_personalization_fields', $product_id );
	if ( empty( $defined_fields ) ) {
		return $passed;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Missing — WC handles nonce upstream.
	$submitted = isset( $_POST['alwayshere_personalization'] )
		? (array) wp_unslash( $_POST['alwayshere_personalization'] )
		: [];

	foreach ( $defined_fields as $index => $field ) {
		if ( empty( $field['required'] ) ) {
			continue;
		}

		$value = isset( $submitted[ $index ] ) ? trim( sanitize_text_field( $submitted[ $index ] ) ) : '';
		if ( '' === $value ) {
			$label = isset( $field['label'] ) ? $field['label'] : __( 'שדה', 'alwayshere-core' );
			/* translators: %s = field label */
			wc_add_notice( sprintf( __( 'אנא מלא את השדה: %s', 'alwayshere-core' ), $label ), 'error' );
			$passed = false;
		}
	}

	return $passed;
}

// ── 3. Attach to cart item ────────────────────────────────────────────────────

add_filter( 'woocommerce_add_cart_item_data', 'alwayshere_add_personalization_to_cart', 10, 2 );

function alwayshere_add_personalization_to_cart( array $cart_item_data, int $product_id ): array {
	if ( ! function_exists( 'get_field' ) ) {
		return $cart_item_data;
	}

	$enabled = get_field( 'alwayshere_enable_personalization', $product_id );
	if ( ! $enabled ) {
		return $cart_item_data;
	}

	$defined_fields = get_field( 'alwayshere_personalization_fields', $product_id );
	if ( empty( $defined_fields ) ) {
		return $cart_item_data;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Missing — WC handles nonce upstream.
	$submitted = isset( $_POST['alwayshere_personalization'] )
		? (array) wp_unslash( $_POST['alwayshere_personalization'] )
		: [];

	$saved = [];
	foreach ( $defined_fields as $index => $field ) {
		$raw   = isset( $submitted[ $index ] ) ? $submitted[ $index ] : '';
		$value = sanitize_text_field( $raw );

		if ( '' === $value ) {
			continue;
		}

		$maxlength = isset( $field['maxlength'] ) ? (int) $field['maxlength'] : 0;
		if ( $maxlength > 0 && mb_strlen( $value, 'UTF-8' ) > $maxlength ) {
			$value = mb_substr( $value, 0, $maxlength, 'UTF-8' );
		}

		$saved[ $index ] = [
			'label' => isset( $field['label'] ) ? sanitize_text_field( $field['label'] ) : '',
			'value' => $value,
		];
	}

	if ( ! empty( $saved ) ) {
		$cart_item_data['alwayshere_personalization'] = $saved;
		// Unique key so WC treats two identical products with different text as separate line items.
		$cart_item_data['alwayshere_personalization_key'] = md5( (string) json_encode( $saved ) );
	}

	return $cart_item_data;
}

// ── 4. Display in cart & checkout ────────────────────────────────────────────

add_filter( 'woocommerce_get_item_data', 'alwayshere_display_personalization_in_cart', 10, 2 );

function alwayshere_display_personalization_in_cart( array $item_data, array $cart_item ): array {
	if ( empty( $cart_item['alwayshere_personalization'] ) ) {
		return $item_data;
	}

	foreach ( $cart_item['alwayshere_personalization'] as $entry ) {
		$item_data[] = [
			'key'   => esc_html( $entry['label'] ),
			'value' => esc_html( $entry['value'] ),
		];
	}

	return $item_data;
}

// ── 5. Copy to order item meta on checkout ───────────────────────────────────

add_action( 'woocommerce_checkout_create_order_line_item', 'alwayshere_save_personalization_to_order', 10, 4 );

function alwayshere_save_personalization_to_order(
	WC_Order_Item_Product $item,
	string $cart_item_key,
	array $values,
	WC_Order $order
): void {
	if ( empty( $values['alwayshere_personalization'] ) ) {
		return;
	}

	foreach ( $values['alwayshere_personalization'] as $entry ) {
		// Data was sanitized with sanitize_text_field() at cart-add time. Store raw; escape at output.
		$item->add_meta_data(
			$entry['label'],
			$entry['value'],
			true
		);
	}
}
