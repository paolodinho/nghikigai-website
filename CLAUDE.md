# CLAUDE.md - Nghikigai (rebuild)

Website: https://nghikigai.com - store hương thơm (nến, nước hoa, tinh dầu) tiếng Việt, WooCommerce.
**Mục tiêu:** code lại web, **giữ nguyên giao diện / cấu trúc / nội dung**, bỏ theme premium TemplateMela (Avanam/Kidupia) + Elementor + Slider Revolution.
**Ràng buộc cốt lõi:** mọi sửa đổi về sau khách **tự làm được, không đụng code**.

## Quyết định kiến trúc (2026-06-05)
- Theme: **Kadence** (free) + child theme riêng + Gutenberg blocks/patterns gốc. Không page builder.
- Global colors/typography + pattern → khách sửa bằng WP editor mặc định.
- Nội dung: **chỉ giữ store thật**, bỏ section/menu demo của theme.
- Dữ liệu: Hiếu export từ site live → import vào Local.
- Dựng trên **Local (Flywheel)**: site `nghikigai`, php 8.2, mysql 8.0, nginx.

## Brand nhanh
- Logo: `_assets/logo.webp` (gốc cropped-Con-dau-2-png.webp)
- Font: Nunito (body) + Jost (heading)
- Màu: primary `#e62a65` (hồng magenta), teal `#199588`, dark `#1e1e1e`, green `#5fbd74`

## Files
- `PLAN.md` - task & tiến độ
- `.claude/context/brand-info.md` - brand chi tiết, tokens
- `.claude/context/site-structure.md` - cấu trúc trang/menu site gốc
- `_export/` - file export từ live (products CSV, WXR, uploads)
- `_assets/` - logo, ảnh brand

## Trạng thái (2026-06-05)
Site Local hoàn chỉnh, chạy đúng. 21 sản phẩm import từ **CSV gốc WooCommerce** (Hiếu export) → danh mục phân cấp (Nến thơm cao cấp ▸ Nến kể chuyện/decor/thông điệp), gallery đầy đủ, mô tả HTML thật, slug + permalink `/san-pham/` khớp live. Trang chủ/About/FAQ/Contact/menu/header-footer xong.

### GOTCHA quan trọng
- **WooCommerce Coming Soon mode** mặc định BẬT ở WC 9.x → che shop/sản phẩm/giỏ (chỉ hiện trang chủ). Đã tắt: `woocommerce_coming_soon=no`, `woocommerce_store_pages_only=no`. Nếu dựng trên server khác nhớ kiểm tra.
- wp-cli: dùng `_bin/wp.sh`. Script import: `_export/import-from-csv.php` (đọc products_csv.json + slugmap.json).

### Tối ưu đã làm (2026-06-05)
- Địa chỉ thật (research): Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Q1 → điền Contact (kèm Google Map) + footer.
- Header thêm **tìm kiếm + giỏ hàng** (dễ tìm sản phẩm).
- Trang chủ gọn gàng: Hero → Mua theo danh mục → Bán chạy + "Xem tất cả" → Vì sao chọn → Testimonials → CTA. Bỏ section blog rỗng.
- Shop 3 cột, sắp theo phổ biến. CSS polish (card hover, FAQ accordion, line-height dễ đọc).
- Dọn demo: trash Refund mẫu, xoá Uncategorized.

### Còn mở
- Blog: 3 bài live là demo marketing → đã bỏ. Chờ nội dung thật.
- (Tùy chọn) Trang/section Workshop "Letter to Soul".
- SĐT/giờ mở cửa: xác nhận lại với Hiếu nếu cần.
