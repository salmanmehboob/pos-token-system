<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function printInvoice($id)
    {
        $order = Order::with('items')->find($id);

        return view('invoice.index', compact('order'));
    }
}