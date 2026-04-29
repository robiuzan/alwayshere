/**
 * Admin Site Settings — repeater UI for trust badges & payment methods,
 * plus media-library picker for the header logo.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', () => {
		// ── Header logo picker (uses WP media library) ─────────────────────────
		initLogoPicker();

		// Remove row
		document.addEventListener('click', (e) => {
			const btn = e.target.closest('.ah-settings__remove-row');
			if (!btn) return;
			btn.closest('tr').remove();
			reindex();
		});

		// Add row
		document.addEventListener('click', (e) => {
			const btn = e.target.closest('.ah-settings__add-row');
			if (!btn) return;

			const tableId = btn.dataset.target;
			const option  = btn.dataset.option;
			const tbody   = document.querySelector(`#${tableId} tbody`);
			const count   = tbody.querySelectorAll('tr').length;

			// Trust badges have icon + text; payments have just a label.
			const isTrust = option.includes('trust');
			const row     = document.createElement('tr');
			row.className = 'ah-settings__row';

			if (isTrust) {
				row.innerHTML = `
					<td><input type="text" name="${option}[${count}][icon]" value="" class="small-text ah-settings__emoji-input"></td>
					<td><input type="text" name="${option}[${count}][text]" value="" class="regular-text"></td>
					<td><button type="button" class="button ah-settings__remove-row">&times;</button></td>
				`;
			} else {
				row.innerHTML = `
					<td><input type="text" name="${option}[${count}]" value="" class="regular-text"></td>
					<td><button type="button" class="button ah-settings__remove-row">&times;</button></td>
				`;
			}

			tbody.appendChild(row);
		});
	});

	/**
	 * Wire up the WP media library to the logo Select / Change / Remove buttons.
	 */
	function initLogoPicker() {
		const selectBtn = document.getElementById('ah-logo-select');
		const removeBtn = document.getElementById('ah-logo-remove');
		const idInput   = document.getElementById('ah-logo-id');
		const preview   = document.getElementById('ah-logo-preview');

		if (!selectBtn || !idInput || !preview || typeof wp === 'undefined' || !wp.media) {
			return;
		}

		let frame = null;

		selectBtn.addEventListener('click', (e) => {
			e.preventDefault();

			if (!frame) {
				frame = wp.media({
					title: 'בחר/י לוגו',
					button: { text: 'השתמש/י בלוגו זה' },
					library: { type: 'image' },
					multiple: false,
				});

				frame.on('select', () => {
					const att = frame.state().get('selection').first().toJSON();
					idInput.value = att.id;
					preview.innerHTML = `<img src="${att.url}" alt="">`;
					selectBtn.textContent = 'החלף לוגו';
					removeBtn.style.display = '';
				});
			}

			frame.open();
		});

		if (removeBtn) {
			removeBtn.addEventListener('click', (e) => {
				e.preventDefault();
				idInput.value = '0';
				preview.innerHTML = '<span class="ah-settings__logo-empty">לא נבחר לוגו — משתמש בברירת מחדל.</span>';
				selectBtn.textContent = 'בחר/י לוגו';
				removeBtn.style.display = 'none';
			});
		}
	}

	/**
	 * Re-index all row inputs so PHP receives sequential keys.
	 */
	function reindex() {
		document.querySelectorAll('.ah-settings__repeater').forEach((table) => {
			const rows = table.querySelectorAll('tbody tr');
			rows.forEach((row, i) => {
				row.querySelectorAll('input').forEach((input) => {
					input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
				});
			});
		});
	}
})();
