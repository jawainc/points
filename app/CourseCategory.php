<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * get the courses belongs to category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses () {
        return $this->hasMany('App\Course', 'course_category_id');
    }
}
