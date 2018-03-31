<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilesController extends Controller
{
   function __construct() 
	{

	}

	public function index() 
	{
		return view('dashboard.profiles');
	}
}
