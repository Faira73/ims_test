<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
   protected $table = 'candidates';

   public function employee(): BelongsTo //class
   {
      return $this->belongsTo(Employee::class, 'created_by_id');
   }

   public function interviews(){
      return $this->hasOne(Interview::class);
   }
   protected $fillable = [
    'name',
    'email',
    'phone',
    'position',
    'resume_url',
    'created_by_id' , 
    'years_experience'
   ];
}