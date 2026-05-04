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
        // 1. Video Completion Check
        $paidVideoIds = \App\Models\PaidVideo::where('course_id', $course->id)->pluck('id')->toArray();
        $topicVideoIds = \App\Models\Topic::whereHas('unit.subject', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->whereNotNull('video_id')->pluck('id')->map(fn($id) => $id + 1000000)->toArray();

        $allRequiredVideoIds = array_merge($paidVideoIds, $topicVideoIds);

        if (!empty($allRequiredVideoIds)) {
            $completedCount = \App\Models\VideoCompletion::where('user_id', $this->id)
                ->whereIn('video_id', $allRequiredVideoIds)
                ->where('is_completed', true)
                ->count();

            if ($completedCount < count($allRequiredVideoIds)) {
                return false;
            }
        }

        // 2. Exam Completion Check (only for subjects that HAVE MCQs)
        $examSubjects = \App\Models\CourseSubject::where('course_id', $course->id)->whereHas('mcqs')->get();
        
        if ($examSubjects->isEmpty()) {
            return true;
        }

        $passedCount = \App\Models\ExamResult::where('user_id', $this->id)
            ->whereIn('course_subject_id', $examSubjects->pluck('id'))
            ->where('status', 'pass')
            ->pluck('course_subject_id')
            ->unique()
            ->count();

        return ($passedCount >= $examSubjects->count());
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
