<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'course_id' => 'integer',
            'grade' => 'string',
            'year' => 'integer',
        ];
    }

    protected $fillable = [
        'student_id',
        'course_id',
        'notes',
        'grade_value',
        'year',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeStudent(Builder $query, ?string $student_id)
    {
        if ($student_id) {
            $query->where('student_id', $student_id);
        }
    }

    public function scopeCourse(Builder $query, ?string $course_id)
    {
        if ($course_id) {
            $query->where('course_id', $course_id);
        }
    }

    public function scopecourseTitle(Builder $query, ?string $course_title)
    {
        if ($course_title) {
            $query->withWhereHas('course', function ($query) use ($course_title) {
                $query->where('title', 'like', "%$course_title%");
            });
        } else {
            $query->with('course');
        }
    }

    protected static function booted(): void
    {
        static::creating(function (Grade $grade) {
            $grade->year ??= now()->year;
        });
    }
}
