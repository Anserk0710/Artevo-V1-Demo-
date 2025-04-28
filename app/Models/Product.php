<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'size',
        'material',
        'product_code',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product){
            $product->product_code = strtoupper(uniqid('PRD'));
        });
    }
}
