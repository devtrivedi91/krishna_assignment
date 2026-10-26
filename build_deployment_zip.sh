#!/usr/bin/env bash
# ==============================================================================
# DevPortfolio - Production Deployment Package Builder
# Bundles the clean production files into devportfolio-deploy.zip
# ==============================================================================

set -e

ZIP_NAME="devportfolio-deploy.zip"

echo "Creating clean production deployment package: ${ZIP_NAME}..."

# Remove old zip if present
rm -f "${ZIP_NAME}"

# Create zip bundle excluding local git, vscode, and temporary files
zip -r "${ZIP_NAME}" \
  index.php \
  about.php \
  skills.php \
  projects.php \
  contact.php \
  process_contact.php \
  database.sql \
  .htaccess \
  config/ \
  includes/ \
  assets/ \
  admin/ \
  -x "*.git*" "*.DS_Store*" "*node_modules*" "*test_verification*"

echo "Successfully generated ${ZIP_NAME} ($(du -h ${ZIP_NAME} | cut -f1))"
echo "Ready for direct upload to web root (e.g. public_html/ or wwwroot/)."
