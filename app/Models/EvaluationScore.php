<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{   
    protected $fillable = ['evaluation_id', 'criterion_id', 'score', 'comment'];
    public function evaluation() 
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');     
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criterion_id');
    }

    public static function EvaluatorAvg($interviewId, $evaluationId)
    {
        return static::where('interview_id', $interviewId)
                    ->where('evaluator_id', $evaluationId)
                    ->avg('score');

    }
}
