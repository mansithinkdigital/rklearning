<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Course;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'mother_name',
        'father_name',
        'email',
        'phone',
        'address',
        'branch_id',
        'password',
        'role',
        'image',
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
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->withPivot('id', 'payment_method', 'amount', 'status', 'certificate_no')
            ->withTimestamps();
    }

    public function checkCourseCompletion($course)
    {
        // 1. If a certificate number is already assigned in the pivot table, the course is officially completed.
        if (isset($course->pivot) && $course->pivot->certificate_no) {
            return true;
        }

        // 2. Check if the student has passed at least one subject exam for this course (matching dashboard logic).
        $hasPassedExam = \App\Models\ExamResult::where('user_id', $this->id)
            ->where('status', 'pass')
            ->whereHas('courseSubject', function($q) use ($course) {
                $q->where('course_id', $course->id);
            })->exists();

        if ($hasPassedExam) {
            return true;
        }

        // 3. Fallback for courses without exams: check video completion.
        $paidVideoIds = \App\Models\PaidVideo::where('course_id', $course->id)
            ->whereNotNull('video_id')
            ->where('video_id', '!=', '')
            ->pluck('video_id')
            ->toArray();
            
        $topicVideoIds = \App\Models\Topic::whereHas('unit.subject', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })
            ->whereNotNull('video_id')
            ->where('video_id', '!=', '')
            ->pluck('video_id')
            ->toArray();

        $allRequiredVideoIds = array_values(array_unique(array_merge($paidVideoIds, $topicVideoIds)));

        if (!empty($allRequiredVideoIds)) {
            $completedCount = \App\Models\VideoCompletion::where('user_id', $this->id)
                ->whereIn('video_id', $allRequiredVideoIds)
                ->where('is_completed', true)
                ->count();

            return ($completedCount >= count($allRequiredVideoIds));
        }

        return true;
    }

    public function hasCompletedAnyCourse()
    {
        foreach ($this->courses()->wherePivot('status', 'approved')->get() as $course) {
            if ($this->checkCourseCompletion($course)) {
                return true;
            }
        }
        return false;
    }
}
