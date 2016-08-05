<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public function roles()
	{
	    return $this->belongsToMany(Role::class);
	}

	public function chindren(){
		return $this->hasMany(Permission::class, 'pid', 'id');
	}
}
