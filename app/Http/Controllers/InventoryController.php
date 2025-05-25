<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index(Request $request)
    {
        $title = 'Inventories';
        $productCategories = Category::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->get();

      
        if ($request->ajax()) {
            $inventories = Inventory::with('category', 'product')->get();


            return DataTables()->of($inventories)
                ->addColumn('category_name', function ($inventory) {
                    return $inventory->category ? $inventory->category->name : 'N/A';
                })
                ->addColumn('product_name', function ($inventory) {
                    return $inventory->product ? $inventory->product->name : 'N/A';
                })

               ->addColumn('actions', function ($inventory) {
                    return '
                        <div class="d-flex">
                            <a href="javascript:void(0)"
                            id="editBtn"
                            class="btn btn-primary shadow btn-sm sharp me-1"
                            data-url="' . route('inventories.update', $inventory->id) . '"
                            data-id="' . $inventory->id . '"
                            data-category="' . $inventory->product_category_id . '"
                            data-product="' . $inventory->product_id . '"
                            data-quantity="' . $inventory->quantity . '"
                            data-is_stock="' . $inventory->is_stock . '"
                            title="Edit Record">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-danger shadow btn-sm sharp delete-record"
                            data-url="' . route('inventories.destroy', $inventory->id) . '"
                            data-label="delete"
                            data-id="' . $inventory->id . '"
                            data-table="inventoryTable"
                            title="Delete Record">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    ';
                })
                 ->rawColumns(['actions']) // Ensure both actions and image are treated as raw HTML
                ->make(true);
        }

        return view('inventories.index', compact('title', 'productCategories', 'products'));
    }






    /**
     * Store a newly created inventory in storage.
     */
    public function store(Request $request)
    {

        if ($request->ajax()) {

            $validatedData = $request->validate([
                'product_category_id' => 'required|exists:categories,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer',
                'is_stock' => 'boolean',
            ]);

            try {
                // Start a database transaction
                DB::beginTransaction();

                // Check if the same product/category exists
                $existingInventory = Inventory::where('product_category_id', $validatedData['product_category_id'])
                    ->where('product_id', $validatedData['product_id'])
                    ->first();

                if ($existingInventory) {
                    // Update the quantity by adding new quantity to existing
                    $existingInventory->update([
                        'quantity' => $existingInventory->quantity + $validatedData['quantity'],
//                        'is_stock' => $validatedData['is_stock'], // optionally update is_stock
                    ]);

                    DB::commit();
                    return response()->json(['success' => 'Inventory updated successfully.', 'data' => $existingInventory], 200);
                }

                // Create the item without the image first to get the ID
//                $inventory = Inventory::create(array_merge($validatedData, ['image' => null]));

                $inventory = Inventory::create(array_merge($validatedData));
                History::create([
                    'product_category_id' => $validatedData['product_category_id'],
                    'product_id' => $validatedData['product_id'],
                    'quantity' => $validatedData['quantity'],
//                    'is_stock' => $validatedData['is_stock'],
                    'date' => now(),
                ]);



                // Commit the transaction
                DB::commit();


                return response()->json(['success' =>  'Item created successfully.', 'data' => $inventory], 201);
                History::create([
                    'product_category_id' => $validatedData['product_category_id'],
                    'product_id' => $validatedData['product_id'],
                    'quantity' => $validatedData['quantity'],
                    'is_stock' => $validatedData['is_stock'],
                    'created_at' => now(),
                ]);

            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollBack();
                return response()->json(['success' =>  'Failed to create item.', 'error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid request.'], 400);
    }





    /**
     * Update the specified inventory in storage.
     */

    public function update(Request $request,  $id)
    {
        $validatedData = $request->validate([
            'product_category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'is_stock' => 'boolean',
        ]);

        DB::beginTransaction();

        try {

            $inventory = Inventory::find($id);
           // Update the Inventory
           $inventory->update($validatedData);

            DB::commit();

            return response()->json(['success' => 'product updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update product: ' . $e->getMessage()], 500);
        }
    }




    /**
     * Remove the specified item from storage (Soft Delete).
     */
    public function destroy($id)
    {

        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();
            return response()->json(['success' => 'product deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product.'], 500);
        }
    }


    /**
     * Restore a soft-deleted item.
     */
    public function restore($id)
    {
        try {
            $inventory = Inventory::withTrashed()->findOrFail($id);
            $inventory->restore();
            return response()->json(['success' => 'Item restored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore item.'], 500);
        }
    }

    /**
     * Get products by category.
     */
    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $products = Product::where('product_category_id', $categoryId)->orderBy('name', 'asc')->get();

        return response()->json($products);
    }


}