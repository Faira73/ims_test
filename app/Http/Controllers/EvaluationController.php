<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Interview;
use App\Models\EvaluationCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Show form to create evaluation for an interview
     */
    public function create(Interview $interview)
    {
        // Check if current user is an interviewer for this interview
        if (!$interview->interviewers->contains(Auth::id())) {
            abort(403, 'You are not assigned to this interview.');
        }

        // Check if user already submitted evaluation
        $existingEvaluation = Evaluation::where('interview_id', $interview->id)
            ->where('evaluator_id', Auth::id())
            ->first();

        if ($existingEvaluation) {
            return redirect()->route('evaluations.show', $existingEvaluation)
                ->with('info', 'You have already submitted an evaluation.');
        }

        $criteria = EvaluationCriteria::all();
        
        return view('evaluations.create', compact('interview', 'criteria'));
    }

    /**
     * Store a newly created evaluation
     */
    public function store(Request $request, Interview $interview)
    {
        // Check if current user is an interviewer
        if (!$interview->interviewers->contains(Auth::id())) {
            abort(403, 'You are not assigned to this interview.');
        }

        // Check for existing evaluation
        if (Evaluation::where('interview_id', $interview->id)
            ->where('evaluator_id', Auth::id())
            ->exists()) {
            return back()->with('error', 'You have already submitted an evaluation.');
        }

        $validated = $request->validate([
            'overall_note' => 'nullable|string',
            'overall_score' => 'nullable|numeric|min:0|max:100',
            'scores' => 'required|array',
            'scores.*.criterion_id' => 'required|exists:evaluation_criteria,id',
            'scores.*.score' => 'required|integer|min:1|max:5',
            'scores.*.comment' => 'nullable|string',
        ]);

        // Create evaluation
        $evaluation = Evaluation::create([
            'interview_id' => $interview->id,
            'evaluator_id' => Auth::id(),
            'overall_note' => $validated['overall_note'],
            'overall_score' => $validated['overall_score'],
        ]);

        // Create evaluation scores
        foreach ($validated['scores'] as $scoreData) {
            $evaluation->scores()->create([
                'criterion_id' => $scoreData['criterion_id'],
                'score' => $scoreData['score'],
                'comment' => $scoreData['comment'] ?? null,
            ]);
        }

        return redirect()->route('interviews.show', $interview)
            ->with('success', 'Evaluation submitted successfully!');
    }

    /**
     * Display the specified evaluation
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['interview.candidate', 'evaluator', 'scores.criterion']);
        
        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show form to edit evaluation (only if user is the evaluator)
     */
    public function edit(Evaluation $evaluation)
    {
        // Check if current user is the evaluator
        if ($evaluation->evaluator_id !== Auth::id()) {
            abort(403, 'You can only edit your own evaluations.');
        }

        $criteria = EvaluationCriteria::all();
        
        return view('evaluations.edit', compact('evaluation', 'criteria'));
    }

    /**
     * Update the specified evaluation
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        // Check if current user is the evaluator
        if ($evaluation->evaluator_id !== Auth::id()) {
            abort(403, 'You can only edit your own evaluations.');
        }

        $validated = $request->validate([
            'overall_note' => 'nullable|string',
            'overall_score' => 'nullable|numeric|min:0|max:100',
            'scores' => 'required|array',
            'scores.*.criterion_id' => 'required|exists:evaluation_criteria,id',
            'scores.*.score' => 'required|integer|min:1|max:5',
            'scores.*.comment' => 'nullable|string',
        ]);

        // Update evaluation
        $evaluation->update([
            'overall_note' => $validated['overall_note'],
            'overall_score' => $validated['overall_score'],
        ]);

        // Delete old scores and create new ones
        $evaluation->scores()->delete();
        
        foreach ($validated['scores'] as $scoreData) {
            $evaluation->scores()->create([
                'criterion_id' => $scoreData['criterion_id'],
                'score' => $scoreData['score'],
                'comment' => $scoreData['comment'] ?? null,
            ]);
        }

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Evaluation updated successfully!');
    }

    /**
     * Remove the specified evaluation
     */
    public function destroy(Evaluation $evaluation)
    {
        // Only admin or the evaluator can delete
        if ($evaluation->evaluator_id !== Auth::id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $evaluation->scores()->delete();
        $evaluation->delete();

        return redirect()->route('interviews.show', $evaluation->interview_id)
            ->with('success', 'Evaluation deleted successfully!');
    }

    /**
     * List all evaluations for an interview
     */
    public function index(Interview $interview)
    {
        $evaluations = $interview->evaluations()
            ->with(['evaluator', 'scores.criterion'])
            ->get();
        
        return view('evaluations.index', compact('interview', 'evaluations'));
    }
}