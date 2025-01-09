<?php

namespace App\Actions\Logs;

use App\Services\LoggerService;

class LogUserLoginAction
{
    protected LoggerService $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function execute(int $userId): void
    {
        $this->loggerService->logByName("Logged in", $userId, []);
    }
}
