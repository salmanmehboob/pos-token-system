<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{




   /**
    * Display a listing of the items.
    */
   public function index(Request $request)
   {
      $title = 'Settings';
      $settings = Setting::query();

      if ($request->ajax()) {
         return DataTables()->of($settings)

            ->addColumn('comp_logo', function ($setting) {
               if ($setting->comp_logo) {
                  $imagePath = asset($setting->comp_logo);
                  return '<img src="' . $imagePath . '" width="50" height="50" alt="Image">';
               }
               return 'No Image';
            })
            ->addColumn('actions', function ($setting) {
               return '
                    <div class="d-flex">
                        <a id="editBtn" data-url="' . route('settings.update', $setting->id) . '"
                           data-id="' . $setting->id . '"
                           data-comp_name="' . $setting->comp_name . '"
                           data-comp_address="' . $setting->comp_address . '"
                           data-comp_phone="' . $setting->comp_phone . '"
                           data-comp_mobile="' . $setting->comp_mobile . '"
                           data-comp_email="' . $setting->comp_email . '"
                           data-Comp_logo="' . asset($setting->comp_logo) . '"
                           href="javascript:void(0)"
                           class="btn btn-primary shadow btn-sm sharp me-1"><i class="fas fa-pencil-alt"></i></a>

                        <a href="javascript:void(0)"
                           data-url="' . route('settings.destroy', $setting->id) . '"
                           data-label="delete"
                           data-id="' . $setting->id . '"
                           data-table="settingTable"
                           class="btn btn-danger shadow btn-sm sharp delete-record"
                           style="margin-left:0.5rem;"
                           title="Delete Record"><i class="fa fa-trash"></i></a>
                    </div>
                ';
            })
            ->rawColumns(['actions', 'comp_logo']) // Ensure both actions and image are treated as raw HTML
            ->make(true);
      }

      return view('.profiles.setting', compact('title'));
   }












   /**
    * Store a newly created item in storage.
    */
   public function store(Request $request)
   {

      if ($request->ajax()) {

         $validatedData = $request->validate([
            'comp_name' => 'required|string|max:255|unique:settings,comp_name',
            'comp_address' => 'required|string',
            'comp_phone' => 'required|string',
            'comp_mobile' => 'required|string',
            'comp_email' => 'required|string',
            'comp_logo' => 'required',
         ]);

         try {
            // Start a database transaction
            DB::beginTransaction();

            $dbData = [
               'comp_name' => $validatedData['comp_name'],
               'comp_address' => $validatedData['comp_address'],
               'comp_phone' => $validatedData['comp_phone'],
               'comp_mobile' => $validatedData['comp_mobile'],
               'comp_email' => $validatedData['comp_email'],
               'comp_logo' =>  $validatedData['comp_logo'],
            ];
            // Create the item without the image first to get the ID
            $setting = Setting::create($dbData);


            // Handle image upload after getting the item ID
            $imagePath = null;
            if ($request->hasFile('comp_logo')) {
               // Generate a unique file name using timestamp
               $fileName = now()->timestamp . '.' . $request->file('comp_logo')->getClientOriginalExtension();

               // Store the file in the public disk under a specific folder
               $imagePath = $request->file('comp_logo')->storeAs(
                  'images/items/' . $setting->id,
                  $fileName,
                  'public'
               );

               // Update the item with the correct image path
               $setting->update(['comp_logo' => 'storage/' . $imagePath]);
            }


            // Commit the transaction
            DB::commit();


            return response()->json(['success' =>  'Item created successfully.', 'data' => $setting], 201);
         } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return response()->json(['success' =>  'Failed to create item.', 'error' => $e->getMessage()], 500);
         }
      }

      return response()->json(['success' => false, 'message' => 'Invalid request.'], 400);
   }








   /**
    * Update the specified item in storage.
    */

   public function update(Request $request, Setting $setting)
   {
      $validatedData = $request->validate([
         'comp_name' => 'required|string|max:255|unique:settings,comp_name,' . $setting->id,
         'comp_address' => 'required|string',
         'comp_phone' => 'required|string',
         'comp_mobile' => 'required|string',
         'comp_email' => 'required|string',
         'comp_logo' => 'required',
      ]);

      DB::beginTransaction();

      try {
          // Handle image upload
         if ($request->hasFile('comp_logo')) {
            // Delete old image if it exists
            if ($setting->comp_logo && Storage::exists(str_replace('storage/', 'public/', $setting->comp_logo))) {
               Storage::delete(str_replace('storage/', 'public/', $setting->comp_logo));
            }

            $fileName = now()->timestamp . '.' . $request->file('comp_logo')->getClientOriginalExtension();

            // ✅ Fixed path (matches store method)
            $imagePath = $request->file('comp_logo')->storeAs(
               'images/items/' . $setting->id,
               $fileName,
               'public'
            );

            $validatedData['comp_logo'] = 'storage/' . $imagePath;
         }

         // Update the product
         $setting->update($validatedData);

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
         $setting = Setting::findOrFail($id);
         $setting->delete();
         return response()->json(['success' => 'product deleted successfully.']);
      } catch (\Exception $e) {
         return response()->json(['error' => 'Failed to delete product.'], 500);
      }
   }



}
