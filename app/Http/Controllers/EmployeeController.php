<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller{
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            abort(404);
        }

        return view('employee.show', compact('employee'));
    }

    public function filterByStatus($status)
    {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            abort(404);
        }

        $employees = Employee::status($status)->get(); 
        // $employees = Employee::status($status);
        // $employees = $employees ->where('is_admin', true)->get();
        if($status == 'pending'){
            return view('employee.pending', compact('employees', 'status'));
        }
        return view('employee.index', compact('employees', 'status'));
    }

    public function updateStatus(Request $request, $id)
    {
        $employee = Employee::findOrFail($id); 
        $employee->status = $request->status;
        $employee->save();

        return redirect()
        ->back()
        ->with('success', "{$employee->name} has been {$employee->status}.");
    }
}