# Brand - Nghikigai

Store hương thơm cao cấp (tiếng Việt): nến thơm kể chuyện, nước hoa độc bản, tinh dầu nội thất, xô thơm, quà tặng.

## Logo
- File: `_assets/logo.webp` (gốc: `cropped-Con-dau-2-png.webp`, 500×200)
- Đã import vào Media (attachment ID 10), gán làm Site Logo.

## Màu (tokens) - CHỦ ĐẠO = MÀU LOGO (cập nhật 2026-06-05)
| Token | Hex | Dùng |
|---|---|---|
| **primary (xanh logo)** | `#406247` | nút, link, nhấn, top bar, testimonials title |
| primary-dark | `#2f4a35` | hover, CTA nền |
| hero/section tint | `#f1f6f2` | nền hero nhạt |
| dark | `#1e1e1e` | text heading |
| neutral gray | `#f7fafc` | nền section testimonials |
| trắng | `#ffffff` | nền |
> Trước đây dùng hồng `#e62a65` - đã đổi toàn bộ sang xanh logo theo yêu cầu khách. Palette set ở Kadence (palette1=#406247) → khách đổi được trong Customizer → Colors.

## Font
- Heading: **Lora** (serif, weight 600) - đổi từ Jost vì **Jost thiếu glyph tiếng Việt (vỡ dấu)**. Lora hỗ trợ đầy đủ tiếng Việt.
- Body: **Nunito** (400/700) - hỗ trợ tiếng Việt tốt.
- (Google Fonts - Kadence load qua global typography. Lora/Nunito tự nạp subset vietnamese qua unicode-range.)
- ⚠️ Khi đổi font sau này: chỉ chọn font có subset **vietnamese** (vd Be Vietnam Pro, Lora, Playfair Display, Montserrat, Nunito) - tránh Jost/Quicksand/Poppins-thiếu-dấu.

## Lưu ý
- Màu/font tinh chỉnh lại khi xem trực quan site gốc; trên đây là trích từ CSS live.
