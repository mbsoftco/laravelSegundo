<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRoles extends Model
{



	public function admins()
	{
	  return $this->belongsToMany(Admin::class);
	}

}
