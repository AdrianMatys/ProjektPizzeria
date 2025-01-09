<?php

namespace App\Services;

use App\Models\Log;
use App\Models\LogCategory;
use App\Models\LogType;

class LoggerService
{
    public function log(int $logTypeId, ?int $userId, array $details)
    {
        return Log::create([
            'log_type_id' => $logTypeId,
            'user_id' => $userId,
            'details' => json_encode($details),
        ]);
    }
    public function logByName(string $name, ?int $userId, array $details)
    {
        $logType = LogType::query()
            ->where('name', $name)
            ->first();
        $this->log($logType->id, $userId, $details);
    }
}
