<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateTotalPrice()
    {
        return $this->items()->sum('total_price');
    }
}
