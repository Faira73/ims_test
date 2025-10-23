<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionBank extends Model
{
    protected $fillable = ['question_text', 'category_id'];
    public function category(): BelongsTo {

        return $this->belongsTo(QuestionCategory::class);
    }
}
