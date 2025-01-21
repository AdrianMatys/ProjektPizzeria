<?php

namespace Tests\Feature;

use App\Actions\Carts\CreateCustomPizzaAction;
use App\Actions\Carts\CreateEditedPizzaAction;
use App\Models\Ingredient;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PizzaControllerTest extends TestCase
{
    use RefreshDatabase;

    // Testuje tworzenie nowej pizzy przez użytkownika
    public function testCreatingCustomPizza()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pizza = Pizza::factory()->create();
        $ingredients = Ingredient::factory()->count(3)->create(); // Załóżmy, że pizza ma 3 składniki

        $data = [
            'ingredient' => $ingredients->pluck('id')->toArray(),
        ];

        $this->mock(CreateCustomPizzaAction::class, function ($mock) use ($data) {
            $mock->shouldReceive('execute')->once()->with($data['ingredient']);
        });

        $response = $this->post(route('pizza.store'), $data);

        // Oczekujemy, że po zapisaniu pizzy użytkownik zostanie przekierowany
        $response->assertRedirect(route('client.menu.index'))
                 ->assertSessionHas('success', __('client.addedCustomPizza'));
    }

    // Testuje edytowanie pizzy przez użytkownika
    public function testEditingPizza()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pizza = Pizza::factory()->create();
        $ingredients = Ingredient::factory()->count(3)->create(); // Załóżmy, że pizza ma 3 składniki

        $data = [
            'ingredient' => $ingredients->pluck('id')->toArray(),
        ];

        $this->mock(CreateEditedPizzaAction::class, function ($mock) use ($data, $pizza) {
            $mock->shouldReceive('execute')->once()->with($data['ingredient'], $pizza);
        });

        $response = $this->put(route('pizza.update', $pizza->id), $data);

        $response->assertRedirect(route('client.menu.index'))
                 ->assertSessionHas('success', __('client.addedEditedPizza'));
    }

    // Testuje, czy widok tworzenia pizzy jest poprawny
    public function testViewCreatePizza()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pizza = Pizza::factory()->create();
        $ingredients = Ingredient::factory()->count(5)->create(); // Załóżmy, że mamy 5 składników

        $response = $this->get(route('pizza.create', $pizza->id));

        $response->assertStatus(200)
                 ->assertViewIs('client.pizza.create')
                 ->assertViewHas('pizza', $pizza)
                 ->assertViewHas('ingredients', $ingredients);
    }

    // Testuje, czy widok edytowania pizzy jest poprawny
    public function testViewEditPizza()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pizza = Pizza::factory()->create();
        $ingredients = Ingredient::factory()->count(5)->create(); // Załóżmy, że mamy 5 składników

        $response = $this->get(route('pizza.edit', $pizza->id));

        $response->assertStatus(200)
                 ->assertViewIs('client.pizza.edit')
                 ->assertViewHas('pizza', $pizza)
                 ->assertViewHas('ingredients', $ingredients);
    }

    // Testuje próbę stworzenia pizzy bez zalogowanego użytkownika
    public function testCreatingPizzaWithoutLogin()
    {
        $data = ['ingredient' => [1, 2, 3]]; // Przykładowe składniki

        $response = $this->post(route('pizza.store'), $data);

        $response->assertStatus(401)
                 ->assertJson(['error' => __('client.userNotFound')]);
    }

    // Testuje próbę edytowania pizzy bez zalogowanego użytkownika
    public function testEditingPizzaWithoutLogin()
    {
        $pizza = Pizza::factory()->create();
        $data = ['ingredient' => [1, 2, 3]]; // Przykładowe składniki

        $response = $this->put(route('pizza.update', $pizza->id), $data);

        $response->assertStatus(401)
                 ->assertJson(['error' => __('client.userNotFound')]);
    }
}
