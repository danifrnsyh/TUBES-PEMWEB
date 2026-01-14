<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    use HasFactory;

    protected $table = 'pesanan_item';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'nama_produk',
        'sku',
        'jumlah',
        'harga_unit',
        'subtotal',
        'metode',
        'status',
        'bukti',
    ];

    protected $guarded = [];

    public static function createSafe($data)
    {
        try {
            return self::create($data);
        } catch (\Exception $e) {
            // If produk_id column doesn't exist, remove and retry
            if (isset($data['produk_id']) && strpos($e->getMessage(), 'produk_id') !== false) {
                unset($data['produk_id']);
                return self::create($data);
            }
            throw $e;
        }
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
