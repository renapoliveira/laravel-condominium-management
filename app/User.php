<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password', 'status', 'profile_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        // The belongsTo relationship allows you to define a default model that will be returned if the given relationship is null. This pattern is often referred to as the Null Object pattern and can help remove conditional checks in your code.
        // https://laravel.com/docs/5.6/eloquent-relationships#one-to-one
        return $this->belongsTo('App\Profile', 'profile_id', 'id')->withDefault();        
    }
}
