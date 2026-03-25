(function () {
	'use strict';

	function triggerQtyChange(input) {
		// Native event (for non-jQuery listeners)
		input.dispatchEvent(new Event('change', { bubbles: true }));

		// jQuery event — WC's cart.js listens via $(document).on('change', '.qty')
		// and keeps the update button disabled until this fires.
		if (window.jQuery) {
			window.jQuery(input).trigger('change');
		}

		// Explicitly enable the update button regardless, as a fallback.
		var form = input.closest('.woocommerce-cart-form');
		if (form) {
			var updateBtn = form.querySelector('[name="update_cart"]');
			if (updateBtn) {
				updateBtn.disabled = false;
				updateBtn.removeAttribute('disabled');
			}
		}
	}

	function initQtyButtons() {
		document.querySelectorAll('.quantity').forEach(function (wrapper) {
			if (wrapper.dataset.qtyInit) return;
			wrapper.dataset.qtyInit = '1';

			var input = wrapper.querySelector('input.qty');
			if (!input) return;

			var minus = document.createElement('button');
			minus.type = 'button';
			minus.className = 'ah-qty-btn ah-qty-btn--minus';
			minus.setAttribute('aria-label', 'הפחת כמות');
			minus.textContent = '−';

			var plus = document.createElement('button');
			plus.type = 'button';
			plus.className = 'ah-qty-btn ah-qty-btn--plus';
			plus.setAttribute('aria-label', 'הגדל כמות');
			plus.textContent = '+';

			wrapper.insertBefore(minus, input);
			wrapper.appendChild(plus);

			minus.addEventListener('click', function () {
				var val = parseInt(input.value, 10) || 1;
				var min = parseInt(input.min, 10) || 1;
				if (val > min) {
					input.value = val - 1;
					triggerQtyChange(input);
				}
			});

			plus.addEventListener('click', function () {
				var val = parseInt(input.value, 10) || 1;
				var max = parseInt(input.max, 10);
				if (!max || val < max) {
					input.value = val + 1;
					triggerQtyChange(input);
				}
			});

			// Also handle manual edits in the number input
			input.addEventListener('change', function () {
				var form = input.closest('.woocommerce-cart-form');
				if (!form) return;
				var updateBtn = form.querySelector('[name="update_cart"]');
				if (updateBtn) {
					updateBtn.disabled = false;
					updateBtn.removeAttribute('disabled');
				}
			});
		});
	}

	document.addEventListener('DOMContentLoaded', initQtyButtons);

	// Re-init after WC AJAX cart fragment updates
	document.body.addEventListener('wc_fragments_refreshed', initQtyButtons);
	document.body.addEventListener('wc_fragments_loaded', initQtyButtons);
	document.body.addEventListener('updated_cart_totals', initQtyButtons);
}());
