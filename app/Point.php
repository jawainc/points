<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'course_id',
        'course_enrollment_id',
        'course_section_id',
        'student_id',
        'student_group_id',
        'points',
        'hours',
        'minutes'
    ];



    /*****************
     * Model Relations
     ****************/

    /**
     * get course section
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course_section ()
    {
        return $this->belongsTo('App\CourseSection', 'course_section_id');
    }

    /**
     * get student
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student ()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }

    /**
     * get student enrollment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enrollment ()
    {
        return $this->belongsTo('App\CourseEnrollment', 'course_enrollment_id');
    }

    /**
     * get course
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course ()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }

    /**
     * get student group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group ()
    {
        return $this->belongsTo('App\StudentGroup', 'student_group_id');
    }

    /**
     * get hours + minutes for single entry
     *
     * @return string
     */
    public function getTotalHoursAttribute()
    {
        return  $this->hours .".". $this->minutes;
    }

}
