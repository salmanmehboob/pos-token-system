<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        //        $items = Item::with('itemCategory')->first();
        //
        //        dd($items);
        if ($request->ajax()) {
//            $products = Product::with('category');
            $inventories = Inventory::with('category', 'product')->get();


            return DataTables()->of($inventories)
                ->addColumn('category_name', function ($inventory) {
                    return $inventory->category ? $inventory->category->name : 'N/A';
                })
                ->addColumn('product_name', function ($inventory) {
                    return $inventory->product ? $inventory->product->name : 'N/A';
//                })
//                ->addColumn('image', function ($inventory) {
//                    if ($inventory->image) {
//                        $imagePath = asset($inventory->image);
//                        //                        dd($imagePath );
//                        return '<img src="' . $imagePath . '" width="50" height="50" alt="Image">';
//                    }
//                    return 'No Image';
//                })
                ->addColumn('actions', function ($inventory) {
                    return '
                    <div class="d-flex">
                        <a id="editBtn" data-url="' . route('inventories.update', $inventory->id) . '"
                           data-id="' . $inventory->id . '"
//                           data-image="' . asset($inventory->image) . '"

                           data-category="' . $inventory->product_category_id . '"
                           data-product="' . $inventory->product_id . '"
                           data-quantity="' . $inventory->quantity . '"
                           data-is_stock="' . $inventory->is_stock . '"
                           href="javascript:void(0)"
                           class="btn btn-primary shadow btn-sm sharp me-1"><i class="fas fa-pencil-alt"></i></a>

                        <a href="javascript:void(0)"
                           data-url="' . route('inventories.destroy', $inventory->id) . '"
                           data-label="delete"
                           data-id="' . $inventory->id . '"
                           data-table="inventoryTable"
                           class="btn btn-danger shadow btn-sm sharp delete-record"
                           style="margin-left:0.5rem;"
                           title="Delete Record"><i class="fa fa-trash"></i></a>
                    </div>
                ';
                })
                ->rawColumns(['actions']) // Ensure both actions and image are treated as raw HTML
                ->make(true);
        }

        return view('inventories.index', compact('title', 'productCategories', 'products'));
    }






    /**
     * Store a newly created item in storage.
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


                // Create the item without the image first to get the ID
                $inventory = Inventory::create(array_merge($validatedData, ['image' => null]));

                // Handle image upload after getting the item ID
                $imagePath = null;
//                if ($request->hasFile('image')) {
//                    // Generate a unique file name using timestamp
//                    $fileName = now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
//
//                    // Store the file in the public disk under a specific folder
//                    $imagePath = $request->file('image')->storeAs(
//                        'images/inventories/' . $inventory->id,
//                        $fileName,
//                        'public'
//                    );
//
//                    // Update the item with the correct image path
//                    $inventory->update(['image' => 'storage/' . $imagePath]);
//                }


                // Commit the transaction
                DB::commit();


                return response()->json(['success' =>  'Item created successfully.', 'data' => $inventory], 201);
            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollBack();
                return response()->json(['success' =>  'Failed to create item.', 'error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid request.'], 400);
    }


    /**
     * Show the form for editing the specified item.
     */
//    public function edit($id)
//    {
//        $product = Product::findOrFail($id); // Fetch the item by ID
//        $categories = Category::all(); // Assuming you have categories to list
//
//        return view('products.edit', compact('product', 'categories'));
//    }


    /**
     * Update the specified item in storage.
     */

    public function update(Request $request, Product $inventory)
    {
        $validatedData = $request->validate([
            'product_category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'is_stock' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            // Handle image upload
//            if ($request->hasFile('image')) {
//                // Delete old image if it exists
//                if ($inventory->image && Storage::exists(str_replace('storage/', 'public/', $inventory->image))) {
//                    Storage::delete(str_replace('storage/', 'public/', $inventory->image));
//                }
//
//                $fileName = now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
//
//                // ✅ Fixed path (matches store method)
//                $imagePath = $request->file('image')->storeAs(
//                    'images/inventories/' . $inventory->id,
//                    $fileName,
//                    'public'
//                );
//
//                $validatedData['image'] = 'storage/' . $imagePath;
//            }
//
//            // Update the product
//            $inventory->update($validatedData);

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
}
