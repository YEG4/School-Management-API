<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'code',
        'hours',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')->using(Enrollment::class)->withPivot('enrolled_at')->as('enrollment');
    }
}
