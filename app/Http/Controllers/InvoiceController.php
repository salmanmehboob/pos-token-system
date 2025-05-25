<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function printInvoice($id)
    {
        $order = Order::with('items')->find($id);
        $setting = Setting::first();
         return view('invoice.index', compact('order','setting'));
    }
}
