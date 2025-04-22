<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(){
        $title = 'Pos';
        $productCategories = Category::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc');

        









        return view('pos.index', compact('title', 'productCategories', 'products'));
    }
}