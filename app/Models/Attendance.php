<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'status' => AttendanceStatus::class,
        ];
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
