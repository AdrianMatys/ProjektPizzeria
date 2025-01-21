<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    // Testowanie wyświetlania formularza edycji profilu
    public function testEditingProfileForm()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('profile.edit'));

        $response->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $inertia) => 
        $inertia->component('Profile/Edit')
        ->has('mustVerifyEmail')
        ->has('status')
        );
    }

    // Testowanie aktualizacji informacji o profilu
    public function testUpdatingProfile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->put(route('profile.update'), $data);

        // Sprawdzamy, czy dane zostały zapisane w bazie
        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);

        // Sprawdzamy, czy następuje przekierowanie z komunikatem
        $response->assertRedirect(route('profile.edit'));
    }

    // Testowanie usuwania konta użytkownika
    public function testDeletingAccount()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('profile.destroy'), [
            'password' => 'password', // Zakładając, że użytkownik ma takie hasło
        ]);

        // Sprawdzamy, czy użytkownik został usunięty
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        // Sprawdzamy, czy użytkownik został wylogowany
        $this->assertNull(Auth::user());

        // Sprawdzamy, czy nastąpiło przekierowanie
        $response->assertRedirect('/');
    }

    // Testowanie błędu przy usuwaniu konta bez poprawnego hasła
    public function testDeletingAccountFailsWithoutCorrectPassword()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('profile.destroy'), [
            'password' => 'incorrect-password', // Błędne hasło
        ]);

        // Sprawdzamy, czy użytkownik nie został usunięty
        $this->assertDatabaseHas('users', ['id' => $user->id]);

        // Sprawdzamy, czy nie wylogowano użytkownika
        $this->assertNotNull(Auth::user());

        // Sprawdzamy, czy pojawił się odpowiedni komunikat o błędzie
        $response->assertSessionHasErrors('password');
    }
}
