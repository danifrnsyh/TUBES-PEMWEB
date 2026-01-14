<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'penambah_id',
        'kategori_id',
        'nama',
        'deskripsi',
        'sku',
        'harga',
        'stok',
        'berat_gram',
        'dimensi',
        'gambar_utama',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function penambah()
    {
        return $this->belongsTo(User::class, 'penambah_id');
    }

    public function gambar()
    {
        return $this->hasMany(ProdukGambar::class, 'produk_id');
    }

    public function isActive()
    {
        return $this->status === 'aktif' && $this->stok > 0;
    }

    public function formattedPrice()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
