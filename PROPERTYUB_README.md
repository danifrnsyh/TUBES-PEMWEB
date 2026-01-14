# PropertyHub - Platform Jual Beli Property Online

![PropertyHub Logo](https://img.shields.io/badge/PropertyHub-v1.0-blue)

Platform e-commerce profesional untuk jual beli properti dengan dua tipe pengguna: **Penjual (Seller)** dan **Pembeli (Buyer)**.

## 🎯 Fitur Utama

### Untuk Penjual (Seller)
- **Dashboard Penjual**: Statistik penjualan real-time
- **Kelola Property**: Tambah, edit, hapus property dengan detail lengkap
- **Manajemen Inventory**: Atur stok dan status ketersediaan
- **Pesanan Pembeli**: Lihat dan kelola semua pesanan masuk
- **Konfirmasi Pesanan**: Terima atau tolak pesanan pembeli
- **Laporan Pendapatan**: Pantau total penjualan dan pendapatan

### Untuk Pembeli (Buyer)
- **Browse Property**: Jelajahi property dari berbagai penjual
- **Detail Property**: Lihat informasi lengkap setiap property
- **Keranjang Belanja**: Buat pesanan property
- **Manajemen Pesanan**: Lihat status pesanan Anda
- **Cetak Invoice**: Download dan cetak resi pesanan
- **Invoice Resmi**: Bukti transaksi yang profesional

## 🛠️ Tech Stack

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: Bootstrap 5 + Blade Templating
- **Icons**: Bootstrap Icons
- **PHP Version**: 8.1+

## 📦 Instalasi

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL
- Node.js (opsional)

### Langkah-langkah Setup

1. **Clone Repository**
```bash
cd c:\laragon\www\TUBESPEMWEB
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database** (Edit file `.env`)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tubespemweb
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan Migrasi**
```bash
php artisan migrate
```

6. **Seeding (Optional)**
```bash
php artisan db:seed
```

7. **Generate Storage Link**
```bash
php artisan storage:link
```

8. **Jalankan Server**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 📁 Struktur Project

```
├── app/
│   ├── Models/
│   │   ├── User.php                 # Model User dengan roles
│   │   ├── Property.php             # Model Property
│   │   └── Order.php                # Model Order
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PropertyController.php
│   │   │   ├── OrderController.php
│   │   │   ├── SellerController.php
│   │   │   ├── BuyerController.php
│   │   │   └── ...
│   │   ├── Middleware/
│   │   │   ├── CheckSeller.php
│   │   │   └── CheckBuyer.php
│   │   └── Kernel.php
│   └── Policies/
│       └── PropertyPolicy.php
├── database/
│   ├── migrations/
│   │   ├── 2025_12_20_000001_add_role_to_users_table.php
│   │   ├── 2025_12_20_000002_create_properties_table.php
│   │   └── 2025_12_20_000003_create_orders_table.php
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php        # Master layout
│       ├── properties/
│       │   ├── index.blade.php
│       │   ├── show.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── seller/
│       │   ├── dashboard.blade.php
│       │   ├── properties.blade.php
│       │   └── orders.blade.php
│       ├── buyer/
│       │   ├── dashboard.blade.php
│       │   └── orders.blade.php
│       ├── orders/
│       │   ├── show.blade.php
│       │   ├── create.blade.php
│       │   └── print-invoice.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php                      # Route definitions
└── public/
    └── storage/                     # Storage untuk upload
```

## 🔐 Sistem Autentikasi & Role

### User Roles
- **Buyer**: Pengguna yang membeli property
- **Seller**: Pengguna yang menjual property

### Middleware
- `auth`: Verifikasi user sudah login
- `seller`: Verifikasi user adalah seller
- `buyer`: Verifikasi user adalah buyer

### Authorization
Menggunakan Policy untuk mengontrol akses:
- Hanya seller yang bisa mengedit property mereka
- Hanya seller yang bisa melihat pesanan untuk property mereka
- Hanya buyer yang bisa melihat pesanan mereka

## 📊 Database Schema

### Users Table
```sql
- id
- name
- email
- password
- role (buyer/seller)
- phone
- address
- city
- province
- created_at
- updated_at
```

### Properties Table
```sql
- id
- seller_id (FK)
- title
- description
- address
- city
- province
- postal_code
- price
- stock
- type (apartment, house, land, commercial, other)
- area
- bedrooms
- bathrooms
- image
- status (available, sold, inactive)
- created_at
- updated_at
```

### Orders Table
```sql
- id
- invoice_number (unique)
- buyer_id (FK)
- seller_id (FK)
- property_id (FK)
- quantity
- price
- total_price
- status (pending, confirmed, completed, cancelled)
- notes
- ordered_at
- confirmed_at
- completed_at
- created_at
- updated_at
```

## 🚀 Cara Menggunakan

### Sebagai Pembeli

1. **Register**: Daftar dengan email dan password
2. **Browse Property**: Lihat daftar property yang tersedia
3. **Lihat Detail**: Klik property untuk melihat detail lengkap
4. **Buat Pesanan**: Tentukan jumlah unit dan buat pesanan
5. **Kelola Pesanan**: Pantau status pesanan di dashboard
6. **Cetak Invoice**: Setelah selesai, cetak invoice sebagai bukti

### Sebagai Penjual

1. **Register**: Daftar dengan memilih role "Seller"
2. **Tambah Property**: Tambahkan property ke katalog Anda
3. **Kelola Stok**: Edit stok dan harga property
4. **Lihat Pesanan**: Lihat semua pesanan dari pembeli
5. **Konfirmasi**: Terima atau tolak pesanan
6. **Tandai Selesai**: Tandai pesanan sebagai selesai setelah transaksi

## 📋 Route List

### Public Routes
- `GET /` - Landing page
- `GET /properties` - Browse all properties

### Authenticated Routes
- `GET /properties/{property}` - View property detail
- `GET /buyer/orders` - Buyer orders list
- `GET /buyer/dashboard` - Buyer dashboard
- `GET /seller/dashboard` - Seller dashboard
- `GET /seller/properties` - Seller properties list

### Seller Routes
- `POST /seller/properties` - Create new property
- `PUT /seller/properties/{property}` - Update property
- `DELETE /seller/properties/{property}` - Delete property
- `GET /seller/orders` - View all orders
- `POST /seller/orders/{order}/confirm` - Confirm order
- `POST /seller/orders/{order}/complete` - Complete order

### Buyer Routes
- `GET /buyer/properties/{property}/buy` - Buy property form
- `POST /buyer/properties/{property}/buy` - Create order
- `GET /buyer/orders/{order}` - View order detail
- `GET /buyer/orders/{order}/print` - Print invoice
- `POST /buyer/orders/{order}/cancel` - Cancel order

## 🎨 UI/UX Features

- **Responsive Design**: Bekerja sempurna di desktop dan mobile
- **Modern Dashboard**: Interface yang intuitif dan mudah digunakan
- **Professional Invoice**: Template invoice yang rapi dan profesional
- **Bootstrap 5**: UI framework yang modern dan cepat
- **Icons**: Bootstrap Icons untuk visual yang lebih baik

## 🔄 Workflow Transaksi

1. **Pembeli browsing** → Lihat property yang tersedia
2. **Pembeli buat pesanan** → Pilih jumlah dan buat pesanan
3. **Pesanan pending** → Menunggu konfirmasi penjual
4. **Penjual konfirmasi** → Pesanan berubah status "confirmed"
5. **Penjual tandai selesai** → Pesanan berubah status "completed"
6. **Pembeli cetak invoice** → Download bukti transaksi

## 🔍 Fitur Search & Filter

- Filter property berdasarkan kota, tipe, harga
- Pagination untuk property list
- Sort berdasarkan tanggal, harga, dll

## 📱 Responsive Features

- Mobile-friendly navigation
- Responsive tables
- Touch-friendly buttons
- Optimized images

## 🛡️ Security Features

- CSRF protection
- Password hashing
- Authorization policies
- Role-based access control
- SQL injection prevention (PDO prepared statements)

## 📄 License

Proprietary Software - 2025

## 👥 Author

PropertyHub Team

---

## 📞 Support

Untuk bantuan atau pertanyaan, hubungi:
- Email: info@propertyhub.com
- Phone: +62 8xx xxxx xxxx

---

**Selamat menggunakan PropertyHub! 🎉**
