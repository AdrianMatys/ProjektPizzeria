<?php

namespace Tests\Feature;

use App\Actions\Statistics\GetStatisticsAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class StatisticsControllerTest extends TestCase
{
    use RefreshDatabase;

    // Testuje, czy widok statystyk ładuje poprawnie dane za dzisiejszy dzień, tydzień i miesiąc
    public function testStatisticsPageLoadsCorrectlyWithStatistics()
    {
        // Przygotowanie mocka dla akcji, która zwróci dane statystyk
        $this->mock(GetStatisticsAction::class, function ($mock) {
        $mock->shouldReceive('execute')
                 ->once()
                 ->with(Carbon::now()->startOfDay())
                 ->andReturn(['daily' => 10]);

        $mock->shouldReceive('execute')
                 ->once()
                 ->with(Carbon::now()->startOfWeek())
                 ->andReturn(['weekly' => 50]);

        $mock->shouldReceive('execute')
                 ->once()
                 ->with(Carbon::now()->startOfMonth())
                 ->andReturn(['monthly' => 200]);
        });

        // Wykonanie zapytania GET na stronę statystyk
        $response = $this->get(route('statistics.index'));

        // Sprawdzenie, czy odpowiedź jest poprawna i zawiera odpowiednie dane
        $response->assertStatus(200)
                 ->assertViewIs('management.admin.statistics.index')
                 ->assertViewHas('dailyStatistics', ['daily' => 10])
                 ->assertViewHas('weeklyStatistics', ['weekly' => 50])
                 ->assertViewHas('monthlyStatistics', ['monthly' => 200]);
    }

    // Testuje, czy akcja GetStatisticsAction jest wywoływana z odpowiednimi datami
    public function testActionIsCalledWithCorrectDates()
    {
        // Ustawienie mocka dla GetStatisticsAction
        $mock = $this->mock(GetStatisticsAction::class);

        // Oczekiwanie, że metoda execute zostanie wywołana z trzema różnymi datami
        $mock->shouldReceive('execute')
             ->with(Carbon::now()->startOfDay())
             ->once();
        $mock->shouldReceive('execute')
             ->with(Carbon::now()->startOfWeek())
             ->once();
        $mock->shouldReceive('execute')
             ->with(Carbon::now()->startOfMonth())
             ->once();

        // Wykonanie zapytania GET na stronę statystyk
        $this->get(route('statistics.index'));

        // Upewnij się, że wszystkie oczekiwania zostały spełnione
        $mock->assertVerified();
    }
}
