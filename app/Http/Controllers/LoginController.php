<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; //Used for creating local rules (Checking blocked users)
use Validator;
use DB;
use App\Rules\UserPassword;


class LoginController extends Controller
{
	public function __construct()
	{

	}

	public function index() 
	{
		return view('dashboard.login');
	}

	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'password' => 'required',			
			'email' => [
				'required',
				'email', 
				//exists:users will automatically look for the input inside the table users and column email
				'exists:users' ,
			],
		],[
			'email.required' => 'Insira um e-mail válido.',
			'email.exists' => 'Usuário ou senha não conferem.',
		])->validate();		

		
		// Not using User Model here because the password is configured as hidden inside the model and I need to validate it.
		$user = DB::table('users')->where(['email' => request('email')])->get()->first();
		$request['passwords'] = array('db' => $user->password, 'request' => request('password'));		
		$validator = Validator::make($request->all(), ['passwords' => [new UserPassword],])->validate();

		// Validate Blocked Users
		$validator = Validator::make($request->all(), [
			'email' => [
				Rule::exists('users')->where(function ($query) {
					$query->where('blocked', '0');
				}),
			],
		],[
			'email.exists' => 'Você não está autorizado a entrar no sistema, fale com o administrador.',
		])->validate();                


		return redirect('dashboard');
	}
}
