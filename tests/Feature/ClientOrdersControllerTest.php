<?php

namespace Tests\Feature;

use App\Http\Requests\CancelOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ClientOrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test wyświetlania listy zamówień użytkownika
    public function testIndexDisplaysGroupedOrders()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Order::factory()->for($user)->create(['status' => 'pending']);
        Order::factory()->for($user)->create(['status' => 'in_progress']);
        Order::factory()->create(['status' => 'completed']); // Inne zamówienie, nie tego użytkownika

        $response = $this->get(route('client.orders.index'));

        $response->assertStatus(200)
                 ->assertViewIs('client.orders.index')
                 ->assertViewHas('groupedOrders', function ($groupedOrders) use ($user) {
                     return $groupedOrders->has('pending') && $groupedOrders->has('in_progress')
                         && !$groupedOrders->has('completed');
                 });
    }

    // Test wyświetlania szczegółów zamówienia
    public function testShowDisplaysOrderDetails()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->get(route('client.orders.show', $order->id));

        $response->assertStatus(200)
                 ->assertViewIs('client.orders.show')
                 ->assertViewHas('order', $order);
    }

    // Test anulowania zamówienia o statusie 'pending'
    public function testCancelOrderUpdatesStatusToCanceled()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create(['status' => 'pending']);

        $this->actingAs($user);

        $data = ['status' => 'canceled'];

        $response = $this->post(route('client.orders.cancel', $order->id), $data);

        $response->assertRedirect(route('client.orders.index'))
                 ->assertSessionHas('success', __('client.orderCanceled'));

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'canceled']);
    }

    // Test nieudanej próby anulowania zamówienia o statusie innym niż 'pending'
    public function testCancelOrderFailsForNonPendingStatus()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create(['status' => 'in_progress']);

        $this->actingAs($user);

        $data = ['status' => 'canceled'];

        $response = $this->post(route('client.orders.cancel', $order->id), $data);

        $response->assertRedirect()
                 ->assertSessionHas('error', __('client.cancelOnlyPending'));

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'in_progress']);
    }

    // Test dostępu do zamówienia innego użytkownika
    public function testShowFailsForAnotherUsersOrder()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $order = Order::factory()->for($otherUser)->create();

        $this->actingAs($user);

        $response = $this->get(route('client.orders.show', $order->id));

        $response->assertStatus(403); // Forbidden
    }
}
