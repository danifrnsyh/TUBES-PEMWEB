<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'address',
        'city',
        'province',
        'postal_code',
        'price',
        'stock',
        'type',
        'area',
        'bedrooms',
        'bathrooms',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'available' && $this->stock > 0;
    }

    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getSoldCount()
    {
        return $this->orders()->whereIn('status', ['confirmed', 'completed'])->sum('quantity');
    }
}
