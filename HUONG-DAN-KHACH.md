# Hướng dẫn tự quản trị website Nghikigai

> Website code lại trên nền **WordPress + WooCommerce + theme Kadence**.
> Mọi nội dung dưới đây **bạn tự chỉnh được, KHÔNG cần đụng tới code**.

---

## 0. Đăng nhập trang quản trị
- Vào: `https://nghikigai.com/wp-admin` (bản demo: `http://nghikigai.local/wp-admin`)
- Tài khoản admin do bạn giữ. Sau khi nhận bàn giao, **đổi mật khẩu** ngay (Người dùng → Hồ sơ).

---

## 1. Sản phẩm (sửa giá, ảnh, mô tả, tồn kho)
**Sản phẩm** (Products) ở menu trái.
- Bấm vào tên sản phẩm để sửa.
- **Giá:** với sản phẩm có size/loại → kéo xuống **Dữ liệu sản phẩm → Các biến thể**, sửa giá từng size. Sản phẩm 1 giá → tab **Chung**.
- **Ảnh:** cột phải → *Ảnh sản phẩm* (ảnh đại diện) và *Bộ sưu tập sản phẩm* (ảnh phụ).
- **Mô tả:** ô lớn = mô tả chi tiết; *Mô tả ngắn* = đoạn cạnh giá.
- **Còn/hết hàng:** Dữ liệu sản phẩm → Kho hàng → *Tình trạng kho*.
- Xong bấm **Cập nhật**.

### Thêm sản phẩm mới
Sản phẩm → **Thêm mới** → nhập tên, mô tả, ảnh, chọn **Danh mục** bên phải.
- Nếu có nhiều size: Dữ liệu sản phẩm → chọn **Sản phẩm có biến thể** → tab *Thuộc tính* tạo "Size" (vd 100g | 220g) → tab *Các biến thể* → *Tạo biến thể từ tất cả thuộc tính* → điền giá từng size.
- Bấm **Đăng**.

### Danh mục sản phẩm
Sản phẩm → **Danh mục**. Có cấu trúc cha-con sẵn (Nến thơm cao cấp ▸ Nến kể chuyện / Nến decor / Nến thông điệp). Thêm/sửa tại đây; đặt **Ảnh** đại diện cho danh mục để hiện đẹp ở trang chủ.

---

## 2. Sửa nội dung các trang (Trang chủ, Giới thiệu, FAQ, Liên hệ, Workshop)
**Trang** (Pages) → bấm trang cần sửa → mở **trình soạn thảo khối (Gutenberg)**.
- Bấm vào đoạn chữ để sửa trực tiếp; bấm khối ảnh để đổi ảnh.
- Thêm khối mới: bấm dấu **+**.
- Trang chủ gồm các khối: banner, *Mua theo danh mục*, *Sản phẩm bán chạy*, *Vì sao chọn Nghikigai*, *Khách hàng nói gì*, kêu gọi liên hệ. Sửa chữ/nút tùy ý.
- **FAQ**: mỗi câu hỏi là 1 khối *Chi tiết* (bấm mở/đóng) - sửa câu hỏi ở dòng tiêu đề, câu trả lời bên trong.
- Xong bấm **Cập nhật**.

> Danh sách sản phẩm trong trang chủ tự cập nhật theo kho - không cần sửa tay.

---

## 3. Menu điều hướng
**Giao diện → Menu** (Appearance → Menus).
- Kéo-thả để đổi thứ tự; kéo thụt vào để tạo menu con.
- Thêm mục: chọn Trang / Danh mục / Liên kết tùy chỉnh bên trái → **Thêm vào menu**.
- Bấm **Lưu menu**.

---

## 4. Logo, màu sắc, phông chữ, Header, Footer
**Giao diện → Tùy biến** (Customize) - xem trực tiếp thay đổi:
- **Site Identity:** đổi Logo, favicon.
- **Colors & Fonts:** màu thương hiệu (hồng `#e62a65`), phông chữ (Jost / Nunito).
- **Header:** bố cục đầu trang - kéo-thả logo, menu, ô tìm kiếm, giỏ hàng; sửa **thanh thông báo ship** (Top Row → HTML).
- **Footer:** thông tin chân trang (địa chỉ, hotline, mạng xã hội) ở mục HTML.
- Bấm **Đăng** (Publish) để lưu.

---

## 5. Đơn hàng & Thanh toán
- **WooCommerce → Đơn hàng:** xem, cập nhật trạng thái đơn (Đang xử lý → Hoàn thành...).
- **WooCommerce → Cài đặt → Thanh toán:**
  - *Chuyển khoản ngân hàng* → **điền số tài khoản, tên ngân hàng thật** (hiện đang để trống chờ bạn điền).
  - *Thanh toán khi nhận hàng (COD)* đã bật.
- **WooCommerce → Cài đặt → Vận chuyển:** khu vực "Việt Nam" - phí 30.000đ, **miễn phí cho đơn > 500.000đ**. Sửa mức phí tại đây.

---

## 6. Blog (tin tức)
**Bài viết → Thêm mới** (giống soạn trang). Bài mới sẽ tự hiện ở mục Blog. Hiện chưa có bài thật - bạn thêm khi cần.

---

## Nguyên tắc an toàn
- Luôn bấm **Cập nhật / Lưu** sau khi sửa.
- Sửa nội dung/giá/ảnh/menu/màu = an toàn, không ảnh hưởng code.
- Tránh xóa các trang hệ thống: Giỏ hàng, Thanh toán, Tài khoản.
- Cần thay đổi lớn (thêm tính năng, sửa bố cục phức tạp) → báo đội kỹ thuật (Digito Combat).

---
*Bàn giao bởi Digito Combat - 2026.*
