<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;

trait CartProdutsManage
{
    public function proccess_cart_whit_product(CartProduct $cartProduct,Cart $cart, $product_id)
    {
        if ($cartProduct) {
            $cartProduct->increment('quantity');
            $cartProduct->save();
        } else {
            $this->attach_product_to_cart($cart, $product_id);
        }
    }

    public function attach_product_to_cart(Cart $cart, $product_id)
    {
        $cart->products()->attach($product_id, [
            'quantity' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function new_cart($user_id)
    {
        $cart = new Cart();
        $cart->user_id = $user_id;
        $cart->status = 'open';
        $cart->timestamps = true;
        $cart->save();
        return $cart;
    }

    public function get_products_info($cart_id)
    {
        $cart_products = CartProduct::where('cart_id', $cart_id)->get();
        $products_info =(array) [];
        foreach ($cart_products as $cart_product) {
            $product = Product::find($cart_product->product_id);
//            info object
            $product_info = (object)[
                'id' => $product->id,
                'cart_product_id' => $cart_product->id,
                'description' => $product->description,
                'brand'=> $product->brand,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'quantity' => $cart_product->quantity,
                'total' => (double) $product->price * $cart_product->quantity,
                'image' => $product->image
            ];

            $products_info[] = $product_info;
        }
        return $products_info;
    }

    public function get_cart_open($user_id)
    {
        $cart = Cart::where('user_id', $user_id)->where('status', 'open')->first();
        if ($cart) {
            return $cart;
        } else {
            return $this->new_cart($user_id);
        }
    }
    public function getTotalCart($cart_id)
    {
        $products_info = $this->get_products_info($cart_id);
        $total = 0;
        foreach ($products_info as $product_info) {
            $total += $product_info->total;
        }
        return $total;
    }

}
