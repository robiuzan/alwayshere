# Code Style — PHP & WordPress Standards

Follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/).

## PHP

- **Indentation**: Tabs (not spaces) — WordPress standard.
- **Naming**:
  - `snake_case` — functions, variables, file names.
  - `PascalCase` — classes.
  - `UPPER_SNAKE_CASE` — constants.
  - Prefix all functions/classes/hooks with the project namespace: `alwayshere_`.
- **Braces**: Opening brace on same line for control structures; own line for classes/functions.
- **Yoda conditions**: `if ( 'value' === $var )` — required by WPCS.
- **Spaces inside parentheses**: `if ( $x )`, `function foo( $a, $b )`.
- **No closing PHP tag** at end of files.
- **Type hints**: Use PHP 7.4+ typed properties and return types.

## Security (Non-Negotiable)

- **Escape all output**: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()` — always, no exceptions.
- **Sanitize all input**: `sanitize_text_field()`, `absint()`, `wp_unslash()` before using `$_POST`/`$_GET`.
- **Nonces on all forms and AJAX**: `wp_nonce_field()` + `check_admin_referer()` / `check_ajax_referer()`.
- **Capability checks**: `current_user_can()` before any privileged action.
- **Prepared statements**: `$wpdb->prepare()` — never raw SQL with user data.

## WordPress Patterns

- Register everything via hooks — never call functions at file scope.
- Use `wp_enqueue_scripts` / `wp_enqueue_style` — never `<script>` or `<link>` tags directly.
- Prefix all options, meta keys, transients: `alwayshere_`.
- Use `get_template_part()` for template includes.
- Use `wp_remote_get()` / `wp_remote_post()` for HTTP — never `file_get_contents()` or `curl` directly.
- Use `WP_Query` — avoid raw `$wpdb` queries for post data.

## Comments

- Only comment *why*, not *what*.
- PHPDoc on all public class methods and functions.
- No commented-out code blocks in commits.

## File Structure

```
wp-content/
├── plugins/
│   └── alwayshere-core/         ← custom functionality
│       ├── alwayshere-core.php
│       ├── includes/
│       └── src/
└── themes/
    ├── parent-theme/            ← untouched
    └── alwayshere-child/        ← all custom theme work
        ├── functions.php        ← enqueue + hooks only
        ├── style.css
        └── woocommerce/         ← copied + overridden templates
```
