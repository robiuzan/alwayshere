---
paths:
  - "wp-content/themes/**/*.css"
  - "wp-content/themes/**/*.scss"
  - "wp-content/themes/**/*.js"
  - "wp-content/themes/**/*.ts"
  - "wp-content/themes/**/*.jsx"
  - "wp-content/themes/**/*.tsx"
  - "wp-content/themes/**/*.html"
  - "wp-content/themes/**/*.php"
---

# Frontend Rules

## RTL & Hebrew (Critical)

- Site is **Hebrew-only, RTL**. Every layout must work right-to-left.
- Never use `margin-left`/`padding-left`/`right`/`left` for directional spacing — use logical properties: `margin-inline-start`, `padding-inline-end`, `inset-inline-start`, etc.
- Set `direction: rtl` and `text-align: right` at the root — never override per-element unless truly needed.
- Fonts: use a Hebrew-supporting font (e.g., Heebo, Assistant, Rubik from Google Fonts) — test all weights.
- Numbers and prices: Hebrew convention — `₪` symbol before the number (e.g., `₪99`).
- Always test layout with long Hebrew words — they don't break the same way English does.

## CSS / SCSS

- **Methodology**: BEM naming — `.block__element--modifier`.
- **Units**: `rem` for typography/spacing, `px` only for borders and fine-grained details.
- **No inline styles** — always a class.
- **Mobile-first**: base styles for mobile, `min-width` media queries to scale up.
- **CSS variables** for all colors, spacing, and typography tokens — define in `:root`.
- No `!important` unless overriding a third-party plugin with no other option (leave a comment why).
- SCSS: max nesting depth of 3 levels. No `&` hell.

## JavaScript

- **ES2020+** — `const`/`let`, arrow functions, async/await, optional chaining.
- No `var`.
- Single quotes. Template literals when interpolating.
- `jQuery` is available globally via WordPress — use it sparingly; prefer vanilla JS for new code.
- Always wrap jQuery in `(function($) { ... })(jQuery);` — never assume `$` globally.
- Use `wp_localize_script()` to pass PHP data to JS — never inline `<script>` with PHP.
- AJAX: always use `wp_ajax_{action}` / `wp_ajax_nopriv_{action}` hooks with nonce verification.

## Accessibility

- All interactive elements keyboard-accessible.
- Images: meaningful `alt` text always; decorative images: `alt=""`.
- Semantic HTML: `<button>` for actions, `<a>` for navigation — never `<div onclick>`.
- Color contrast: minimum WCAG AA (4.5:1 for text).

## Performance

- No render-blocking scripts — use `defer` or `async` via `wp_script_add_data()`.
- Lazy-load images below the fold (`loading="lazy"`).
- Avoid loading assets globally — enqueue only on pages that need them (conditional tags: `is_shop()`, `is_product()`, etc.).
- Minimize DOM queries — cache selectors.

## WooCommerce Template Overrides

- Copy template from `woocommerce/templates/` into `themes/alwayshere-child/woocommerce/` before editing.
- Keep customizations minimal — prefer hooks to template overrides where possible.
- Note the WooCommerce version the template was copied from in a comment at the top.
