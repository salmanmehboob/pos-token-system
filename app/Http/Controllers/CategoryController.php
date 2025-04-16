<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // ✅ Import this!

class CategoryController extends Controller
{
    /**
     * Display all product  categories.
     */
    public function index(Request $request)
    {
        $title = 'Categories';

        if ($request->ajax()) {
            $categories = Category::select(['id', 'name']);
            return DataTables()->of($categories)
                ->addColumn('actions', function ($category) {
                    return '
                    <div class="d-flex align-items-center">
                        <a id="editBtn" data-url="' . route('product.categories.update', $category->id) . '"
                           data-id="' . $category->id . '" data-name="' . $category->name . '" href="javascript:void(0)"
                           class="btn btn-primary shadow btn-sm sharp "><i class="fas fa-pencil-alt fa-sm"></i></a>

                        <a href="javascript:void(0)"
                           data-url="' . route('product.categories.destroy', $category->id) . '"
                           data-label="delete"
                           data-id="' . $category->id . '"
                           data-table="productCategoriesTable"
                           style="margin-left: 1.5rem"
                           class="btn btn-danger shadow btn-sm  sharp delete-record"
                           title="Delete Record"><i class="fa fa-trash fa-sm"></i></a>
                    </div>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('product_categories.index', compact('title'));
    }

    /**
     * Store a new product category.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            Category::create([
                'name' => $request->name,
                'status' => $request->status ?? 0,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => 'Category added successfully.']);
            }

            return redirect()->route('product.categories.index')->with('success', 'Category added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // ✅ Log the error correctly
            Log::error('Category Store Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    /**
     * Update a product category.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $categories = Category::findOrFail($id);
            $categories->update(['name' => $request->name]);

            if ($request->ajax()) {
                return response()->json(['success' => 'Category updated successfully.']);
            }

            return redirect()->route('product.categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            // ✅ Log the error correctly
            Log::error('Category Update Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to update category. Please try again.'], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Failed to update category.']);
        }
    }

    /**
     * Delete a product category.
     */
    public function destroy($id)
    {
        try {
            $categories = Category::findOrFail($id);
           $categories->delete();

            return response()->json(['success' => 'Category deleted successfully.']);
        } catch (\Exception $e) {
            // ✅ Log the error correctly
            Log::error('Category Delete Error: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to delete category.']);
        }
    }
}