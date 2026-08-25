<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\RoomTypes;

class RoomTypesController extends Controller
{
	public function __construct()
	{
		$this->airlines  = storage_path("uploads/airlines");
	}

	public function index()
	{
		$data['rooms'] = RoomTypes::orderBy('name', 'ASC')->get();
		return view('user.tasks.roomType.manage-types', $data);
	}

	public function showAddForm()
	{
		return view('user.tasks.roomType.add-type');
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
            $a    = RoomTypes::where('id', $req->id)->first();
        }else{
            $a    = New RoomTypes;
        }

		$a->name       = $req->name;


		$isSave         = $a->save();

		if ($isSave) {
			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->to('admin/manage-room-type');
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['detail'] = RoomTypes::where('id', $id)->first();
		return view('user.tasks.roomType.add-type', $data);
	}
}
