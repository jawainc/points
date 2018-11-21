<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'course_id',
        'name',
        'details'
    ];


    /*****************
     * Model Relations
     ****************/

    /**
     * get course that owns this section
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course () {
        return $this->belongsTo('App\Course', 'course_id');
    }

    /**
     * get points for section
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points () {
        return $this->hasMany('App\Point', 'course_section_id');
    }


    /**
     * Boot function
     */
    public static function boot() {
        parent::boot();

        /**
         * Delete related records
         */
        static::deleting(function($section) {
            $section->points()->delete();
        });
    }
}
