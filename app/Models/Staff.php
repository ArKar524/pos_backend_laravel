<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['id','staffCode','staffName','dateOfBirth','mobileNo','address','gender','position', 'shop_id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
