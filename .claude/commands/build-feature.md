---
description: Build a complete feature end-to-end — design, PHP backend, frontend, tests, and review
---

Build this feature: $ARGUMENTS

## Phase 1 — Understand & Plan
1. Clarify requirements — ask if anything is ambiguous
2. Identify all affected files (plugin, theme, templates, SCSS, JS)
3. Output a plan:
   - Files to create/modify
   - WordPress hooks/filters involved
   - ACF fields needed (if any)
   - WooCommerce integration points (if any)
   - Security considerations
   - SEO impact
4. Wait for approval before coding

## Phase 2 — Backend (PHP)
- All logic in `alwayshere-core` plugin
- Hooks registered in `__construct` or `init`
- Full security: nonces, capability checks, sanitization, escaping
- Prefixed: `alwayshere_`
- PHPDoc on all public methods

## Phase 3 — Frontend
- Template in child theme (or WC override)
- SCSS component file (BEM, RTL, mobile-first)
- JS only if interaction needed
- Hebrew labels, RTL layout verified

## Phase 4 — ACF (if applicable)
- Field group registered in PHP
- Personalization → cart → order pipeline complete

## Phase 5 — Quality Gate (run all agents)
In parallel:
- `code-reviewer` — standards + RTL + WP patterns
- `security-auditor` — if feature touches user input, payments, or orders
- `seo-specialist` — if feature affects frontend templates or meta
- `acf-specialist` — if feature uses ACF fields

## Phase 6 — Done
- All agents PASS
- Tests written and passing
- No lint errors
- Summary: what was built, files changed, how to test manually
