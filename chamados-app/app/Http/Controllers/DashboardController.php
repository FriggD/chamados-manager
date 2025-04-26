<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Monthly stats
        $totalMonthly = Orders::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $completedMonthly = Orders::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereNotNull('solution_date')
            ->count();

        $openMonthly = $totalMonthly - $completedMonthly;

        $lateMonthly = Orders::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereNull('solution_date')
            ->where('due_date', '<', $today)
            ->count();

        $completionRateMonthly = $totalMonthly > 0 ? round(($completedMonthly / $totalMonthly) * 100, 1) : 0;

        // Daily stats
        $totalDaily = Orders::whereDate('created_at', $today)->count();
        $completedDaily = Orders::whereDate('solution_date', $today)->count();
        $openDaily = Orders::whereDate('created_at', $today)->whereNull('solution_date')->count();
        $lateDaily = Orders::whereDate('created_at', $today)
            ->whereNull('solution_date')
            ->where('due_date', '<', $today)
            ->count();

        $completionRateDaily = $totalDaily > 0 ? round(($completedDaily / $totalDaily) * 100, 1) : 0;

        // Orders by category
        $ordersByCategory = DB::table('categories')
            ->leftJoin('orders', 'categories.id', '=', 'orders.category_id')
            ->select('categories.name', DB::raw('count(orders.id) as total'))
            ->groupBy('categories.name')
            ->get();

        // Orders by status
        $ordersByStatus = DB::table('status')
            ->leftJoin('orders', 'status.id', '=', 'orders.status_id')
            ->select('status.name', DB::raw('count(orders.id) as total'))
            ->groupBy('status.name')
            ->get();

        // Recent orders
        $recentOrders = Orders::with(['category', 'status'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMonthly', 'completedMonthly', 'openMonthly', 'lateMonthly', 'completionRateMonthly',
            'totalDaily', 'completedDaily', 'openDaily', 'lateDaily', 'completionRateDaily',
            'ordersByCategory', 'ordersByStatus', 'recentOrders'
        ));
    }
}