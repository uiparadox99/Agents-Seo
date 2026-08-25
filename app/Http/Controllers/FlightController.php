<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Airlines;
use App\Flight;
use App\Agents;
use App\Cities;
use App\AgentCity;
use App\Visitor;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
use \Validator;
class FlightController extends Controller
{
	public function flightListing(Request $r,$code = null)
	{
		$today = date("Y-m-d", strtotime("today"));
		$yesterday = date("Y-m-d", strtotime("yesterday"));

		$flight = Flight::with('airline')->where('premium','!=',1)->where('status',1)->whereDate('out_bound_date','>=',$today)->where('cost_price','!=','');
		if (!empty($r->from)) {
			$flight = $flight->where('first_from','LIKE','%'.$r->from.'%');
		}

		if (!empty($r->to)) {
			$flight = $flight->where('first_to','LIKE','%'.$r->to.'%');
		}

		if (!empty($r->airline)) {
			$flight = $flight->where('airlines_id',$r->airline);
		}
		if(!empty($r->month)){
			$flight = $flight->whereMonth('out_bound_date',$r->month);
		}
		if(!empty($r->agent)){
			$flight = $flight->where('agents_id',$r->agent);
		}
		if (!is_null($code)) {
	       $agent = Agents::where('code',$code)->first();
	       $data['agentDetail'] = $agent;
	       $flight = $flight->where('agents_id',$agent->id);
		}
		if(!empty($r->sort)){
			if($r->sort == "low"){
				$flight = $flight->orderBy('cost_price','ASC');
			}else{
				$flight = $flight->orderBy('cost_price','DESC');
			} 

		}else{
			$flight = $flight->orderBy('out_bound_date','ASC');
		}

		$data['all_flights'] = $flight->get();
		$data['flights'] = $flight->paginate(15)->appends(request()->query()); 
		$premium = Flight::with('airline')->where('premium',1)->where('status',1)->whereDate('out_bound_date','>=',$today)->where('cost_price','!=','');
		if (!empty($r->from)) {
			$premium = $premium->where('first_from','LIKE','%'.$r->from.'%');
		}

		if (!empty($r->to)) {
			$premium = $premium->where('first_to','LIKE','%'.$r->to.'%');
		}
		$data['premiumFlights'] = $premium->get();
		$data['airlines'] =  Airlines::orderBy('name','ASC')->get();
		$data['agents'] =  Agents::join('flights','flights.agents_id','agents.id')->where('flights.status',1)->whereDate('flights.out_bound_date','>=',$today)->select('agents.*')->groupBy('agents.business_name')->orderBy('agents.business_name','ASC')->get();

		$data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
		$data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
		if($r->ajax()){
			$flights = $data['flights'];
			$view = view('partials.load-flight',compact('flights'))->render();
			return response()->json(['html'=>$view,'next_page' => $flights->nextPageUrl()]);
		}else{
		    $ip = request()->ip();
            $today = date('Y-m-d'); // example: 2025-02-15
            
            $already = Visitor::where('ip', $ip)->where('type','umrah_tickets')
                ->whereDate('created_at', $today)
                ->exists();
            
            if (!$already) {
            
                // $position = Location::get($ip);
            
                $v = new Visitor;
                $v->ip = $ip;
                // $v->location = isset($position) && !is_null($position)
                //     ? $position->cityName.', '.$position->countryName
                //     : '';
                // $v->browser = $agent->browser();
                // $v->platform = $agent->platform();
                // $v->device = $device_type;
                $v->header = request()->header('User-Agent');
                $v->type = 'umrah_tickets';
                $v->save();
            }
			return view('flights.listing',$data);
		}
	}
	
}
