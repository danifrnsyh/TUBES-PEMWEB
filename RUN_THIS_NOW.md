# 🔧 FINAL FIX - Run This Command NOW!

## Instruksi Paling Simple:

Buka **PowerShell/Terminal** di folder project dan copy-paste command ini:

```bash
php artisan reset:pesanan-tables
```

Ketika ditanya "Do you want to continue?", ketik: **yes**

---

## Expected Output:

```
⚠️  This will DELETE all pesanan data! Continue? (yes/no)
 > yes

Dropping foreign keys and tables...
✓ Dropped pesanan_item
✓ Dropped pesanan
Creating pesanan table...
✓ Created pesanan
Creating pesanan_item table...
✓ Created pesanan_item

✓✓✓ SUCCESS! ✓✓✓

Pesanan table columns:
  ✓ id
  ✓ nomor_invoice
  ✓ pembeli_id
  ✓ total
  ✓ status
  ✓ catatan
  ✓ alamat_kirim
  ✓ ongkir
  ✓ metode_pembayaran
  ✓ created_at
  ✓ updated_at

Pesanan_item table columns:
  ✓ id
  ✓ pesanan_id
  ✓ produk_id
  ✓ nama_produk
  ✓ sku
  ✓ jumlah
  ✓ harga_unit
  ✓ subtotal
  ✓ metode
  ✓ status
  ✓ bukti
  ✓ created_at
  ✓ updated_at
```

---

## Setelah Command Berhasil:

1. ✅ Tutup terminal
2. ✅ Refresh browser
3. ✅ Coba beli produk: `http://127.0.0.1:8000/produk/3/buy`
4. ✅ Seharusnya **BERHASIL** sekarang! 🎉

---

## Jika Masih Error:

Import SQL manual di HeidiSQL/MySQL Workbench:

File: `recreate_pesanan_item.sql` (sudah ada di project root)

---

**JALANKAN COMMAND DI ATAS SEKARANG! 👆**
