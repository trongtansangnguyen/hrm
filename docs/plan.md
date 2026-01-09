# HRM (PHP Thuần & MySQL) — Kế Hoạch Triển Khai

Tài liệu này mô tả kế hoạch xây dựng, triển khai và vận hành hệ thống HRM dùng PHP thuần và MySQL, ưu tiên đơn giản, bảo mật và khả năng lặp lại.

## Tổng Quan
- Phạm vi: PHP thuần (không framework, không thư viện bên ngoài) + MySQL
- Mục tiêu: Dev (Windows), Prod (Linux với Apache hoặc Nginx + PHP-FPM)
- Nguyên tắc: Không Composer, không Docker Compose; chỉ dùng tính năng sẵn có của PHP và MySQL
- Kết quả: Triển khai ổn định, bảo mật, backup và giám sát cơ bản

## 1) Yêu Cầu & Kiến Trúc
- Nghiệp vụ: hồ sơ nhân sự, chấm công, nghỉ phép, payroll cơ bản, vai trò/quyền
- Phi chức năng: bảo mật, hiệu năng, khả năng mở rộng, backup, audit logs
- Kiến trúc: cấu trúc thư mục kiểu MVC đơn giản; routing bằng PHP; schema MySQL
- Đầu ra: sơ đồ ngữ cảnh, ERD, ma trận quyền, danh sách trang/chức năng

## 2) Môi Trường Phát Triển & Sản Xuất
- Dev (Windows): PHP ≥ 8.1, MySQL ≥ 8.0; có thể dùng `php -S` hoặc XAMPP/WAMP (tuỳ chọn)
- PHP extensions: `pdo_mysql` hoặc `mysqli`, `intl`, `mbstring`, `openssl`, `curl`, `json`

## 3) Cấu Trúc Dự Án & Cấu Hình
- Thư mục:
  - public/ (entry `index.php`, assets)
  - app/ (Controllers/, Models/, Views/, Services/)
  - config/ (`config.php`, `routes.php`, `autoload.php`)
  - migrations/ (SQL thuần, có version)
  - scripts/ (tiện ích vận hành, backup)
  - logs/ (ghi log app nếu cần)
- Cấu hình:
  - `config/config.php` chứa thông số DB và app, đọc từ biến môi trường hệ thống nếu có (không dùng `.env` library)
- Khởi tạo:
  - Bootstrap, router tối thiểu, autoloader bằng `spl_autoload_register()`, error handler cơ bản

## 4) Thiết Kế CSDL & Migrations
- Bảng lõi: `users`, `roles`, `departments`, `employees`, `attendance`, `leave_requests`, `payroll`, `audit_logs`
- Migrations: file `.sql` có version, chạy tuần tự, ghi nhận lịch sử đã chạy
- Seed: tạo role admin và user admin ban đầu
- Backup/Restore: chiến lược `mysqldump` và kỳ hạn lưu giữ

Tạo DB và user:
```sql
CREATE DATABASE hrm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hrm_user'@'%' IDENTIFIED BY 'changeMe!';
GRANT ALL PRIVILEGES ON hrm.* TO 'hrm_user'@'%';
FLUSH PRIVILEGES;
```

## 5) Tính Năng Lõi
- Xác thực: đăng nhập/đăng xuất, reset mật khẩu bằng token
- Phân quyền: kiểm tra RBAC theo vai trò
- Module: CRUD nhân sự, chấm công, nghỉ phép (đề xuất/duyệt), payroll cơ bản
- Audit: ghi thao tác nhạy cảm

## 6) Bảo Mật
- Mật khẩu: `password_hash()`/`password_verify()`, chính sách mạnh
- Phiên: `session_set_cookie_params(['secure'=>true,'httponly'=>true,'samesite'=>'Strict'])`, regenerate ID sau login
- SQL: prepared statements (PDO/mysqli), không nối chuỗi
- CSRF: token ẩn trong form và kiểm tra với POST
- HTTPS/TLS: bắt buộc ở prod; HSTS và các header an toàn
- DB: tài khoản tối thiểu quyền, không dùng `root` trong ứng dụng
- Headers: `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`

CSRF cơ bản:
```php
<?php
session_start();
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
function verify_csrf($token){ return hash_equals($_SESSION['csrf'] ?? '', $token ?? ''); }
```

## 7) Kiểm Thử (Không Thư Viện)
- Lint: `php -l` cho các file thay đổi
- Smoke/E2E thủ công cho luồng chính: login, tạo nhân sự, tạo nghỉ phép
- Trang `/health`: ping DB + trạng thái app

## 8) Đóng Gói & Phát Hành
- Artifact: nén `public/`, `app/`, `config/`, `migrations/`, `scripts/` và loại trừ thông tin bí mật
- Phiên bản: `vX.Y.Z` gắn với snapshot của schema/migrations

## 9) Vận Hành & Giám Sát
- Logging: ghi file trong `logs/` với cơ chế rotate (logrotate/Task Scheduler)
- Healthcheck: `/health` (DB ping + readiness)
- Cảnh báo: 5xx tăng, thiếu dung lượng, lỗi backup

## 10) Sao Lưu & Khôi Phục (DR)
- DB: `mysqldump` hằng ngày, lưu giữ 7/30/90 ngày; mã hóa và lưu kho tách biệt
- Test khôi phục hàng quý; có runbook DR với mục tiêu RPO/RTO

Ví dụ backup:
```bash
mysqldump -u hrm_user -p hrm > /backups/hrm_$(date +%F).sql
```

## 11) Bảo Trì & Mở Rộng
- Vá lỗi: OS/PHP/MySQL định kỳ
- Hiệu năng: index truy vấn, pagination, cache đọc nóng (file cache đơn giản nếu cần)
- Mở rộng: scale web theo chiều ngang, tách DB sang managed service khi tăng tải

## 12) Go-Live Checklist
- HTTPS bật, redirect HTTP→HTTPS
- Tài khoản admin riêng, đổi mật khẩu mặc định
- Backup chạy và đã test restore
- RBAC kiểm tra cho từng vai trò
- Healthcheck xanh, logging hoạt động
