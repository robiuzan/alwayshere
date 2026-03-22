---
description: Design a frontend UI section or page — outputs visual design decisions, HTML structure, SCSS, and mobile-first RTL implementation for alwayshere.co.il
---

Design and build the frontend for: $ARGUMENTS

## Context
- Site: alwayshere.co.il — personal gifts e-commerce
- Hebrew only, RTL, mobile-first
- Audience: Israeli gift buyers — emotional, warm, modern aesthetic
- Stack: WordPress child theme, BEM CSS, vanilla JS or jQuery

## Design Phase (do this first)

Before writing code, define:

1. **Visual direction**: mood, color palette suggestion, typography feel
2. **Layout structure**: describe the section visually (grid, flex, key elements)
3. **Mobile vs desktop**: what changes between breakpoints
4. **Interaction**: hover states, animations, transitions (keep subtle and modern)
5. **RTL considerations**: what flips, what stays the same

## Implementation

After design is approved (or if this is a one-shot request), output:

### HTML (PHP template)
- Semantic elements (`<section>`, `<article>`, `<figure>`, etc.)
- BEM class names
- `dir="rtl"` only if overriding parent
- Accessibility: `aria-label`, `role`, keyboard targets
- ACF field output where applicable (`get_field()`)

### SCSS
- CSS variables for all colors/spacing (use `:root` tokens)
- Mobile-first (`min-width` breakpoints)
- Logical properties only (`margin-inline-start`, not `margin-left`)
- Max nesting: 3 levels
- No `!important`

### JS (if needed)
- Vanilla JS preferred; jQuery only if WP already loads it
- Wrap jQuery: `(function($){ ... })(jQuery)`
- No inline scripts

## Quality bar
- Must look premium and modern — this is a gift brand, not a generic store
- Warm color palette resonates with gifting (avoid cold corporate blues)
- Product images are heroes — design around them
- Every interaction should feel intentional

Run `code-reviewer` after writing code.
