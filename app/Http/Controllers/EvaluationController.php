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
                ->where('evaluator_id', Auth::id());

            if ($existing){
                return redirect()->route('evaluations.edit', $existing->id);
            }
            return view('evaluation.create', compact('interview', 'criteria'));
        }

        public function store(Request $request, Interview $interview)
    {
        $user = Auth::id();

        if (!$interview ->interviewers->contains($user)){
            abort(403, 'Unauthorized');
        }

        $validate = $request->validate([
            'ratings' => 'required | array', 
            'ratings.*' => 'required | integer | min:1 | max:5',
            'comments' => 'nullable | array', 
            'comment.*' => 'lullable | string | max: 255'
        ]);

        $existingEvaluation = Evaluation::where('interview_id', $interview->id)
            ->where('evaluator_id', $user)
            ->first();
        
        if($existingEvaluation){
            return redirect()->back()->with('error', 'You have already submitted your evaluation');
        }

         $evaluation = Evaluation::create([
            'interview_id' => $interview->id,
            'evaluator_id' => $user,
            'overall_score' => null, // you can calculate later if needed
            'overall_note' => null,
        ]);
        
        foreach ($validate['ratings'] as $criterionId => $score) {
        EvaluationScore::create([
            'evaluation_id' => $evaluation->id,
            'criterion_id' => $criterionId,
            'score' => $score,
            'comment' => $validate['comments'][$criterionId] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Evaluation submitted successfully.');
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