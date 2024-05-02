<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(ProductCategory::class, 'ProductCategoryId','ProductCategoryId');
    }
}
