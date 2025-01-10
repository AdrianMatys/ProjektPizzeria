<?php

namespace App\Actions\Logs;

use App\Services\LoggerService;

class LogCreateTranslationAction
{
    protected LoggerService $loggerService;

    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function execute(int $userId, $details): void
    {
        $this->loggerService->logByName("New translation", $userId, $details);
    }
}
