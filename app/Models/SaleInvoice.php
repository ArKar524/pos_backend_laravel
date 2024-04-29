<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleInvoice extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function staff() : BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    // public function shop() : BelongsTo
    // {
    //     return $this->belongsTo(Shop::class, 'shop_id');
    // }
}
