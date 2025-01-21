<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test wyświetlanie listy pracowników.
     */
    public function test_index_displays_employees_list()
    {
        // Przygotowanie danych testowych
        $users = User::factory()->count(3)->create();

        // Wykonanie żądania GET
        $response = $this->get(route('management.admin.employees.index'));

        // Sprawdzenie statusu odpowiedzi
        $response->assertStatus(200);

        // Sprawdzenie, czy dane pracowników są widoczne w widoku
        foreach ($users as $user) {
            $response->assertSee($user->name);
            $response->assertSee($user->email);
        }
    }

    /**
     * Test usuwania użytkownika.
     */
    public function test_destroy_deletes_user()
    {
        // Przygotowanie użytkownika
        $user = User::factory()->create();

        // Sprawdzenie, czy użytkownik istnieje przed usunięciem
        $this->assertDatabaseHas('users', ['id' => $user->id]);

        // Wykonanie żądania DELETE
        $response = $this->delete(route('management.admin.employees.destroy', $user->id));

        // Sprawdzenie, czy użytkownik został usunięty z bazy danych
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        // Sprawdzenie przekierowania i komunikatu sukcesu
        $response->assertRedirect(route('management.admin.employees.index'));
        $response->assertSessionHas('success', 'Użytkownik został usunięty');
    }

    /**
     * Test próby usunięcia nieistniejącego użytkownika.
     */
    public function test_destroy_nonexistent_user_redirects_with_error()
    {
        // Wykonanie żądania DELETE na nieistniejącego użytkownika
        $response = $this->delete(route('management.admin.employees.destroy', 999));

        // Sprawdzenie przekierowania i komunikatu o błędzie
        $response->assertRedirect(route('management.admin.employees.index'));
        $response->assertSessionHas('error', 'Nie udało się usunąć użytkownika');
    }
}
