<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Airlines;
use App\Flight;
use App\Agents;
use App\Cities;
use App\AgentCity;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
use \Validator;
class FlightController extends Controller
{
	public function index(Request $r)
	{
		$agent  = Agents::where('users_id',auth()->user()->id)->first();
		if (is_null($agent)) {
			Session::flash("error-msg", "Please Add Business First");
			return redirect()->back();
		}
		$today = date("Y-m-d", strtotime("today"));
		$flight = Flight::where('agents_id',$agent->id);
		if (empty($r->old)) {
			$flight = $flight->whereDate('out_bound_date','>=',$today); 
		}else{
			$flight = $flight->whereDate('out_bound_date','<',$today); 
		}
		if (!empty($r->from)) {
			$flight = $flight->where('first_from','LIKE','%'.$r->from.'%');
		}

		if (!empty($r->to)) {
			$flight = $flight->where('first_to','LIKE','%'.$r->to.'%');
		}

		if (!empty($r->airline)) {
	
			$flight = $flight->where('airlines_id',$r->airline);
		}
		if (!empty($r->agent)) {
			$flight = $flight->where('agents_id',$r->agent);
		}
		if (!empty($r->type)) {
			if ($r->type == 'one_way') {
					$flight = $flight->where('one_way_or_return',0);
			}else{
					$flight = $flight->where('one_way_or_return',$r->type);
			}
		
		}
		$data['flights']  = $flight->paginate(10); 
	    $data['airlines'] =  Airlines::orderBy('name','ASC')->get();
		$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['agent'] = $agent;
		if($r->ajax()){
			$flights = $data['flights'];
			$view = view('partials.agent-flights',compact('flights'))->render();
			return response()->json(['html'=>$view]);
		}else{
			return view('user.flights.index',$data);
		}
	}
	public function addflight()
	{
		$data['airlines'] =  Airlines::orderBy('name','ASC')->get();
		$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['via']   =  Cities::where('cities.via',1)->orderBy('cities.name','ASC')->get();
		return view('user.flights.add',$data);
	}
	public function editflight($id)
	{
		$data['detail']   =  Flight::where('id',$id)->first();
		$data['airlines'] =  Airlines::orderBy('name','ASC')->get();
		$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['via']   =  Cities::where('cities.via',1)->orderBy('cities.name','ASC')->get();
		return view('user.flights.add',$data);
	}
	public function flightActive(Request $req)
	{
	    $visa           = Flight::where('id', $req->id)->first();
	    $visa->status  = $req->is_home;
	    $isSave         = $visa->save();
	    if ($isSave) {
	        return response()->json(["notify"=>true, "msg"=>"Success"]);
	    }else{
	        return response()->json(["notify"=>false, "msg"=>"Fail"]);
	    }
	}
	public function save(Request $r)
	{
		$validator = Validator::make(Input::all(), [
			'one_way_or_return'   => 'required',
			'airline'   		  => 'required',
			'cost_price'   		  => 'required',
			'from'   			  => 'required',
			'to'   				  => 'required',
			'flight_number'   	  => 'required',
			'out_bound_date'   	  => 'required',
			'one_way_departure_h' => 'required',
			'one_way_arrival_h'   => 'required',
		]);

		if ($validator->fails()) {
			Session::flash("error-msg", $validator->messages()->first());
			return redirect()->back()->withInput(Input::all());
		}
		if (!empty($r->id)) {
			$f 							= Flight::where('id',$r->id)->first();
		}else{
			$f 							= new Flight;
			$f->agents_id 				= auth()->user()->agents()->first()->id;
		}

		$status_date_time 				= date("Y-m-d", strtotime($r->status_date))." ".$r->status_h.":".$r->status_m; 
		$airline 						=  $r->airline;
		$saver 							=  $r->saver;

		$pnr 							=  strtoupper($r->pnr);
		$status 						=  isset($r->status)?$r->status:'1';
		$payment_percentage 			= $r->payment_percentage;
		$umrah_block 					= ($r->umrah_block == "yes")?"yes":"no";
		if(isset($r->status_date)){
			$status_date_time 			= date("Y-m-d H:i:s", strtotime($status_date_time));
		}else{
			$status_date_time 			= null;
		}

        // First Flight Number
		$flight_number 					= strtoupper($r->flight_number);
		$from 							=  $r->from;
		$to 							=  $r->to;
		$one_way_or_return 				=  $r->one_way_or_return == 1?1:0;
		$out_bound_date 				=  date("Y-m-d", strtotime(str_replace("/","-",$r->out_bound_date)));
		$in_bound_date 					=  date("Y-m-d", strtotime(str_replace("/","-",$r->in_bound_date)));

		$one_way_departure_time 		= $r->one_way_departure_h; 

		$one_way_arrival_time 			= $r->one_way_arrival_h; 

        // Return Flight Number
		$return_flight_number 			= strtoupper($r->return_flight_number); 

		$return_departure_time 			= isset($r->return_departure_h) && !empty($r->return_departure_h)? $r->return_departure_h.":".$r->return_departure_m:"00:00";
		$return_arrival_time 			= isset($r->return_arrival_h) && !empty($r->return_arrival_h)? $r->return_arrival_h.":".$r->return_arrival_m:"00:00"; 

		$cost_price					    =  $r->cost_price;
		$child_price 					=  $r->child_price;
		$infant_price 					=  $r->infant_price;
		$seats 							=  isset($r->seats)?$r->seats:0;

        // Direct below flight number :left side box
		$extra_flight_code1 			=  strtoupper($r->extra_flight_code1);
		$extra_trancend_date 			=  $r->extra_trancend_date;
		$extra_from 					=  $r->extra_via;
        // $extra_to =  $r->extra_to;


        // Return below flight number :right side box
		$extra_r_flight_code1 			=  $r->extra_r_flight_code1;
		$extra_r_trancend_date		    =  $r->extra_r_trancend_date;
		$extra_r_from 					=  $r->extra_r_via;
        // $extra_r_to =  $r->extra_r_to;
		$extra_one_way_departure_time1 	=  isset($r->extra_one_way_departure_h1) && !empty($r->extra_one_way_departure_h1)?$r->extra_one_way_departure_h1:"00:00";
		$extra_one_way_arrival_time1 	=  isset($r->extra_one_way_arrival_h1) && !empty($r->extra_one_way_arrival_h1)?$r->extra_one_way_arrival_h1:"00:00";
		$extra_return_departure_time1 	= isset($r->extra_return_departure_h1) && !empty($r->extra_return_departure_h1)?$r->extra_return_departure_h1:"00:00";
		$extra_return_arrival_time1 	=  isset($r->extra_return_arrival_h1) && !empty($r->extra_return_arrival_h1)?$r->extra_return_arrival_h1:"00:00 ";

		$extra_flight_code2 			=  $r->extra_flight_code2;
		$extra_r_flight_code2 			=  $r->extra_r_flight_code2;
		$extra_r_from_2 				=  $r->extra_r_from_2;
		$extra_r_to_2 					=  $r->extra_r_to_2;
		$status_remarks 				=  !empty($r->status_remarks)?$r->status_remarks:"";
		$extra_one_way_departure_time2  =  isset($r->extra_one_way_departure_h2) && !empty($r->extra_one_way_departure_h2)?$r->extra_one_way_departure_h2:"00:00";
		$extra_one_way_arrival_time2    = isset($r->extra_one_way_arrival_h2) && !empty($r->extra_one_way_arrival_h2)?$r->extra_one_way_arrival_h2:"00:00";
		$extra_return_departure_time2   = isset($r->extra_return_departure_h2) && !empty($r->extra_return_departure_h2)?$r->extra_return_departure_h2:"00:00";
		$extra_return_arrival_time2     = isset($r->extra_return_arrival_h2) && !empty($r->extra_return_arrival_h2)?$r->extra_return_arrival_h2:"00:00";

		$f->airlines_id 				  = $airline;
		$f->pnr 						  = $pnr; 
		$f->status 						  = $status;
		$f->luggage 					  = $r->luggage;
		$f->return_luggage 				  = $r->return_luggage;
		$f->meal 						  = $r->meal;
		$f->refundable 					  = $r->refundable;
		$f->remarks 					  = $r->remarks;
		$f->status_remarks 				  = $status_remarks; 
		$f->status_date_time 			  = $status_date_time; 
		$f->payment_percentage 			  = $payment_percentage; 
		$f->umrah_block					  = $umrah_block; 
		$f->flight_number 				  = $flight_number; 
		$f->return_flight_number 		  = $return_flight_number; 
		$f->extra_flight_code1 			  = $extra_flight_code1; 
		$f->extra_r_flight_code1 		  = $extra_r_flight_code1; 
		$f->first_from 					  = $from; 
		$f->first_to 					  = $to; 
		$f->return_to 					  = $r->return_to; 
		$f->return_from 				  = $r->return_from; 
		$f->one_way_or_return 			  = $one_way_or_return; 
		$f->out_bound_date				  = $out_bound_date; 
		$f->in_bound_date 			      = $in_bound_date; 
		$f->one_way_departure_time 		  = $one_way_departure_time; 
		$f->one_way_arrival_time 		  = $one_way_arrival_time; 
		$f->return_departure_time 		  = $return_departure_time; 
		$f->return_arrival_time 		  = $return_arrival_time; 
		$f->cost_price 					  = $cost_price; 
		$f->child_price 				  = $child_price; 
		$f->infant_price 				  = $infant_price; 
		$f->seats 						  = $seats; 
		$f->extra_trancend_date 		  = $extra_trancend_date; 
		$f->extra_r_trancend_date 		  = $extra_r_trancend_date; 
		$f->extra_via 					  = $extra_from; 
		$f->extra_r_via 				  = $extra_r_from; 
		$f->extra_one_way_departure_time1 = $extra_one_way_departure_time1; 
		$f->extra_one_way_arrival_time1   = $extra_one_way_arrival_time1; 
		$f->extra_return_departure_time1  = $extra_return_departure_time1; 
		$f->extra_return_arrival_time1    = $extra_return_arrival_time1; 
		$f->extra_flight_code2 			  = $extra_flight_code2; 
		$f->extra_r_flight_code2 		  = $extra_r_flight_code2; 
		$f->extra_r_from_2				  = $extra_r_from_2; 
		$f->extra_r_to_2 				  = $extra_r_to_2; 
		$f->extra_one_way_departure_time2 = $extra_one_way_departure_time2; 
		$f->extra_one_way_arrival_time2   = $extra_one_way_arrival_time2; 
		$f->extra_return_departure_time2  = $extra_return_departure_time2; 
		$f->extra_return_arrival_time2 	  = $extra_return_arrival_time2;
		$saved = $f->save();
		if ($saved) {
			if (!empty($r->id)) {
				
				Session::flash("success-msg", "Flight Updated Successfully.");
			}else{

				Session::flash("success-msg", "Flight Added Successfully.");
			}

			return redirect()->to('agent-flights');
		}else{
			Session::flash("success-msg", "There is an Error.");

			return redirect()->back();
		}
	}
}
