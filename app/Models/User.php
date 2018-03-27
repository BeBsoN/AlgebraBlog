<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
 /**
     * Get the posts of user, 1 user ima više postova .. onetomany relation
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
	
	
	
}
