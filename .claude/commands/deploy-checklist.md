---
description: Full pre-launch / pre-deploy checklist for alwayshere.co.il — runs all agents and verifies the site is production-ready
---

Run the full deploy checklist for: $ARGUMENTS (or "full site" if no argument)

## Security
- [ ] `security-auditor` agent run on all custom PHP files — zero blockers
- [ ] `WP_DEBUG` set to `false` in production `wp-config.php`
- [ ] No `var_dump`, `error_log`, `console.log` left in code
- [ ] All forms have nonce verification
- [ ] File permissions: `wp-config.php` = 600, `uploads/` = 755
- [ ] WP admin URL hardened (not `/wp-admin` if customized)

## SEO
- [ ] `seo-specialist` agent run on homepage, shop, and at least one product page
- [ ] Yoast SEO configured: site name, separator, social profiles
- [ ] XML sitemap accessible at `/sitemap.xml`
- [ ] Google Search Console verified
- [ ] No pages accidentally `noindex`
- [ ] `robots.txt` correct

## Performance
- [ ] Google PageSpeed Insights score ≥ 80 mobile
- [ ] Images: WebP format, correct sizes, lazy loading
- [ ] No render-blocking scripts on critical path
- [ ] Caching plugin configured (WP Rocket / W3TC / LiteSpeed)
- [ ] CDN configured for images/assets

## WooCommerce
- [ ] Test order placed successfully (guest + logged-in)
- [ ] Payment gateway in live mode — test with real card
- [ ] Order confirmation email sends
- [ ] Stock management working
- [ ] Shipping rates correct
- [ ] Tax configuration verified for Israel (17% VAT)
- [ ] Personalization fields save to order correctly

## Frontend / RTL
- [ ] Site tested in Hebrew on mobile (iOS Safari + Android Chrome)
- [ ] RTL layout correct — no broken directional CSS
- [ ] Hebrew font loading correctly
- [ ] All product images have alt text
- [ ] No broken images or 404 assets

## ACF
- [ ] ACF UI disabled in production (`acf/settings/show_admin` → false)
- [ ] All field groups registered in PHP (not DB-only)
- [ ] Personalization fields tested end-to-end

## Social / OG
- [ ] OG image set for homepage, shop, and product pages
- [ ] Test Facebook share preview with [developers.facebook.com/tools/debug](https://developers.facebook.com/tools/debug)
- [ ] Instagram image sizes correct (1:1 + 4:5)
- [ ] TikTok pixel installed (if applicable)
- [ ] Facebook Pixel installed (if applicable)

## Legal (Israel)
- [ ] Privacy policy page in Hebrew
- [ ] Cookie consent banner (GDPR / Israeli Privacy Protection Law)
- [ ] Terms & conditions page
- [ ] Refund/return policy visible on checkout
- [ ] Company registration number displayed (as required by Israeli e-commerce law)

## Backup
- [ ] Automated backup configured (daily minimum)
- [ ] Backup tested — restore works

Output: PASS / FAIL for each section, with specific action items for anything failing.
