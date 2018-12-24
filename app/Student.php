<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'student_group_id'
    ];

    /*****************
     * Model Relations
     ****************/

    /**
     * get student enrollments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments () {
        return $this->hasMany('App\CourseEnrollment', 'student_id');
    }

    /**
     * get courses that student enrolled in
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function courses () {

        return $this->hasManyThrough(
            'App\Course',
            'App\CourseEnrollment',
            'student_id',
            'id',
            'id',
            'course_id'
        );

    }

    /**
     * get student group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group () {
        return $this->belongsTo('App\StudentGroup', 'student_group_id');
    }

    /**
     * get student account
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account () {
        return $this->hasOne('App\User', 'student_id');
    }

    /**
     * get student points
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points () {
        return $this->hasMany('App\Point', 'student_id');
    }

    /****************************
     * Attributes for model
     ****************************/

    /**
     * get course count
     * @return int
     */
    public function getCoursesCountAttribute () {
        return $this->courses()->count();
    }

    /**
     * get enrollments count
     * @return int
     */
    public function getEnrollmentsCountAttribute () {
        return $this->enrollments()->count();
    }

    /**
     * get full name of student
     * @return string
     */
    public function getFullNameAttribute () {
        return $this->first_name." ".$this->last_name;
    }



    /**
     * Boot function
     */
    public static function boot() {
        parent::boot();

        /**
         * Delete related records
         */
        static::deleting(function($student) {
            $student->enrollments()->delete();
            $student->account()->delete();
            $student->points()->delete();
        });
    }
}
