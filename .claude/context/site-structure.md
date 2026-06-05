# Cấu trúc site gốc nghikigai.com (để dựng lại)

## Stack gốc (đang bỏ)
Theme Avanam + child Avanam-Kidupia (TemplateMela) · Elementor · Slider Revolution · WooCommerce + Wishlist/Compare/Quick-view · Contact Form 7.

## Menu header (BẢN THẬT - đã bỏ mục demo)
> Menu gốc còn lẫn demo theme (Product Types, WooCommerce Pages, Product Features, Elements > Accordion/Icon box/Portfolio/FAQs/Gallery/Tabs...). **Bỏ hết demo.** Menu thật dự kiến:
- Trang chủ
- Shop / Sản phẩm
- Danh mục: Nến thơm cao cấp · Tinh dầu · Nước hoa độc bản · Quà tặng · Xô thơm
- Blog
- Về chúng tôi (About)
- Liên hệ (Contact)
- (icons) Tài khoản · Wishlist · Giỏ hàng
→ Chốt lại theo data export thật.

## Trang chủ - các section (giữ nguyên thứ tự)
1. Thanh banner: miễn ship nội thành TPHCM
2. Slider sản phẩm nổi bật (nến kể chuyện, nước hoa độc bản) - thay RevSlider bằng Kadence block/slider
3. "Sản phẩm chính" - grid danh mục (5 cat)
4. "Sản phẩm bán chạy" - grid 10 sản phẩm
5. "Feedback từ khách hàng" - 8 testimonials
6. "Blog" - 3 bài gần đây
7. Footer - thông tin liên hệ

## Trang con
- /shop/, /san-pham/<slug>, /cart/, /checkout/, /my-account/
- /blog/, /about-us/, /contact-us/, /faqs/

## Map dựng lại (Kadence + Gutenberg)
| Phần gốc | Cách dựng mới (no-code cho khách) |
|---|---|
| RevSlider hero | Kadence Blocks (slider/rows) hoặc Kadence hero pattern |
| Elementor section | Gutenberg + Kadence Blocks pattern (khách sửa trong editor) |
| Header/Footer | Kadence Header/Footer Builder (Customizer, kéo-thả) |
| Danh mục/Sản phẩm | WooCommerce native + Kadence product blocks |
| Testimonials | Kadence Testimonials block |
| Blog mới nhất | Kadence Posts block |

## TODO khi có data
- Lấy danh sách category + product thật, slug, giá.
- Lấy nội dung 8 testimonials, 3 bài blog, About/Contact/FAQ text.
- Lấy ảnh thật (sản phẩm + đội ngũ) → tuân thủ rule ui-anti-slop (không SVG fake).
