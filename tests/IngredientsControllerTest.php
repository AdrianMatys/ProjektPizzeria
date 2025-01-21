<?php
namespace Tests\Feature;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testuje,czy metoda index poprawnie dziala i wyświetla listę składników.
     */
    public function test_ingredients_list_is_displayed_correctly()
    {
        // Przygotowanie danych testowych do testu
        $ingredients = Ingredient::factory()->count(5)->create();

        // Wysłanie żądania GET
        $response = $this->get(route('management.employee.ingredients.index'));

        // Sprawdzenie statusu odpowiedzi
        $response->assertOk();

        // Sprawdzenie, czy odpowiedni widok jest renderowany
        $response->assertViewIs('management.employee.ingredients.index');

        // Sprawdzenie, czy dane składników są przekazane do widoku
        $response->assertViewHas('ingredients', function ($viewIngredients) use ($ingredients) {
            return $viewIngredients->count() === $ingredients->count();
        });
    }

    /**
     * Testuje, czy formularz składnika jest wyświetlany dla kodu.
     */
    public function test_create_form_is_displayed()
    {
        // Wysłanie żądania GET
        $response = $this->get(route('management.employee.ingredients.create'));

        // Sprawdzenie odpowiedzi i widoku
        $response->assertOk();
        $response->assertViewIs('management.employee.ingredients.create');
    }

    /**
     * Testuje, czy formularz składnika działa poprawnie.
     */
    public function test_edit_form_is_displayed_for_existing_ingredient()
    {
        // Przygotowanie danych
        $ingredient = Ingredient::factory()->create();

        // Wysłanie żądania GET
        $response = $this->get(route('management.employee.ingredients.edit', $ingredient->id));

        // Sprawdzenie odpowiedzi i widoku
        $response->assertOk();
        $response->assertViewIs('management.employee.ingredients.edit');
        $response->assertViewHas('ingredient', $ingredient);
    }

    /**
     * Testuje, czy zrobiony składnik może być poprawnie usunięty.
     */
    public function test_ingredient_can_be_deleted()
    {
        // Przygotowanie składnika do usunięcia
        $ingredient = Ingredient::factory()->create();

        // Wysłanie żądania DELETE
        $response = $this->delete(route('management.employee.ingredients.destroy', $ingredient->id));

        // Sprawdzenie przekierowania i wiadomości zwrotnej
        $response->assertRedirect(route('management.employee.ingredients.index'));
        $this->assertDatabaseMissing('ingredients', ['id' => $ingredient->id]);
    }

    /**
     * Testuje, czy składnik może być zaktualizowany poprawne.
     */
    public function test_ingredient_can_be_updated()
    {
        // Przygotowanie składnika i danych aktualizacyjnych
        $ingredient = Ingredient::factory()->create(['name' => 'Old Name']);
        $updateData = ['name' => 'Updated Name'];

        // Wysłanie żądania PUT
        $response = $this->put(route('management.employee.ingredients.update', $ingredient->id), $updateData);

        // Sprawdzenie przekierowania
        $response->assertRedirect(route('management.employee.ingredients.index'));

        // Sprawdzenie, czy dane w bazie zostały zaktualizowane poprawnie.
        $this->assertDatabaseHas('ingredients', $updateData);
    }

    /**
     * Testuje, czy nowy składnik może zostac dodany do bazy.
     */
    public function test_new_ingredient_can_be_stored()
    {
        // Dane do stworzenia nowego składnika
        $newIngredientData = ['name' => 'New Ingredient'];

        // Wysłanie żądania POST
        $response = $this->post(route('management.employee.ingredients.store'), $newIngredientData);

        // Sprawdzenie przekierowania
        $response->assertRedirect(route('management.employee.ingredients.index'));

        // Sprawdzenie, czy składnik został dodany do bazy danych
        $this->assertDatabaseHas('ingredients', $newIngredientData);
    }
}
