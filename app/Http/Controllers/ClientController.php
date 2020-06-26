<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Sector;
use App\Gender;

class ClientController extends Controller
{
	public function create()
	{
		$Sectors = Sector::get();
		$Genders = Gender::get();
		$action = route('clients.store');
		return view('clients.create',compact('action','Sectors','Genders'));
	}

	public function edit($id)
	{
		$clients = Client::where('id',$id)->first();
		$action = route('clients.update',$id);
		$Sectors = Sector::get();
		$Genders = Gender::get();
		return view('clients.edit',compact('action','clients','Sectors','Genders'));
	}

	public function update(Request $request, $id)
	{
		try {
			$validate = $this->validateForm($request,$id);
			$clients = Client::find($id);
			$clients->names          = $request->input('name');
			$clients->surnames 		 = $request->input('surname');
			$clients->identification = $request->input('ruc');
			$clients->email          = $request->input('email');
			$clients->CellPhone      = $request->input('CellPhone');
			$clients->address        = $request->input('address');
			$clients->update();
			return back()->with('message', 'Cliente actualizado correctamente');
		} catch (Exception $e) {
			report($e);
			return false;
		}

	}

    // function to store clients
	public function store(Request $request)
	{
		try {
			$validate = $this->validateForm($request);
			$clients = new Client();
			$clients->names          = $request->input('name');
			$clients->surnames 		 = $request->input('surname');
			$clients->identification = $request->input('ruc');
			$clients->email          = $request->input('email');
			$clients->CellPhone      = $request->input('CellPhone');
			$clients->address        = $request->input('address');
			$clients->birthdate      = $request->input('birthdate');
			$clients->age            = $request->input('age');
			$clients->sector_id      = $request->input('sector_id');
			$clients->gender         = $request->input('gender');
			$clients->user_id		 = \Auth::user()->id;
			$clients->save();
			return redirect()->route('shop')->with(['message' => 'Cliente Creado Correctamente']);
		} catch (Exception $e) {
			report($e);
			return false;
		}

	}

	public function validateForm($request,$id = ''){

		$validate = $this->validate($request,[
			'name'    	 => 'required|string|max:50',
			'surname'	 => 'required|string|max:50',
			'ruc'     	 => 'required|string|max:15',
			'email'   	 => 'required|string|email|max:255|unique:clients,email,'.$id,
			'CellPhone'	 => 'required|string|max:15',
			'address'	 => 'required|string|max:255',
		]);

	}

	public function getDataClients(Request $request)
	{
		$search = trim($request->input('id_client'));
		$clients = Client::where('identification','LIKE','%'.$search.'%')
		->orderBy('id','asc')
		->get();

		return response()->json($clients);
		//return view('sales.sale',['clients' => $clients]);
	}

	public function calculaEdad(Request $request,$fechanacimiento = "1993-09-01"){
		list($ano,$mes,$dia) = explode("-",$fechanacimiento);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($dia_diferencia < 0 || $mes_diferencia < 0)
			$ano_diferencia--;
		return response()->json(['success'=>1,'edad' => $ano_diferencia]);
	}
}
