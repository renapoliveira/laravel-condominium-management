<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrivilegeService;
use DB;
use Validator;


class ProfilesController extends Controller
{
	function __construct() 
	{
		$this->privilegeService = new PrivilegeService;
	}

	public function index() 
	{
		$data = DB::table('profiles')->where(['soft_delete' => 0])->orderBy('created_at', 'DESC')->get();
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
		
		$profileId = DB::table('profiles')->insertGetId(['name'=> $request->name, 'created_at' => date('Y-m-d H:i:s')]);

		if ($profileId) {
			if (! empty($request->privileges)) {
				foreach ($request->privileges as $p) {
					DB::table('profiles_privileges')->insert(['profile' => $profileId, 'privilege' => $p, 'created_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		session()->flash('success', 'Perfil cadastrado com sucesso.');
		return redirect('perfis');

	}

	public function show($id)
	{		
		$profile = DB::table('profiles')->where(['id' => $id])->get();
		$privileges = $this->privilegeService->getPrivileges();
		$profilesPrivileges = DB::table('profiles_privileges')->where(['profile' => $id])->get();		

		$insertedProfilesPrivileges = [];
		foreach ($profilesPrivileges as $p) {
			$insertedProfilesPrivileges[] = $p->privilege;
		}		
		
		return view('profiles.show', ['profile' => $profile[0], 'privileges' => $privileges, 'profilesPrivileges' => $insertedProfilesPrivileges]);
	}

	public function edit($id) 
	{
		$profile = DB::table('profiles')->where(['id' => $id])->get();
		$privileges = $this->privilegeService->getPrivileges();
		$profilesPrivileges = DB::table('profiles_privileges')->where(['profile' => $id])->get();		

		$insertedProfilesPrivileges = [];
		foreach ($profilesPrivileges as $p) {
			$insertedProfilesPrivileges[] = $p->privilege;
		}		
		
		return view('profiles.edit', ['profile' => $profile[0], 'privileges' => $privileges, 'profilesPrivileges' => $insertedProfilesPrivileges]);
	}

	public function update(Request $request) 
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|min:2',					
		],[
			'name.required' => 'Campo nome é obrigatório',
			'name.min' => 'Insira no mínimo 2 caracteres no campo nome',
		])->validate();
		
		DB::table('profiles')->where(['id'=> $request->id])->update(['name' => $request->name, 'updated_at' => date('Y-m-d H:i:s')]);

		DB::table('profiles_privileges')->where(['profile' => $request->id])->delete();
		
		if (! empty($request->privileges)) {
			foreach ($request->privileges as $p) {
				DB::table('profiles_privileges')->insert(['profile' => $request->id,  'privilege' => $p, 'created_at' => date('Y-m-d H:i:s')]);
			}
		}

		session()->flash('success', 'Perfil atualizado com sucesso.');
		return redirect('perfis');
	}

	public function destroy($id) 
	{
		DB::table('profiles')->where(['id'=> $id])->update(['soft_delete' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
		session()->flash('success', 'Perfil removido com sucesso.');
		return redirect('perfis');
	}

}
