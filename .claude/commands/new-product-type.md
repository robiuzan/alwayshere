---
description: Scaffold a new WooCommerce product type with ACF personalization fields, cart/order meta handling, and frontend display
---

Create a new WooCommerce product type for: $ARGUMENTS

## What to scaffold

A complete, production-ready product type with full personalization support.

## Output

### 1. ACF Field Group (personalization fields)
Register in `alwayshere-core/includes/acf/fields-{product-slug}.php`:
- Field group scoped to this product type or category
- Fields for all personalization options (text, select, image upload, etc.)
- Hebrew labels and instructions with character limits where relevant
- Keys: `field_alwayshere_{product-slug}_{field-name}`

### 2. Cart Integration
In `alwayshere-core/includes/woocommerce/personalization.php`:

```php
// Capture personalization on add-to-cart
add_filter('woocommerce_add_cart_item_data', ...)

// Display in cart
add_filter('woocommerce_get_item_data', ...)

// Save to order line item
add_action('woocommerce_checkout_create_order_line_item', ...)

// Display in order/admin
add_action('woocommerce_order_item_meta_end', ...)
```

### 3. Validation
- Server-side validation of all personalization fields
- Max character limits enforced in PHP (not just JS)
- Required field checks before cart add

### 4. Frontend Product Page
Template override if needed: `themes/alwayshere-child/woocommerce/single-product/`
- Personalization form with Hebrew labels
- Character counter for text fields (JS)
- Mobile-friendly input UX
- Preview area if applicable (e.g., live name preview)

### 5. Admin Order View
Display personalization details clearly in:
- WooCommerce order edit page
- Email notifications
- Packing slip (if applicable)

## Checklist after scaffolding
- [ ] Test add to cart with personalization
- [ ] Verify data saves to order meta
- [ ] Check admin order view shows personalization
- [ ] Confirm email includes personalization details
- [ ] Test character limit enforcement
- [ ] Verify RTL layout of personalization form

Run `code-reviewer` + `security-auditor` after writing code.
