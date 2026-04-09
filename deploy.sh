#!/usr/bin/env bash
# deploy.sh — build + commit + push to GitHub → triggers cPanel auto-deploy
# Usage: ./deploy.sh "commit message"

set -e

MSG="${1:-deploy}"

echo "▶ Building assets..."
cd wp-content/themes/alwayshere-child
npm run build
cd ../../..

echo "▶ Staging files..."
git add \
  wp-content/themes/alwayshere-child/assets/css/ \
  wp-content/themes/alwayshere-child/assets/js/ \
  wp-content/themes/alwayshere-child/ \
  wp-content/plugins/alwayshere-core/ \
  .cpanel.yml \
  .gitignore

# Stage anything else already tracked that changed
git add -u

git status --short

echo ""
read -p "Commit and push? (y/n): " CONFIRM
if [[ "$CONFIRM" != "y" ]]; then
  echo "Aborted."
  exit 0
fi

git commit -m "$MSG" || echo "(nothing new to commit)"
git push origin main

echo ""
echo "✓ Pushed to GitHub. cPanel will deploy automatically in ~1 minute."
echo "  Check: cPanel → Git Version Control → Manage → Pull or Deploy"
