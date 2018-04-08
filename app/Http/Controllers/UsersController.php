<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
	public function index() 
	{		
		$data = DB::table('users')->where(['soft_delete' => 0])->orderBy('created_at', 'DESC')->get();
		return view('users.index', ['data' => $data]);
	}
}
