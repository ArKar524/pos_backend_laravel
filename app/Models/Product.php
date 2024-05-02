<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_code',
        'product_name',
        'price',
        'ProductCategoryId'
    ];

    // public function Products () : HasMany {
    //     return $this->HasMany(Product::class);
    // }

    public function ProductCategory() : BelongsTo {
        return $this->belongsTo(ProductCategory::class, 'ProductCategoryId', 'ProductCategoryId');
    }
}
