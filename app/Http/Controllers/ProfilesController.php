<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Services\PrivilegeService;
use App\Profile as Profile;
use App\ProfilePrivilege as ProfilePrivilege;
use App\Services\MainService;


class ProfilesController extends Controller
{
	function __construct() 
	{
		$this->privilegeService = new PrivilegeService;
		$this->tableTitles = [
			['value' => 'name', 'label' => 'Nome'], 
			['value' => 'updated_at', 'label' => 'Última atualização']
		];
		$this->input = request()->input();
		$this->mainService = new mainService($this->createSortLink(), $this->tableTitles, $this->input);
	}

	public function index() 
	{	
		$data = $this->filter();
		$data = $this->mainService->sort($data);
		$tableTitles = $this->mainService->createTableHeader();
		return view('profiles.index', ['data' => $data->appends($this->input), 'search' => $this->input, 'tableTitles' => $tableTitles ]);
	}

	public function create() 
	{
		$privileges = $this->privilegeService->getPrivileges();
		return view('profiles.create', ['privileges' => $privileges]);
	}

	public function store(Request $request)
	{		
		$validator = Validator::make($request->all(), [
			'name' => 'required|min:2',					
		],[
			'name.required' => 'Campo nome é obrigatório',
			'name.min' => 'Insira no mínimo 2 caracteres no campo nome',
		])->validate();
				
		$profile = Profile::create([
			'name' => $request->name			
		]);

		if ($profile->id) {
			if (! empty($request->privileges)) {
				foreach ($request->privileges as $p) {
					ProfilePrivilege::create([
						'profile_id' => $profile->id, 
						'privilege_id' => $p
					]);					
				}
			}
		}

		session()->flash('success', 'Perfil cadastrado com sucesso.');
		return redirect('perfis');

	}

	public function show($id)
	{	
		$profile = Profile::find($id);
		
		$privileges = $this->privilegeService->getPrivileges();

		$profilesPrivileges = [];
		foreach ($profile->privileges as $p) {			
			$profilesPrivileges[] = $p->privilege_id;
		}		
		
		return view('profiles.show', ['profile' => $profile, 'privileges' => $privileges, 'profilesPrivileges' => $profilesPrivileges]);
	}

	public function edit($id) 
	{
		$profile = Profile::find($id);		
		
		$privileges = $this->privilegeService->getPrivileges();

		$profilesPrivileges = [];
		foreach ($profile->privileges as $p) {			
			$profilesPrivileges[] = $p->privilege_id;
		}		
		
		return view('profiles.edit', ['profile' => $profile, 'privileges' => $privileges, 'profilesPrivileges' => $profilesPrivileges]);
	}

	public function update($id) 
	{
		$validator = Validator::make(request()->all(), [
			'name' => 'required|min:2',					
		],[
			'name.required' => 'Campo nome é obrigatório',
			'name.min' => 'Insira no mínimo 2 caracteres no campo nome',
		])->validate();
		
		Profile::where(['id'=> request()->id])->update(['name' => request()->name]);
		ProfilePrivilege::where(['profile_id' => request()->id])->delete();		
		
		if (! empty(request()->privileges)) {
			foreach (request()->privileges as $p) {
				ProfilePrivilege::create([
					'profile_id' => request()->id,
					'privilege_id' => $p
				]);				
			}
		}

		session()->flash('success', 'Perfil atualizado com sucesso.');
		return redirect('perfis');
	}

	public function destroy($id) 
	{
		Profile::where(['id'=> $id])->update(['soft_delete' => 1]);
		session()->flash('success', 'Perfil removido com sucesso.');
		return redirect('perfis');
	}

	private function filter()
	{
		$data = Profile::where(['soft_delete' => 0]);

		if (isset($this->input['name'])) {
			$data = $data->where('name', 'like', $this->input['name']."%");
		}		

		return $data;
	}	

	private function createSortLink()
	{
		$sortLink = "?";

		if (isset($this->input['name'])) {
			$sortLink .= 'name=' . $this->input['name'] . '&';
		}		

		return $sortLink;
	}	

}
