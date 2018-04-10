<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; //Used for creating local rules (Checking blocked users)
use Validator;
use DB;
use App\Rules\UserPassword;
use App\Services\SessionService;


class LoginController extends Controller
{
	public function __construct()
	{
		$this->sessionService = new SessionService;
	}

	public function index() 
	{
		return view('dashboard.login');
	}

	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'password' => 'required',			
			'login' => [
				'required',				
				//exists:users will automatically look for the input inside the table users and column login
				'exists:users' ,
			],
		],[
			'login.required' => 'Campo login é obrigatório.',
			'login.exists' => 'Usuário ou senha não conferem.',
		])->validate();		

		
		// Not using User Model here because the password is configured as hidden inside the model and I need to validate it.
		$user = DB::table('users')->where(['login' => request('login')])->get()->first();
		$request['passwords'] = array('db' => $user->password, 'request' => request('password'));		
		$validator = Validator::make($request->all(), ['passwords' => [new UserPassword],])->validate();

		// Validate Blocked Users
		$validator = Validator::make($request->all(), [
			'login' => [
				Rule::exists('users')->where(function ($query) {
					$query->where('blocked', '0');
				}),
			],
		],[
			'login.exists' => 'Você não está autorizado a entrar no sistema, fale com o administrador.',
		])->validate();                

		$this->sessionService->login($user);
		return redirect('dashboard');
	}

	public function logout()
	{
		$this->sessionService->logout();
		return redirect('login');
	}
}
