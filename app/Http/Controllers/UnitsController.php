<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use Validator;

class UnitsController extends Controller
{
    function __construct() 
	{	

	}

	public function index() 
	{
		$data = Unit::find(1);		
		return view('units.index', ['data' => $data]);
	}

	public function store()
	{
		$validator = Validator::make(request()->all(), [
			'units' => 'required|integer',					
			'floors' => 'required|integer',					
			'apartments' => 'required|integer',					
		],[
			'units.required' => 'Campo unidades é obrigatório',
			'units.integer' => 'Campo unidades deve ser um número',
			'floors.required' => 'Campo andares é obrigatório',
			'floors.integer' => 'Campo andares deve ser um número',
			'apartments.required' => 'Campo apartamentos é obrigatório',
			'apartments.integer' => 'Campo apartamentos deve ser um número',
		])->validate();

		if ( Unit::find(1) ) {
			$unit = Unit::where(['id' => 1])->update([
				'units' => request()->units,
				'floors' => request()->floors,
				'apartments' => request()->apartments
			]);			
		} else {
			$unit = Unit::create([
				'units' => request()->units,
				'floors' => request()->floors,
				'apartments' => request()->apartments,
			]);
		}

		if($unit){
			session()->flash('success', 'Blocos cadastrados com sucesso.');
			return redirect('blocos');
		}		

	}
}
