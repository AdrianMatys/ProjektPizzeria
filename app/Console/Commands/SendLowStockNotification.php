<?php

namespace App\Console\Commands;

use App\Actions\Logs\LogLowStockNotificationAction;
use App\Actions\Logs\LogUpdatePizzeriaAction;
use App\Mail\LowStockNotification;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLowStockNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:low-stock';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wysyłanie powiadomienia niskim stanie magazynowym składników';

    /**
     * Execute the console command.
     */
    public function handle(LogLowStockNotificationAction $logLowStockNotificationAction)
    {
        Log::info('Low stock notification started');

        $lowStockIngredients = Ingredient::query()
            ->whereColumn('quantity', '<', 'minQuantity')
            ->get();

        if($lowStockIngredients->isEmpty()){
            $this->info("Brak składników o niskim stanie magazynowym.");
            return;
        }

        $admins = User::query()->where('role', 'admin')->get();

        if($admins->isEmpty()){
            $this->info("Brak użytkowników z rolą admin do powiadomienia.");
            return;
        }

        foreach ($admins as $admin){
            Mail::to($admin->email)->send(new LowStockNotification($lowStockIngredients));
            $logLowStockNotificationAction->execute(['email' => $admin->email, 'ingredients' => $lowStockIngredients->pluck('name')->implode(', ')]);
            $this->info("Wysłano powiadomienia i niskim stanie magazynowym do: {{$admin->email}}");
        }
    }
}
