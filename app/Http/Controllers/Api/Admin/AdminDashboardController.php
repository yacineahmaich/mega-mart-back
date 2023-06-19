<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $sales = Order::where('status', 'paid')->sum('total_price');
        $orders = Order::count();
        $customers = User::where('role', 'customer')->count();
        $customers_with_multilpe_orders = User::has('orders', '>=', 2)
            ->count();

        $retention_rate = ($customers_with_multilpe_orders / $customers) * 100;

        return response()->json([
            'sales' => $sales,
            'orders' => $orders,
            'customers' => $customers,
            'retentionRate' => round($retention_rate, 1),
        ]);
    }

    public function sales()
    {
        $sales = [];

        // Get the start and end dates for the last 7 days
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        // Get the start and end dates for the corresponding days in the previous week

        // Iterate through each day of the week
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $currentDaySales = Order::where('status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('total_price');

            $previousDaySales = Order::where('status', 'paid')
                ->whereDate('paid_at', $date->subDays(7))
                ->sum('total_price');

            $sales[] = [
                "day" => $date->format("l"),
                "current" => $currentDaySales,
                "prev" => $previousDaySales,
            ];

            $date->addDays(7);
        }


        return response()->json($sales);
    }

    public function salesDistro()
    {
        // get total sales
        $totalSales = Order::where('status', 'paid')->sum('total_price');

        // get total sales by each main_category
        $salesByCategory = Order::join('items', 'orders.id', '=', 'items.order_id')
            ->where('orders.status', 'paid')
            ->join('products', 'items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('main_categories', 'categories.main_category_id', '=', 'main_categories.id')
            ->select('main_categories.name', DB::raw('SUM(items.price) as total_sales'))
            ->groupBy('main_categories.name')
            ->get();


        // add sales contribution percentage
        $sales_contributions = [];
        foreach ($salesByCategory as $item) {
            $percentage = round((($item['total_sales'] / $totalSales) * 100), 1);

            $sales_contributions[] = [
                'name' => $item->name,
                'totalSales' => $item->total_sales,
                'percentage' => $percentage
            ];
        }

        return response()->json($sales_contributions);
    }

    public function latestOrders()
    {
        return new OrderCollection(Order::latest()->take(6)->get());
    }
}
