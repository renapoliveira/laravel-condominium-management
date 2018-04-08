<?php

namespace App\Services;

use App\Http\Controllers\Controller;

class SessionService extends Controller
{

    /*
    *      Login user
    */
    public function login($user)
    {
        session(['logged' => true, 'user' => ['id' => $user->id, 'email' => $user->email, 'profile' => $user->profile] ]);
    }

    /*
    *      Logout user
    */
    public function logout()
    {
        session()->pull('logged');
        session()->pull('user');
    }

    public function getUser()
    {
        return session()->get('user');
    }

    public function set($key, $val)
    {
        session([$key => $val]);
    }

    public function get($key)
    {
        return session()->get($key);
    }    

}
