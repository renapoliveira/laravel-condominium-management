<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\User;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->profiles = DB::table('profiles')->where(['soft_delete' => 0])->orderBy('name', 'ASC')->get();
	}

	public function index() 
	{
		$data = DB::table('users')
		->select('users.id as id', 'users.login as login', 'users.profile as profile', 'users.blocked as blocked', 'users.created_at as created_at', 'users.updated_at as updated_at', 'profiles.name as profile_name')
		->leftJoin('profiles', 'users.profile', '=', 'profiles.id')
		->where(['users.soft_delete' => 0])->orderBy('users.created_at', 'DESC')->get();
		
		return view('users.index', ['data' => $data]);
	}

	public function create() 
	{
		return view('users.create', ['profiles' => $this->profiles]);
	}

	public function store(Request $request)
	{		
		$validator = Validator::make($request->all(), [
			'login' => 'required|unique:users',
			'password' => 'required|min:6',
			'blocked' => 'required',
			'profile' => 'required',
		],[
			'login.required' => 'Campo loginl é obrigatório.',
			'login.unique' => 'Este login já está sendo utilizado.',
			'password.required' => 'Campo senha é obrigatório.',
			'password.min' => 'Senha deve ter no mínimo 6 caracteres.',
			'blocked.required' => 'Campo status é obrigatório.',
			'profile.required' => 'Campo perfil é obrigatório.',
		])->validate();

		$user = User::create([
			'login' => $request->login,
			'password' => bcrypt($request->password),
			'blocked' => $request->blocked,		
			'profile' => $request->profile
		]);

		if($user->id){
			session()->flash('success', 'Usuário cadastrado com sucesso.');
			return redirect('usuarios');
		}

	}
}
