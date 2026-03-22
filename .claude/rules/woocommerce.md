---
paths:
  - "wp-content/themes/**/woocommerce/**"
  - "wp-content/plugins/alwayshere-core/**"
  - "wp-content/themes/alwayshere-child/**"
---

# WooCommerce Rules

## Core Invariants

- **Never edit WooCommerce plugin files** — all customization via hooks, filters, and template overrides.
- Template overrides: copy to child theme's `woocommerce/` folder; always note the source WC version.
- Prefer hooks over template overrides — check WooCommerce hook reference before copying a template.

## Key Hook Reference

```php
// Product display
add_action( 'woocommerce_before_single_product', ... );
add_action( 'woocommerce_after_single_product_summary', ... );
add_filter( 'woocommerce_product_tabs', ... );

// Cart & checkout
add_action( 'woocommerce_before_cart', ... );
add_action( 'woocommerce_checkout_fields', ... );
add_filter( 'woocommerce_checkout_process', ... );

// Orders
add_action( 'woocommerce_order_status_changed', ... );
add_filter( 'woocommerce_email_classes', ... );

// Pricing
add_filter( 'woocommerce_product_get_price', ... );
add_filter( 'woocommerce_cart_item_price', ... );
```

## Orders & Payments

- Always use WooCommerce order statuses — never set custom post status directly on `shop_order`.
- Payment gateway customization: extend `WC_Payment_Gateway` — never fork a gateway plugin.
- Test orders: always use WooCommerce's built-in test mode / Stripe test keys before production.
- Refunds and cancellations: use `wc_create_refund()` — never manipulate order meta directly.

## Products & Catalog

- Custom product data: use `woocommerce_product_options_general_product_data` + `woocommerce_process_product_meta` — never raw post meta without WC wrappers.
- Product queries: use `wc_get_products()` or `WC_Product_Query` — not raw `WP_Query` with `product` post type unless necessary.
- Stock management: use WC stock functions (`wc_update_product_stock()`) — never `update_post_meta` for `_stock`.

## Performance

- Never run heavy queries in `woocommerce_before_main_content` or on every page load.
- Cache expensive lookups with transients (`set_transient()` / `get_transient()`).
- AJAX cart updates: use WC's built-in fragments (`woocommerce_add_to_cart_fragments`) — not page reloads.

## Security

- All custom checkout fields: sanitize on save, escape on output.
- Order notes and meta: `wc_sanitize_order_id()` for order IDs, `absint()` for quantities.
- Never expose full order data in JS — use fragments or REST with `wc/v3` + auth.

## Testing Checklist Before Deploy

- [ ] Guest checkout works.
- [ ] Logged-in checkout works.
- [ ] Payment succeeds and fails gracefully.
- [ ] Order confirmation email sends.
- [ ] Stock decrements correctly.
- [ ] Coupon codes apply/remove correctly.
- [ ] Mobile checkout UX verified.
