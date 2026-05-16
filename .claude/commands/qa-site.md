---
description: Run a full UX QA audit against alwayshere.local — captures Playwright screenshots + DOM + Web Vitals at mobile and desktop, then invokes the ux-qa-auditor agent for a gift-store-opinionated analysis. Usage: /qa-site [url-or-page-key]
---

Run a full UX QA audit on alwayshere.local.

Target: $ARGUMENTS (if blank, audit all pages in .claude/qa/qa.config.json)

## Step 1 — Install Playwright if needed

Check whether `.claude/qa/node_modules/playwright` exists.

If it does NOT exist:
```bash
cd .claude/qa && npm install
```
Then install the Chromium browser binary:
```bash
cd .claude/qa && npx playwright install chromium
```

## Step 2 — Fill in fixture slugs if not yet configured

Check `.claude/qa/qa.config.json` for placeholder values like `REPLACE_WITH_SIMPLE_PRODUCT_SLUG`.

If any placeholder is still there, **stop and ask the user** to provide:
- A simple (non-engravable) product slug — URL: `/product/<slug>/`
- An engravable product slug
- A category slug — URL: `/product-category/<slug>/`
- (Optional) A fixture order ID + order key for the order-pay page

If all fixtures look like real slugs, proceed.

## Step 3 — Run the Playwright crawler

```bash
cd .claude/qa && node qa-run.mjs $ARGUMENTS
```

The runner will:
- Log in via `QA_USER` / `QA_PASS` env vars if set (required for cart-filled, checkout, orders, favorites)
- Visit every page (or just the targeted one) at 375×812 (mobile) and 1440×900 (desktop)
- Run interactive scenarios (hover, menu open, real add-to-cart, empty checkout submit, engraving focus)
- Write artifacts to `.claude/qa/runs/<timestamp>/`
- Print the run directory path as its last line of output

Capture the run directory from the last line of the runner output.

## Step 4 — Invoke ux-qa-auditor

Invoke the `ux-qa-auditor` agent with the full path to the run directory:

> Audit the UX QA run at `.claude/qa/runs/<timestamp>/`.
> For each page subdirectory, `Read` the mobile.png and desktop.png screenshots (vision — primary evidence), then read dom.json, metrics.json, console.json, network.json, and any files in scenarios/.
> Apply the full ux-qa-auditor checklist and produce a severity-tagged report.

## Step 5 — Print report and delegate

Print the agent's full report verbatim.

Then, based on findings:

- If any `[BLOCKER]` or `[HIGH]` implicates a PHP/JS/CSS file → suggest:
  `Run code-reviewer on <file path>`
- If Web Vitals findings are present → suggest:
  `Run /performance-auditor or invoke the performance-auditor agent`
- If title/meta/schema findings → suggest:
  `Run /seo-audit on the affected page`
- If personalization field issues → suggest:
  `Invoke the acf-specialist agent`

---

**Note on credentials:** Set `QA_USER` and `QA_PASS` environment variables to a WordPress test account before running. Without these, logged-in flows (cart-filled, checkout, my-account) will be captured in a logged-out state. The `storageState.json` is cached in `.claude/qa/` after the first login — delete it to force re-authentication.

**Note on fixture slugs:** After first run, update `.claude/qa/qa.config.json` with real product/category slugs from your WooCommerce catalog. These placeholders only need to be set once.
