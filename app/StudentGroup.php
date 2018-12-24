<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * get students in group
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students () {
        return $this->hasMany('App\Student', 'student_group_id');
    }

    /**
     * get group points
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points () {
        return $this->hasMany('App\Points', 'student_group_id');
    }

    public static function boot() {
        parent::boot();

        /**
         * Delete related records
         */
        static::deleting(function($student_group) {
            $student_group->students()->delete();
        });
    }
}
