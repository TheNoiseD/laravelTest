<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\AppLoginTest;

class AppProductsTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    public $logintest;
    public function setUp() : void
    {
        parent::setUp();
        $this->logintest = new AppLoginTest();
        $this->logintest->setUp();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
//    el usuario puede acceder a los productos
    public function test_the_user_can_see_the_products()
    {
       $this->logintest->test_user_can_login_with_correct_credentials();
    }

//    el usuario puede agregar un producto al carrito
    public function test_the_user_can_add_a_product_to_the_cart()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
        ]);
        $this->actingAs($user);
        $response = $this->post(route('cart.store'),[
            'product_id' => 1,
        ]);
        $response->assertStatus(200);
    }

//    el usuario puede eliminar un producto del carrito
    public function test_the_user_can_delete_a_product_from_the_cart()
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

        $response = $this->delete(route('cart.destroy',1));
        $response->assertStatus(200);
    }
}
