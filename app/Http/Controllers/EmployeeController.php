<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index(Request $request)
    {
        $title = 'Employees';

        if ($request->ajax()) {
            $employees = Employee::query();

            return DataTables()->of($employees)
                ->addColumn('full_name', function ($employee) {
                    return $employee->first_name . ' ' . $employee->last_name;
                })
                ->addColumn('actions', function ($employee) {
                    return '
                    <div class="d-flex align-items-center">
                        <a id="editBtn" data-url="' . route('employees.update', $employee->id) . '"
                           data-id="' . $employee->id . '" data-first="' . $employee->first_name . '"  data-last="' . $employee->last_name . '" href="javascript:void(0)"
                           class="btn btn-primary shadow btn-sm sharp "><i class="fas fa-pencil-alt fa-sm"></i></a>

                       <a href="javascript:void(0)"
                           data-url="' . route('employees.destroy', $employee->id) . '"
                           data-id="' . $employee->id . '"
                           data-table="employeeTable"
                           class="btn btn-danger shadow btn-sm sharp delete-record"
                           title="Delete Record">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('employees.index', compact('title'));
    }


    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {

            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
            ]);

            try {
                DB::beginTransaction();

                $employee = Employee::create($validatedData);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Employee created successfully.',
                    'data' => $employee
                ], 201);

            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create employee.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid request.'
        ], 400);
    }

    /**
     * Show the form for editing the specified item.
     */


    /**
     * Update the specified item in storage.
     */

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $employee->update($validatedData);

            DB::commit();

            return response()->json(['success' => 'Employee updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to update employee: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified item from storage (Soft Delete).
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json(['success' => 'Employee deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete employee.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Restore a soft-deleted item.
     */
    public function restore($id)
    {
        try {
            $employee = Employee::withTrashed()->findOrFail($id);
            $employee->restore();
            return response()->json(['success' => 'Item restored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore item.'], 500);
        }
    }
}
