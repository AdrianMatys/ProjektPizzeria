<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index()
    {
        $logs = Log::query()->with('type')->orderBy('created_at', 'desc')->get();

        return view('management.admin.logs.index', compact('logs'));
    }

    public function show(Log $log)
    {
        $log->details = json_decode($log->details);
        return view('management.admin.logs.show', compact('log'));
    }
}
