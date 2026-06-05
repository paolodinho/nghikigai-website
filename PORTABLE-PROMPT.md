# PORTABLE PROMPT - Nghikigai (rebuild)
*Paste vào tool AI khác khi cần tiếp tục dự án này.*
*Last updated: 2026-06-05 (hoàn thiện store + workshop + bàn giao)*

---

Tôi đang làm dự án code lại website Nghikigai. Bạn là trợ lý AI tiếp nối công việc. Context:

## 1. Dự án
Code lại web https://nghikigai.com - store hương thơm (nến kể chuyện, nước hoa độc bản, tinh dầu, xô thơm, quà tặng), tiếng Việt, WooCommerce. Mục tiêu: GIỮ NGUYÊN giao diện/cấu trúc/nội dung, nhưng BỎ theme premium TemplateMela (Avanam/Kidupia) + Elementor + Slider Revolution. Ràng buộc cốt lõi: mọi sửa đổi sau này KHÁCH TỰ LÀM ĐƯỢC, không đụng code.

## 2. Tôi là ai
Hiếu - agency Digito Combat. Tiếng Việt, ngắn gọn, đề xuất thay vì hỏi mở, không emoji. Luôn backup trước khi sửa file quan trọng.

## 3. Kiến trúc đã chốt
- Dựng trên Local (Flywheel): site `nghikigai.local`, WP 7.0, PHP 8.2, MySQL 8.4. Admin: admin/admin.
- Theme: Kadence (free) + child theme `nghikigai` + Gutenberg/Kadence Blocks (KHÔNG page builder).
- WooCommerce: store VN/VND (giá 1.000 ₫, 0 thập phân).
- Khách sửa: sản phẩm/giá trong Woo admin; text/ảnh trang trong Gutenberg editor; màu/font/header/footer trong Kadence Customizer.

## 4. Brand
- Logo: `_assets/logo.webp` (đã gán Site Logo).
- Màu chính: hồng magenta #e62a65; phụ teal #199588, dark #1e1e1e.
- Font: heading Jost, body Nunito.
- Hotline 0382 475 611 · 0938 365 100 | nghikigai@gmail.com | 10:00-18:00 | FB/IG/TikTok @nghikigai.

## 5. Đã làm xong (2026-06-05)
- Site Local chạy, theme + child + Woo + Kadence Blocks active.
- Import 21 sản phẩm thật (giá, biến thể, ảnh full-size) + 5 danh mục VN (gán theo tên, bỏ demo "clothes"), 37 ảnh.
- Trang chủ Gutenberg: top bar free-ship (hồng), hero, danh mục (thumbnail thật), sản phẩm bán chạy, testimonials (7 review thật), blog.
- Trang Về chúng tôi, FAQs (31 Q&A accordion), Liên hệ.
- Menu chính + dropdown danh mục, footer liên hệ.
- Global palette + font brand. "Quà tặng theo yêu cầu" hiển thị "Liên hệ".

## 6. Cấu trúc file dự án
- `_bin/wp.sh` - wrapper wp-cli cho site Local (tự dò socket). Dùng: `./_bin/wp.sh <lệnh>`.
- `_export/` - products.json, faqs.json, testimonials_clean.json, các script PHP (import-products, build-content, setup-design, setup-header-footer, fixes), `raw/` HTML crawl.
- `_assets/` - logo.
- `.claude/context/` - brand-info, site-structure, content.
- Site files: `~/Local Sites/nghikigai/app/public` (child theme tại `wp-content/themes/nghikigai`).

## 7. Đã hoàn thiện thêm (2026-06-05 chiều)
- Sản phẩm import lại từ **CSV gốc** (danh mục phân cấp, gallery đầy đủ, mô tả HTML, slug + permalink /san-pham/).
- Tắt **WooCommerce Coming Soon** (đang che shop/sản phẩm).
- Research Google: địa chỉ thật **Hẻm 341 Nguyễn Trãi, P. Nguyễn Cư Trinh, Q1** → điền Contact (+Google Map) & footer.
- Header thêm **tìm kiếm + giỏ hàng**. Trang chủ sắp lại gọn gàng. Shop 3 cột. CSS polish.
- **Store mua được**: COD + Chuyển khoản (chờ khách điền số TK), shipping VN (free >500K + 30k). QA Store API OK (giỏ→ship→thanh toán).
- Trang **Workshop "Letter to Soul"** + favicon vuông từ logo + menu cập nhật.
- Doc bàn giao: `HUONG-DAN-KHACH.md`.

## Còn mở
- Khách điền **số tài khoản ngân hàng thật** (WooCommerce → Thanh toán → Chuyển khoản).
- Nội dung blog thật (3 bài live là demo → đã bỏ).
- (Tùy chọn) ảnh đội ngũ/con người (rule ui-anti-slop).
- Lưu ý: screenshot tự động bị kẹt "idle" do script nền theme - site vẫn chạy tốt, mở `nghikigai.local` xem trực tiếp.

## 8. Yêu cầu tiếp theo
[Hiếu paste yêu cầu mới ở đây]
