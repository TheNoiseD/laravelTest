<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppLoginTest extends TestCase
{
    use RefreshDatabase,DatabaseMigrations;

    public $user;
    public $password;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = User::factory()->make([
            'name' => 'John',
            'last_name' => 'Doe',
            'phone' => '123456789',
            'email' => 'test@gmail.com',
            'password' => bcrypt('i-love-laravel'),
        ]);
        $this->password = 'i-love-laravel';
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $response = $this->actingAs($this->user)->get('/login');
        $response->assertRedirect('/home');
    }

    // el usuario puede iniciar sesion con credenciales correctas
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // el usuario puede iniciar sesion con credenciales correctas
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertRedirect('/products');
    }


}
