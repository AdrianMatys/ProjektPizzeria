<?php

namespace App\Actions\Logs;

use App\Services\LoggerService;

class LogUpdateIngredientAction
{
    protected LoggerService $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function execute(int $userId, array $details): void
    {
        $this->loggerService->logByName("Updated ingredient", $userId, $details);
    }
}
