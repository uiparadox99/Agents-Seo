<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use  App\Airlines as Airline;
use App\TasksModels\Status;

class StatusController extends Controller
{
	public function __construct()
	{
		$this->airlines  = storage_path("uploads/airlines");
	}

	public function index()
	{
		$data['status'] = Status::orderBy('name', 'ASC')->get();
		return view('user.tasks.status.manage-status', $data);
	}

	public function showAddForm()
	{
		return view('user.tasks.status.add-status');
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
            $a    = Status::where('id', $req->id)->first();
        }else{
            $a    = New Status;
        }

		$a->name       = $req->name;
		$a->type       = $req->type;

		

		$isSave         = $a->save();

		if ($isSave) {
			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->to('admin/manage-status');
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['status'] = Status::where('id', $id)->first();
		return view('user.tasks.status.add-status', $data);
	}
}
