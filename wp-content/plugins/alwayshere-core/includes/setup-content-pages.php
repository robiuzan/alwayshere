<?php
/**
 * One-time setup: create all static content pages with Hebrew content.
 *
 * Creates: about, privacy-policy, returns-policy, shipping-policy, faq, contact.
 * Self-disables via the `alwayshere_content_pages_created` option.
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'alwayshere_setup_content_pages' );

function alwayshere_setup_content_pages(): void {
	if ( get_option( 'alwayshere_content_pages_created' ) ) {
		return;
	}

	$pages = alwayshere_get_content_pages();

	foreach ( $pages as $slug => $data ) {
		// Check if a page with this slug already exists.
		$existing = get_page_by_path( $slug );

		if ( $existing ) {
			wp_update_post( [
				'ID'           => $existing->ID,
				'post_title'   => $data['title'],
				'post_content' => wp_kses_post( $data['content'] ),
				'post_status'  => 'publish',
			] );
		} else {
			wp_insert_post( [
				'post_title'   => $data['title'],
				'post_name'    => $slug,
				'post_content' => wp_kses_post( $data['content'] ),
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
			] );
		}
	}

	update_option( 'alwayshere_content_pages_created', true );
}

function alwayshere_get_content_pages(): array {
	return [

		// ── About ────────────────────────────────────────────────────────────────
		'about' => [
			'title'   => 'אודות',
			'content' => '
<div class="ah-legal-page">

<h1>אנחנו Always Here</h1>
<p class="ah-lead">אנחנו מאמינים שמתנה אמיתית היא כזו שמרגישים שנעשתה רק עבורך — בעבודת יד, עם אהבה ותשומת לב לפרטים הקטנים.</p>

<h2>הסיפור שלנו</h2>
<p>Always Here נולדה מתוך אהבה אמיתית למתנות שמדברות. ידענו שהפוטנציאל הגדול ביותר של מתנה הוא ביכולת שלה להגיד "חשבתי עליך, רק עליך" — ומזה הכל התחיל.</p>
<p>מה שהתחיל כרעיון קטן הפך לחברה מובילה בתחום המתנות המותאמות אישית בישראל, עם מאות מוצרים ייחודיים שניתן להתאים לכל אירוע ולכל נמען. אנחנו כאן כי אתם כאן — וכי כל רגע שווה להיזכר בו.</p>

<h2>מה אנחנו מציעים</h2>
<p>אצלנו תמצאו מגוון עצום של מוצרים שניתנים להתאמה אישית מלאה:</p>
<ul>
<li>🖼️ <strong>הדפסה על בלוק עץ</strong> — תמונות מחיים על חומרים טבעיים</li>
<li>☕ <strong>ספלים ואביזרי שתייה</strong> — בהתאמה אישית מלאה</li>
<li>🛏️ <strong>כריות ופאזלים</strong> — מתנה שתמיד תהיה בבית</li>
<li>🪟 <strong>זכוכיות וגבישים</strong> — בכל הגדלים ובכל הצורות</li>
<li>👕 <strong>חולצות וביגוד</strong> — עיצוב שנוגע לעור</li>
<li>🔑 <strong>מחזיקי מפתחות ואביזרים</strong> — פרטי ומשמעותי</li>
<li>🕯️ <strong>נרות ותכשיטים</strong> — בעיצוב שמרגש</li>
</ul>
<p>כל המוצרים ניתנים לעיצוב על ידכם — או בעזרת צוות המעצבים שלנו שישמח לעזור.</p>

<h2>למה לבחור בנו?</h2>
<ul>
<li>✅ <strong>עיצוב אישי</strong> — כל מוצר מותאם במיוחד לכם</li>
<li>✅ <strong>איכות גבוהה</strong> — חומרים מהמובחרים, הדפסה עמידה</li>
<li>✅ <strong>משלוח מהיר לכל הארץ</strong> — עד 7 ימי עסקים</li>
<li>✅ <strong>שירות אישי</strong> — צוות שמלווה אתכם לאורך כל הדרך</li>
<li>✅ <strong>מחירים הוגנים</strong> — ללא פשרות על איכות</li>
</ul>

<h2>צרו קשר</h2>
<p>יש שאלה? רוצים ייעוץ לבחירת מתנה? אנחנו כאן בשבילכם.</p>
<p>📞 <a href="tel:0556601006">055-6601006</a> &nbsp;|&nbsp; 📧 <a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a></p>

</div>',
		],

		// ── Privacy Policy ────────────────────────────────────────────────────────
		'privacy-policy' => [
			'title'   => 'מדיניות פרטיות',
			'content' => '
<div class="ah-legal-page">

<p><em>עודכן לאחרונה: מרץ 2025</em></p>

<p>Always Here מחויבת לשמירה על פרטיות המשתמשים. מדיניות זו מסבירה אילו מידע אנו אוספים, כיצד אנו משתמשים בו, ואילו זכויות עומדות לך.</p>

<h2>1. מידע שאנו אוספים</h2>
<p>בעת שימוש באתר ו/או ביצוע הזמנה, ייתכן שנאסוף את הפרטים הבאים:</p>
<ul>
<li>שם מלא, כתובת דוא"ל, מספר טלפון</li>
<li>כתובת למשלוח</li>
<li>פרטי הזמנות ורכישות</li>
<li>מידע טכני: כתובת IP, סוג דפדפן, עמודים שנצפו (דרך עוגיות)</li>
</ul>

<h2>2. שימוש במידע</h2>
<p>המידע שנאסף ישמש אך ורק למטרות הבאות:</p>
<ul>
<li>עיבוד הזמנות ואספקת מוצרים</li>
<li>יצירת קשר בנוגע להזמנתכם</li>
<li>שיפור חווית המשתמש באתר</li>
<li>משלוח עדכונים ומבצעים — בהסכמתכם בלבד</li>
<li>עמידה בדרישות חוקיות</li>
</ul>

<h2>3. שיתוף מידע עם צדדים שלישיים</h2>
<p>אנו לא מוכרים, משכירים או מעבירים פרטים אישיים לגורמים חיצוניים, למעט:</p>
<ul>
<li>ספקי משלוח — לצורך אספקת ההזמנה בלבד</li>
<li>עיבוד תשלומים — דרך ספקים מאובטחים בלבד (Stripe, PayPal וכדומה)</li>
<li>גורמים חוקיים — כאשר מחויבים על פי דין</li>
</ul>
<p>כל גורם חיצוני מחויב בהסכם סודיות ואינו רשאי להשתמש במידע לכל מטרה אחרת.</p>

<h2>4. עוגיות (Cookies)</h2>
<p>האתר עושה שימוש בעוגיות לצורך:</p>
<ul>
<li>שמירת תכולת עגלת הקניות</li>
<li>ניתוח תנועה (Google Analytics)</li>
<li>שיפור חווית הגלישה</li>
</ul>
<p>ניתן להשבית עוגיות דרך הגדרות הדפדפן, אך הדבר עשוי לפגוע בחלק מפונקציות האתר.</p>

<h2>5. אבטחת מידע</h2>
<p>אנו נוקטים באמצעי אבטחה מתקדמים לשמירה על המידע שלכם:</p>
<ul>
<li>חיבור מוצפן HTTPS/SSL בכל עמודי האתר</li>
<li>פרטי כרטיס אשראי אינם נשמרים בשרתינו</li>
<li>גישה מוגבלת לנתונים אישיים</li>
</ul>

<h2>6. זכויותיכם</h2>
<p>בהתאם לחוק הגנת הפרטיות הישראלי, עומדות לכם הזכויות הבאות:</p>
<ul>
<li>לעיין במידע המוחזק עליכם</li>
<li>לבקש תיקון מידע שגוי</li>
<li>לבקש מחיקת המידע ("הזכות להישכח")</li>
<li>לבטל הסכמה לקבלת דיוור שיווקי בכל עת</li>
</ul>
<p>לכל פנייה: <a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a></p>

<h2>7. שינויים במדיניות</h2>
<p>אנו שומרים לעצמנו את הזכות לעדכן מדיניות זו. כל שינוי מהותי יפורסם באתר עם תאריך עדכון.</p>

</div>',
		],

		// ── Returns Policy ────────────────────────────────────────────────────────
		'returns-policy' => [
			'title'   => 'מדיניות החזרות',
			'content' => '
<div class="ah-legal-page">

<p><em>עודכן לאחרונה: מרץ 2025</em></p>
<p>שביעות רצונכם חשובה לנו מאוד. אנא קראו את מדיניות ההחזרות שלנו בקפידה לפני ביצוע הזמנה.</p>

<h2>1. מוצרים סטנדרטיים (ללא התאמה אישית)</h2>
<p>ניתן להחזיר מוצרים שלא עברו התאמה אישית תוך <strong>14 ימים</strong> מיום קבלתם, בכפוף לתנאים הבאים:</p>
<ul>
<li>המוצר נמצא באריזתו המקורית ובמצב תקין לחלוטין</li>
<li>לא נעשה שימוש במוצר</li>
<li>פנייה אלינו בכתב לפני שליחת המוצר בחזרה</li>
</ul>
<p>עלויות המשלוח לצורך ההחזרה חלות על הלקוח, אלא אם ההחזרה נובעת מפגם שלנו.</p>

<h2>2. מוצרים מותאמים אישית</h2>
<p>מוצרים שיוצרו עם חריטה, הדפסה, שם, תמונה, או כל התאמה אישית אחרת — <strong>לא ניתן להחזירם</strong>, אלא במקרים הבאים:</p>
<ul>
<li>המוצר הגיע פגום או שבור</li>
<li>ההדפסה/חריטה שונה מהותית ממה שהוזמן</li>
<li>הגיע מוצר שגוי (שלא הוזמן)</li>
</ul>
<p>במקרים אלו נשלח לכם מוצר חלופי ללא תשלום נוסף, או נחזיר לכם את מלוא הסכום.</p>

<h2>3. תהליך ההחזרה</h2>
<ol>
<li>פנו אלינו בדוא"ל <a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a> תוך 14 יום מקבלת ההזמנה</li>
<li>ציינו מספר הזמנה וסיבת ההחזרה</li>
<li>צרפו תמונות של המוצר (במקרה של פגם)</li>
<li>נחזור אליכם תוך יום עסקים עם הוראות להמשך</li>
</ol>

<h2>4. החזר כספי</h2>
<ul>
<li>החזר כספי יבוצע לאמצעי התשלום המקורי תוך <strong>5–10 ימי עסקים</strong> מאישור ההחזרה</li>
<li>דמי משלוח לא יוחזרו אלא אם ההחזרה נובעת מטעות שלנו</li>
<li>לחלופין, ניתן לקבל זיכוי לחנות בשווי מלא</li>
</ul>

<h2>5. ביטול הזמנה לפני ייצור</h2>
<p>ניתן לבטל הזמנה ללא עלות בתוך <strong>2 שעות</strong> מרגע ביצועה. לאחר מכן, אם הייצור כבר החל — ייתכן שנגבה דמי ביטול חלקיים.</p>

<h2>שאלות?</h2>
<p>📞 <a href="tel:0556601006">055-6601006</a> &nbsp;|&nbsp; 📧 <a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a></p>

</div>',
		],

		// ── Shipping Policy ───────────────────────────────────────────────────────
		'shipping-policy' => [
			'title'   => 'מדיניות משלוחים',
			'content' => '
<div class="ah-legal-page">

<p><em>עודכן לאחרונה: מרץ 2025</em></p>

<h2>אזורי משלוח</h2>
<p>אנחנו שולחים לכל רחבי ישראל — מאילת ועד קריית שמונה, כולל יישובים מרוחקים ואיזורי עדיפות לאומית.</p>

<h2>זמני אספקה</h2>
<table>
<thead><tr><th>סוג מוצר</th><th>זמן ייצור</th><th>זמן משלוח</th><th>סה"כ משוער</th></tr></thead>
<tbody>
<tr><td>מוצר סטנדרטי</td><td>1–2 ימי עסקים</td><td>2–4 ימי עסקים</td><td>3–6 ימי עסקים</td></tr>
<tr><td>מוצר עם הדפסה/חריטה</td><td>2–4 ימי עסקים</td><td>2–4 ימי עסקים</td><td>5–8 ימי עסקים</td></tr>
<tr><td>הזמנה מורכבת / כמות גדולה</td><td>5–7 ימי עסקים</td><td>2–4 ימי עסקים</td><td>7–11 ימי עסקים</td></tr>
</tbody>
</table>
<p><strong>שימו לב:</strong> בתקופות עמוסות (חגים, ימי מכירות) זמני הייצור עשויים להתארך. נעדכן אתכם מראש.</p>

<h2>עלויות משלוח</h2>
<ul>
<li>🚚 <strong>משלוח חינם</strong> — להזמנות מעל ₪199</li>
<li>📦 <strong>משלוח רגיל</strong> — ₪25 להזמנות עד ₪199</li>
<li>⚡ <strong>משלוח מהיר</strong> — ₪45 (1–2 ימי עסקים לאחר ייצור)</li>
</ul>

<h2>אספקה ומעקב</h2>
<p>לאחר שליחת ההזמנה תקבלו הודעת SMS/דוא"ל עם מספר מעקב. ניתן לעקוב אחר ההזמנה ישירות דרך אתר חברת השליחויות.</p>

<h2>הזמנות לאירועים</h2>
<p>מתכננים מתנה לאירוע? מומלץ להזמין לפחות <strong>10 ימי עסקים מראש</strong> כדי להבטיח אספקה בזמן. לאירועים גדולים — צרו קשר ישירות לתיאום מיוחד.</p>

<h2>אחריות על משלוח</h2>
<p>אנו אחראים על המוצר עד מסירתו לחברת השליחויות. לאחר מכן, האחריות על עמידה בזמנים עוברת לחברת השליחויות. במקרה של עיכוב חריג — נעשה כל מאמץ לסייע.</p>
<p>אם ההזמנה הגיעה פגומה — צרו קשר תוך 48 שעות מקבלתה עם תמונות ונטפל מיד.</p>

<h2>שאלות על משלוח?</h2>
<p>📞 <a href="tel:0556601006">055-6601006</a> &nbsp;|&nbsp; 📧 <a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a></p>

</div>',
		],

		// ── FAQ ───────────────────────────────────────────────────────────────────
		'faq' => [
			'title'   => 'שאלות נפוצות',
			'content' => '
<div class="ah-legal-page ah-faq-page">

<h2>הזמנה ורכישה</h2>

<details open>
<summary>איך מבצעים הזמנה?</summary>
<p>פשוט מאוד — בחרו מוצר, הוסיפו את ההתאמה האישית שלכם (טקסט, תמונה, שם), הוסיפו לעגלה ועברו לתשלום. הכל אונליין, מהיר ופשוט.</p>
</details>

<details>
<summary>האם ניתן לצפות בעיצוב לפני ביצוע ההזמנה?</summary>
<p>כן! רוב המוצרים כוללים תצוגה מקדימה של העיצוב ישירות בדף המוצר. אם יש לכם שאלה לגבי איך ייראה המוצר הסופי — שלחו לנו הודעה ונשמח לעזור.</p>
</details>

<details>
<summary>האם ניתן לבצע שינויים לאחר ביצוע הזמנה?</summary>
<p>ניתן לבצע שינויים בתוך <strong>2 שעות</strong> מרגע ביצוע ההזמנה. לאחר מכן, אם הייצור כבר התחיל, ייתכן שלא נוכל לבצע שינויים. פנו אלינו בהקדם האפשרי.</p>
</details>

<details>
<summary>האם ניתן להזמין כמויות גדולות (הזמנות עסקיות)?</summary>
<p>כן בהחלט! אנחנו עובדים עם עסקים, חברות ואירגונים על הזמנות מותאמות בכמויות גדולות. צרו איתנו קשר לקבלת הצעת מחיר מיוחדת.</p>
</details>

<h2>עיצוב והתאמה אישית</h2>

<details>
<summary>אני לא גרפיקאי — האם תוכלו לעזור לי בעיצוב?</summary>
<p>בהחלט! צוות המעצבים שלנו זמין לעזור לכם ליצור את העיצוב המושלם. שלחו לנו תמונה, שם, או כל רעיון שיש לכם — ונדאג לשאר.</p>
</details>

<details>
<summary>באיזה פורמט לשלוח תמונות?</summary>
<p>עדיף לשלוח תמונות ב-JPG או PNG ברזולוציה גבוהה (לפחות 1500x1500 פיקסלים). ככל שהתמונה חדה יותר — כך המוצר הסופי ייצא יפה יותר.</p>
</details>

<details>
<summary>האם ניתן לבקש עיצוב מיוחד שלא קיים באתר?</summary>
<p>כן! צרו קשר עם הצוות שלנו ונשמח לדון ברעיון. אנחנו עובדים על פרויקטים מיוחדים ומותאמים אישית בכל עת.</p>
</details>

<h2>משלוח ואספקה</h2>

<details>
<summary>כמה זמן לוקח לקבל את ההזמנה?</summary>
<p>מוצרים סטנדרטיים: 3–6 ימי עסקים. מוצרים עם הדפסה/חריטה: 5–8 ימי עסקים. בתקופות עמוסות כגון חגים — ייתכן עיכוב נוסף של 2–3 ימים.</p>
</details>

<details>
<summary>האם יש משלוח חינם?</summary>
<p>כן! משלוח חינם לכל הזמנה מעל <strong>₪199</strong>. לפחות מזה — עלות המשלוח היא ₪25.</p>
</details>

<details>
<summary>האם אתם שולחים מחוץ לישראל?</summary>
<p>כרגע אנחנו משלחים לישראל בלבד. אנחנו עובדים על הרחבת השירות לחו"ל — עקבו אחרינו לעדכונים.</p>
</details>

<h2>תשלום והחזרות</h2>

<details>
<summary>אילו אמצעי תשלום מתקבלים?</summary>
<p>אנחנו מקבלים: כרטיסי אשראי (ויזה, מסטרקארד), PayPal ו-Bit. כל התשלומים מאובטחים ב-SSL.</p>
</details>

<details>
<summary>האם ניתן לשלם בתשלומים?</summary>
<p>כן, ניתן לפרוס עד 12 תשלומים בכרטיס אשראי בהתאם לתנאי חברת כרטיסי האשראי שלכם.</p>
</details>

<details>
<summary>מה קורה אם המוצר הגיע פגום?</summary>
<p>אנחנו מתנצלים! צרו קשר תוך 48 שעות מקבלת ההזמנה עם תמונות של הפגם, ואנחנו נשלח מוצר חלופי ללא תשלום או נחזיר את הכסף במלואו.</p>
</details>

<h2>עדיין יש לכם שאלה?</h2>
<p>📞 <a href="tel:0556601006">055-6601006</a> &nbsp;|&nbsp; 📧 <a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a></p>
<p>אנחנו זמינים ימים א׳–ה׳, 09:00–18:00.</p>

</div>',
		],

		// ── Contact ───────────────────────────────────────────────────────────────
		'contact' => [
			'title'   => 'צרו קשר',
			'content' => '
<div class="ah-legal-page ah-contact-page">

<p class="ah-lead">שאלה? בקשה מיוחדת? רוצים לשמוע עוד? אנחנו כאן בשבילכם.</p>

<div class="ah-contact-grid">

<div class="ah-contact-info">
<h2>פרטי התקשרות</h2>

<div class="ah-contact-item">
<span class="ah-contact-icon">📞</span>
<div>
<strong>טלפון</strong><br>
<a href="tel:0556601006">055-6601006</a><br>
<small>ימים א׳–ה׳, 09:00–18:00</small>
</div>
</div>

<div class="ah-contact-item">
<span class="ah-contact-icon">📧</span>
<div>
<strong>דוא"ל</strong><br>
<a href="mailto:info@alwayshere.co.il">info@alwayshere.co.il</a><br>
<small>נחזור תוך יום עסקים</small>
</div>
</div>

<div class="ah-contact-item">
<span class="ah-contact-icon">💬</span>
<div>
<strong>וואטסאפ</strong><br>
<a href="https://wa.me/9720556601006" target="_blank" rel="noopener">שלחו הודעה</a><br>
<small>מענה מהיר בשעות הפעילות</small>
</div>
</div>

<div class="ah-contact-item">
<span class="ah-contact-icon">📍</span>
<div>
<strong>שירות</strong><br>
משלוח לכל הארץ
</div>
</div>

</div><!-- .ah-contact-info -->

<div class="ah-contact-form-wrap">
<h2>שלחו לנו הודעה</h2>
' . alwayshere_contact_form_html() . '
</div>

</div><!-- .ah-contact-grid -->

</div>',
		],

	];
}

function alwayshere_contact_form_html(): string {
	return '<form class="ah-contact-form" id="ah-contact-form" novalidate>
<div class="ah-contact-form__row">
<div class="ah-contact-form__field">
<label for="ah_contact_name">שם מלא <span aria-hidden="true">*</span></label>
<input type="text" id="ah_contact_name" name="name" required placeholder="ישראל ישראלי">
</div>
<div class="ah-contact-form__field">
<label for="ah_contact_phone">טלפון</label>
<input type="tel" id="ah_contact_phone" name="phone" placeholder="050-0000000">
</div>
</div>
<div class="ah-contact-form__field">
<label for="ah_contact_email">כתובת דוא"ל <span aria-hidden="true">*</span></label>
<input type="email" id="ah_contact_email" name="email" required placeholder="email@example.com">
</div>
<div class="ah-contact-form__field">
<label for="ah_contact_subject">נושא</label>
<select id="ah_contact_subject" name="subject">
<option value="">בחרו נושא...</option>
<option value="order">שאלה לגבי הזמנה</option>
<option value="design">עזרה בעיצוב</option>
<option value="bulk">הזמנה עסקית / כמות גדולה</option>
<option value="return">החזרה / תלונה</option>
<option value="other">אחר</option>
</select>
</div>
<div class="ah-contact-form__field">
<label for="ah_contact_message">הודעה <span aria-hidden="true">*</span></label>
<textarea id="ah_contact_message" name="message" required rows="5" placeholder="כתבו את הודעתכם כאן..."></textarea>
</div>
<div class="ah-contact-form__field ah-contact-form__field--submit">
<button type="submit" class="ah-btn ah-btn--primary ah-contact-form__submit">שלח הודעה</button>
<p class="ah-contact-form__status" aria-live="polite"></p>
</div>
</form>';
}

// ── Contact form AJAX handler ─────────────────────────────────────────────────

add_action( 'wp_ajax_alwayshere_contact',        'alwayshere_handle_contact_form' );
add_action( 'wp_ajax_nopriv_alwayshere_contact', 'alwayshere_handle_contact_form' );

function alwayshere_handle_contact_form(): void {
	check_ajax_referer( 'alwayshere_contact', 'nonce' );

	$name    = sanitize_text_field( wp_unslash( $_POST['name']    ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email']   ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone']   ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		wp_send_json_error( [ 'message' => 'אנא מלאו את כל השדות החובה.' ] );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => 'כתובת דוא"ל אינה תקינה.' ] );
	}

	$subject_labels = [
		'order'  => 'שאלה לגבי הזמנה',
		'design' => 'עזרה בעיצוב',
		'bulk'   => 'הזמנה עסקית',
		'return' => 'החזרה / תלונה',
		'other'  => 'אחר',
	];
	$subject_label = $subject_labels[ $subject ] ?? 'פנייה מהאתר';

	$body  = "שם: {$name}\n";
	$body .= "דוא\"ל: {$email}\n";
	if ( $phone ) $body .= "טלפון: {$phone}\n";
	$body .= "נושא: {$subject_label}\n\n";
	$body .= "הודעה:\n{$message}\n";

	$sent = wp_mail(
		'info@alwayshere.co.il',
		"[Always Here] פנייה חדשה: {$subject_label}",
		$body,
		[
			"From: {$name} <{$email}>",
			'Content-Type: text/plain; charset=UTF-8',
		]
	);

	if ( $sent ) {
		wp_send_json_success( [ 'message' => 'תודה! הודעתכם התקבלה. נחזור אליכם בהקדם.' ] );
	} else {
		wp_send_json_error( [ 'message' => 'אירעה שגיאה בשליחה. אנא נסו שוב או פנו אלינו ישירות.' ] );
	}
}
