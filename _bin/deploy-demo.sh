#!/usr/bin/env bash
# deploy-demo.sh — export static + push gh-pages
# Usage: ./_bin/deploy-demo.sh
# Gọi mỗi khi có thay đổi theme để link demo cập nhật.

set -e

SITE_URL="http://nghikigai.local"
STATIC_DIR="$(pwd)/_static"
REPO_DIR="$(pwd)"

echo "=== Nghikigai deploy-demo ==="
echo "1. Xoá _static cũ..."
rm -rf "$STATIC_DIR"
mkdir -p "$STATIC_DIR"

echo "2. Export static từ $SITE_URL ..."
wget --mirror \
     --convert-links \
     --adjust-extension \
     --page-requisites \
     --no-parent \
     --no-verbose \
     -e robots=off \
     --reject-regex='(\?|/wp-admin|/wp-json|/cart/|/checkout/|/my-account/)' \
     -P "$STATIC_DIR" \
     "$SITE_URL" 2>&1 | tail -5

echo "3. Push lên gh-pages..."
cd "$STATIC_DIR/nghikigai.local"

# Init git nếu chưa có
if [ ! -d ".git" ]; then
  git init
  git remote add origin "https://github.com/paolodinho/nghikigai-website.git"
fi

git checkout -B gh-pages
git add -A
git commit -m "auto: deploy demo $(date '+%Y-%m-%d %H:%M')" || echo "(no changes)"
git push origin gh-pages --force

echo ""
echo "=== Xong! Demo: https://paolodinho.github.io/nghikigai-website/ ==="
