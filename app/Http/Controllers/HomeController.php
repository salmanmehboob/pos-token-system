<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Support\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Total Sales";
        // Orders placed today
        $ordersToday = Order::whereDate('created_at', Carbon::today())->get();

        // Count of today's orders
        $ordersCount = $ordersToday->count();

        // Optionally, sum the total sales amount for today
        $totalSalesToday = $ordersToday->sum('total');


        // Sales for the current month
        $totalSalesThisMonth = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        // Sales for the current year
        $totalSalesThisYear = Order::whereYear('created_at', Carbon::now()->year)
            ->sum('total');


        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $inventoriesCount = Inventory::count();
        $historiesCount = History::count();
        $ordersCount = Order::count();

        return view('dashboard', compact('title','categoriesCount', 'productsCount', 'inventoriesCount', 'historiesCount', 'ordersCount', 'totalSalesToday', 'totalSalesThisMonth', 'totalSalesThisYear'));
    }
}