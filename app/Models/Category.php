<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = ['name', 'created_by' ];

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionBank::class);
    }
}
