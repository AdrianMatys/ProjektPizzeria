<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Statistics\GetStatisticsAction;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class adminPanelController extends Controller
{
    //statistics logs
    public function index(GetStatisticsAction $getStatisticsAction)
    {
        $logs = Log::query()->with('type')->orderBy('created_at', 'desc')->get();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisDay = Carbon::now()->startOfDay();
        $thisMonth = Carbon::now()->startOfMonth();

        $dailyStatistics = $getStatisticsAction->execute($thisDay);
        $weeklyStatistics = $getStatisticsAction->execute($thisWeek);
        $monthlyStatistics = $getStatisticsAction->execute($thisMonth);
        return view('management.admin.panel.index',
            compact('dailyStatistics', 'weeklyStatistics', 'monthlyStatistics', 'logs'));
    }
}
