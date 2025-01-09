<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){
        $logs = Log::query()->with('type')->get();
        return view('management.admin.logs.index', compact('logs'));
    }
    public function show(Log $log){

        return view('management.admin.logs.show', compact('log'));
    }
}
