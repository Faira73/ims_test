<?php

namespace App\Http\Controllers;

use App\Models\Employee;                // or App\Models\Employee if you're using a custom model
use Illuminate\Http\Request;        // handles HTTP requests
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller 
{
    public function __invoke(Request $request)
    {
        $employeeData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
        ]);


        $employeeData['password'] = bcrypt($employeeData['password']);
        $employee = Employee::create($employeeData);
        // $employee = new Employee($employeeData);
        // $employee->save();

        Auth::login($employee);

        return redirect()->route('dashboard');
    }
}