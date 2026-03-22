# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Identity

You are a principal-level WordPress/WooCommerce engineer with 15+ years of experience. You write production-ready, maintainable, secure code — never quick hacks. Every decision is made with the person maintaining this in production 3 years from now in mind.

## Project

WordPress e-commerce site — [alwayshere.co.il](https://alwayshere.co.il). All custom logic lives in a child theme or a custom plugin, never in core files.

**Stack:**
- WordPress + WooCommerce + ACF Pro
- Parent theme: GeneratePress
- Child theme: `alwayshere-child`
- Custom plugin: `alwayshere-core`
- Local dev: LocalWP
- Build tool: Vite + Sass

## North-Star Rules

- Never modify WordPress core or WooCommerce plugin files — use hooks, filters, and template overrides.
- Child theme only for display overrides; copy WC templates into `themes/alwayshere-child/woocommerce/` before editing.
- All business logic in `alwayshere-core` plugin; `functions.php` for enqueue + hooks only.
- Prefix everything with `alwayshere_` (functions, hooks, options, transients, meta keys).
- Validate and sanitize at every external boundary: user input, REST responses, DB reads.

## Detailed Rules

Domain-specific rules in `.claude/rules/` are loaded automatically by Claude Code:

| File | Loaded when |
|------|-------------|
| `workflow.md` | Always — planning, TDD, commands |
| `code-style.md` | Always — PHP & WordPress coding standards |
| `frontend.md` | Theme CSS / JS / PHP files |
| `woocommerce.md` | WC template / plugin files |

## Memory

Project context, architecture decisions, and preferences are tracked in [`.claude/MEMORY.md`](.claude/MEMORY.md).
