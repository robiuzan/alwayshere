<?php
/**
 * Template for the Contact page (/contact/).
 *
 * Replaces the default page loop with a custom elegant layout.
 * Form submission is handled via AJAX → alwayshere_handle_contact_form().
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<style>
/* ── Contact page scoped styles ─────────────────────────────────────────── */
.ah-cp {
	padding-block: 4rem 5rem;
	background: #fafafa;
}

.ah-cp__hero {
	text-align: center;
	padding-block-end: 3rem;
}

.ah-cp__hero-tag {
	display: inline-block;
	font-size: 0.8125rem;
	font-weight: 700;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: var(--accent);
	background: color-mix(in srgb, var(--accent) 10%, transparent);
	padding: 0.3rem 0.9rem;
	border-radius: 999px;
	margin-block-end: 1rem;
}

.ah-cp__hero h1 {
	font-size: clamp(2rem, 4vw, 2.75rem);
	font-weight: 900;
	color: var(--dark);
	margin: 0 0 0.75rem;
	line-height: 1.15;
}

.ah-cp__hero p {
	font-size: 1.0625rem;
	color: var(--text-muted, #666);
	max-inline-size: 480px;
	margin-inline: auto;
	line-height: 1.7;
}

/* ── Two-column grid ─────────────────────────────────────────────────────── */
.ah-cp__grid {
	display: grid;
	grid-template-columns: 1fr 1.55fr;
	gap: 2rem;
	max-inline-size: 1060px;
	margin-inline: auto;
	padding-inline: 1.25rem;
	align-items: start;
}

@media (max-width: 768px) {
	.ah-cp__grid { grid-template-columns: 1fr; }
}

/* ── Info panel ─────────────────────────────────────────────────────────── */
.ah-cp__info {
	display: flex;
	flex-direction: column;
	gap: 1rem;
}

.ah-cp__info-card {
	background: #fff;
	border: 1.5px solid var(--gray-border, #e8e8e8);
	border-radius: var(--radius-md, 0.875rem);
	padding: 1.25rem 1.5rem;
	display: flex;
	align-items: flex-start;
	gap: 1rem;
	transition: box-shadow 0.18s ease, border-color 0.18s ease;
}

.ah-cp__info-card:hover {
	border-color: color-mix(in srgb, var(--accent) 40%, transparent);
	box-shadow: 0 4px 18px rgba(0,0,0,0.07);
}

.ah-cp__info-icon {
	width: 2.5rem;
	height: 2.5rem;
	flex-shrink: 0;
	border-radius: 50%;
	background: color-mix(in srgb, var(--accent) 12%, transparent);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 1.125rem;
}

.ah-cp__info-body strong {
	display: block;
	font-size: 0.8125rem;
	font-weight: 700;
	color: var(--text-muted, #888);
	text-transform: uppercase;
	letter-spacing: 0.06em;
	margin-block-end: 0.2rem;
}

.ah-cp__info-body a,
.ah-cp__info-body span {
	font-size: 0.9375rem;
	color: var(--dark);
	text-decoration: none;
	font-weight: 500;
	line-height: 1.5;
}

.ah-cp__info-body a:hover { color: var(--accent); }

.ah-cp__info-body small {
	display: block;
	font-size: 0.8125rem;
	color: var(--text-muted, #888);
	margin-block-start: 0.15rem;
}

.ah-cp__hours {
	background: linear-gradient(135deg, color-mix(in srgb, var(--accent) 8%, #fff), #fff);
	border: 1.5px solid color-mix(in srgb, var(--accent) 25%, transparent);
	border-radius: var(--radius-md, 0.875rem);
	padding: 1.25rem 1.5rem;
}

.ah-cp__hours h3 {
	font-size: 0.8rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.07em;
	color: var(--accent);
	margin: 0 0 0.75rem;
}

.ah-cp__hours-row {
	display: flex;
	justify-content: space-between;
	font-size: 0.875rem;
	padding-block: 0.3rem;
	border-block-end: 1px solid var(--gray-border, #eee);
	color: var(--dark);
}

.ah-cp__hours-row:last-child { border-block-end: none; }

/* ── Form panel ─────────────────────────────────────────────────────────── */
.ah-cp__form-panel {
	background: #fff;
	border: 1.5px solid var(--gray-border, #e8e8e8);
	border-radius: var(--radius-md, 0.875rem);
	padding: 2rem 2rem 2.25rem;
	box-shadow: 0 2px 20px rgba(0,0,0,0.05);
}

.ah-cp__form-panel h2 {
	font-size: 1.375rem;
	font-weight: 800;
	color: var(--dark);
	margin: 0 0 0.375rem;
}

.ah-cp__form-panel > p {
	font-size: 0.9rem;
	color: var(--text-muted, #777);
	margin: 0 0 1.75rem;
}

.ah-cf {
	display: flex;
	flex-direction: column;
	gap: 1.125rem;
}

.ah-cf__row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 1rem;
}

@media (max-width: 500px) {
	.ah-cf__row { grid-template-columns: 1fr; }
}

.ah-cf__field label {
	display: block;
	font-size: 0.8125rem;
	font-weight: 700;
	color: var(--dark);
	margin-block-end: 0.35rem;
}

.ah-cf__field label span[aria-hidden] { color: var(--accent); }

.ah-cf__field input,
.ah-cf__field select,
.ah-cf__field textarea {
	inline-size: 100%;
	padding: 0.65rem 0.875rem;
	border: 1.5px solid var(--gray-border, #ddd);
	border-radius: var(--radius-sm, 0.5rem);
	font-family: var(--font);
	font-size: 0.9375rem;
	color: var(--dark);
	background: #fafafa;
	transition: border-color 0.15s ease, box-shadow 0.15s ease;
	box-sizing: border-box;
	direction: rtl;
}

.ah-cf__field input:focus,
.ah-cf__field select:focus,
.ah-cf__field textarea:focus {
	outline: none;
	border-color: var(--accent);
	box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 18%, transparent);
	background: #fff;
}

.ah-cf__field textarea { resize: vertical; min-block-size: 120px; }

.ah-cf__submit {
	display: flex;
	align-items: center;
	gap: 1rem;
	flex-wrap: wrap;
}

.ah-cf__btn {
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	padding: 0.8rem 2rem;
	background: var(--accent);
	color: #fff;
	font-family: var(--font);
	font-size: 1rem;
	font-weight: 800;
	border: none;
	border-radius: 999px;
	cursor: pointer;
	transition: background 0.18s ease, transform 0.18s ease;
}

.ah-cf__btn:hover { background: var(--accent-hover, #5a2d8a); transform: translateY(-1px); }
.ah-cf__btn:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

.ah-cf__status {
	font-size: 0.9rem;
	font-weight: 600;
}

.ah-cf__status.is-success { color: #1a7f4e; }
.ah-cf__status.is-error   { color: #c0392b; }
</style>

<main class="ah-cp" id="ah-contact-main">
	<div class="ah-container">

		<!-- Hero -->
		<header class="ah-cp__hero">
			<span class="ah-cp__hero-tag"><?php esc_html_e( 'נשמח לשמוע מכם', 'alwayshere-child' ); ?></span>
			<h1><?php esc_html_e( 'צרו קשר', 'alwayshere-child' ); ?></h1>
			<p><?php esc_html_e( 'שאלה, בקשה מיוחדת, או סתם רוצים לשמוע עוד? הצוות שלנו כאן בשבילכם.', 'alwayshere-child' ); ?></p>
		</header>

		<!-- Grid -->
		<div class="ah-cp__grid">

			<!-- Info column -->
			<div class="ah-cp__info">

				<a href="tel:0556601006" class="ah-cp__info-card" style="text-decoration:none;">
					<div class="ah-cp__info-icon">📞</div>
					<div class="ah-cp__info-body">
						<strong><?php esc_html_e( 'טלפון', 'alwayshere-child' ); ?></strong>
						<span>055-6601006</span>
						<small><?php esc_html_e( 'ימים א׳–ה׳, 09:00–18:00', 'alwayshere-child' ); ?></small>
					</div>
				</a>

				<a href="mailto:info@alwayshere.co.il" class="ah-cp__info-card" style="text-decoration:none;">
					<div class="ah-cp__info-icon">📧</div>
					<div class="ah-cp__info-body">
						<strong><?php esc_html_e( 'דוא"ל', 'alwayshere-child' ); ?></strong>
						<span>info@alwayshere.co.il</span>
						<small><?php esc_html_e( 'נחזור תוך יום עסקים', 'alwayshere-child' ); ?></small>
					</div>
				</a>

				<a href="https://wa.me/9720556601006" target="_blank" rel="noopener noreferrer" class="ah-cp__info-card" style="text-decoration:none;">
					<div class="ah-cp__info-icon">💬</div>
					<div class="ah-cp__info-body">
						<strong><?php esc_html_e( 'וואטסאפ', 'alwayshere-child' ); ?></strong>
						<span><?php esc_html_e( 'שלחו הודעה', 'alwayshere-child' ); ?></span>
						<small><?php esc_html_e( 'מענה מהיר בשעות הפעילות', 'alwayshere-child' ); ?></small>
					</div>
				</a>

				<div class="ah-cp__info-card">
					<div class="ah-cp__info-icon">📍</div>
					<div class="ah-cp__info-body">
						<strong><?php esc_html_e( 'כתובת', 'alwayshere-child' ); ?></strong>
						<span><?php esc_html_e( 'דרך שרה 25/2', 'alwayshere-child' ); ?></span>
						<small><?php esc_html_e( 'זכרון יעקב', 'alwayshere-child' ); ?></small>
					</div>
				</div>

				<!-- Hours -->
				<div class="ah-cp__hours">
					<h3><?php esc_html_e( 'שעות פעילות', 'alwayshere-child' ); ?></h3>
					<div class="ah-cp__hours-row">
						<span><?php esc_html_e( 'ראשון – חמישי', 'alwayshere-child' ); ?></span>
						<span>09:00 – 18:00</span>
					</div>
					<div class="ah-cp__hours-row">
						<span><?php esc_html_e( 'שישי', 'alwayshere-child' ); ?></span>
						<span>09:00 – 13:00</span>
					</div>
					<div class="ah-cp__hours-row">
						<span><?php esc_html_e( 'שבת וחגים', 'alwayshere-child' ); ?></span>
						<span><?php esc_html_e( 'סגור', 'alwayshere-child' ); ?></span>
					</div>
				</div>

			</div><!-- /.ah-cp__info -->

			<!-- Form panel -->
			<div class="ah-cp__form-panel">
				<h2><?php esc_html_e( 'שלחו לנו הודעה', 'alwayshere-child' ); ?></h2>
				<p><?php esc_html_e( 'מלאו את הטופס ונחזור אליכם בהקדם האפשרי.', 'alwayshere-child' ); ?></p>

				<form class="ah-cf" id="ah-contact-form" novalidate>

					<div class="ah-cf__row">
						<div class="ah-cf__field">
							<label for="ah_contact_name">
								<?php esc_html_e( 'שם מלא', 'alwayshere-child' ); ?>
								<span aria-hidden="true"> *</span>
							</label>
							<input type="text" id="ah_contact_name" name="name" required
								placeholder="<?php esc_attr_e( 'ישראל ישראלי', 'alwayshere-child' ); ?>">
						</div>
						<div class="ah-cf__field">
							<label for="ah_contact_phone"><?php esc_html_e( 'טלפון', 'alwayshere-child' ); ?></label>
							<input type="tel" id="ah_contact_phone" name="phone"
								placeholder="<?php esc_attr_e( '050-0000000', 'alwayshere-child' ); ?>">
						</div>
					</div>

					<div class="ah-cf__field">
						<label for="ah_contact_email">
							<?php esc_html_e( 'כתובת דוא"ל', 'alwayshere-child' ); ?>
							<span aria-hidden="true"> *</span>
						</label>
						<input type="email" id="ah_contact_email" name="email" required
							placeholder="<?php esc_attr_e( 'email@example.com', 'alwayshere-child' ); ?>">
					</div>

					<div class="ah-cf__field">
						<label for="ah_contact_subject"><?php esc_html_e( 'נושא', 'alwayshere-child' ); ?></label>
						<select id="ah_contact_subject" name="subject">
							<option value=""><?php esc_html_e( 'בחרו נושא...', 'alwayshere-child' ); ?></option>
							<option value="order"><?php esc_html_e( 'שאלה לגבי הזמנה', 'alwayshere-child' ); ?></option>
							<option value="design"><?php esc_html_e( 'עזרה בעיצוב', 'alwayshere-child' ); ?></option>
							<option value="bulk"><?php esc_html_e( 'הזמנה עסקית / כמות גדולה', 'alwayshere-child' ); ?></option>
							<option value="return"><?php esc_html_e( 'החזרה / תלונה', 'alwayshere-child' ); ?></option>
							<option value="other"><?php esc_html_e( 'אחר', 'alwayshere-child' ); ?></option>
						</select>
					</div>

					<div class="ah-cf__field">
						<label for="ah_contact_message">
							<?php esc_html_e( 'הודעה', 'alwayshere-child' ); ?>
							<span aria-hidden="true"> *</span>
						</label>
						<textarea id="ah_contact_message" name="message" required rows="5"
							placeholder="<?php esc_attr_e( 'כתבו את הודעתכם כאן...', 'alwayshere-child' ); ?>"></textarea>
					</div>

					<div class="ah-cf__submit">
						<button type="submit" class="ah-cf__btn">
							<svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
								<line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
							</svg>
							<?php esc_html_e( 'שלח הודעה', 'alwayshere-child' ); ?>
						</button>
						<p class="ah-cf__status" id="ah-contact-status" aria-live="polite"></p>
					</div>

				</form>
			</div><!-- /.ah-cp__form-panel -->

		</div><!-- /.ah-cp__grid -->
	</div><!-- /.ah-container -->
</main>

<script>
(function () {
	var form   = document.getElementById('ah-contact-form');
	var status = document.getElementById('ah-contact-status');
	var btn    = form ? form.querySelector('.ah-cf__btn') : null;

	if (!form) return;

	form.addEventListener('submit', function (e) {
		e.preventDefault();

		var name    = form.querySelector('[name="name"]').value.trim();
		var email   = form.querySelector('[name="email"]').value.trim();
		var message = form.querySelector('[name="message"]').value.trim();

		if (!name || !email || !message) {
			status.textContent = '<?php echo esc_js( __( 'אנא מלאו את כל השדות החובה.', 'alwayshere-child' ) ); ?>';
			status.className = 'ah-cf__status is-error';
			return;
		}

		btn.disabled = true;
		status.textContent = '<?php echo esc_js( __( 'שולח...', 'alwayshere-child' ) ); ?>';
		status.className = 'ah-cf__status';

		var data = new FormData(form);
		data.append('action', 'alwayshere_contact');
		data.append('nonce',  '<?php echo esc_js( wp_create_nonce( 'alwayshere_contact' ) ); ?>');

		fetch('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', {
			method: 'POST',
			body: data,
			credentials: 'same-origin',
		})
		.then(function (r) { return r.json(); })
		.then(function (r) {
			if (r.success) {
				status.textContent = r.data.message;
				status.className = 'ah-cf__status is-success';
				form.reset();
			} else {
				status.textContent = r.data && r.data.message ? r.data.message : '<?php echo esc_js( __( 'שגיאה בשליחה. נסו שוב.', 'alwayshere-child' ) ); ?>';
				status.className = 'ah-cf__status is-error';
			}
		})
		.catch(function () {
			status.textContent = '<?php echo esc_js( __( 'שגיאה בשליחה. נסו שוב.', 'alwayshere-child' ) ); ?>';
			status.className = 'ah-cf__status is-error';
		})
		.finally(function () {
			btn.disabled = false;
		});
	});
})();
</script>

<?php get_footer(); ?>
