<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // support both English and Indonesian column names
        'name',
        'nama',
        'email',
        'password',
        'role',
        'peran',
        'phone',
        'telepon',
        'address',
        'alamat',
        'city',
        'province',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function properties()
    {
        return $this->hasMany(Property::class, 'seller_id');
    }

    public function orders()
    {
        // Legacy Property System relationship - pointing to non-existent 'orders' table
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'pembeli_id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    // Helper methods
    public function isSeller()
    {
        $r = strtolower($this->role ?? $this->peran ?? '');
        return in_array($r, ['seller', 'pegawai', 'pegawai']);
    }

    public function isBuyer()
    {
        $r = strtolower($this->role ?? $this->peran ?? '');
        return in_array($r, ['buyer', 'pembeli']);
    }

    // Indonesian-named helpers
    public function isPegawai()
    {
        return $this->isSeller();
    }

    public function isPembeli()
    {
        return $this->isBuyer();
    }
}
