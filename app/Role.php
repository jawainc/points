<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /*****************
     * Model Relations
     ****************/

    /**
     * get role users
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'role_id');
    }
}