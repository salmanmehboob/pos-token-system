<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{



    public function placeOrder(Request $request)
    {
        $userId = Auth::id();

        // Step 1: Get the cart for the user
        $cart = Cart::with('items')->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Step 2: Create the Order
            $order = Order::create([
                'user_id' => $userId,
                'total' => $cart->total,
                'sub_total' => $cart->sub_total,
                'discount' => $cart->discount,
                'status' => 'Completed',
                'created_at' => now(),
            ]);

            // Step 3: Create Order Items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }

            // Step 4: Clear the cart and its items
            $cart->items()->delete(); // delete cart_items
            $cart->delete(); // delete the cart itself

            DB::commit();

            return redirect()->route('invoice', ['id'=>$order->id])->with('success', 'Order placed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }





    public function orderHistory()
    {
        $orders = Order::with('items.product')->where('user_id', Auth::id())->latest()->get();
        return view('orders.index', [
            'title' => 'Your Order History',
            'orders' => $orders,
        ]);
    }


    
}