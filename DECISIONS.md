# DECISIONS - Nghikigai

> Quyết định quan trọng + lý do. Mới nhất ở trên.

## 2026-06-06 - Demo giao diện qua GitHub Pages
- **Quyết định:** Giao demo cho khách bằng static export → nhánh `gh-pages` → GitHub Pages (repo Public).
- **Lý do:** Repo code thuần không render được WordPress; khách cần link bấm vào XEM được giao diện. Static = chỉ xem (giỏ hàng/thanh toán/tìm kiếm không chạy) nhưng đủ để duyệt bố cục.
- **Hệ quả:** Mỗi lần cập nhật lớn phải re-export + push `gh-pages`. Repo phải Public để Pages công khai.

## 2026-06-05 - Tắt wptexturize
- **Quyết định:** `add_filter('run_wptexturize','__return_false')` + chuẩn hoá khoảng giá WooCommerce về "-".
- **Lý do:** WordPress tự đổi " - " thành en-dash "–", vi phạm rule Hiếu (không dùng em/en dash). <!-- Claude suy luận, Hiếu xác nhận -->

## 2026-06-05 - Màu chủ đạo #406247 (xanh logo)
- **Quyết định:** Đổi primary từ hồng `#e62a65` sang xanh lá logo `#406247`.
- **Lý do:** Hiếu yêu cầu lấy màu logo làm màu chủ đạo cho nhất quán brand.

## 2026-06-05 - Font Lora (heading) + Nunito (body)
- **Quyết định:** Heading dùng **Lora** thay Jost.
- **Lý do:** Jost thiếu glyph tiếng Việt (vỡ chữ "Hương"). Lora đủ dấu, vẫn sang.

## 2026-06-05 - Kadence + child theme + Gutenberg (kiến trúc gốc)
- **Quyết định:** Bỏ theme premium TemplateMela (Avanam/Kidupia) + Elementor + Slider Revolution → **Kadence free + child theme + Gutenberg/Kadence Blocks**, không page builder.
- **Lý do:** Ràng buộc cốt lõi - khách phải tự sửa nội dung được mà không đụng code. Gutenberg + Customizer là chuẩn WP, khách tự làm.
