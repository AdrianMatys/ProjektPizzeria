<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test formularza edycji profilu użytkownika.
     */
    public function test_edit_form_displays_correctly()
    {
        // Tworzenie użytkownika
        $user = User::factory()->create();

        // Zalogowanie jako użytkownik
        $this->actingAs($user);

        // Wykonanie zapytania do formularza edycji
        $response = $this->get(route('profile.edit'));

        // Sprawdzenie statusu i widoku
        $response->assertStatus(200);
        $response->assertViewIs('Profile/Edit');

        // Weryfikacja przekazywanych danych
        $response->assertViewHas('mustVerifyEmail', $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail);
        $response->assertViewHas('status', session('status'));
    }

    /**
     * Test aktualizacji profilu użytkownika.
     */
    public function test_user_profile_can_be_updated()
    {
        // Tworzenie użytkownika
        $user = User::factory()->create(['email' => 'original@example.com']);

        // Zalogowanie jako użytkownik
        $this->actingAs($user);

        // Dane do aktualizacji
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        // Wysłanie żądania PATCH do aktualizacji profilu
        $response = $this->patch(route('profile.update'), $updatedData);

        // Odświeżenie danych użytkownika
        $user->refresh();

        // Sprawdzenie, czy dane zostały zaktualizowane
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertNull($user->email_verified_at); // Email powinien stracić weryfikację

        // Sprawdzenie przekierowania
        $response->assertRedirect(route('profile.edit'));
    }

    /**
     * Test usuwania konta użytkownika.
     */
    public function test_user_account_can_be_deleted()
    {
        // Tworzenie użytkownika
        $user = User::factory()->create();

        // Zalogowanie jako użytkownik
        $this->actingAs($user);

        // Wysłanie żądania DELETE do usunięcia konta
        $response = $this->delete(route('profile.destroy'), [
            'password' => 'password', // Domyślnie ustawione hasło
        ]);

        // Sprawdzenie, czy użytkownik został wylogowany
        $this->assertGuest();

        // Sprawdzenie, czy użytkownik został usunięty z bazy danych
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        // Sprawdzenie przekierowania na stronę główną
        $response->assertRedirect('/');
    }

    /**
     * Test walidacji błędnego hasła podczas usuwania konta.
     */
    public function test_account_deletion_fails_with_invalid_password()
    {
        // Tworzenie użytkownika
        $user = User::factory()->create();

        // Zalogowanie jako użytkownik
        $this->actingAs($user);

        // Wysłanie żądania DELETE z błędnym hasłem
        $response = $this->delete(route('profile.destroy'), [
            'password' => 'wrongpassword',
        ]);

        // Upewnienie się, że użytkownik jest nadal zalogowany
        $this->assertAuthenticatedAs($user);

        // Sprawdzenie, czy użytkownik nadal istnieje w bazie danych
        $this->assertDatabaseHas('users', ['id' => $user->id]);

        // Sprawdzenie przekierowania i komunikatu o błędzie
        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('password');
    }
}
