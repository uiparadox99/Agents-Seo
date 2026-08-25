<?php

namespace App\Http\Controllers\Tasks;

use App\TasksModels\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\CallLog;
use App\TasksModels\Vendee;
use App\TasksModels\Flight;
use App\Agents;


class CallLogController extends Controller
{
	public function index()
	{
		$data['logs'] 		= CallLog::with('attachment')->orderBy('id', 'DESC')->get();
		$data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
		$data['admins_id'] 	= Agents::orderBy('business_name', 'ASC')->get();
		return view('user.tasks.call-logs.manage-call-logs', $data);
	}

	public function showAddForm()
	{
		$data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
		$data['admins'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['flights'] 	= Flight::orderBy('name', 'ASC')->get();
        $data['statuses'] 	= Status::where('type', 'calllog')->orderBy('name', 'ASC')->get();

		return view('user.tasks.call-logs.add-call-log', $data);
	}

    public function saveCallLog(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'sector'            => 'required',
            'flights_id'        => 'required',
            'travel_date'       => 'required',
            'call_date'         => 'required',
            'admins_id'         => 'required',
            'parties_id'        => 'required',
            'booking_detail'    => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        $log                    = New CallLog;
        $log->sector            = strtoupper($req->sector);
        $log->flights_id        = $req->flights_id;
        $log->travel_date       = $req->travel_date;
        $log->call_date_time    = $req->call_date;
        $log->admins_id         = $req->admins_id;
        $log->vendees_id        = $req->parties_id;
        $log->statuses_id       = $req->statuses_id;
        $log->booking_detail    = $req->booking_detail;
        $isSave                 = $log->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-call-logs');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }

	}
}
