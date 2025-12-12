<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CandidateController extends Controller
{
    public function show($id)
{ 
   $candidate = Candidate::with('employee')->find($id); //Eager loading to reduce number of queries 
    if (!$candidate) {
        abort(404);
    }                                    
    return view('candidate.show', compact('candidate'));
}
    public function index(Request $request)
    {
        $query = Candidate::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $candidates = $query->paginate(10); // paginate for nicer display

        return view('candidate.index', compact('candidates'));
    }

    public function store(Request $request){

        $validate = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'position' => ['required', 'string'],
            'resume_url' => ['required', 'file', 'mimes:pdf,doc,docx'],
            'years_experience' => ['required', 'numeric', 'min:0'],
        ]);

        if($request->hasFile('resume_url')){
            $resumePath = $request->file('resume_url')
            ->store('resumes','public');
            $validate['resume_url'] = $resumePath;
        }

        $validate['created_by_id'] = Auth::id();

        Candidate::create($validate);

        return redirect()->back()->with('success', 'Candidate added successfully!');
    }
}

