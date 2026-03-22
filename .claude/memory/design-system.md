---
name: Design System
description: Visual design tokens, color palette, typography, and homepage layout reference for alwayshere.co.il
type: project
---

## Brand Colors (CSS Custom Properties)

```css
/* Primary palette */
--accent: #1a4a6b;          /* Deep teal — primary brand color */
--accent-hover: #0f3550;    /* Darker teal for hover states */
--teal: #1a4a6b;
--teal-dark: #0f3550;
--teal-light: #245d82;
--sky: #e8f4fd;             /* Light blue tint for backgrounds */

/* Neutrals */
--charcoal: #222222;        /* Primary text */
--contrast: #222222;
--contrast-2: #575760;
--contrast-3: #b2b2be;
--gray-light: #f5f5f5;
--gray-mid: #888888;
--gray-border: #e0e0e0;
--white: #ffffff;
--black: #000000;

/* Footer */
--footer-bg: #0f1a24;       /* Very dark navy — used for footer + top bar */
--footer-card: #162230;     /* Slightly lighter dark card */

/* WooCommerce */
--woocommerce: #720eec;     /* WC purple — used for WC UI elements */
--wc-primary: #720eec;
--wc-primary-text: #fcfbfe;
--wc-secondary: #e9e6ed;

/* Status */
--green: #3ecf4a;
--blue: #2196f3;
--yellow: #f5c518;
```

## Typography

```css
--font: 'Heebo', sans-serif;   /* Primary font — Hebrew-optimized */
font-size: 17px;
line-height: 1.5;
direction: rtl;
```

Font sizes (WP presets):
- Small: 13px
- Normal: 16px
- Medium: 20px
- Large: 36px
- X-Large / Huge: 42px

## Homepage Sections (reference design — screenshot provided 2026-03-21)

### 1. Top Announcement Bar
- Background: `--footer-bg` (#0f1a24)
- Content: contact info (phone/email) + promo text center + social icons
- Full width, fixed top

### 2. Header
- White background, sticky
- Logo "Always Here" — centered
- Navigation RTL (right side in RTL = start)
- Cart / search / wishlist icons
- Mobile: hamburger

### 3. Hero Section
- Split layout: text/CTA right, image collage left
- Headline: large, bold, Hebrew
- Sub: short description
- CTAs: 2 buttons (primary teal + secondary outline)
- Trust badges below: free shipping, fast delivery, reviews count
- Background: white or very light

### 4. "למי המתנה?" — Recipient Categories
- Section heading centered
- Circular image icons in a row (horizontal scroll on mobile)
- Categories: לאישה, לגבר, לחייל/ת, לבית, למשרד, etc.
- Background: white

### 5. Promo Banner
- Full-width, background: `--accent` (#1a4a6b)
- Discount code + CTA button
- Bold Hebrew text, white

### 6. "הצעות מיוחדות" — Featured Products
- 4-column grid (2 on mobile)
- Standard WC product card + price
- Section heading + sub

### 7. "המוצרים הכי אהובים" — Best Sellers
- Same grid as above
- Different background: `--gray-light` (#f5f5f5)

### 8. "לאיזה אירוע?" — Occasion Categories
- Grid with lifestyle background images
- Category name overlaid
- 4+ items (2 rows on mobile)

### 9. "מה תרצו לעצב היום?" — Product Type Grid
- Masonry/grid of product category thumbnails
- 6-8 categories visible
- Small cards with image + label

### 10. Trust / About Section
- Split: image left, text + trust icons right
- Trust icons: delivery, reviews count, satisfaction
- CTA: "קרא עוד עלינו"
- Background: white

### 11. Newsletter Section
- Background: `--accent` (#1a4a6b)
- Email input + submit button
- Short Hebrew copy

### 12. Footer
- Background: `--footer-bg` (#0f1a24)
- 4 columns: logo + about | navigation | categories | contact + social
- Bottom bar: legal links + payment icons

## Spacing Scale (WP presets)
- xs: 0.44rem
- sm: 0.67rem
- md: 1rem
- lg: 1.5rem
- xl: 2.25rem
- 2xl: 3.38rem
- 3xl: 5.06rem

## Shadows
- Natural: `6px 6px 9px rgba(0,0,0,0.2)`
- Deep: `12px 12px 50px rgba(0,0,0,0.4)`
