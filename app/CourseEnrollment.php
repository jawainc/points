<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class CourseEnrollment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'course_id',
        'student_id',
        'start_date'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date'
    ];

    /**
     * scope query where students can only start course
     * @param $query
     * @return mixed
     */
    public function scopeCanStartCourse ($query) {
        return $query->whereDate('start_date', '>=', Carbon::now());
    }

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
