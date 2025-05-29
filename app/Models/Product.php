<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'likes',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product){
            $product->product_code = strtoupper(uniqid('PRD'));
        });
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ProductLike::class);
    }
}
