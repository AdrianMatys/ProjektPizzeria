<?php

namespace Tests\Feature;

use App\Actions\Orders\AddItemToCartAction;
use App\Actions\Logs\LogNewOrderAction;
use App\Actions\Orders\CreateOrderItemsFromCartItemsAction;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    // Testuje dodawanie produktu do koszyka
    public function testAddingItemToCart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = ['item_id' => 1, 'quantity' => 2];

        $this->mock(AddItemToCartAction::class, function ($mock) use ($data) {
            $mock->shouldReceive('execute')->once()->with($data);
        });

        $response = $this->postJson(route('cart.add'), $data);

        // Sprawdzamy, czy odpowiedź jest zgodna z oczekiwaniami
        $response->assertStatus(200)
                 ->assertJson(['success' => true, 'message' => __('client.addedToCart')]);
    }

    // Testuje proces tworzenia zamówienia
    public function testCreatingOrderFromCart()
    {
        $user = User::factory()->has(Cart::factory()->hasItems(3))->create();
        $this->actingAs($user);

        $this->mock(CreateOrderItemsFromCartItemsAction::class, function ($mock) use ($user) {
            $mock->shouldReceive('execute')->once()->with($user->cart->items, $user->cart->id);
        });

        $this->mock(LogNewOrderAction::class, function ($mock) use ($user) {
            $mock->shouldReceive('execute')->once()->with($user->id, ['cart_id' => $user->cart->id]);
        });

        $response = $this->get(route('cart.order'));

        $response->assertStatus(200)
                 ->assertViewIs('client.orders.completed')
                 ->assertViewHas('cartItems', $user->cart->items);
    }

    // Testuje pobieranie danych koszyka w formacie JSON
    public function testFetchingCartAsJson()
    {
        $user = User::factory()->has(Cart::factory()->hasItems(3))->create();
        $this->actingAs($user);

        $response = $this->getJson(route('cart.getJson'));

        $response->assertStatus(200)
                 ->assertJsonStructure(['cart' => ['items']])
                 ->assertJson(['cart' => $user->cart->toArray()]);
    }

    // Testuje wyświetlenie pustego koszyka w JSON
    public function testEmptyCartReturnsMessage()
    {
        $user = User::factory()->has(Cart::factory())->create();
        $this->actingAs($user);

        $response = $this->getJson(route('cart.getJson'));

        $response->assertStatus(200)
                 ->assertJson(['message' => __('client.emptyCart')]);
    }

    // Testuje widok koszyka
    public function testViewingCartPage()
    {
        $user = User::factory()->has(Cart::factory()->hasItems(3))->create();
        $this->actingAs($user);

        $response = $this->get(route('client.cart.index'));

        $response->assertStatus(200)
                 ->assertViewIs('client.cart.index')
                 ->assertViewHas('cart', $user->cart);
    }

    // Testuje widok pustego koszyka
    public function testViewingEmptyCart()
    {
        $user = User::factory()->has(Cart::factory())->create();
        $this->actingAs($user);

        $response = $this->get(route('client.cart.index'));

        $response->assertStatus(200)
                 ->assertViewIs('client.cart.index')
                 ->assertViewHas('cart', []);
    }

    // Testuje usuwanie elementu z koszyka
    public function testRemovingItemFromCart()
    {
        $user = User::factory()->create();
        $cartItem = CartItem::factory()->for($user)->create();
        $this->actingAs($user);

        $this->assertDatabaseHas('cart_items', ['id' => $cartItem->id]);

        $response = $this->delete(route('client.cart.destroy', $cartItem->id));

        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
        $response->assertRedirect(route('client.cart.index'))
                 ->assertSessionHas('success', __('client.deletedFromCart'));
    }

    // Testuje próbę usunięcia nieistniejącego elementu
    public function testRemovingNonexistentItem()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('client.cart.destroy', 999));

        $response->assertRedirect(route('client.cart.index'))
                 ->assertSessionHas('error', __('client.couldntRemoveItemFromCart'));
    }

    // Testuje aktualizację ilości produktu
    public function testUpdatingItemQuantity()
    {
        $user = User::factory()->create();
        $cartItem = CartItem::factory()->for($user)->create(['quantity' => 1]);
        $this->actingAs($user);

        $data = ['quantity' => 3];

        $response = $this->patch(route('client.cart.updateQuantity', $cartItem->id), $data);

        $this->assertDatabaseHas('cart_items', ['id' => $cartItem->id, 'quantity' => 3]);
        $response->assertRedirect(route('client.cart.index'))
                 ->assertSessionHas('success', __('client.productQuantityUpdated'));
    }

    // Testuje aktualizację ilości z błędnymi danymi
    public function testInvalidQuantityFails()
    {
        $user = User::factory()->create();
        $cartItem = CartItem::factory()->for($user)->create(['quantity' => 1]);
        $this->actingAs($user);

        $data = ['quantity' => -1];

        $response = $this->patch(route('client.cart.updateQuantity', $cartItem->id), $data);

        $response->assertSessionHasErrors('quantity');
    }
}
