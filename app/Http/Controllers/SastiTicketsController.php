<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Airlines;
use App\SastiTickets;
use App\Agents;
use App\Cities;
use App\AgentCity;
use App\TicketsFilter;
use App\Visitor;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
use \Validator;
class SastiTicketsController extends Controller
{
	public function index(Request $r,$code = null)
	{
		$today = date("Y-m-d", strtotime("today"));
		$yesterday = date("Y-m-d", strtotime("yesterday"));

		$flight = SastiTickets::with('airline')->where('premium','!=',1)->where('status',1)->where('seats','>=',1)->whereDate('out_bound_date','>=',$today)->where('cost_price','!=','');
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

		$data['flights'] = $flight->paginate(15); 
	  $data['filters'] = TicketsFilter::where('active', 1)
                        ->whereExists(function ($query) use ($today) {
                            $query->select(DB::raw(1))
                                ->from('sasti_tickets')
                                ->whereColumn('sasti_tickets.first_from', 'tickets_filter_blocks.from_city')
                                ->whereColumn('sasti_tickets.first_to', 'tickets_filter_blocks.to_city')
                                ->where('sasti_tickets.seats','>=',1)->whereDate('sasti_tickets.out_bound_date','>=',$today)->where('sasti_tickets.cost_price','!=','');
                        })
                        ->get();

		$data['airlines'] =  Airlines::orderBy('name','ASC')->get();
		$data['agents'] =  Agents::join('sasti_tickets','sasti_tickets.agents_id','agents.id')->where('sasti_tickets.status',1)->whereDate('sasti_tickets.out_bound_date','>=',$today)->select('agents.*')->groupBy('agents.business_name')->orderBy('agents.business_name','ASC')->get();

		$data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.sasti_ticket',1)->whereExists(function ($query) use ($today) {
                            $query->select(DB::raw(1))
                                ->from('sasti_tickets')
                                ->whereColumn('sasti_tickets.first_from', 'cities.name')
                                ->where('sasti_tickets.seats','>=',1)->whereDate('sasti_tickets.out_bound_date','>=',$today)->where('sasti_tickets.cost_price','!=','');
                        })->orderBy('cities.name','ASC')->get();
		$data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.sasti_ticket',1)->whereExists(function ($query) use ($today) {
                            $query->select(DB::raw(1))
                                ->from('sasti_tickets')
                                ->whereColumn('sasti_tickets.first_to', 'cities.name')
                                ->where('sasti_tickets.seats','>=',1)->whereDate('sasti_tickets.out_bound_date','>=',$today)->where('sasti_tickets.cost_price','!=','');
                        })->orderBy('cities.name','ASC')->get();
		if($r->ajax()){
			$flights = $data['flights'];
			$view = view('partials.load-flight',compact('flights'))->render();
			return response()->json(['html'=>$view,'next_page' => $flights->nextPageUrl()]);
		}else{
		    $ip = request()->ip();
            $today = date('Y-m-d'); // example: 2025-02-15
            
            $already = Visitor::where('ip', $ip)->where('type','sasti_tickets')
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
                $v->type = 'sasti_tickets';
                $v->save();
            }
			return view('tickets.index',$data);
		}
	}
	
}
