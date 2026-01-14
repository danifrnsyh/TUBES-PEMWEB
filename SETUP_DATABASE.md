# SETUP DATABASE INSTRUCTIONS

## Prerequisites
Pastikan Anda memiliki:
1. Database `tubespemweb_toko` sudah dibuat di MySQL
2. PHP dan Composer sudah ter-install
3. Laravel sudah ter-install di project

## Step 1: Install Dependencies
```bash
composer install
```

## Step 2: Generate Application Key (jika belum)
```bash
php artisan key:generate
```

## Step 3: Run Database Migrations
```bash
php artisan migrate
```

## Step 4: (Optional) Seed Database dengan Test Data
```bash
php artisan db:seed
```

Ini akan membuat:
- Test buyer user: buyer@test.com / password123
- Test seller user: seller@test.com / password123
- 3 sample products (Sofa, Meja, etc)

## Step 5: Start Development Server
```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Atau jika menggunakan Laragon, langsung akses melalui browser.

## Verify Setup
Buka browser dan cek:
- http://127.0.0.1:8000 - Halaman landing
- http://127.0.0.1:8000/shop - Halaman shop
- http://127.0.0.1:8000/login - Halaman login

## Troubleshooting

### Error "Column not found"
Jalankan: `php artisan migrate`

### Error "Database tidak ditemukan"
Buat database `tubespemweb_toko` di MySQL Workbench atau command line:
```sql
CREATE DATABASE tubespemweb_toko CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Test Login
Email: buyer@test.com
Password: password123
