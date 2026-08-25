<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use  App\Airlines as Airline;

class AirlineController extends Controller
{
	public function __construct()
	{
		$this->airlines  = storage_path("uploads/airlines");
	}

	public function index()
	{
		$data['airlines'] = Airline::orderBy('name', 'ASC')->get();
		return view('user.tasks.airlines.manage-airlines', $data);
	}

	public function showAddForm()
	{
		return view('user.tasks.airlines.add-airline');
	}

	public function saveAirline(Request $req)
	{
		$validator = Validator::make(Input::all(), [
			'name' 	=> 'required',
			'code' 	=> 'required',
		]);

		if ($validator->fails()) {
			Session::flash("error-msg", $validator->messages()->first());
			return redirect()->back()->withInput(Input::all());
		}

		if (!is_null($req->id)) {
            $a    = Airline::where('id', $req->id)->first();
        }else{
            $a    = New Airline;
        }

		$a->name       = $req->name;
		$a->code       = $req->code;

		if (Input::hasFile("img") && Input::file('img')->isValid()) {
			$filename   = Input::file('img')->getClientOriginalName();
			$a->logo    = $filename;
			Input::file('img')->move($this->airlines, $filename);
		}

		$isSave         = $a->save();

		if ($isSave) {
			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->to('admin/manage-airlines');
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['airline'] = Airline::where('id', $id)->first();
		return view('user.tasks.airlines.add-airline', $data);
	}
}
