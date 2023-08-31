<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded;

    public function admin() {
        return $this->belongsTo(User::class,"admin_id","id");
    }
    public function category() {
       return $this->belongsTo(Category::class,"category_id","id");
    }
    public function details() {
        return $this->hasOne(ProductDetails::class, 'product_id', 'id');
    }
}
