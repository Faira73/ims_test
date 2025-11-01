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

        return view('interview.index', compact('interviews'));
    }

    public function show(Interview $interview)
    {
        // Load all relevant relations for the detail view
        $interview->load(['candidate', 'interviewers', 'evaluations.employee']);

        return view('interview.show', compact('interview'));
    }
}
