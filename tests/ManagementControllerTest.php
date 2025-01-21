<?php
namespace Tests\Feature;
use App\Models\Pizzeria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ManagementControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test, żeby wyświetlić stronę z danymi pizzeri.
     *
     * @return void
     */
    public function test_index_displays_pizzeria()
    {
        // Utworzenie fikcyjnej pizzerii
        $pizzeria = Pizzeria::factory()->create();

        // Wykonanie zapytania GET do strony
        $response = $this->get(route('management.admin.pizzeria.index'));

        // Sprawdzenie, czy odpowiedź ma status 200
        $response->assertStatus(200);

        // Sprawdzenie, czy odpowiedni widok został załadowany
        $response->assertViewIs('management.admin.pizzeria.index');

        // Sprawdzenie, czy pizzeria jest przekazywana do widoku
        $response->assertViewHas('pizzeria', $pizzeria);
    }

    /**
     * Test, żeby wyświetlić formularz edycji pizzerii.
     *
     * @return void
     */
    public function test_edit_displays_edit_form()
    {
        // Utworzenie fikcyjnej pizzerii
        $pizzeria = Pizzeria::factory()->create();

        // Wykonanie zapytania GET do formularza edycji
        $response = $this->get(route('management.admin.pizzeria.edit', $pizzeria->id));

        // Sprawdzenie, czy odpowiedź ma status 200
        $response->assertStatus(200);

        // Sprawdzenie, czy odpowiedni widok został załadowany
        $response->assertViewIs('management.admin.pizzeria.edit');

        // Sprawdzenie, czy pizzeria jest przekazywana do widoku
        $response->assertViewHas('pizzeria', $pizzeria);
    }

    /**
     * Test, żeby aktualizować dany pizzerii.
     *
     * @return void
     */
    public function test_update_updates_pizzeria()
    {
        // Utworzenie fikcyjnej pizzerii
        $pizzeria = Pizzeria::factory()->create();

        // Przygotowanie danych do aktualizacji
        $updatedData = [
            'name' => 'Nowa Pizzeria',
            'address' => 'Nowy adres 123',
            // Dodaj inne pola, które chcesz zaktualizować
        ];

        // Wykonanie zapytania PATCH do zaktualizowania pizzerii
        $response = $this->patch(route('management.admin.pizzeria.update', $pizzeria->id), $updatedData);

        // Sprawdzenie, czy dane zostały zaktualizowane
        $pizzeria->refresh();
        $this->assertEquals('Nowa Pizzeria', $pizzeria->name);
        $this->assertEquals('Nowy adres 123', $pizzeria->address);

        // Sprawdzenie, czy użytkownik został przekierowany na stronę z listą pizzerii
        $response->assertRedirect(route('management.admin.pizzeria.index'));

        // Sprawdzenie, czy sesja zawiera komunikat o sukcesie
        $response->assertSessionHas('success', 'Zaktualizowano dane pizzerii');
    }
}
