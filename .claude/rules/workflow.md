# Workflow - Nghikigai (dựng/sửa site Local)

## wp-cli
- Dùng wrapper: `./_bin/wp.sh <command>` (tự dò SITE_ID + mysql socket của Local).
- Site Local: `nghikigai` · nghikigai.local · PHP 8.2 · MySQL 8.x · DB local/root/root.

## Sửa nội dung site → bằng script PHP (eval-file)
Mọi thay đổi nội dung lặp lại/hàng loạt viết thành script trong `_export/`, chạy:
```
./_bin/wp.sh eval-file _export/<script>.php
```
Script chính (thứ tự dựng lại từ đầu):
1. `setup-design.php` - palette #406247 + font Lora/Nunito
2. `import-from-csv.php` - 21 sp + danh mục + ảnh (đọc products_csv.json + slugmap.json)
3. `update-homepage.php` - trang chủ
4. `rebuild-about.php` / `build-workshop-favicon.php` - About + Workshop + favicon
5. `optimize.php` - header search+cart, footer địa chỉ, contact + map, dọn demo
6. `complete-store.php` - COD + chuyển khoản + vận chuyển VN (free > 500K)
7. `update-descriptions.php` - dọn mô tả (đọc clean_desc.json)

## Sửa giao diện (CSS/JS/PHP theme)
- Theme: `~/Local Sites/nghikigai/app/public/wp-content/themes/nghikigai/`
- Đồng bộ về repo: `wp-content/themes/nghikigai/` (chỉ theme, không kèm WP core).
- Sửa CSS → bump `NGHIKIGAI_VERSION`.

## Audit giao diện
- Chrome MCP `javascript_tool` (JS đồng bộ - async timeout trên site này).
- Screenshot tool fail (document_idle không fire) → query DOM/computed-style trực tiếp.

## Gửi khách demo
Theo rule global `web-deploy-workflow.md`: export static → `gh-pages` → Pages.
Repo: paolodinho/nghikigai-website · Demo: https://paolodinho.github.io/nghikigai-website/
