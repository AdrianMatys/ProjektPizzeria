<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageOrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    // Testuje, czy lista zamówień jest wyświetlana w widoku
    public function testViewingOrdersList()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Tworzymy kilka zamówień o różnych statusach
        Order::factory()->count(5)->create();

        $response = $this->get(route('management.employee.orders.index'));

        $response->assertStatus(200)
                 ->assertViewIs('management.employee.orders.index');
    }

    // Testuje, czy szczegóły zamówienia są wyświetlane
    public function testViewingOrderDetails()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $order = Order::factory()->create();

        $response = $this->get(route('management.employee.orders.show', $order));

        $response->assertStatus(200)
                 ->assertViewIs('management.employee.orders.show')
                 ->assertViewHas('order', $order);
    }

    // Testuje, czy zmiana statusu zamówienia działa poprawnie
    public function testChangingOrderStatus()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $order = Order::factory()->create();
        $newStatus = 'completed';

        $response = $this->patch(route('management.employee.orders.updateStatus', $order), [
            'status' => $newStatus,
        ]);

        $response->assertRedirect()
                 ->assertSessionHas('success', __('employee.orderStatusUpdated'));

        // Sprawdzamy, czy status zamówienia został zaktualizowany
        $order->refresh();
        $this->assertEquals($newStatus, $order->status);
    }

    // Testuje, czy nieautoryzowany użytkownik nie ma dostępu do widoku listy zamówień
    public function testUnauthorizedUserCannotViewOrdersList()
    {
        $response = $this->get(route('management.employee.orders.index'));

        $response->assertStatus(302); // Zostanie przekierowany do logowania
    }

    // Testuje, czy nieautoryzowany użytkownik nie może zaktualizować statusu zamówienia
    public function testUnauthorizedUserCannotUpdateOrderStatus()
    {
        $order = Order::factory()->create();
        $newStatus = 'completed';

        $response = $this->patch(route('management.employee.orders.updateStatus', $order), [
            'status' => $newStatus,
        ]);

        $response->assertStatus(302); // Zostanie przekierowany do logowania
    }
}
