# Aplikasi Invoice Laravel

Aplikasi invoice sederhana berbasis Laravel yang mendukung:
- Multi user login
- CRUD invoice
- Multi item dalam satu invoice
- Export PDF invoice
- Dashboard invoice
- Modal edit invoice

---

# Teknologi

- Laravel 12
- PHP 8.2
- MySQL
- Blade Template
- DomPDF

---

# Cara Menjalankan Project

## 1. Clone / Download Project

Pindahkan project ke folder:

```bash
C:\xampp\htdocs\
```

---

## 2. Install Dependency

Buka terminal di folder project lalu jalankan:

```bash
composer install
```

---

## 3. Copy File Environment

```bash
copy .env.example .env
```

---

## 4. Generate Key Laravel

```bash
php artisan key:generate
```

---

## 5. Atur Database

Buat database baru di phpMyAdmin:

```text
invoice_app
```

Lalu ubah file `.env`

```env
DB_DATABASE=invoice_app
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Jalankan Migration

```bash
php artisan migrate
```

---

## 7. Jalankan Server

```bash
php artisan serve
```

---

# Login

Buat akun melalui halaman register.

---

# Fitur

- Login & Register
- Dashboard invoice
- Tambah invoice
- Multi item barang
- Edit invoice menggunakan modal
- Hapus invoice
- Export invoice PDF
- Data invoice per user

---

# Author

Dimas Ghifari