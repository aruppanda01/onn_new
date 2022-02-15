<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function productColor(){
        return $this->hasMany(ProductColor::class);
    }
    public function productSize(){
        return $this->hasMany(ProductSize::class);
    }
}
