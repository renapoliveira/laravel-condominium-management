<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrivilegeService;
use DB;
use Validator;
use App\Profile as Profile;
use App\ProfilePrivilege as ProfilePrivilege;


class ProfilesController extends Controller
{
	function __construct() 
	{
		$this->privilegeService = new PrivilegeService;
	}

	public function index() 
	{		
		$data = Profile::where(['soft_delete' => 0])->orderBy('created_at', 'DESC')->get();
		return view('profiles.index', ['data' => $data]);
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
		
		// $profileId = DB::table('profiles')->insertGetId(['name'=> $request->name, 'created_at' => date('Y-m-d H:i:s')]);
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
		$profile = Profile::find($id)->first();		
		
		$privileges = $this->privilegeService->getPrivileges();

		$profilesPrivileges = [];
		foreach ($profile->privileges as $p) {			
			$profilesPrivileges[] = $p->privilege_id;
		}		
		
		return view('profiles.show', ['profile' => $profile, 'privileges' => $privileges, 'profilesPrivileges' => $profilesPrivileges]);
	}

	public function edit($id) 
	{
		$profile = Profile::find($id)->first();		
		
		$privileges = $this->privilegeService->getPrivileges();

		$profilesPrivileges = [];
		foreach ($profile->privileges as $p) {			
			$profilesPrivileges[] = $p->privilege_id;
		}		
		
		return view('profiles.edit', ['profile' => $profile, 'privileges' => $privileges, 'profilesPrivileges' => $profilesPrivileges]);
	}

	public function update(Request $request) 
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|min:2',					
		],[
			'name.required' => 'Campo nome é obrigatório',
			'name.min' => 'Insira no mínimo 2 caracteres no campo nome',
		])->validate();
		
		Profile::where(['id'=> $request->id])->update(['name' => $request->name]);
		ProfilePrivilege::where(['profile_id' => $request->id])->delete();		
		
		if (! empty($request->privileges)) {
			foreach ($request->privileges as $p) {
				ProfilePrivilege::create([
					'profile_id' => $request->id,  
					'privilege_id' => $p
				]);				
			}
		}

		session()->flash('success', 'Perfil atualizado com sucesso.');
		return redirect('perfis');
	}

	public function destroy($id) 
	{
		Profile::where(['id'=> $id])->update(['soft_delete' => 1, 'updated_at' => date('Y-m-d H:i:s')]);		
		session()->flash('success', 'Perfil removido com sucesso.');
		return redirect('perfis');
	}

}
