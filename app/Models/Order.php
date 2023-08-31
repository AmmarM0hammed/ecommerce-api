<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded;

    public function order_item() {
        return $this->hasMany(OrderItem::class,"order_id","id");
    }
    public function user() {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
