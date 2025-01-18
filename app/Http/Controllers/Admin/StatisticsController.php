<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Statistics\GetStatisticsAction;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class StatisticsController extends Controller
{
    public function index(GetStatisticsAction $getStatisticsAction)
    {
        $thisWeek = Carbon::now()->startOfWeek();
        $thisDay = Carbon::now()->startOfDay();
        $thisMonth = Carbon::now()->startOfMonth();

        $dailyStatistics = $getStatisticsAction->execute($thisDay);
        $weeklyStatistics = $getStatisticsAction->execute($thisWeek);
        $monthlyStatistics = $getStatisticsAction->execute($thisMonth);
        return view('management.admin.statistics.index', compact('dailyStatistics', 'weeklyStatistics', 'monthlyStatistics'));
    }
}
