<?php

namespace Tests\Feature;

use App\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testuje widok listy logów.
     */
    public function testIndexDisplaysLogs()
    {
        // Tworzymy kilka przykładowych logów
        $logs = Log::factory()->count(5)->create();

        // Wykonujemy żądanie GET na trasę index
        $response = $this->get(route('management.admin.logs.index'));

        // Sprawdzamy, czy status odpowiedzi to 200
        $response->assertStatus(200);

        // Sprawdzamy, czy widok jest poprawny
        $response->assertViewIs('management.admin.logs.index');

        // Sprawdzamy, czy widok otrzymał listę logów
        $response->assertViewHas('logs', function ($viewLogs) use ($logs) {
            return $viewLogs->count() === $logs->count();
        });
    }

    /**
     * Testuje widok szczegółów pojedynczego logu.
     */
    public function testShowDisplaysLogDetails()
    {
        // Tworzymy przykładowy log
        $log = Log::factory()->create();

        // Wykonujemy żądanie GET na trasę show
        $response = $this->get(route('management.admin.logs.show', $log));

        // Sprawdzamy, czy status odpowiedzi to 200
        $response->assertStatus(200);

        // Sprawdzamy, czy widok jest poprawny
        $response->assertViewIs('management.admin.logs.show');

        // Sprawdzamy, czy widok otrzymał odpowiedni log
        $response->assertViewHas('log', function ($viewLog) use ($log) {
            return $viewLog->id === $log->id;
        });
    }
}
