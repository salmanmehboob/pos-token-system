<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosController extends Controller
{





    public function index()
    {
        $title = 'Pos';
        $productCategories = Category::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->get();

        return view('pos.index', compact('title', 'productCategories', 'products'));
    }





    public function getCart()
    {
        $cart = $this->getCurrentCart();
        return response()->json($cart->items()->with('product')->get());
    }






    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $cart = $this->getCurrentCart();
        $product = Product::find($request->product_id);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->retail_price,
                'quantity' => 1
            ]);
        }

        $cart->updateTotals();

        return response()->json([
            'success' => true,
            'cart' => $cart->load('items.product')
        ]);

dd($cart);

    }





    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($id);

        $item->update(['quantity' => $request->quantity]);
        $cart->updateTotals();

        return response()->json(['success' => true]);
    }






    public function destroy($id)
    {
        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($id);
        $item->delete();

        $cart->updateTotals();

        return response()->json(['success' => true]);
    }







    public function applyDiscount(Request $request)
    {
        $request->validate(['discount' => 'required|numeric|min:0']);

        $cart = $this->getCurrentCart();
        $cart->update([
            'discount' => $request->discount,
            'total' => $cart->subtotal - $request->discount
        ]);

        return response()->json([
            'success' => true,
            'cart' => $cart->fresh()
        ]);
    }





    
    protected function getCurrentCart()
    {
        // For authenticated users
        if (auth()->check()) {
            return Cart::firstOrCreate(['user_id' => auth()->id()]);
        }

        // For guest users (using session)
        $sessionId = session()->get('cart_session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('cart_session_id', $sessionId);
        }

        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }
}