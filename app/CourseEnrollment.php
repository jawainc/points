<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'course_id',
        'student_id',
    ];

    /*****************
     * Model Relations
     ****************/

    /**
     * get course that owned this enrollment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course () {
        return $this->belongsTo('App\Course', 'course_id');
    }

    /**
     * get student that owned this enrollment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student () {
        return $this->belongsTo('App\Student', 'student_id');
    }

    /**
     * get student points for course enrollment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points () {
        return $this->hasMany('App\Point', 'course_enrollment_id');
    }

    /**
     * get course sections for enrollment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function course_sections () {

        return $this->hasManyThrough(
            'App\CourseSection',
            'App\Course',
            'id',
            'course_id',
            'id'

        );

    }



    /**
     * get numbers for enrollment
     *
     * @return array
     */
    public function points_calculations () {

        $sections = $this->course_sections()->count();

        if ($sections > 0) {
            $points_count = $this->points()->count();
            $points_hours = $this->points()->sum('hours');
            $points_points = $this->points()->sum('points');
            $percent = intval(($points_count/$sections)*100);
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


    /**
     * Boot function
     */
    public static function boot() {
        parent::boot();

        /**
         * Delete related records
         */
        static::deleting(function($enrollment) {
            $enrollment->points()->delete();
        });
    }
}
