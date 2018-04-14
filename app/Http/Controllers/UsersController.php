<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Input;
use App\User as User;
use App\Profile as Profile;

class UsersController extends Controller
{
	public function __construct()
	{		
		$this->profiles = Profile::where(['soft_delete' => 0])->orderBy('name', 'ASC')->get();
		$this->tableTitles = [['value' => 'login', 'label' => 'Login'], ['value' => 'profile_id', 'label' => 'Perfil'], ['value' => 'status', 'label' => 'Status'], ['value' => 'updated_at', 'label' => 'Última atualização']];
		$this->input = request()->input();
	}

	public function index() 
	{
		$this->createTableTitles();
		$data = $this->filter();
		$data = $this->sort($data);
		$tableTitles = $this->createTableTitles();
		// appends(request()->input()) will preserve the GET parameters when creating the pagination links
		// https://stackoverflow.com/questions/17159273/laravel-pagination-links-not-including-other-get-parameters#answer-38556505
		return view('users.index', ['data' => $data->appends($this->input), 'search' => $this->input, 'profiles' => $this->profiles, 'tableTitles' => $tableTitles ]);
	}	

	public function create() 
	{
		return view('users.create', ['profiles' => $this->profiles]);
	}

	public function store(Request $request)
	{		
		$validator = Validator::make($request->all(), [
			'login' => 'required|alpha_dash|unique:users',
			'password' => 'required|min:6',
			'status' => 'required',
			'profile' => 'required',
		],[
			'login.required' => 'Campo login é obrigatório.',
			'login.alpha_dash' => 'O campo login suporta apenas letras, números, - e _.',
			'login.unique' => 'Este login já está sendo utilizado.',
			'password.required' => 'Campo senha é obrigatório.',
			'password.min' => 'Senha deve ter no mínimo 6 caracteres.',
			'status.required' => 'Campo status é obrigatório.',
			'profile.required' => 'Campo perfil é obrigatório.',
		])->validate();

		$user = User::create([
			'login' => $request->login,
			'password' => bcrypt($request->password),
			'status' => $request->status,
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
			'login' => 'required|alpha_dash|unique:users,login,'.$id,			
			'status' => 'required',
			'profile' => 'required',
		],[
			'login.required' => 'Campo login é obrigatório.',
			'login.alpha_dash' => 'O campo login suporta apenas letras, números, - e _.',
			'login.unique' => 'Este login já está sendo utilizado.',			
			'status.required' => 'Campo status é obrigatório.',
			'profile.required' => 'Campo perfil é obrigatório.',
		])->validate();

		$user = User::where(['id' => $id])->update([
			'login' => request()->login,			
			'status' => request()->status,
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

	public function editPassword($id)
	{	
		$user = User::find($id);
		return view('users.editPassword', ['user' => $user, 'profiles' => $this->profiles]);
	}

	public function updatePassword($id)
	{		
		$validator = Validator::make(request()->all(), [			
			'password' => 'required|min:6|confirmed',
		],[			
			'password.required' => 'Campo senha é obrigatório.',
			'password.min' => 'Senha deve ter no mínimo 6 caracteres.',
			'password.confirmed' => 'Senhas não conferem.',
		])->validate();

		$user = User::where(['id' => $id])->update([
			'password' => bcrypt(request()->password),
		]);

		if($user){
			session()->flash('success', 'Senha do usuário atualizado com sucesso.');
			return redirect('usuarios');
		}

	}

	private function filter()
	{
		$data = User::where(['soft_delete' => 0]);

		if (isset($this->input['login'])) {
			$data = $data->where('login', 'like', $this->input['login']."%");
		}

		if (isset($this->input['profile_id'])) {			
			$data = $data->where('profile_id', $this->input['profile_id']);
		}

		if (isset($this->input['status'])) {
			$data = $data->where('status', $this->input['status']);
		}

		return $data;
	}

	private function sort($data)
	{
		if (isset($this->input['sort'])) {
			if (isset($this->input['order']) && ($this->input['order'] == 'asc' || $this->input['order'] == 'desc') ) {
				$data = $data->orderBy($this->input['sort'], $this->input['order']);
			} else {
				$data = $data->orderBy($this->input['sort'], 'asc');
			}
		} else {
			$data = $data->orderBy('created_at', 'DESC');
		}
		$data = $data->paginate(15);
		return $data;
	}

	private function createSortLink()
	{
		$sortLink = "?";

		if (isset($this->input['login'])) {
			$sortLink .= 'login=' . $this->input['login'] . '&';
		}

		if (isset($this->input['profile_id'])) {
			$sortLink .= 'profile_id=' . $this->input['profile_id'] . '&';
		}

		if (isset($this->input['status'])) {
			$sortLink .= 'status=' . $this->input['status'] . '&';
		}

		return $sortLink;
	}

	private function createTableTitles()
	{
		$tableTitles = [];
		$sortLink = $this->createSortLink();		

		foreach($this->tableTitles as $t){
			if (isset($this->input['sort'])) {
				if ($this->input['sort'] == $t['value']) {
					if (isset($this->input['order'])) {
						$link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order='. (($this->input['order'] == 'asc') ? 'desc ' : 'asc') . '">' . $t['label'] .'</a> <i class="fa fa-chevron-' . (($this->input['order'] == 'asc') ? 'up' : 'down') . '"></i>';						
					} else {
						$link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order=asc' . '">' . $t['label'] .'</a> <i class="fa fa-chevron-up"></i>';
					}
				} else {
					$link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order=asc' . '">' . $t['label'] .'</a>';					
				}
			} else {
				$link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order=asc' . '">' . $t['label'] .'</a>';				
			}
			$tableTitles[] = $link;			
		}

		return $tableTitles;
	}
}
