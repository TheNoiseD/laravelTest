<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    static public function get_cart_open($user_id)
    {
        return self::where('user_id', $user_id)->where('status', 'open')->first();
    }
}
