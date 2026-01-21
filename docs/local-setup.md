# Hướng dẫn cài đặt dự án HRM trên máy local

> Tham khảo và điều chỉnh từ bài viết: https://viblo.asia/p/cach-cai-dat-du-an-laravel-clone-tu-github-63vKjkpkZ2R

## 1. Yêu cầu môi trường
- PHP 8.1+ và các extension Laravel yêu cầu (pdo_mysql, mbstring, tokenizer, xml, ctype, json, openssl, bcmath)
- Composer 2+
- Node.js 18+ và npm
- MySQL/MariaDB
- Git

## 2. Clone mã nguồn
```bash
git clone https://github.com/trongtansangnguyen/hrm.git
cd hrm
```

## 3. Cài đặt dependencies PHP
```bash
composer install
```

## 4. Thiết lập file môi trường
```bash
copy .env.example .env
```

Chỉnh sửa các biến sau trong `.env` cho phù hợp với máy của bạn:
```
APP_NAME="HRM"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hrm
DB_USERNAME=root
DB_PASSWORD=your_password
```

## 5. Tạo key ứng dụng
```bash
php artisan key:generate
```

## 6. Cấu trúc database
- Tạo database trống (ví dụ: `hrm`).
- Chạy migration và seed (nếu có seeder):
```bash
php artisan migrate --seed
```

## 7. Cài đặt frontend assets
```bash
npm install
npm run build   # hoặc npm run dev nếu muốn chạy chế độ phát triển
```

## 8. Khởi động ứng dụng
- Chạy server Laravel:
```bash
php artisan serve
```
Ứng dụng mặc định chạy tại `http://127.0.0.1:8000`.

- Nếu dùng Vite cho frontend (chế độ dev):
```bash
npm run dev
```

## 9. Kiểm tra nhanh
- Truy cập trình duyệt: `http://127.0.0.1:8000`.
- Đăng nhập bằng tài khoản được seed (nếu có) hoặc tạo mới qua giao diện/seed tùy cấu hình dự án.

## 10. Ghi chú
- Nếu dùng Sail (Docker) có thể thay các lệnh `php`/`composer` bằng `./vendor/bin/sail ...`.
- Nếu gặp lỗi quyền trên Windows, thử chạy terminal bằng quyền Administrator hoặc kiểm tra permission của thư mục dự án.
- Luôn đảm bảo `.env` không bị commit lên remote.
