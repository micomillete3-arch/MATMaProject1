<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   protected $fillable = [
        'fname',
        'lname',
        'contactno',
        'degree_id',
        'user_account_id',
    ];

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class , 'course_student', 'student_id', 'course_id');
    }

    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccounts::class, 'user_account_id');
    }
}
