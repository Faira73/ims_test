<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{

    protected $fillable = [
        'candidate_id',
        'scheduled_at',
        'location',
        'notes',
    ];

    public function interviewers(): BelongsToMany 
    {
        return $this->belongsToMany(Employee::class, 'interviewers', 
        'interview_id',
        'employee_id');
    }
    
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by_id');
    }
}
