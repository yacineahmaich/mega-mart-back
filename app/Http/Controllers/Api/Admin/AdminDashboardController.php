<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Product;
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
            ->where('role', 'customer')
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
        $days = 6;
        $sales = [];

        // Get the start and end dates for the last 7 days
        $startDate = Carbon::now()->subDays($days);
        $endDate = Carbon::now();

        // Get the start and end dates for the corresponding days in the previous week

        // Iterate through each day of the week
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $currentDaySales = Order::where('status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('total_price');

            $previousDaySales = Order::where('status', 'paid')
                ->whereDate('paid_at', $date->subDays($days))
                ->sum('total_price');

            $sales[] = [
                "day" => $date->format("l"),
                "current" => $currentDaySales,
                "prev" => $previousDaySales,
            ];

            $date->addDays($days);
        }


        return response()->json($sales);
    }

    public function salesDistro()
    {
        // get total sales by each main_category
        $sales_contributions = Order::join('items', 'orders.id', '=', 'items.order_id')
            ->where('orders.status', 'paid')
            ->join('products', 'items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('main_categories', 'categories.main_category_id', '=', 'main_categories.id')
            ->select('main_categories.name', DB::raw('SUM(items.price) as total_sales'))
            ->groupBy('main_categories.name')
            ->get();


        // transfer sales field to a number :> need fix
        $sales_contributions = collect($sales_contributions)->map(fn ($item) =>  [
            'name' => $item->name,
            'sales' => +$item->total_sales,
        ]);

        return response()->json($sales_contributions);
    }

    public function latestOrders()
    {
        return new OrderCollection(Order::latest()->take(6)->get());
    }

    public function sharedStats()
    {

        $total_sales = Order::where('status', 'paid')
            ->sum('total_price');
        $total_products = Product::count();
        $total_orders = Order::count();


        return response()->json([
            'totalSales' => $total_sales,
            'totalProducts' => $total_products,
            'totalOrders' => $total_orders,
        ]);
    }
}
