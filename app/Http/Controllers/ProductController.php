<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index(Request $request)
    {
        $title = 'Products';
        $productCategories = Category::orderBy('id', 'asc')->get();

        if ($request->ajax()) {
            $products = Product::with('category')->get();


            return DataTables()->of($products)
                ->addColumn('category_name', function ($product) {
                    return $product->category ? $product->category->name : 'N/A';
                })
                ->addColumn('image', function ($product) {
                    if ($product->image) {
                        $imagePath = asset($product->image);
                        //                        dd($imagePath );
                        return '<img src="' . $imagePath . '" width="50" height="50" alt="Image">';
                    }
                    return 'No Image';
                })
                ->addColumn('actions', function ($product) {
                    return '
                    <div class="d-flex">
                        <a id="editBtn" data-url="' . route('products.update', $product->id) . '"
                           data-id="' . $product->id . '"
                           data-name="' . $product->name . '"
                           data-image="' . asset($product->image) . '"

                           data-category="' . $product->product_category_id . '"
                           data-cost_price="' . $product->cost_price . '"
                           data-retail_price="' . $product->retail_price . '"
                           data-is_stock="' . $product->is_stock . '"
                           href="javascript:void(0)"
                           class="btn btn-primary shadow btn-sm sharp me-1"><i class="fas fa-pencil-alt"></i></a>

                        <a href="javascript:void(0)"
                           data-url="' . route('products.destroy', $product->id) . '"
                           data-label="delete"
                           data-id="' . $product->id . '"
                           data-table="productTable"
                           class="btn btn-danger shadow btn-sm sharp delete-record"
                           style="margin-left:0.5rem;"
                           title="Delete Record"><i class="fa fa-trash"></i></a>
                    </div>
                ';
                })
                ->rawColumns(['actions', 'image']) // Ensure both actions and image are treated as raw HTML
                ->make(true);
        }

        return view('products.index', compact('title', 'productCategories'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {

        if ($request->ajax()) {

            $validatedData = $request->validate([
                'product_category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255|unique:products,name',
                'image' => 'nullable|image|max:2048',
                'cost_price' => 'required|numeric',
                'retail_price' => 'required|numeric',
                'is_stock' => 'boolean',
            ]);

            try {
                // Start a database transaction
                DB::beginTransaction();


                // Create the item without the image first to get the ID
                $product = Product::create(array_merge($validatedData, ['image' => null]));

                // Handle image upload after getting the item ID
                $imagePath = null;
                if ($request->hasFile('image')) {
                    // Generate a unique file name using timestamp
                    $fileName = now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();

                    // Store the file in the public disk under a specific folder
                    $imagePath = $request->file('image')->storeAs(
                        'images/products/' . $product->id,
                        $fileName,
                        'public'
                    );

                    // Update the item with the correct image path
                    $product->update(['image' => 'storage/' . $imagePath]);
                }


                // Commit the transaction
                DB::commit();


                return response()->json(['success' =>  'Item created successfully.', 'data' => $product], 201);
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

//        return view('products.edit', compact('product', 'categories'));
//    }


    /**
     * Update the specified item in storage.
     */

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'image' => 'nullable|image|max:2048',
            'cost_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'is_stock' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($product->image && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
                    Storage::delete(str_replace('storage/', 'public/', $product->image));
                }

                $fileName = now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();

                // ✅ Fixed path (matches store method)
                $imagePath = $request->file('image')->storeAs(
                    'images/products/' . $product->id,
                    $fileName,
                    'public'
                );

                $validatedData['image'] = 'storage/' . $imagePath;
            }

            // Update the product
            $product->update($validatedData);

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
            $product = Product::findOrFail($id);
            $product->delete();

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
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();
            return response()->json(['success' => 'Item restored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore item.'], 500);
        }
    }
}
