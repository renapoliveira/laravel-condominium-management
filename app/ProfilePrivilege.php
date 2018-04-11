<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilePrivilege extends Model
{
	protected $table = 'profiles_privileges';

	protected $fillable = [
		'profile_id', 'privilege_id'
	];
	
}
