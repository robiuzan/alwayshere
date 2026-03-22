---
description: Generate Yoast SEO filters for Open Graph + social meta for Instagram, Facebook, and TikTok
---

Generate complete social media meta tags for: $ARGUMENTS

Site: alwayshere.co.il — personal gifts, Hebrew only (he_IL), RTL.
SEO plugin: Yoast SEO — use Yoast filters, never raw wp_head.
Platforms: Instagram, Facebook, TikTok.

---

**1. Yoast OG overrides (PHP)**

Use these filters for product pages:
- `wpseo_opengraph_title`
- `wpseo_opengraph_desc`
- `wpseo_opengraph_image`
- `wpseo_opengraph_type` → "product" for products

Requirements:
- `og:locale` → he_IL
- `og:site_name` → AlwaysHere
- `og:title` → product name + emotional Hebrew hook, max 60 chars
- `og:description` → benefit-first, warm tone, max 200 chars
- `og:image` → 1200×630 for Facebook, also register 1:1 square fallback for Instagram

**2. Facebook**
- Image: 1200×630px, JPG, show product + lifestyle context
- Copy tone: warm, personal, gifting occasion focus
- Output a sample post caption in Hebrew (max 125 chars before "more")

**3. Instagram**
- Image sizes needed: 1:1 (1080×1080) and 4:5 (1080×1350)
- Output 3 caption variants in Hebrew:
  - Short punchy (under 100 chars)
  - Story-driven (3–4 lines)
  - With emoji + hashtags (15–20 relevant Hebrew + niche tags)

**4. TikTok**
- Vertical video thumbnail: 1080×1920 (9:16)
- Output a short Hebrew video script hook (first 3 seconds — must stop the scroll)
- Suggest 5 TikTok content angles for this product (e.g., unboxing, personalization process, gift reveal reaction)

**5. Image asset checklist**
List all image sizes and formats needed across all 3 platforms.
