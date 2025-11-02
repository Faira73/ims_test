<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model 
{
    protected $fillable = ['label', 'description'];

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class, 'criterion_id');
    }
}