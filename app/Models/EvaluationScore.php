<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    public function evaluation() 
    {
        return $this->belongsTo(Evaluation::class);     
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criterion_id');
    }
}
