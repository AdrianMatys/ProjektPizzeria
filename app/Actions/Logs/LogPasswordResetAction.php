<?php

namespace App\Actions\Logs;

use App\Services\LoggerService;

class LogPasswordResetAction
{
    protected LoggerService $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function execute(array $details): void
    {
        $this->loggerService->logByName("Password reset", null, $details);
    }
}
