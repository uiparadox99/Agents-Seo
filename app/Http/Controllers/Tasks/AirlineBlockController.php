<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\City;
use App\Agents;
use  App\Airlines as Airline;
use App\TasksModels\History;
use  App\Airlines as AirlineBlock;
use App\TasksModels\BlockedSeat;
use PDF;

class AirlineBlockController extends Controller
{
	public function index(Request $req)
	{
        $data['blocks']   = AirlineBlock::whereNotNull('id');
        $NotDate          = true;

        if (!is_null($req->airline)) {
            $data['blocks'] = $data['blocks']->where('airlines_id', $req->airline);
        }
        if (!is_null($req->out_bound_date_start) && !is_null($req->out_bound_date_end)) {
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','>=', Date('Y-m-d', strtotime($req->out_bound_date_start)));
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','>=', Date('Y-m-d', strtotime($req->out_bound_date_end)));
            $NotDate          = false;
        }
        if (!is_null($req->out_bound_date_start) && is_null($req->out_bound_date_end)) {
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','=' ,Date('Y-m-d', strtotime($req->out_bound_date_start)));
            $NotDate          = false;
        }
        if (!is_null($req->staff)) {
            $data['blocks'] = $data['blocks']->where('admins_id', $req->staff);
        }
        if (!is_null($req->umrah)) {
            $data['blocks'] = $data['blocks']->where('umrah_block', $req->umrah);
        }
        if (!is_null($req->status)) {
            $data['blocks'] = $data['blocks']->where('status', $req->status);
            $data['blocks'] = $data['blocks']->orderBy('status_date_time', 'ASC');
        }
        // if ($NotDate) {
        //     $data['blocks']->whereDate('out_bound_date','>', Date('Y-m-d', strtotime('+ 3 days')));
        // }
        $data['blocks'] = $data['blocks']->orderBy('out_bound_date')->get();

		$data['history']  = History::select('airlineseatsblockingdetails.pnr',
       'history.activity_description',
       'history.remarks',
       'history.type',
       'history.datetime AS performedOn',
       'admins.name AS performedBy')
        ->join('airlineseatsblockingdetails', 'airlineseatsblockingdetails.id', 'history.airline_block_id')
        ->join('admins','admins.id','history.admins_id')
        ->whereDate('history.datetime','>', date('Y-m-d', strtotime('-7 days')))
        ->where('history.type', 'airline_block_status_update')
        ->orderBy('history.datetime', 'DESC')
        ->get();

        $data['staffs']     = Agents::orderBy('business_name', 'ASC')->get();
        $data['airlines']   = Airline::orderBy('name', 'ASC')->get();

		return view('user.tasks.airline-block.manage-airline-block', $data);
	}

    public function showAddForm()
    {
    	$data['cities'] 	= City::orderBy('name', 'ASC')->get();
    	$data['airlines'] 	= Airline::orderBy('name', 'ASC')->get();
        $data['r']          = null;
        
    	return view('user.tasks.airline-block.add-airline-block', $data);
    }

    public function saveAirlineBlock(Request $req)
    {
    	$validator = Validator::make(Input::all(), [
    		
    	]);

    	if ($validator->fails()) {
    		Session::flash("error-msg", $validator->messages()->first());
    		return redirect()->back()->withInput(Input::all());
    	}

    	$status_date_time 					= date("Y-m-d", strtotime($req->status_date))." ".checkNull($req->status_h, '00').":".checkNull($req->status_m, '00'); 

    	$dataArray = [
            "admins_id"                       => auth()->guard('admin')->user()->id,
            "airlines_id"                     => $req->airlines_id,
            "pnr"                             => strtoupper($req->pnr),
            "status"                          => $req->status,
            "payment_percentage"              => $req->payment_percentage,
            "umrah_block"                     => ($req->umrah_block == "yes")?"yes":"no",
            "status_date_time"                => $status_date_time,
            "flight_number"                   => strtoupper($req->flight_number),
            "from_city_id"                    => $req->from_city_id,
            "to_city_id"                      => $req->to_city_id,
            "one_way_or_return"               => $req->one_way_or_return,
            "out_bound_date"                  => date("Y-m-d", strtotime(str_replace("/","-",$req->out_bound_date))),          
            "in_bound_date"                   => date("Y-m-d", strtotime(str_replace("/","-",$req->in_bound_date))),
            "one_way_departure_time"          => checkNull($req->one_way_departure_h, '00').":".checkNull($req->one_way_departure_m, '00'),
            "one_way_arrival_time"            => checkNull($req->one_way_arrival_h, '00').":".checkNull($req->one_way_arrival_m, '00'),
            "return_departure_time"           => checkNull($req->return_departure_h, '00').":".checkNull($req->return_departure_m, '00'),
            "return_arrival_time"             => checkNull($req->return_arrival_h, '00').":".checkNull($req->return_arrival_m, '00'),
            "cost_price"                      => $req->cost_price,
            "seats"                           => $req->seats,
            "extra_flight_code1"              => $req->extra_flight_code1,
            "extra_trancend_date"             => $req->extra_trancend_date,
            "extra_from_city_id1"             => $req->extra_from_city_id1,
            "extra_to_city_id1"               => $req->extra_to_city_id1,
            "extra_r_flight_code1"            => $req->extra_r_flight_code1,
            "extra_r_trancend_date"           => $req->extra_r_trancend_date,
            "extra_r_from_city_id1"           => $req->extra_r_from_city_id1,
            "extra_r_to_city_id1"             => $req->extra_r_to_city_id1,
            "extra_one_way_departure_time1"   => checkNull($req->extra_one_way_departure_h1, '00').":".checkNull($req->extra_one_way_departure_m1, '00'),
            "extra_one_way_arrival_time1"     => checkNull($req->extra_one_way_arrival_h1, '00').":".checkNull($req->extra_one_way_arrival_m1, '00'),
            "extra_return_departure_time1"    => checkNull($req->extra_return_departure_h1, '00').":".checkNull($req->extra_return_departure_m1, '00'),
            "extra_return_arrival_time1"      => checkNull($req->extra_return_arrival_h1, '00').":".checkNull($req->extra_return_arrival_m1, '00'),
            "extra_flight_code2"              => $req->extra_flight_code2,
            "extra_from_city_id2"             => $req->extra_from_city_id2,
            "extra_to_city_id2"               => $req->extra_to_city_id2,
            "extra_r_flight_code2"            => $req->extra_r_flight_code2,
            "extra_r_from_city_id2"           => $req->extra_r_from_city_id2,
            "extra_r_to_city_id2"             => $req->extra_r_to_city_id2,
            "extra_one_way_departure_time2"   => checkNull($req->extra_one_way_departure_h2, '00').":".checkNull($req->extra_one_way_departure_m2, '00'),
            "extra_one_way_arrival_time2"     => checkNull($req->extra_one_way_arrival_h2, '00').":".checkNull($req->extra_one_way_arrival_m2, '00'),
            "extra_return_departure_time2"    => checkNull($req->extra_return_departure_h2, '00').":".checkNull($req->extra_return_departure_m2, '00'),
            "extra_return_arrival_time2"      => checkNull($req->extra_return_arrival_h2, '00').":".checkNull($req->extra_return_arrival_m2, '00')
        ];

        $blockedSeatsError = false;

        if (!is_null($req->id)) {
            $blockedSeats = BlockedSeat::where('admins_id', '<>', 0)
            ->where('airlineblockingdetails_id', $req->id)
            ->where('canNotEdit', 1)
            ->where('isDeleted', '<>', 'yes')->count();

            if($req->seats < $blockedSeats){
                $blockedSeatsError = true;
            }

            $dataArray['available_seats'] = $req->seats - $blockedSeats;

            $isSave = AirlineBlock::where('id', $req->id)->update($dataArray);
        }else{
            $dataArray['available_seats'] = $req->seats;

            $isSave = AirlineBlock::create($dataArray);
        }

    	if ($isSave) {
    		Session::flash("success-msg", "Completed Successfully.");
    		return redirect()->to('admin/manage-airline-block');
    	}else{
    		Session::flash("error-msg", "Something went wrong. Try again.");
    		return redirect()->back();
    	}
    }

    public function showEditForm($id)
    {
        $data['cities']     = City::orderBy('name', 'ASC')->get();
        $data['airlines']   = Airline::orderBy('name', 'ASC')->get();
        $data['r']          = AirlineBlock::where('id', $id)->first();
        $data['id']         = $id;

        return view('user.tasks.airline-block.add-airline-block', $data);
    }

    public function export(Request $req)
    {
        $data['blocks']   = AirlineBlock::whereNotNull('id');
        $NotDate          = true;

        if (!is_null($req->airline)) {
            $data['blocks'] = $data['blocks']->where('airlines_id', $req->airline);
        }
        if (!is_null($req->out_bound_date_start) && !is_null($req->out_bound_date_end)) {
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','>=', Date('Y-m-d', strtotime($req->out_bound_date_start)));
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','>=', Date('Y-m-d', strtotime($req->out_bound_date_end)));
            $NotDate        = false;
        }
        if (!is_null($req->out_bound_date_start) && is_null($req->out_bound_date_end)) {
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','=' ,Date('Y-m-d', strtotime($req->out_bound_date_start)));
            $NotDate        = false;
        }
        if (!is_null($req->staff)) {
            $data['blocks'] = $data['blocks']->where('admins_id', $req->staff);
        }
        if (!is_null($req->umrah)) {
            $data['blocks'] = $data['blocks']->where('umrah_block', $req->umrah);
        }
        if (!is_null($req->status)) {
            $data['blocks'] = $data['blocks']->where('status', $req->status);
            $data['blocks'] = $data['blocks']->orderBy('status_date_time', 'ASC');
        }

        $data['blocks'] = $data['blocks']->orderBy('out_bound_date')->get();
        $pdf = PDF::loadView('user.tasks.airline-block.export', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('invoice.pdf');

    }

    public function backup(Request $req)
    {
        $data['blocks']   = AirlineBlock::whereNotNull('id');
        $NotDate          = true;

        if (!is_null($req->airline)) {
            $data['blocks'] = $data['blocks']->where('airlines_id', $req->airline);
        }
        if (!is_null($req->out_bound_date_start) && !is_null($req->out_bound_date_end)) {
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','>=', Date('Y-m-d', strtotime($req->out_bound_date_start)));
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','>=', Date('Y-m-d', strtotime($req->out_bound_date_end)));
            $NotDate        = false;
        }
        if (!is_null($req->out_bound_date_start) && is_null($req->out_bound_date_end)) {
            $data['blocks'] = $data['blocks']->whereDate('out_bound_date','=' ,Date('Y-m-d', strtotime($req->out_bound_date_start)));
            $NotDate        = false;
        }
        if (!is_null($req->staff)) {
            $data['blocks'] = $data['blocks']->where('admins_id', $req->staff);
        }
        if (!is_null($req->umrah)) {
            $data['blocks'] = $data['blocks']->where('umrah_block', $req->umrah);
        }
        if (!is_null($req->status)) {
            $data['blocks'] = $data['blocks']->where('status', $req->status);
            $data['blocks'] = $data['blocks']->orderBy('status_date_time', 'ASC');
        }

        $data['blocks'] = $data['blocks']->orderBy('out_bound_date')->get();

        return view('user.tasks.airline-block.backup-airline-block', $data);
    }
}
