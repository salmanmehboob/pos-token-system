<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;

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
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $inventoriesCount = Inventory::count();
        $historiesCount = History::count();
        return view('dashboard', compact('categoriesCount', 'productsCount', 'inventoriesCount', 'historiesCount'));
    }
}
