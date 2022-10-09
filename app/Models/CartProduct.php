<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;
    protected $table = 'cart_product';

    static public function get_existing_product($cart_id, $product_id)
    {
        return self::where('cart_id', $cart_id)->where('product_id', $product_id)->first();
    }

    static public function total_products_in_cart($cart_id)
    {
        return self::where('cart_id', $cart_id)->sum('quantity');
    }

}
