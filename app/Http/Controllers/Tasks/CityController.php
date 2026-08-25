<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\City;

class CityController extends Controller
{
	public function index()
	{
		$data['cities'] = City::orderBy('name', 'ASC')->get();
		return view('user.tasks.cities.manage-cities', $data);
	}

	public function showAddForm()
	{
		return view('user.tasks.cities.add-city');
	}

	public function saveAirline(Request $req)
	{
		$validator = Validator::make(Input::all(), [
            'name'  => 'required',
			'code' 	=> 'required',
		]);

		if ($validator->fails()) {
			Session::flash("error-msg", $validator->messages()->first());
			return redirect()->back()->withInput(Input::all());
		}

		if (!is_null($req->id)) {
			$c    = City::where('id', $req->id)->first();
		}else{
			$c    = New City;
		}

        $c->name       = $req->name;
		$c->code       = strtoupper($req->code);
		$isSave        = $c->save();

		if ($isSave) {
			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->to('admin/manage-cities');
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['city'] = City::where('id', $id)->first();
		return view('user.tasks.cities.add-city', $data);
	}
}
