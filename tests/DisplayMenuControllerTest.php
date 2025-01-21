<?php

namespace Tests\Feature;

use App\Models\Pizza;
use App\Models\Ingredient;
use App\Models\IngredientTranslation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class DisplayMenuControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testuje, czy menu wyświetla listę pizz.
     */
    public function testMenuDisplaysListOfPizzas()
    {
        $locale = 'en';
        App::setLocale($locale);

        // Tworzymy pizzę z powiązanymi składnikami i tłumaczeniami
        $pizza = Pizza::factory()->has(
            Ingredient::factory()->count(3)->has(
                IngredientTranslation::factory()->state(['language_code' => $locale])
            )
        )->create();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200)
                 ->assertViewIs('client.menu.index')
                 ->assertViewHas('pizzas', function ($pizzas) use ($pizza) {
                     return $pizzas->contains($pizza);
                 });
    }

    /**
     * Testuje, czy składniki są odpowiednio tłumaczone.
     */
    public function testIngredientsAreTranslated()
    {
        $locale = 'en';
        App::setLocale($locale);

        $ingredient = Ingredient::factory()->has(
            IngredientTranslation::factory()->state(['language_code' => $locale, 'name' => 'Cheese'])
        )->create();

        $pizza = Pizza::factory()->hasAttached($ingredient)->create();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $pizzas = $response->viewData('pizzas');
        
        $this->assertNotEmpty($pizzas);
        $this->assertEquals('Cheese', $pizzas->first()->ingredients->first()->translations->first()->name);
    }

    /**
     * Testuje oznaczanie niedostępnych pizz (brak składników).
     */
    public function testUnavailablePizzasAreMarkedAsUnavailable()
    {
        $locale = 'en';
        App::setLocale($locale);

        $ingredient = Ingredient::factory()->state(['quantity' => 1])->has(
            IngredientTranslation::factory()->state(['language_code' => $locale])
        )->create();

        $pizza = Pizza::factory()->hasAttached($ingredient, ['quantityOnPizza' => 2])->create();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $pizzas = $response->viewData('pizzas');

        $this->assertNotEmpty($pizzas);
        $this->assertTrue($pizzas->first()->unavailable);
    }

    /**
     * Testuje, czy pizze z odpowiednią ilością składników są dostępne.
     */
    public function testAvailablePizzasAreNotMarkedAsUnavailable()
    {
        $locale = 'en';
        App::setLocale($locale);

        $ingredient = Ingredient::factory()->state(['quantity' => 5])->has(
            IngredientTranslation::factory()->state(['language_code' => $locale])
        )->create();

        $pizza = Pizza::factory()->hasAttached($ingredient, ['quantityOnPizza' => 3])->create();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $pizzas = $response->viewData('pizzas');

        $this->assertNotEmpty($pizzas);
        $this->assertFalse(isset($pizzas->first()->unavailable));
    }
}
