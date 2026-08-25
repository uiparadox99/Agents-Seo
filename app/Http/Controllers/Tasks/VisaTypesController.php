<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\VisaTypes;

class VisaTypesController extends Controller
{
	public function __construct()
	{
		$this->airlines  = storage_path("uploads/airlines");
	}

	public function index()
	{
		$data['types'] = VisaTypes::orderBy('name', 'ASC')->get();
		return view('user.tasks.VisaType.manage-types', $data);
	}

	public function showAddForm()
	{
		return view('user.tasks.VisaType.add-type');
	}

	public function saveForm(Request $req)
	{
		$validator = Validator::make(Input::all(), [
			'name' 	=> 'required',
		]);

		if ($validator->fails()) {
			Session::flash("error-msg", $validator->messages()->first());
			return redirect()->back()->withInput(Input::all());
		}

		if (!is_null($req->id)) {
            $a    = VisaTypes::where('id', $req->id)->first();
        }else{
            $a    = New VisaTypes;
        }

		$a->name       = $req->name;


		$isSave         = $a->save();

		if ($isSave) {
			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->to('admin/manage-visa-type');
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['detail'] = VisaTypes::where('id', $id)->first();
		return view('user.tasks.VisaType.add-type', $data);
	}
}
