---
description: Audit a page or template for SEO — checks title, meta, schema, OG tags, headings, image alt text
---

Perform a full SEO audit on: $ARGUMENTS

Check and report on:

**Technical SEO**
- Title tag: present, unique, 50–60 chars, includes primary keyword
- Meta description: present, 150–160 chars, has CTA
- Canonical tag: present and correct
- robots meta: not accidentally set to noindex
- Heading hierarchy: one H1, logical H2/H3 structure

**Schema / Structured Data**
- Product pages: `Product` schema with name, image, price, availability, review aggregate
- Category pages: `BreadcrumbList` schema
- Blog posts: `Article` schema with author and datePublished
- Organization / LocalBusiness schema on homepage

**Open Graph & Social**
- `og:title`, `og:description`, `og:image` (min 1200×630px), `og:url`, `og:type`
- `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
- Product OG: `og:type = product`, price and availability tags

**WooCommerce Specific**
- Product images: `alt` text includes product name + keyword
- Short description: keyword-rich, 1–2 sentences
- Long description: 300+ words, semantic structure, internal links
- Permalink: short, keyword-focused, no stop words

**Performance Signals**
- Images: lazy loading on below-fold images
- No render-blocking scripts on critical path

Output a checklist with PASS / FAIL / MISSING for each item, then list the top 3 priority fixes.
