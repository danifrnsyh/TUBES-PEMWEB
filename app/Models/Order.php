<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'buyer_id',
        'seller_id',
        'property_id',
        'quantity',
        'price',
        'total_price',
        'status',
        'notes',
        'ordered_at',
        'confirmed_at',
        'completed_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'ordered_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Helper methods
    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
