<?php

namespace App\Actions\Logs;

use App\Services\LoggerService;

class LogCreateNewUserAction
{
    protected LoggerService $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function execute(int $userId): void
    {
        $this->loggerService->logByName("New User", $userId, []);
    }
}
