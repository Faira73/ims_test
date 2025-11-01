<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Candidate;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    public function index(Request $request)
    {
        // Always eager-load related models to avoid N+1 query problems
        $interviews = Interview::with(['candidate', 'interviewers'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        $candidates = Candidate::all();
        $employees = Employee::all();

        return view('interview.index', compact('interviews', 'candidates',
                                        'employees'));
    }

    public function show(Interview $interview)
    {
        // Load all relevant relations for the detail view
        $interview->load(['candidate', 'interviewers', 'evaluations.evaluator']);

        return view('interview.show', compact('interview'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'candidate_id'  => ['required', 'exists:candidates,id'],
        'interviewers'  => ['required', 'array', 'min:1'],
        'interviewers.*'=> ['exists:employees,id'],
        'scheduled_at'  => ['required', 'date', 'after_or_equal:today'],
        'link'          => ['nullable', 'url'],
        'notes'         => ['nullable', 'string', 'max:1000'],
        ]);
        
        $interview = Interview::create([
            'candidate_id' => $validated['candidate_id'],
            'scheduled_at' => $validated['scheduled_at'],
            'location'         => $validated['link'] ?? null,
            'notes'        => $validated['notes'] ?? null,
            'status'       => 'scheduled', // default status
        ]);
        $interview->interviewers()->attach($validated['interviewers']);

        return redirect()->route('interview.index')
                        ->with('success', 'Interview created successfully.');
    }
}