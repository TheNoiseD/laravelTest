<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\User;
use App\Traits\CartProdutsManage;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\PlaceToPay ;
use GuzzleHttp\Client;


class OrderController extends Controller
{
    use CartProdutsManage;
    private mixed $p2p;
    public mixed $cart_qty;
    public mixed $user;


    public function __construct(PlaceToPay $p2p)
    {
        $this->p2p = $p2p;
    }

    public function index()
    {
        $user = auth()->user();
        $cart = $this->get_cart_open($user->id);
        $cart_qty = Helper::total_products_in_cart($cart->id);
        $orders = Order::where('user_id', $user->id)->get();
        return view('orders.index', compact('cart_qty', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    public function store(Request $request){
       $user = auth()->user();
        return $this->p2p->getResponse($request, $user,'api/session');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $user = auth()->user();
        $cart = $this->get_cart_open($user->id);
        $cart_qty = Helper::total_products_in_cart($cart->id);
        $cart = Cart::find($order->cart_id);
        $apiUri = 'api/session/'.$order->request_id;
        $requestInfo = $this->p2p->getOrderStatus($order, $apiUri);
        $paymentStatus = $requestInfo->status->status;
        Order::updateOrderStatus($order, $paymentStatus);
        $products_info = $this->get_products_info($cart->id);
        $status = Helper::get_status($order->status);
        debug($order->status);

        return view('orders.show',
            compact('order', 'cart_qty', 'products_info','status'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
