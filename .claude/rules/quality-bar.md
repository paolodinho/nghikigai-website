# Quality Bar - Nghikigai (web WordPress)

> Tiêu chí riêng dự án. Rule chung (typography-dash, ui-anti-slop...) đã ở global, không lặp.

## Ràng buộc CỐT LÕI (không được phá)
- **Khách tự sửa được, KHÔNG đụng code:** mọi nội dung/trang/khối phải chỉnh qua WP editor + Customizer. KHÔNG hardcode nội dung trong theme.
- Giữ nguyên giao diện / cấu trúc / nội dung site gốc khi recode.

## Trước khi báo "xong"
- [ ] Test cả desktop + **mobile** (rule wording-orphans, mobile padding).
- [ ] Không còn dấu "—"/"–" trên giao diện (rule typography-dash) - check cả khoảng giá WooCommerce.
- [ ] Không chữ mồ côi cuối dòng ở heading/CTA.
- [ ] Ảnh sản phẩm/logo/đội ngũ là ảnh THẬT, không SVG placeholder (rule ui-anti-slop).
- [ ] Coming Soon mode TẮT (`woocommerce_coming_soon=no`) - nếu không shop bị ẩn.
- [ ] Mô tả sản phẩm không lỗi ký tự (không "n" thừa từ \n, không span builder rác).

## Khi sửa theme code
- Bump `NGHIKIGAI_VERSION` trong functions.php để cache-bust CSS/JS.
- Backup file binary trước khi ghi đè (rule backup-before-edit).

## Trước khi gửi khách (demo)
- Re-export static + push `gh-pages` để link Pages cập nhật.
- Verify HTTP 200 các trang chính + CSS/logo/ảnh load (rule web-deploy-workflow).
