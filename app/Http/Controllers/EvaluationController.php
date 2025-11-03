<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Interview;
use App\Models\EvaluationCriteria;
use App\Models\EvaluationScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function create(Interview $interview)
        {
            $criteria = EvaluationCriteria::all();

            $existing = Evaluation::where('interview_id', $interview->id)
                ->where('evaluator_id', Auth::id())
                ->first();
مم
            if ($existing){
                return redirect()->route('evaluations.edit', $existing->id);
            }
            return view('evaluation.create', compact('interview', 'criteria'));
        }

        public function store(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'overall_note' => 'nullable|string',
            'overall_score' => 'nullable|numeric|min:0|max:5',
            'scores' => 'required|array',
            'scores.*.criterion_id' => 'required|exists:evaluation_criteria,id',
            'scores.*.score' => 'required|integer|min:1|max:5',
            'scores.*.comment' => 'nullable|string',
        ]);

        $evaluation = Evaluation::create([
            'interview_id' => $interview->id,
            'evaluator_id' => Auth::id(),
            'overall_note' => $validated['overall_note'] ?? null,
            'overall_score' => $validated['overall_score'] ?? null,
        ]);

        foreach ($validated['scores'] as $scoreData) {
            EvaluationScore::create([
                'evaluation_id' => $evaluation->id,
                'criterion_id'  => $scoreData['criterion_id'],
                'score'         => $scoreData['score'],
                'comment'       => $scoreData['comment'] ?? null,
            ]);
        }

        return redirect()->route('interview.show', $interview->id)
            ->with('success', 'Evaluation submitted successfully.');
    }
     public function edit(Evaluation $evaluation)
    {
        $criteria = EvaluationCriteria::all();
        $evaluation->load('scores.criterion');

        return view('evaluation.edit', compact('evaluation', 'criteria'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'overall_note' => 'nullable|string',
            'overall_score' => 'nullable|numeric|min:0|max:100',
            'scores' => 'required|array',
            'scores.*.criterion_id' => 'required|exists:evaluation_criteria,id',
            'scores.*.score' => 'required|integer|min:1|max:5',
            'scores.*.comment' => 'nullable|string',
        ]);

        $evaluation->update([
            'overall_note' => $validated['overall_note'] ?? null,
            'overall_score' => $validated['overall_score'] ?? null,
        ]);

        foreach ($validated['scores'] as $scoreData) {
            $evaluation->scores()->updateOrCreate(
                ['criterion_id' => $scoreData['criterion_id']],
                [
                    'score' => $scoreData['score'],
                    'comment' => $scoreData['comment'] ?? null,
                ]
            );
        }

        return redirect()->route('interview.show', $evaluation->interview_id)
            ->with('success', 'Evaluation updated successfully.');
    }
}