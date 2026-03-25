<?php
/**
 * Translate all WooCommerce-generated strings to Hebrew.
 *
 * Covers: billing/shipping field labels & placeholders, checkout field labels,
 * cart/checkout buttons, shipping calculator, payment section, notices.
 *
 * @package alwayshere-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Billing fields ────────────────────────────────────────────────────────────

add_filter( 'woocommerce_billing_fields', 'alwayshere_translate_billing_fields', 20 );

function alwayshere_translate_billing_fields( array $fields ): array {
	$map = [
		'billing_first_name' => [ 'label' => 'שם פרטי',              'placeholder' => 'ישראל'         ],
		'billing_last_name'  => [ 'label' => 'שם משפחה',             'placeholder' => 'ישראלי'        ],
		'billing_company'    => [ 'label' => 'חברה',                  'placeholder' => 'שם החברה (אופציונלי)' ],
		'billing_country'    => [ 'label' => 'מדינה'                                                   ],
		'billing_address_1'  => [ 'label' => 'רחוב ומספר בית',       'placeholder' => 'רחוב הרצל 12'  ],
		'billing_address_2'  => [ 'label' => '',                      'placeholder' => 'דירה / קומה (אופציונלי)' ],
		'billing_city'       => [ 'label' => 'עיר',                   'placeholder' => 'תל אביב'       ],
		'billing_state'      => [ 'label' => 'מחוז / אזור'                                             ],
		'billing_postcode'   => [ 'label' => 'מיקוד',                 'placeholder' => '6100000'       ],
		'billing_phone'      => [ 'label' => 'טלפון',                 'placeholder' => '050-0000000'   ],
		'billing_email'      => [ 'label' => 'כתובת דוא"ל',          'placeholder' => 'email@example.com' ],
	];

	foreach ( $map as $key => $values ) {
		if ( ! isset( $fields[ $key ] ) ) continue;
		if ( isset( $values['label'] ) )       $fields[ $key ]['label']       = $values['label'];
		if ( isset( $values['placeholder'] ) ) $fields[ $key ]['placeholder'] = $values['placeholder'];
	}

	return $fields;
}

// ── Shipping fields ───────────────────────────────────────────────────────────

add_filter( 'woocommerce_shipping_fields', 'alwayshere_translate_shipping_fields', 20 );

function alwayshere_translate_shipping_fields( array $fields ): array {
	$map = [
		'shipping_first_name' => [ 'label' => 'שם פרטי',         'placeholder' => 'ישראל'         ],
		'shipping_last_name'  => [ 'label' => 'שם משפחה',        'placeholder' => 'ישראלי'        ],
		'shipping_company'    => [ 'label' => 'חברה',             'placeholder' => 'שם החברה (אופציונלי)' ],
		'shipping_country'    => [ 'label' => 'מדינה'                                              ],
		'shipping_address_1'  => [ 'label' => 'רחוב ומספר בית',  'placeholder' => 'רחוב הרצל 12'  ],
		'shipping_address_2'  => [ 'label' => '',                 'placeholder' => 'דירה / קומה (אופציונלי)' ],
		'shipping_city'       => [ 'label' => 'עיר',              'placeholder' => 'תל אביב'       ],
		'shipping_state'      => [ 'label' => 'מחוז / אזור'                                        ],
		'shipping_postcode'   => [ 'label' => 'מיקוד',            'placeholder' => '6100000'       ],
	];

	foreach ( $map as $key => $values ) {
		if ( ! isset( $fields[ $key ] ) ) continue;
		if ( isset( $values['label'] ) )       $fields[ $key ]['label']       = $values['label'];
		if ( isset( $values['placeholder'] ) ) $fields[ $key ]['placeholder'] = $values['placeholder'];
	}

	return $fields;
}

// ── Checkout order/extra fields (notes) ──────────────────────────────────────

add_filter( 'woocommerce_checkout_fields', 'alwayshere_translate_checkout_fields', 20 );

function alwayshere_translate_checkout_fields( array $fields ): array {
	if ( isset( $fields['order']['order_comments'] ) ) {
		$fields['order']['order_comments']['label']       = 'הערות להזמנה';
		$fields['order']['order_comments']['placeholder'] = 'הערות מיוחדות לגבי ההזמנה או המשלוח (אופציונלי)';
	}
	return $fields;
}

// ── "Proceed to checkout" button ─────────────────────────────────────────────

add_filter( 'woocommerce_order_button_html', 'alwayshere_translate_order_button_html' );

function alwayshere_translate_order_button_html( string $html ): string {
	return str_replace( 'Place order', 'אשר הזמנה ושלם', $html );
}

add_filter( 'woocommerce_order_button_text', function(): string {
	return 'אשר הזמנה ושלם';
} );

// ── Shipping calculator labels ────────────────────────────────────────────────

add_filter( 'gettext', 'alwayshere_translate_wc_strings', 20, 3 );

function alwayshere_translate_wc_strings( string $translated, string $text, string $domain ): string {
	if ( 'woocommerce' !== $domain ) return $translated;

	$strings = [
		'Calculate shipping'                   => 'חישוב עלות משלוח',
		'Update totals'                         => 'עדכן סכומים',
		'Shipping to %s.'                       => 'משלוח ל-%s.',
		'Enter your address to view shipping options.' => 'הכנס כתובת לבדיקת אפשרויות משלוח.',
		'No shipping options were found.'       => 'לא נמצאו אפשרויות משלוח לכתובת זו.',
		'Free shipping'                         => 'משלוח חינם',
		'Flat rate'                             => 'תעריף קבוע',
		'Local pickup'                          => 'איסוף עצמי',
		'Proceed to checkout'                   => '🔒 לתשלום מאובטח',
		'Apply coupon'                          => 'החל קופון',
		'Coupon code'                           => 'קוד קופון',
		'Remove'                                => 'הסר',
		'Remove this item'                      => 'הסר פריט זה',
		'Undo?'                                 => 'בטל?',
		'Your cart is currently empty.'         => 'העגלה שלך ריקה.',
		'Return to shop'                        => 'חזרה לחנות',
		'Cart'                                  => 'עגלה',
		'Update cart'                           => 'עדכן עגלה',
		'Subtotal'                              => 'סכום ביניים',
		'Total'                                 => 'סה"כ',
		'Shipping'                              => 'משלוח',
		'Payment'                               => 'תשלום',
		'Place order'                           => 'אשר הזמנה ושלם',
		'Your order'                            => 'סיכום הזמנה',
		'Product'                               => 'מוצר',
		'Price'                                 => 'מחיר',
		'Quantity'                              => 'כמות',
		'Order total'                           => 'סה"כ לתשלום',
		'Coupon:'                               => 'קופון:',
		'I have read and agree to the website %s' => 'קראתי ואני מסכים/ה ל%s',
		'terms and conditions'                  => 'תקנון האתר',
		'Have a coupon?'                        => 'יש לך קופון?',
		'Click here to enter your code'         => 'לחץ להזנת הקוד',
		'If you have a coupon code, please apply it below.' => 'אם יש לך קוד קופון, הכנס אותו כאן.',
		'Notes about your order, e.g. special notes for delivery.' => 'הערות להזמנה, לדוגמה: הערות מיוחדות למשלוח.',
		'Order notes'                           => 'הערות להזמנה',
		'Additional information'                => 'מידע נוסף',
		'Billing details'                       => 'פרטי חיוב',
		'Ship to a different address?'          => 'לשלוח לכתובת אחרת?',
		'First name'                            => 'שם פרטי',
		'Last name'                             => 'שם משפחה',
		'Company name (optional)'               => 'חברה (אופציונלי)',
		'Country / Region'                      => 'מדינה',
		'Street address'                        => 'רחוב ומספר בית',
		'Apartment, suite, unit, etc. (optional)' => 'דירה / קומה (אופציונלי)',
		'Town / City'                           => 'עיר',
		'State / County'                        => 'מחוז / אזור',
		'Postcode / ZIP'                        => 'מיקוד',
		'Phone'                                 => 'טלפון',
		'Email address'                         => 'כתובת דוא"ל',
		'Create an account?'                    => 'צור חשבון?',
		'Password'                              => 'סיסמה',
		'Returning customer?'                   => 'לקוח חוזר?',
		'Click here to login'                   => 'לחץ כאן להתחברות',
		'Username or email address'             => 'שם משתמש או דוא"ל',
		'Lost your password?'                   => 'שכחת סיסמה?',
		'Login'                                 => 'כניסה',
		'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.' => 'לא נמצאו אמצעי תשלום זמינים. אנא פנה אלינו לסיוע.',
		'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.' => 'לא נמצאו אמצעי תשלום זמינים. אנא פנה אלינו לסיוע.',
	];

	return $strings[ $text ] ?? $translated;
}
