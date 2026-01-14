# 🚀 PROPERTYUB QUICK START GUIDE

## Instalasi dan Cara Menjalankan

### Langkah 1: Setup Database
```bash
# Buat database MySQL
mysql -u root -e "CREATE DATABASE tubespemweb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Langkah 2: Konfigurasi Environment
Edit file `.env` di root project:

```env
APP_NAME="PropertyHub"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tubespemweb
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 3: Install Dependencies
```bash
composer install
```

### Langkah 4: Generate Key
```bash
php artisan key:generate
```

### Langkah 5: Jalankan Migrasi
```bash
# Migrasi semua tables
php artisan migrate

# Jika ingin reset database (hapus semua data)
php artisan migrate:fresh
```

### Langkah 6: Seed Database (Optional)
```bash
# Jalankan seeder untuk membuat test data
php artisan migrate:fresh --seed
```

### Langkah 7: Storage Link
```bash
# Untuk upload file (gambar property)
php artisan storage:link
```

### Langkah 8: Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## 🧪 Test Accounts

### Akun Penjual
```
Email: seller@propertyhub.com
Password: password
```

### Akun Pembeli
```
Email: buyer@propertyhub.com
Password: password
```

---

## 📝 Struktur File Penting

### Controllers
- `app/Http/Controllers/PropertyController.php` - Kelola property
- `app/Http/Controllers/OrderController.php` - Kelola pesanan
- `app/Http/Controllers/SellerController.php` - Dashboard seller
- `app/Http/Controllers/BuyerController.php` - Dashboard buyer

### Models
- `app/Models/User.php` - User dengan roles (seller/buyer)
- `app/Models/Property.php` - Data property
- `app/Models/Order.php` - Data pesanan

### Views
- `resources/views/layouts/app.blade.php` - Master layout
- `resources/views/seller/` - Views untuk seller
- `resources/views/buyer/` - Views untuk buyer
- `resources/views/properties/` - Views untuk property
- `resources/views/orders/` - Views untuk pesanan

### Routes
- `routes/web.php` - Semua web routes

---

## 🎯 Fitur Utama

### 1️⃣ Penjual (Seller)
- ✅ Dashboard dengan statistik penjualan
- ✅ Tambah/Edit/Hapus property
- ✅ Kelola stok dan harga
- ✅ Lihat pesanan pembeli
- ✅ Konfirmasi/Tolak pesanan
- ✅ Tandai pesanan selesai
- ✅ Laporan pendapatan

### 2️⃣ Pembeli (Buyer)
- ✅ Browse property dari berbagai penjual
- ✅ Lihat detail lengkap property
- ✅ Buat pesanan
- ✅ Lihat riwayat pesanan
- ✅ Cetak invoice
- ✅ Batalkan pesanan (jika pending)

---

## 🛠️ Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"
→ Pastikan MySQL sudah running di XAMPP/Laragon

### Error: "Class 'App\Models\Property' not found"
→ Jalankan `composer dump-autoload`

### Error: "Target class controller does not exist"
→ Jalankan `php artisan route:cache` dan clear cache

### Images tidak tampil
→ Pastikan sudah jalankan `php artisan storage:link`

### Flash messages tidak muncul
→ Pastikan session middleware sudah aktif di routes

---

## 📱 Responsive Testing

Aplikasi ini **fully responsive**:
- ✅ Desktop (1920px)
- ✅ Tablet (768px)
- ✅ Mobile (375px)

---

## 🔐 Security

- ✅ CSRF Protection
- ✅ Password Hashing (Bcrypt)
- ✅ Role-Based Access Control
- ✅ Authorization Policies
- ✅ Input Validation
- ✅ File Upload Restrictions

---

## 📊 Database Schema

### Users Table
- id, name, email, password, role, phone, address, city, province

### Properties Table
- id, seller_id, title, description, address, city, province, postal_code, price, stock, type, area, bedrooms, bathrooms, image, status

### Orders Table
- id, invoice_number, buyer_id, seller_id, property_id, quantity, price, total_price, status, notes, ordered_at, confirmed_at, completed_at

---

## 🎨 UI Framework

- **Bootstrap 5** - Responsive CSS framework
- **Bootstrap Icons** - Icon library
- **Custom Styling** - Modern gradient design

---

## 📚 Dokumentasi Lengkap

Baca file `PROPERTYUB_README.md` untuk dokumentasi lengkap

---

## ✨ Fitur Bonus

- 📧 Flash messages untuk feedback user
- 🎨 Professional invoice template
- 📈 Dashboard dengan statistik real-time
- 🔍 Pagination untuk list data
- 💬 Form validation dengan error messages
- 🖼️ Image upload support
- 📱 Mobile-first responsive design

---

## 🎓 Belajar Lebih Lanjut

Docs:
- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)

---

## 🐛 Report Issues

Temukan bug? Silakan buat issue atau hubungi:
- Email: info@propertyhub.com

---

## 📄 License

Proprietary - 2025

---

**Happy Coding! 🎉**

*Dibuat dengan ❤️ untuk PropertyHub*
