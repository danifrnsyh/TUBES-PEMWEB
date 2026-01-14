<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Tambahkan field yang boleh diisi massal
    protected $fillable = ['nama', 'stok'];
}
