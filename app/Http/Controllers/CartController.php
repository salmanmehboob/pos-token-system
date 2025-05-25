<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $product = Product::findOrFail($request->product_id);
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }

    public function updateCart(Request $request)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        if ($request->action === 'increment') {
            $cartItem->quantity += 1;
        } elseif ($request->action === 'decrement' && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }

        $cartItem->save();
        return response()->json(['message' => 'Cart updated']);
    }

    public function removeFromCart(Request $request)
    {
        Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json(['message' => 'Product removed from cart']);
    }

    public function getCart()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($cartItems);
    }
}