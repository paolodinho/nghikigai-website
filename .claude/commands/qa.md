---
description: Gọi qa-reviewer check output vừa tạo
argument-hint: [file hoặc mô tả output cần check]
---

Gọi sub-agent `qa-reviewer` để kiểm tra output vừa tạo.

Target cần review: $ARGUMENTS

Sau khi QA trả về:
- Nếu PASS → báo cho Hiếu ngắn gọn
- Nếu FAIL/WARNING → tự sửa các blocker, rồi QA lại
- Tối đa 3 vòng QA. Sau đó báo Hiếu các warning còn lại để quyết.
