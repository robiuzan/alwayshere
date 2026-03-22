---
description: Scaffold a complete reusable UI component — PHP template, SCSS, JS, and ACF block registration for the alwayshere child theme
---

Create a new UI component: $ARGUMENTS

## What to build

A fully self-contained, reusable component for the `alwayshere-child` theme.

## Output (all of these)

### 1. ACF Block registration (if it's a Gutenberg block)
In `alwayshere-child/functions.php` or a dedicated `inc/blocks.php`:
```php
acf_register_block_type([
    'name'            => 'alwayshere-{component-name}',
    'title'           => '{Hebrew Title}',
    'render_template' => 'template-parts/blocks/{component-name}.php',
    'category'        => 'alwayshere',
    'icon'            => '{dashicon}',
    'supports'        => ['align' => false, 'jsx' => true],
]);
```

### 2. PHP Template
Path: `template-parts/blocks/{component-name}.php` or `template-parts/components/{component-name}.php`

- Include `ABSPATH` check
- Use `get_field()` for ACF data
- BEM class names
- Semantic HTML
- Escape all output
- Hebrew labels/placeholder text

### 3. SCSS
Path: `assets/scss/components/_{component-name}.scss`

- Self-contained — no leaking styles
- CSS variables for tokens
- Mobile-first
- RTL logical properties
- Import in main `style.scss`

### 4. JS (if interactive)
Path: `assets/js/components/{component-name}.js`

- Vanilla JS or jQuery wrapper
- Init on `DOMContentLoaded`
- Export as module if build tool supports it

### 5. ACF Field Group (if needed)
- Registered in PHP via `acf_add_local_field_group()`
- Keys prefixed: `field_alwayshere_{component}_*`
- Labels in Hebrew

## Naming
- File names: `kebab-case`
- PHP functions: `alwayshere_snake_case()`
- CSS classes: `.ah-{component-name}__element--modifier` (BEM)
- ACF keys: `field_alwayshere_{component}_{field}`

After writing all files, run `code-reviewer` agent.
