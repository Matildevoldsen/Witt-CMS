<?php

namespace Tests\Feature;

use App\Cart\Contracts\CartInterface;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_creates_a_cart_for_a_user()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->app->make(CartInterface::class)->create($user);

        // Assert
        $cart = Cart::where('user_id', $user->id)->first();
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals(Session::get(config('cart.session.key')), $cart->uuid);
    }

    public function test_creates_a_cart_without_a_user()
    {
        // Act
        $this->app->make(CartInterface::class)->create();

        // Assert
        $cart = Cart::first();
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals(Session::get(config('cart.session.key')), $cart->uuid);
    }
}
