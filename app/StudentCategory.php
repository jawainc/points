<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * get students in category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students () {
        return $this->hasMany('App\Student', 'student_category_id');
    }


    public static function boot() {
        parent::boot();

        /**
         * Delete related records
         */
        static::deleting(function($student_category) {
            $student_category->students()->delete();
        });
    }
}
