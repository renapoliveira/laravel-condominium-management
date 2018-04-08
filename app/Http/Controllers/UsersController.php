<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->profiles = DB::table('profiles')->where(['soft_delete' => 0])->orderBy('name', 'ASC')->get();
	}

	public function index() 
	{		
		$data = DB::table('users')->where(['soft_delete' => 0])->orderBy('created_at', 'DESC')->get();
		return view('users.index', ['data' => $data]);
	}

	public function create() 
	{
		return view('users.create', ['profiles' => $this->profiles]);
	}
}
