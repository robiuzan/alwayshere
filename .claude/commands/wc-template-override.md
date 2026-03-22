---
description: Copy a WooCommerce template into the child theme for safe customization
---

Override the WooCommerce template: $ARGUMENTS

Steps:
1. Find the template file inside `wp-content/plugins/woocommerce/templates/`
2. Determine the correct mirror path under `wp-content/themes/alwayshere-child/woocommerce/`
3. Create any missing subdirectories
4. Copy the file to the child theme path
5. Add this comment block at the very top of the copied file (after the opening `<?php` if present):

```php
/**
 * Overrides WooCommerce template: {original/path/to/template.php}
 * WooCommerce version at time of copy: {current WC version — check wp-content/plugins/woocommerce/woocommerce.php}
 * Copied: {today's date}
 *
 * @see https://woocommerce.com/document/template-structure/
 */
```

6. Confirm the destination path and remind me to re-check this file after every WooCommerce update.

Do NOT modify any logic in the copied file — copy only, then stop and wait for further instructions.
