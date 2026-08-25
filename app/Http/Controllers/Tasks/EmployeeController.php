<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\Agents;
use App\TasksModels\Permissions;
use App\TasksModels\PermissionHasAdmin;

class EmployeeController extends Controller
{
    public function index()
	{
		$data['admins'] = Agents::where('type','!=','admin')->orderBy('name', 'ASC')->get();
		return view('user.tasks.employees.manage-employees', $data);
	}

	public function showAddForm()
	{
		$data['permissions'] = Permissions::where('status','1')->get();
		return view('user.tasks.employees.add-employee',$data);
	}

	public function saveAirline(Request $req)
	{
		$validator = Validator::make(Input::all(), [
			'name' 		=> 'required|max:255',
            'email' 	=> 'required|email|max:255|'
		]);

		if ($validator->fails()) {
			Session::flash("error-msg", $validator->messages()->first());
			return redirect()->back()->withInput(Input::all());
		}

		if (!is_null($req->id)) {
			PermissionHasAgents::where('admins_id',$req->id)->delete();
			$a    = Agents::where('id', $req->id)->first();
		}else{
			$validator = Validator::make(Input::all(), [
				'password' 	=> 'required|min:6|confirmed'
			]);

			if ($validator->fails()) {
				Session::flash("error-msg", $validator->messages()->first());
				return redirect()->back()->withInput(Input::all());
			}
			$a    = New Admin;
		}

		$a->name 		=  strtoupper($req->name);
		$a->email 		=  $req->email;
		$a->type 		=  'employee';
		$a->visible_password 	=  $req->password;
		$a->password 	=  bcrypt($req->password);
		$isSave			=  $a->save();

		if ($isSave) {
			foreach ($req->permissions as $key => $value) {
				$pa = new PermissionHasAdmin;
				$pa->admins_id = $a->id;
				$pa->permissions_id = $value;
				$pa->save();
			}
		


			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->to('admin/manage-employees');
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['admin'] = Agents::where('id', $id)->first();
		$data['permissions'] = Permissions::where('status','1')->get();
		$oldPermissions = PermissionHasAgents::select('permissions_id')->where('admins_id',$data['admin']->id)->get();
		$addedpermissions = array();
		foreach ($oldPermissions as $key => $value) {
			$addedpermissions[] = $value->permissions_id;
		}
		$data['addedpermissions'] = $addedpermissions;
		return view('user.tasks.employees.add-employee', $data);
	}
}
