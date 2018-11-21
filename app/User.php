<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'student_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * relation to role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role () {
        return $this->belongsTo('App\Role', 'role_id');
    }



    /**
     * authorize role
     * @param $roles
     * @return bool
     */
    public function authorizeRole($role)
    {
        return $this->hasRole($role) || abort(401, 'This action is unauthorized.');
    }

    /**
     * check admin role
     * @return bool
     */
    public function isAdmin () {
        return $this->hasRole('Admin');
    }

    /**
     * Check role
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role && $this->role->name == $role;
    }
}
