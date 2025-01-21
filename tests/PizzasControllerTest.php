<?php

namespace Tests\Feature;

use App\Actions\Logs\LogDeletedPizzaAction;
use App\Actions\Logs\LogNewPizzaAction;
use App\Actions\Logs\LogUpdatePizzaAction;
use App\Actions\Pizzas\CreatePizzaAsEmployeeAction;
use App\Actions\Pizzas\UpdatePizzaAsEmployeeAction;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzasControllerTest extends TestCase
{
    use RefreshDatabase;

    // Testuje pobieranie listy pizz
    public function test_index_shows_all_pizzas()
    {
        $user = $this->actingAsEmployee();
        $pizza = Pizza::factory()->create();

        $response = $this->get(route('management.employee.pizzas.index'));

        $response->assertStatus(200)
                 ->assertViewIs('management.employee.pizzas.index')
                 ->assertViewHas('pizzas', Pizza::all());
    }

    // Testuje wyświetlanie strony do tworzenia pizzy
    public function test_create_show_create_pizza_form()
    {
        $user = $this->actingAsEmployee();

        $response = $this->get(route('management.employee.pizzas.create'));

        $response->assertStatus(200)
                 ->assertViewIs('management.employee.pizzas.create');
    }

    // Testuje zapisywanie nowej pizzy
    public function test_store_creates_new_pizza()
    {
        $user = $this->actingAsEmployee();
        $data = [
            'name' => 'Test Pizza',
            'ingredients' => [1, 2, 3], // przykładowe ID składników
            'price' => 20,
        ];

        $this->mock(CreatePizzaAsEmployeeAction::class, function ($mock) use ($data) {
            $mock->shouldReceive('execute')->once()->with($data);
        });

        $this->mock(LogNewPizzaAction::class, function ($mock) use ($data) {
            $mock->shouldReceive('execute')->once()->with($user->id, ['pizza' => $data]);
        });

        $response = $this->post(route('management.employee.pizzas.store'), $data);

        $response->assertRedirect(route('management.employee.pizzas.index'))
                 ->assertSessionHas('success', __('employee.pizzaAdded'));
    }

    // Testuje edycję istniejącej pizzy
    public function test_edit_shows_edit_pizza_form()
    {
        $user = $this->actingAsEmployee();
        $pizza = Pizza::factory()->create();

        $response = $this->get(route('management.employee.pizzas.edit', $pizza->id));

        $response->assertStatus(200)
                 ->assertViewIs('management.employee.pizzas.edit')
                 ->assertViewHas('pizza', $pizza);
    }

    // Testuje aktualizowanie istniejącej pizzy
    public function test_update_updates_pizza()
    {
        $user = $this->actingAsEmployee();
        $pizza = Pizza::factory()->create();
        $data = [
            'name' => 'Updated Pizza',
            'ingredients' => [1, 2],
            'price' => 25,
        ];

        $this->mock(UpdatePizzaAsEmployeeAction::class, function ($mock) use ($data, $pizza) {
            $mock->shouldReceive('execute')->once()->with($data, $pizza);
        });

        $this->mock(LogUpdatePizzaAction::class, function ($mock) use ($data) {
            $mock->shouldReceive('execute')->once()->with($user->id, ['pizza' => $data]);
        });

        $response = $this->put(route('management.employee.pizzas.update', $pizza->id), $data);

        $response->assertRedirect(route('management.employee.pizzas.index'))
                 ->assertSessionHas('success', __('employee.pizzaUpdated'));
    }

    // Testuje usuwanie pizzy
    public function test_destroy_deletes_pizza()
    {
        $user = $this->actingAsEmployee();
        $pizza = Pizza::factory()->create();

        $this->mock(LogDeletedPizzaAction::class, function ($mock) use ($pizza) {
            $mock->shouldReceive('execute')->once()->with($user->id, ['pizza' => $pizza]);
        });

        $response = $this->delete(route('management.employee.pizzas.destroy', $pizza->id));

        $response->assertRedirect(route('management.employee.pizzas.index'))
                 ->assertSessionHas('success', __('employee.pizzaRemoved'));
    }

    // Testuje próbę usunięcia pizzy, która nie istnieje
    public function test_destroy_fails_when_pizza_not_found()
    {
        $user = $this->actingAsEmployee();

        $response = $this->delete(route('management.employee.pizzas.destroy', 999));

        $response->assertRedirect(route('management.employee.pizzas.index'))
                 ->assertSessionHas('error', __('employee.failedRemovePizza'));
    }

    // Pomocnicza metoda do symulowania zalogowanego pracownika
    private function actingAsEmployee()
    {
        // Załóżmy, że mamy fabrykę dla użytkowników- pracowników
        return \App\Models\User::factory()->employee()->create();
    }
}
