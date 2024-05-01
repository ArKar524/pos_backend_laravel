<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['customerCode','customerName','mobileNo','dateOfBirth','gender','stateCode','townshipCode'];
}

// customerCode customerName mobileNo dateOfBirth gender stateCode townshipCode