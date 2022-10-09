<?php

namespace App\Helpers;

use App\Models\CartProduct;

class Helper
{
    static public function get_status($order_status){
        switch ($order_status) {
            case 'PAYED':
                $status = (object)[
                    'status' => 'Completada',
                    'color' => 'badge-light-success'
                ];
                return $status;
                break;
            case 'REJECTED':
                $status = (object)[
                    'status' => 'Rechazada',
                    'color' => 'badge-light-danger'
                ];
                return $status;
                break;
            case 'CREATED':
                $status = (object)[
                    'status' => 'Pendiente',
                    'color' => 'badge-light-warning'
                ];
                return $status;
                break;
        }
    }

    static public function total_products_in_cart($cart_id)
    {
        return CartProduct::where('cart_id', $cart_id)->sum('quantity');
    }
}
