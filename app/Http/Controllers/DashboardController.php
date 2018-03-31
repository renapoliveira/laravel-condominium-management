<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	function __construct() 
	{

	}

	public function index() 
	{
		return view('dashboard.index');
	}
}
