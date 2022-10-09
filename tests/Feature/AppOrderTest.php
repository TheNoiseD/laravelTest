<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppOrderTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // el usuario puede ver las ordenes
    public function test_the_user_can_see_the_orders()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
        ]);
        $this->actingAs($user);

        $response = $this->get('/orders');
        $response->assertStatus(200);
    }

//    ver una orden en especifico
    public function test_the_user_can_see_a_specific_order()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
        ]);
        $this->actingAs($user);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
        ]);
        $cartProducts = CartProduct::factory()->create([
            'id' => 1,
            'cart_id' => $cart->id,
            'product_id' => 1,
        ]);
        $order = Order::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'cart_id' => $cart->id,
            'status' => 'CREATED',
            'status_pay' => 'PENDING',
        ]);

        $response = $this->get(route('orders.show',1));
        $response->assertStatus(200);
    }

}
