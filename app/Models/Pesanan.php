<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'nomor_invoice',
        'pembeli_id',
        'total',
        'status',
        'catatan',
        'alamat_kirim',
        'ongkir',
        'metode_pembayaran',
    ];

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pesanan_id');
    }

    public function formattedTotal()
    {
        return 'Rp ' . number_format($this->total + $this->ongkir, 0, ',', '.');
    }
}
