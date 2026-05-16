/**
 * Admin Site Settings — repeater UI for trust badges & payment methods.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', () => {
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
