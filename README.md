<div align="center">

# 🏥 Clinic Management System

### ✨ Laravel-based Healthcare Scheduling & Management Platform

<p>
Hệ thống quản lý phòng khám xây dựng hoàn toàn bằng Laravel (Blade + PHP + MySQL),
tối ưu vận hành lịch khám và phân quyền người dùng
</p>

<img src="https://img.shields.io/badge/Framework-Laravel-red" />
<img src="https://img.shields.io/badge/Frontend-Blade-green" />
<img src="https://img.shields.io/badge/Backend-PHP-blue" />
<img src="https://img.shields.io/badge/Database-MySQL-blueviolet" />

</div>

---

## 📌 Overview

**Clinic Management System** là hệ thống quản lý phòng khám với trọng tâm:

🔹 Quản lý lịch làm việc bác sĩ thông minh
🔹 Phân quyền chặt chẽ theo vai trò
🔹 Tích hợp đăng nhập mạng xã hội & thanh toán
🔹 UI thân thiện, trực quan, dễ sử dụng

👉 Demo: https://clinicdtn.wuaze.com/

---

## ✨ Core Features

---

## 📅 1. Schedule Management & Medical History

### 🔍 Lọc đa chiều thông minh

* Tìm kiếm theo:

  * 👨‍⚕️ Tên bác sĩ
  * 🕐 Ca làm việc (Sáng / Chiều / Cả ngày)
  * 📌 Trạng thái (Chờ duyệt / Đã duyệt / Đã hủy)
* Hỗ trợ chuyển đổi:

  * 📆 Ngày / Tháng / Năm

---

### 📊 Giao diện ma trận lịch tuần

* Hiển thị lịch theo dạng **weekly grid (calendar matrix)**
* ✅ Highlight ngày hiện tại
* ⏮ ⏭ Điều hướng tuần trước / tuần sau
* 📌 Trực quan, dễ theo dõi lịch làm việc

---

### 🤖 Tự động hóa trạng thái

* Tự động chuyển:

  * `Chờ duyệt` ➝ `Đã duyệt`
* Áp dụng cho:

  * Các lịch đã **quá ngày**
* Giảm thao tác thủ công cho admin

---

### 📁 Lịch sử khám bệnh

* Lưu trữ lịch sử khám của bệnh nhân
* Dễ dàng tra cứu và quản lý dữ liệu

---

## 🔐 2. Role-Based Access Control (RBAC)

### 🛡 Bảo mật 2 lớp (Frontend + Backend)

#### 👑 Admin

* Toàn quyền:

  * ➕ Thêm lịch
  * ✏️ Sửa lịch
  * ❌ Xóa lịch
  * ✅ Duyệt lịch

#### 👨‍⚕️ Doctor

* Chỉ được:

  * 👁 Xem lịch của chính mình
* 🚫 Không hiển thị:

  * Nút Sửa / Xóa trên UI
* 🔒 Backend:

  * Chặn truy cập trái phép qua Controller

---

## 🔑 3. Social Login (Google OAuth 2.0)

* Đăng nhập nhanh bằng tài khoản Google
* Xử lý:

  * 🔐 OAuth 2.0 flow
  * 🌐 HTTPS (TrustProxies)
  * 🔁 Redirect URI (deploy trên Wuaze)
* Tăng trải nghiệm người dùng & bảo mật

---

## 💳 4. Payment Integration

### 📱 Thanh toán MoMo

* Tạo:

  * 🆔 Order ID duy nhất
* Bảo mật:

  * 🔐 Ký điện tử (Signature)
* Xử lý:

  * 📥 Callback / IPN từ MoMo
  * 🔄 Tự động cập nhật:

    * Trạng thái: `Đã thanh toán`
    * Phương thức: `momo`

---

### 💵 Thanh toán tiền mặt

* Phương thức truyền thống
* Admin cập nhật trạng thái thủ công nhanh chóng

---

## 🎨 5. UI/UX & Interaction

### 📬 Trang Liên hệ (Contact)

* Sử dụng **Bootstrap 5**
* ✨ Floating Labels
* 🎯 Icon trực quan
* 🗺 Nhúng Google Maps

---

### 🔔 Phản hồi hệ thống

* Sử dụng:

  * 🏷 Badge (hiển thị số lượng kết quả)
  * ⚠️ Alert (thông báo lỗi/thành công)
* Hỗ trợ:

  * Flash messages rõ ràng

---

## 🧱 Tech Stack

### 🔹 Backend

```id="e1z4hg"
Laravel (PHP Framework)
Blade Template Engine
Eloquent ORM
RESTful Logic
```

### 🔹 Frontend

```id="x4h6k2"
Blade (Laravel View)
Bootstrap 5
JavaScript
```

### 🔹 Database

```id="h5psm9"
MySQL
```

---

## 🚀 Getting Started

### ⚙️ Requirements

```bash id="v62c7g"
PHP >= 8.1
Composer
MySQL >= 8.0
Laravel >= 10
```

---

### 🔧 Installation

```bash id="l5z8nd"
git clone your-repo-url
cd clinic-management

composer install
cp .env.example .env
php artisan key:generate

# Config database trong .env
php artisan migrate --seed

php artisan serve
```

---

## 📂 Project Structure

```bash id="w9p3fd"
app/
 ├── Http/Controllers
 ├── Models
resources/
 ├── views/ (Blade UI)
routes/
 ├── web.php
database/
 ├── migrations/
```

---

## 🤝 Contributing

```bash id="y3f8qp"
# Fork & Clone
git clone your-fork-url

# Install
composer install

# Run
php artisan serve
```

### Workflow

* Fork repository
* Create branch
* Commit changes
* Push & Pull Request

---

## 📄 License

MIT License

---

## 👨‍💻 Contact

* 👤 Developer: **Đỗ Thành Nhân**
* 📧 Email: **[dothanhnhan1024@gmail.com](mailto:dothanhnhan1024@gmail.com)**
* 🌐 Demo: https://clinicdtn.wuaze.com/
* 📱 Hotline: +84 386 356 750

---

<div align="center">

⭐ **If this project helps you, give it a star!** ⭐

</div>
