<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PosController extends Controller
{


    public function index()
    {
        $title = 'Pos';
        $productCategories = Category::orderBy('id', 'asc')->get();
        $products = Product::orderBy('id', 'asc')->get();
        $employees = Employee::orderBy('first_name', 'asc')->get();

        return view('pos.index', compact('title', 'productCategories', 'products','employees'));
    }


    public function getCart()
    {
        $cart = $this->getCurrentCart();

        if (!$cart) {
            return response()->json([]);
        }

        $items = $cart->items()->with('product')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'product' => [
                'image' => asset($item->product->image ?? 'images/no-image.png')
                ]
            ];
        });

        return response()->json($items);
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $authUser = auth()->id();

        try {
            return DB::transaction(function () use ($request, $authUser) {
                $cartExist = $this->getCurrentCart();
                $product = Product::findOrFail($request->product_id); // safe fallback

                 if ($cartExist == null) {

                     $cartData = [
                        'user_id' => $authUser,
                        'sub_total' => $product->retail_price,
                        'discount' => false,
                        'total' => $product->retail_price
                    ];

                    $cart = Cart::create($cartData);
                     $cartItemData = [
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->retail_price,
                        'quantity' => 1
                    ];

                    $cart->items()->create($cartItemData); // using Eloquent relation
                } else {
                    $cartItem = $cartExist->items()->where('product_id', $product->id)->first();

                    if ($cartItem) {
                        $cartItem->increment('quantity');
                    } else {
                        $cartExist->items()->create([
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'price' => $product->retail_price,
                            'quantity' => 1
                        ]);
                    }

                    $cartExist->updateTotals();
                }

                // Reload cart (after possible creation)
                $updatedCart = $this->getCurrentCart();

                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart.',
                    'cart' => [
                        'items' => $updatedCart->items,
                        'sub_total' => $updatedCart->sub_total,
                        'discount' => $updatedCart->discount ?? 0,
                        'total' => $updatedCart->total,
                    ]
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Cart Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart'.$e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($id);

        $item->update(['quantity' => $request->quantity]);
        $cart->updateTotals();

        return response()->json([
            'success' => true,
            'message' => 'Cart item quantity updated.'
        ]);
    }


    public function destroy($id)
    {
        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($id);
        $item->delete();

        // If no more items left, delete the cart
        if ($cart->items()->count() === 0) {
            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'meta' => [
                    'sub_total' => 0,
                    'discount' => 0,
                    'total' => 0,
                ]
            ]);
        }

        // If items still exist, update totals normally
        $cart->updateTotals();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'meta' => [
                'sub_total' => $cart->sub_total,
                'discount' => $cart->discount ?? 0,
                'total' => $cart->total,
            ]
        ]);
    }



    public function applyDiscount(Request $request)
    {
        $request->validate(['discount' => 'required|numeric|min:0']);

        $cart = $this->getCurrentCart();

        $cart->discount = $request->discount;
        $cart->save();

        $cart->updateTotals();

        return response()->json([
            'success' => true,
            'message' => 'Discount applied successfulluy',
            'cart' => $cart->fresh()
        ]);
    }

    protected function getCurrentCart()
    {
        $authUser = auth()->id();

        // For authenticated users
        if (auth()->check()) {
            return Cart::where('user_id', $authUser)->first();
        }

        return false;
    }

    public function cartMeta()
    {
        $cart = $this->getCurrentCart();

        if (!$cart) {
            return response()->json([
                'sub_total' => 0,
                'discount' => 0,
                'total' => 0,
            ]);
        }

        return response()->json([
            'sub_total' => $cart->sub_total,
            'discount' => $cart->discount ?? 0,
            'total' => $cart->total,
        ]);
    }

}
