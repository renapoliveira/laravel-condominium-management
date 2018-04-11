<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name'
    ];

    public function privileges()
    {        
        return $this->hasMany('App\ProfilePrivilege', 'profile_id', 'id');
    }
}
