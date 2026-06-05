# PLAN - Nghikigai rebuild

## Giai đoạn
### 1. Chuẩn bị (XONG)
- [x] Khảo sát stack live (Avanam/Kidupia + Elementor + RevSlider + Woo)
- [x] Trích brand tokens (màu/font/logo)
- [x] Scaffold dự án
- [x] Tạo site Local `nghikigai` (nghikigai.local, WP 7.0, PHP 8.2, MySQL 8.4)
- [x] VI language, timezone, permalink /%postname%/, store VN/VND
- [x] Cài + active: Kadence theme, child theme `nghikigai`, WooCommerce, Kadence Blocks
- [x] Logo import (attachment 10) + gán Site Logo
- [x] wrapper wp-cli `_bin/wp.sh` (tự dò socket)

### 2. Dữ liệu (XONG - crawl public, không cần admin)
- [x] Crawl 21 sản phẩm + trang + home từ live → `_export/raw`
- [x] Trích `products.json` (giá, biến thể, ảnh full-size, mô tả)
- [x] Import 21 sp + 37 ảnh + 5 danh mục (gán danh mục VN, bỏ demo "clothes")
- [x] Trích About/FAQ(31)/Contact/testimonials(7) thật

### 3. Theme & giao diện (XONG)
- [x] Child theme `nghikigai` của Kadence
- [x] Global palette (pink #e62a65) + font Jost/Nunito
- [x] Top bar free-ship (hồng) + footer liên hệ (Kadence, khách sửa Customizer)
- [x] Trang chủ Gutenberg: hero, danh mục (thumbnail thật), bán chạy, testimonials, blog
- [x] Trang About / FAQs (accordion) / Contact
- [x] Menu chính + dropdown danh mục + front page
- [x] Fix: ẩn title trùng, ẩn tiêu đề trang chủ, "Quà tặng" → Liên hệ

### 4. QA & bàn giao (đang)
- [x] QA trực quan trang chủ (desktop) - đạt
- [ ] QA mobile + trang shop/product/cart/checkout
- [ ] Doc hướng dẫn khách tự sửa (text/ảnh/sp/giá/menu)

## Còn mở (cần Hiếu xác nhận)
- Địa chỉ cửa hàng thật (live đang để demo San Francisco)
- Nội dung blog thật (3 bài trên live là demo marketing → đã bỏ)
- Ảnh gallery nhiều hơn / ảnh đội ngũ (rule ui-anti-slop)
- Logo nền xanh - xác nhận có đúng bản brand không
