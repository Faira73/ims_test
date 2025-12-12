<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionBank extends Model
{
    protected $table = 'questions';


    protected $fillable = [
    'text',
    'category_id',
    'created_by_id'];
    
    public function category(): BelongsTo {

        return $this->belongsTo(QuestionCategory::class);
    }
}
