<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student')->withPivot('enrolled_at');
    }
}
