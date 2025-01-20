<?php

namespace App\Actions\Logs;

use App\Models\Ingredient;
use App\Services\LoggerService;

class LogNewPizzaAction
{
    protected LoggerService $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function execute(int $userId, array $details): void
    {
        $ingredientIds = $details['Ingredients'];
        $ingredients = Ingredient::query()->whereIn('id', $ingredientIds)->get();
        $details['Ingredients'] = $ingredients->pluck('name')->implode(', ');
        $this->loggerService->logByName("New pizza", $userId, $details);
    }
}
