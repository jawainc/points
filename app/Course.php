<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'course_category_id'
    ];

    /**
     * get the category that owns the course
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course_category () {
        return $this->belongsTo('App\CourseCategory');
    }

    /**
     * get course enrollments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments () {
        return $this->hasMany('App\CourseEnrollment', 'course_id');
    }

    /**
     * get course sections
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections () {
        return $this->hasMany('App\CourseSection', 'course_id');
    }

    /**
     * get students enrolled in course
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function students () {
        return $this->hasManyThrough(
            'App\Student',
            'App\CourseEnrollment',
            'course_id',
            'id',
            'id',
            'student_id'
        );
    }

    /**
     * calculate percentage for student course
     *
     * @param $student_id
     * @param $course_id
     * @return array
     */
    public function percentage_complete ($student_id, $course_id) {
        $sections = CourseSection::where('course_id', $course_id)->count();
        $enrollment = CourseEnrollment::where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->first();

        if ($enrollment && $sections) {
            $points_count = Point::where('course_enrollment_id', $enrollment->id)->count();
            $points_hours = Point::where('course_enrollment_id', $enrollment->id)->sum('hours');
            $points_minutes = Point::where('course_enrollment_id', $enrollment->id)->sum('minutes');
            $points_points = Point::where('course_enrollment_id', $enrollment->id)->sum('points');
            $percent = intval(($points_count/$sections)*100);

            $t_minutes = ($points_minutes) % 60;
            $t_hours = ($points_minutes - $t_minutes) / 60;
            $total_hours = $points_hours + $t_hours;
            $points_hours =  $total_hours .".". $t_minutes;

            return [
                'percent' => $percent,
                'hours' => $points_hours,
                'points' => $points_points,
            ];
        }

        return [
            'percent' => 0,
            'hours' => 0,
            'points' => 0,
        ];
    }
}
