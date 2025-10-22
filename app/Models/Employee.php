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

   public function candidates(): HasMany
   {
    return $this->hasMany(Candidate::class);
   }

   
   public function scopeStatus($query, $status)
   {
    return $query->where('status', $status); // SELECT * FROM employees WHERE status = $status 
   }
   protected $fillable = [
        'name',
        'email',
        'password', 
    ];

   
}
