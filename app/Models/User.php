<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\StudentStatus;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => StudentStatus::class,
        ];
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')->using(Enrollment::class)->withPivot('enrolled_at')->as('enrollment');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function scopeStudents(Builder $query)
    {
        $query->where('role', 'student');
    }

    public function scopeSearch(Builder $query, ?string $text)
    {
        if ($text) {
            $query->where(function ($q) use ($text) {
                $q->where('name', 'like', "%$text%")
                    ->orWhere('email', 'like', "%$text%");
            });
        }
    }

    public function scopeStatus(Builder $query, ?string $status)
    {
        if ($status) {
            $query->where('status', $status);
        }
    }
}
