<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    //
    protected $fillable = [
        'interview_id',
        'evaluator_id',
        'overall_note',
        'overall_score',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Employee::class, 'evaluator_id');
    }

    public function scores(){
        return $this->hasMany(EvaluationScore::class, 'evaluation_id');
    }
}
