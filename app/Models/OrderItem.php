<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded;
    protected $table = "orders_item";
    
    public function order() {
        return $this->belongsTo(Order::class,"order_id","id");
    }
    public function products() {
        return $this->belongsTo(Product::class,"prodcut_id","id");
    }
}
