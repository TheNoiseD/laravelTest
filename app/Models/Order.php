<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_CREATED = 'CREATED';
    public const STATUS_PAYED = 'PAYED';
    public const DEFAULT_DESCRIPTION = 'Order created No. ';

//    permitir todo en filable
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    static public function updateOrderStatus(Order $order, $paymentStatus)
    {

        if ($order->status_pay != $paymentStatus){
            $order->status_pay = $paymentStatus;
            switch ($paymentStatus){
                case 'APPROVED':
                    $order->status = 'PAYED';
                    $order->save();
                    break;
                case 'REJECTED':
                    $order->status = 'REJECTED';
                    $order->save();
                    break;
                case 'PENDING':
                    $order->status = 'PENDING';
                    $order->save();
                    break;
            }
        }
    }
}
