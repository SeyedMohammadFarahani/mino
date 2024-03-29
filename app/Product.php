<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name', 'code', 'price', 'user_id', 'creator', 'fileName', 'bom', 'date', 'state'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
