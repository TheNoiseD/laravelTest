<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Traits\CartProdutsManage;
use Illuminate\Http\Request;
use function Sodium\increment;

class CartController extends Controller
{
    use CartProdutsManage;

    public function index()
    {
        $user = auth()->user();
        $cart = $this->get_cart_open($user->id);
        $cart_qty = Helper::total_products_in_cart($cart->id);
        $products_info = $this->get_products_info($cart->id);
        $total = $this->getTotalCart($cart->id);
        return view('cart.index',
            compact('products_info', 'total', 'cart_qty', 'cart'));
    }

    public function store(Request $request)
    {
        if ($request->input('id')) {
            $user = auth()->user();
            $product_id = $request->input('id');
            $cart = $this->get_cart_open($user->id);
            $cart_product = CartProduct::get_existing_product($cart->id, $product_id);
            if (!$cart_product) {
                $this->attach_product_to_cart($cart, $product_id);
                $cart_product = CartProduct::get_existing_product($cart->id, $product_id);
            }else{
                $this->proccess_cart_whit_product($cart_product, $cart, $product_id);
            }
            $product_quantity = Helper::total_products_in_cart($cart->id);
            $message = 'Producto agregado al carrito';
            return response()->json(['message' => $message, 'cart_qty' => $product_quantity], 200);
        }
    }

    public function update(Request $request, $cartProduct)
    {
        $cartProduct = CartProduct::find($cartProduct);
        $cartProduct->quantity = $request->input('qty');
        $cartProduct->save();
        return response()->json(['message' => 'Cantidad actualizada'], 200);
    }

    public function destroy($cartProduct)
    {
        $cartProduct = CartProduct::find($cartProduct);
        $cartProduct->delete();
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}
