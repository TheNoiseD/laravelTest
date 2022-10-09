<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Traits\CartProdutsManage;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class PlaceToPay
{
    use CartProdutsManage;
    protected mixed $endponitBase;
    protected mixed $login;
    protected mixed $secretKey;
    protected mixed $url;

    public function __construct()
    {
        $this->endponitBase = env('PLACE_TO_PAY_URL');
        $this->login = env('PLACE_TO_PAY_LOGIN');
        $this->secretKey = env('PLACE_TO_PAY_SECRET_KEY');
        $this->url = env('PLACE_TO_PAY_URL');
    }

    /**
     * @throws GuzzleException
     */
    public function getResponse(Request $request,User $user,$apiUri){

        $order = new Order();
        $order->user_id = $user->id;
        $order->cart_id = $request->cart_id;
        $order->status = Order::STATUS_CREATED;
        $order->status_pay = Order::STATUS_PENDING;
        $order->total = 0;
        $order->timestamps = true;
        $order->save();

        $cart = Cart::where('id', $request->cart_id)->first();

        $credentials = $this->getCredentials();
        $url = env('PLACE_TO_PAY_URL');
        $request = new Client(['verify' => false,'base_uri' => $url]);
        $total = $this->getTotalCart($order->cart_id);
        $json = $this->getRequestCreateSession($credentials,$order,$total);

        try {
            $response = $request->post(env('PLACE_TO_PAY_URL').$apiUri,['json'=> $json]);
            $response = json_decode($response->getBody()->getContents());
            $order->total = $total;
            $order->request_id = $response->requestId;
            $order->url_process = $response->processUrl;
            $order->save();

            $cart->status = 'closed';
            $cart->save();

        }
        catch (GuzzleException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $order->delete();
        }
        return response()->json($response);
    }

    public function getOrderStatus(Order $order,$apiUri){
        $credentials = $this->getCredentials();
        $url =  $this->url;
        $request = new Client(['verify' => false,'base_uri' => $url]);
        $json = $this->getRequestCheckSession($credentials);

        try {
            $response = $request->post($url.$apiUri,['json'=> $json]);
            $response = json_decode($response->getBody()->getContents());
        }
        catch (GuzzleException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
        }

        return $response;

    }

    public function getRequestCheckSession($credentials){
        return [
            'auth' => [
                "login" => env('PLACE_TO_PAY_LOGIN'),
                "tranKey" => $credentials->tranKey,
                "nonce" => $credentials->nonce,
                "seed" => $credentials->seed,
            ]
        ];
    }

    public function getRequestCreateSession($credentials ,Order $order,$total){
        return [
            'locale' => 'es_CO',
            "auth" => [
                "login" => env('PLACE_TO_PAY_LOGIN'),
                "tranKey" => $credentials->tranKey,
                "nonce" => $credentials->nonce,
                "seed" => $credentials->seed,
            ],
            "payment" => [
                "reference" => $order->id,
                "description" => Order::DEFAULT_DESCRIPTION.$order->id,
                "amount" => [
                    "currency" => "COP",
                    "total" => $total,
                ],
            ],
            "expiration" => date('c', strtotime('+2 days')),
            "returnUrl"  => route('orders.show', $order->id),
            "ipAddress"  => "127.0.0.1",
            "userAgent"  => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36 OPR/91.0.4516.20"
        ];
    }

    public function getCredentials(): object{
        $login = $this->login;
        $secretKey = $this->secretKey;
        date_default_timezone_set('America/Bogota');
        $seed = date('c');
        $nonce = random_bytes(16);
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $nonceB64 = base64_encode($nonce);
        return (object)[
            'login' => $login,
            'tranKey' => $tranKey,
            'nonce' => $nonceB64,
            'seed' => $seed,
        ];
    }

}
