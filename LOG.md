# LOG - Nghikigai

> Nhật ký session. Mới nhất ở trên.

## 2026-06-06
- **Ảnh thật + bài viết (trang đầy đặn hơn):** Hiếu gửi 2 folder Google Drive.
  - Folder WS (48 ảnh workshop) tải ok qua gdown → resize 8 ảnh đẹp nhất → import Media (att 433-440).
  - Dựng lại trang **Workshop** với tên THẬT "Tiny Treasures - Balancing Life's Big Pressures" + gallery 8 ảnh thật + list "Nghikigai có" (từ flyer). Script: `import-workshop-gallery.php`.
  - Trang chủ: chèn strip "Trải nghiệm tự tay làm nến" (media-text) giữa "Vì sao chọn" và testimonials.
  - Blog: bài thật "Tiny Treasures - buổi workshop làm nến..." (#443) + featured + gallery. Script: `add-workshop-content.php`. Tạo category "Tin tức".
  - Verify Chrome: pages 200, ảnh load (lazy), không dấu "—", strip đúng vị trí.
  - **BLOCKER:** Folder "Hình sản phẩm" thực ra là kho **2600 ảnh** (DSC/IMG HEIC/nến kể chuyện/set quà/postcard...). gdown bị Google **rate-limit** sau khi enumerate nhiều lần → chưa tải được ảnh sản phẩm. Đã có full 2600 file ID ở `/tmp/product_ids_full.tsv`. Cần retry sau cooldown + Hiếu chỉ định ảnh nào cho sản phẩm nào (archive không đặt tên theo SKU).
- Hệ thống hoá dự án (`/organize-project`): thêm LOG.md, DECISIONS.md, `.claude/rules/` (quality-bar, workflow), `.claude/commands/` (qa, status, wrap).
- Deploy demo giao diện: static export site Local → nhánh `gh-pages` → **GitHub Pages**.
  - Repo: https://github.com/paolodinho/nghikigai-website (Public)
  - Demo: https://paolodinho.github.io/nghikigai-website/
  - Lập rule global `web-deploy-workflow.md`: mọi dự án web → auto push GitHub + link xem giao diện gửi khách.
  - ⚠️ Cần revoke các GitHub token đã lộ trong chat.

## 2026-06-05
- Dựng site Local `nghikigai` hoàn chỉnh (Kadence child theme + Gutenberg, không page builder).
- Import 21 sản phẩm từ CSV gốc WooCommerce (Hiếu export) → danh mục phân cấp, gallery, mô tả HTML thật.
- Trang chủ / About / FAQ / Contact / Workshop / menu / header-footer xong.
- Tối ưu: địa chỉ thật (Hẻm 341 Nguyễn Trãi, Q1), header search+cart, shop 3 cột, testimonials grid gọn.
- Fix hiển thị: font Lora (Jost lỗi tiếng Việt), tắt wptexturize (giữ dấu "-"), hero blur+dim cho dễ đọc, dọn "n" thừa trong mô tả.
- Đổi màu chủ đạo sang xanh logo `#406247`.
- 2 commit: scaffold + theme/scripts/docs; hero blur + tắt wptexturize.
