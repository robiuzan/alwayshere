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
 * Supported field types: text, textarea, select, image, color.
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

	$ratio_labels = [
		'1:1'  => 'מרובעת (1:1)',
		'3:2'  => 'אופקית (3:2)',
		'4:1'  => 'רחבה (4:1)',
		'16:9' => 'פנורמית (16:9)',
		'free' => '',
	];
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

			<div class="ah-personalization__field" data-field-type="<?php echo esc_attr( $type ); ?>">
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

				<?php elseif ( 'image' === $type ) :
					$ratio      = isset( $field['image_ratio'] ) ? $field['image_ratio'] : 'free';
					$min_width  = isset( $field['image_min_width'] ) ? (int) $field['image_min_width'] : 0;
					$ratio_hint = ( 'free' !== $ratio && isset( $ratio_labels[ $ratio ] ) ) ? $ratio_labels[ $ratio ] : '';
				?>

					<div class="ah-personalization__upload-wrap">
						<input
							type="file"
							id="<?php echo esc_attr( $id ); ?>"
							class="ah-personalization__upload-input"
							accept="image/jpeg,image/png,image/webp"
							data-field-index="<?php echo esc_attr( $index ); ?>"
							<?php echo $min_width > 0 ? 'data-min-width="' . esc_attr( $min_width ) . '"' : ''; ?>
						>
						<input
							type="hidden"
							name="alwayshere_personalization_img_<?php echo esc_attr( $index ); ?>"
							id="<?php echo esc_attr( $id ); ?>_hidden"
						>
						<?php if ( $ratio_hint ) : ?>
							<span class="ah-personalization__upload-hint">
								<?php echo esc_html( 'מומלץ: תמונה ' . $ratio_hint ); ?>
							</span>
						<?php endif; ?>
						<?php if ( $min_width > 0 ) : ?>
							<span class="ah-personalization__upload-hint">
								<?php echo esc_html( 'רזולוציה מינימלית: ' . $min_width . 'px' ); ?>
							</span>
						<?php endif; ?>
						<span class="ah-personalization__upload-status" aria-live="polite"></span>
					</div>

				<?php elseif ( 'color' === $type ) : ?>

					<input
						type="color"
						id="<?php echo esc_attr( $id ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						class="ah-personalization__input ah-personalization__input--color"
						value="#000000"
					>

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

				<?php if ( $maxlength > 0 && in_array( $type, [ 'text', 'textarea' ], true ) ) : ?>
					<span class="ah-personalization__counter" aria-live="polite" data-max="<?php echo esc_attr( $maxlength ); ?>">
						0 / <?php echo esc_html( $maxlength ); ?>
					</span>
				<?php endif; ?>

			</div>

		<?php endforeach; ?>

		<?php
		// Show preview button only when a preview base image is configured.
		$preview_image = get_field( 'alwayshere_preview_image', $product->get_id() );
		if ( ! empty( $preview_image ) ) :
		?>
			<button type="button" class="ah-personalization__preview-btn" id="ah-preview-btn">
				<?php esc_html_e( '👁 הצג תצוגה מקדימה', 'alwayshere-core' ); ?>
			</button>
		<?php endif; ?>

	</div>

	<!-- Live preview modal -->
	<div class="ah-preview-modal" id="ah-preview-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'תצוגה מקדימה של המוצר', 'alwayshere-core' ); ?>">
		<div class="ah-preview-modal__backdrop" id="ah-preview-modal-backdrop"></div>
		<div class="ah-preview-modal__box">
			<button class="ah-preview-modal__close" id="ah-preview-modal-close" aria-label="<?php esc_attr_e( 'סגור', 'alwayshere-core' ); ?>">&#10005;</button>
			<h4 class="ah-preview-modal__title"><?php esc_html_e( 'תצוגה מקדימה', 'alwayshere-core' ); ?></h4>
			<div class="ah-preview-modal__canvas-wrap" id="ah-preview-modal-canvas-wrap">
				<!-- Canvas is moved here by JS when modal opens -->
			</div>
		</div>
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

		$type  = isset( $field['type'] ) ? $field['type'] : 'text';
		$label = isset( $field['label'] ) ? $field['label'] : __( 'שדה', 'alwayshere-core' );

		if ( 'image' === $type ) {
			$img_key = 'alwayshere_personalization_img_' . $index;
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$att_id = isset( $_POST[ $img_key ] ) ? absint( wp_unslash( $_POST[ $img_key ] ) ) : 0;
			if ( $att_id < 1 ) {
				/* translators: %s = field label */
				wc_add_notice( sprintf( __( 'אנא העלה תמונה עבור השדה: %s', 'alwayshere-core' ), $label ), 'error' );
				$passed = false;
			}
			continue;
		}

		$value = isset( $submitted[ $index ] ) ? trim( sanitize_text_field( $submitted[ $index ] ) ) : '';
		if ( '' === $value ) {
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
		$type = isset( $field['type'] ) ? $field['type'] : 'text';

		if ( 'image' === $type ) {
			$img_key = 'alwayshere_personalization_img_' . $index;
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$att_id = isset( $_POST[ $img_key ] ) ? absint( wp_unslash( $_POST[ $img_key ] ) ) : 0;
			if ( $att_id > 0 ) {
				$url = wp_get_attachment_url( $att_id );
				if ( $url ) {
					$saved[ $index ] = [
						'label'         => sanitize_text_field( $field['label'] ?? '' ),
						'value'         => esc_url_raw( $url ),
						'type'          => 'image',
						'attachment_id' => $att_id,
					];
				}
			}
			continue;
		}

		if ( 'color' === $type ) {
			$raw   = isset( $submitted[ $index ] ) ? (string) $submitted[ $index ] : '';
			$value = sanitize_hex_color( $raw ) ?: '';
			if ( '' !== $value ) {
				$saved[ $index ] = [
					'label' => sanitize_text_field( $field['label'] ?? '' ),
					'value' => $value,
					'type'  => 'color',
				];
			}
			continue;
		}

		// text, textarea, select
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
			'label' => sanitize_text_field( $field['label'] ?? '' ),
			'value' => $value,
			'type'  => $type,
		];
	}

	if ( ! empty( $saved ) ) {
		$cart_item_data['alwayshere_personalization'] = $saved;
		// Unique key so WC treats two identical products with different customization as separate line items.
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
		$type = isset( $entry['type'] ) ? $entry['type'] : 'text';

		if ( 'image' === $type ) {
			$item_data[] = [
				'key'     => esc_html( $entry['label'] ),
				'value'   => '',
				'display' => '<img src="' . esc_url( $entry['value'] ) . '" width="60" height="60" style="object-fit:cover;border-radius:4px;display:block;" alt="">',
			];
		} else {
			$item_data[] = [
				'key'   => esc_html( $entry['label'] ),
				'value' => esc_html( $entry['value'] ),
			];
		}
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
		// Data was sanitized at cart-add time. Store raw; escape at output.
		$item->add_meta_data(
			$entry['label'],
			$entry['value'],
			true
		);
	}
}

// ── 6. Inject preview data for canvas JS ─────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'alwayshere_enqueue_preview_data', 20 );

function alwayshere_enqueue_preview_data(): void {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}

	if ( ! wp_script_is( 'alwayshere-single-product', 'enqueued' ) ) {
		return;
	}

	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return;
	}

	$enabled = get_field( 'alwayshere_enable_personalization', $post_id );
	if ( ! $enabled ) {
		return;
	}

	$preview_image = get_field( 'alwayshere_preview_image', $post_id );
	if ( empty( $preview_image ) ) {
		return;
	}

	$base_url = is_array( $preview_image ) ? ( $preview_image['url'] ?? '' ) : wp_get_attachment_url( (int) $preview_image );
	if ( ! $base_url ) {
		return;
	}

	$zone = [
		'x' => (float) ( get_field( 'alwayshere_preview_zone_x', $post_id ) ?: 20 ) / 100,
		'y' => (float) ( get_field( 'alwayshere_preview_zone_y', $post_id ) ?: 20 ) / 100,
		'w' => (float) ( get_field( 'alwayshere_preview_zone_w', $post_id ) ?: 60 ) / 100,
		'h' => (float) ( get_field( 'alwayshere_preview_zone_h', $post_id ) ?: 60 ) / 100,
	];

	wp_localize_script( 'alwayshere-single-product', 'ahPreview', [
		'baseImage'   => esc_url( $base_url ),
		'zone'        => $zone,
		'uploadNonce' => wp_create_nonce( 'alwayshere_personalization_upload' ),
		'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		'i18n'        => [
			'uploading'   => 'מעלה תמונה...',
			'uploadError' => 'שגיאה בהעלאת הקובץ. נסה שוב.',
			'tooSmall'    => 'התמונה קטנה מדי — מומלץ ',
			'uploaded'    => '✓ התמונה הועלתה',
		],
	] );
}
