<?php
namespace Tests\Feature;
use App\Models\Token;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TokensControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test wyświetlanie listy tokenów.
     */
    public function test_index_displays_all_tokens()
    {
        // Tworzenie tokenów testowych
        $tokens = Token::factory()->count(3)->create();

        // Wykonanie zapytania GET
        $response = $this->get(route('management.admin.tokens.index'));

        // Sprawdzenie statusu odpowiedzi
        $response->assertStatus(200);

        // Sprawdzenie, czy tokeny są widoczne w widoku
        $response->assertViewIs('management.admin.tokens.index');
        $response->assertViewHas('tokens', function ($viewTokens) use ($tokens) {
            return $viewTokens->count() === $tokens->count();
        });
    }

    /**
     * Test wyświetlanie formularza tworzenia tokena.
     */
    public function test_create_displays_create_form()
    {
        // Wykonanie zapytania GET
        $response = $this->get(route('management.admin.tokens.create'));

        // Sprawdzenie statusu odpowiedzi
        $response->assertStatus(200);

        // Sprawdzenie, czy odpowiedni widok został załadowany
        $response->assertViewIs('management.admin.tokens.create');
    }

    /**
     * Test tworzenie nowego tokena.
     */
    public function test_store_creates_new_token()
    {
        // Dane wejściowe
        $data = [
            'email' => 'test@example.com',
        ];

        // Wykonanie zapytania POST
        $response = $this->post(route('management.admin.tokens.store'), $data);

        // Sprawdzenie, czy token został zapisany w bazie
        $this->assertDatabaseHas('tokens', [
            'email' => 'test@example.com',
        ]);

        // Sprawdzenie, czy token został wygenerowany
        $token = Token::where('email', 'test@example.com')->first();
        $this->assertNotNull($token->token);
        $this->assertEquals(40, strlen($token->token));

        // Sprawdzenie przekierowania i komunikatu
        $response->assertRedirect(route('management.admin.tokens.index'));
        $response->assertSessionHas('success', 'Token rejestracyjny pracownika został stworzony');
    }

    /**
     * Test usuwania tokena.
     */
    public function test_destroy_deletes_token()
    {
        // Tworzenie tokena
        $token = Token::factory()->create([
            'email' => 'test@example.com',
        ]);

        // Wykonanie zapytania DELETE
        $response = $this->delete(route('management.admin.tokens.destroy', $token->email));

        // Sprawdzenie, czy token został usunięty z bazy
        $this->assertDatabaseMissing('tokens', [
            'email' => 'test@example.com',
        ]);

        // Sprawdzenie przekierowania i komunikatu
        $response->assertRedirect(route('management.admin.tokens.index'));
        $response->assertSessionHas('success', 'Token rejestracyjny pracownika został usunięty');
    }

    /**
     * Test błędu usuwania nieistniejącego tokena.
     */
    public function test_destroy_fails_when_token_not_found()
    {
        // Wykonanie zapytania DELETE dla nieistniejącego tokena
        $response = $this->delete(route('management.admin.tokens.destroy', 'nonexistent@example.com'));

        // Sprawdzenie, czy brak tokena nie spowodował błędu krytycznego
        $response->assertRedirect(route('management.admin.tokens.index'));
        $response->assertSessionHas('error', 'Nie udało usunąć się tokenu');
    }
}
