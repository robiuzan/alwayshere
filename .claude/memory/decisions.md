---
name: Architecture Decisions
description: Key decisions made about project structure, conventions, and tools
type: project
---

## Confirmed Decisions (2026-03-21)

- **CLAUDE.md structure**: Lean root `CLAUDE.md` (identity + north-star) + `.claude/rules/` for domain-specific rules loaded per context.
- **Rules split**:
  - `workflow.md` — always loaded
  - `code-style.md` — always loaded
  - `frontend.md` — path-specific (theme CSS/JS files)
  - `woocommerce.md` — path-specific (WC/plugin files)
- **Namespace**: `alwayshere_` prefix on all custom functions, hooks, options, transients, meta keys.
- **No core edits**: WordPress core and WooCommerce plugin files are never modified.
- **Custom logic location**: Custom plugin (`alwayshere-core`) for business logic; child theme for display overrides only.
- **SEO plugin**: Yoast SEO — all meta/OG/schema work via Yoast filters, never raw `wp_head`.
- **ACF Pro**: Used for (1) product personalization fields (engraving, custom options) and (2) theme layout (ACF Blocks + Flexible Content). All field groups registered in PHP, never DB-only. ACF admin UI disabled on production.
- **Language**: Hebrew only — single language, `he_IL` locale, RTL layout required throughout.
- **Social platforms**: Instagram, Facebook, TikTok — visual-first, mobile-first content.
  - Instagram: square (1:1) + portrait (4:5) product images
  - Facebook: OG image 1200×630, warm emotional copy
  - TikTok: short-form video-ready product shots, vertical (9:16)

## Open Decisions (needs resolution)

- [ ] Parent theme choice
- [ ] Page builder (Elementor vs Gutenberg blocks vs custom)
- [ ] Local dev environment (LocalWP / DDEV / Lando)
- [ ] Hosting provider (WP Engine / Kinsta / VPS)
- [ ] PHP minimum version target
