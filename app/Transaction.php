<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'product_code', 'product_name', 'weight', 'finalPrice', 'soldPrice', 'profit', 'date'
    ];

}
