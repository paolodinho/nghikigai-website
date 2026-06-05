# Nghikigai - Website (WordPress + WooCommerce)

Code lại website [nghikigai.com](https://nghikigai.com) - store hương thơm (nến kể chuyện, nước hoa độc bản, tinh dầu, xô thơm, quà tặng).
Bỏ theme premium TemplateMela + Elementor + Slider Revolution; thay bằng **custom child theme trên nền Kadence + Gutenberg blocks**, để khách tự sửa nội dung mà không cần đụng code.

> Demo dựng trên Local (Flywheel). Repo này chứa **code + script dựng + tài liệu**, không kèm WordPress core.

## Công nghệ
- WordPress + WooCommerce
- Theme: **Kadence** (free) + child theme `nghikigai`
- Gutenberg blocks + Kadence Blocks (không page builder)
- Màu chủ đạo: `#406247` (xanh logo) · Font: **Lora** (heading) + **Nunito** (body)

## Cấu trúc repo
```
wp-content/themes/nghikigai/   Child theme (style.css, functions.php, assets/css, assets/js)
_export/                       Script & dữ liệu dựng site (import sản phẩm, dựng trang, cấu hình store)
_assets/                       Logo brand
_bin/wp.sh                     Wrapper wp-cli cho site Local
.claude/                       Context dự án (brand, cấu trúc, nội dung)
HUONG-DAN-KHACH.md             Hướng dẫn khách tự quản trị (không cần code)
PLAN.md / PORTABLE-PROMPT.md   Kế hoạch & tóm tắt dự án
```

## Cài đặt / dựng lại
1. WordPress mới + cài plugin **WooCommerce**, theme **Kadence**, **Kadence Blocks**.
2. Copy `wp-content/themes/nghikigai` vào `wp-content/themes/`, kích hoạt theme **Nghikigai**.
3. (Tùy chọn) chạy các script trong `_export/` qua wp-cli để dựng lại nội dung demo, ví dụ:
   ```bash
   wp eval-file _export/setup-design.php          # palette + font
   wp eval-file _export/import-from-csv.php        # 21 sản phẩm + danh mục + ảnh
   wp eval-file _export/update-homepage.php        # trang chủ
   wp eval-file _export/complete-store.php         # thanh toán + vận chuyển
   ```
   (Xem thứ tự & mô tả trong từng file.)

## Tính năng đã làm
- 21 sản phẩm thật (biến thể, gallery, mô tả sạch), danh mục phân cấp
- Trang chủ (hero ảnh, danh mục, bán chạy, "vì sao chọn", feedback, CTA)
- Về chúng tôi / Workshop / FAQ / Liên hệ (kèm Google Map)
- Store mua được: COD + chuyển khoản, vận chuyển VN (free > 500K)
- Header tìm kiếm + giỏ hàng, footer liên hệ, logo trong suốt, favicon
- Hiệu ứng fade-up khi cuộn, hover; tối ưu mobile

## Quản trị (cho khách)
Xem [HUONG-DAN-KHACH.md](HUONG-DAN-KHACH.md): sửa sản phẩm/giá/ảnh, nội dung trang, menu, màu/font, đơn hàng - tất cả qua WP admin, không cần code.

---
Thực hiện bởi **Digito Combat** - 2026.
