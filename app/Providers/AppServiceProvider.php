<?php

namespace App\Providers;

use App\Models\CustomPizza;
use App\Models\EditedPizza;
use App\Models\Pizza;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Relation::morphMap([
            'Pizza' => Pizza::class,
            'EditedPizza' => EditedPizza::class,
            'CustomPizza' => CustomPizza::class,
        ]);
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
