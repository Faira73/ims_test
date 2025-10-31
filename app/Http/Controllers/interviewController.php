<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Candidate;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class interviewController extends Controller
{
 public function index(Request $request){
    $query = Interview::query();

    $interviews = $query->paginate(10);

    return view('interview.index', compact('interviews'));
 }   
}

