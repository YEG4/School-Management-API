<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'status',
        'check_in_at',
        'check_out_at',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'status' => AttendanceStatus::class,
        ];
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function scopeStudentId(Builder $query, ?int $student_id)
    {
        if ($student_id) {
            $query->where('student_id', $student_id);
        }
    }

    public function scopeDateRange(Builder $query, ?string $start_date, ?string $end_date)
    {
        if ($start_date && $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
        } elseif ($start_date && ! $end_date) {
            $query->where('date', '>=', $start_date);
        } elseif (! $start_date && $end_date) {
            $query->where('date', '<=', $end_date);
        }
    }
}
