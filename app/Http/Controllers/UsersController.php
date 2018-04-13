<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\User as User;
use App\Profile as Profile;

class UsersController extends Controller
{
	public function __construct()
	{		
		$this->profiles = Profile::where(['soft_delete' => 0])->orderBy('name', 'ASC')->get();
	}

	public function index() 
	{

		$data = User::where(['soft_delete' => 0])->orderBy('users.created_at', 'DESC')->paginate(15);
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
			'login.required' => 'Campo login é obrigatório.',
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

	public function show($id)
	{		
		$user = User::find($id);
		return view('users.show', ['user' => $user, 'profiles' => $this->profiles]);
	}

	public function edit($id)
	{	
		$user = User::find($id);
		return view('users.edit', ['user' => $user, 'profiles' => $this->profiles]);
	}

	public function update($id)
	{		
		$validator = Validator::make(request()->all(), [
			'login' => 'required|unique:users,login,'.$id,			
			'blocked' => 'required',
			'profile' => 'required',
		],[
			'login.required' => 'Campo login é obrigatório.',
			'login.unique' => 'Este login já está sendo utilizado.',			
			'blocked.required' => 'Campo status é obrigatório.',
			'profile.required' => 'Campo perfil é obrigatório.',
		])->validate();

		$user = User::where(['id' => $id])->update([
			'login' => request()->login,			
			'blocked' => request()->blocked,		
			'profile_id' => request()->profile
		]);

		if($user){
			session()->flash('success', 'Usuário atualizado com sucesso.');
			return redirect('usuarios');
		}

	}

	public function destroy($id) 
	{
		User::where(['id'=> $id])->update(['soft_delete' => 1]);		
		session()->flash('success', 'Usuário removido com sucesso.');
		return redirect('usuarios');
	}
}
