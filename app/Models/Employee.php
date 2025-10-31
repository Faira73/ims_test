<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Authenticatable
{
   protected $table = 'employees';
    protected $fillable = [
            'name',
            'email',
            'password', 
        ];

   public function candidates(): HasMany
   {
    return $this->hasMany(Candidate::class);
   }

   public function scopeStatus($query, $status)
   {
    return $query->where('status', $status); // SELECT * FROM employees WHERE status = $status 
   }

   public function evaluations()
   {
    return $this->hasMany(Evaluation::class, 'evaluator_id');
   }

   public function interviews()
   {
    return $this->belongsToMany(Interview::class, 'interviewers',
     'employee_id',
     'interview_id');
   }
   
}
