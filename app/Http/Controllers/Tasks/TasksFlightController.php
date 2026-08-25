<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\Flight;

class TasksFlightController extends Controller
{
    public function index()
    {
        $data['flights'] = Flight::orderBy('id', 'ASC')->get();
        return view('user.tasks.flights.manage-flights', $data);
    }

    public function showAddForm()
    {
        return view('user.tasks.flights.add-flight');
    }

    public function save(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'name' 	=> 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (!is_null($req->id)) {
            $c    = Flight::where('id', $req->id)->first();
        }else{
            $c    = New Flight;
        }

        $c->name       = strtoupper($req->name);
        $isSave        = $c->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-flights');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }

    public function showEditForm($id)
    {
        $data['flight'] = Flight::where('id', $id)->first();
        return view('user.tasks.flights.add-flight', $data);
    }
}
