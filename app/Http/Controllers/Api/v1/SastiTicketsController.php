<?php

namespace App\Http\Controllers\Api\v1;

use App\Traits\RestApi;
use App\Utilities\ErrorStatusResponse;
use App\Utilities\GroceryValidator;
use App\Utilities\MobiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SastiTickets;
use App\Agents;
use App\Airlines;
use App\Cities;
use App\Http\Resources\Tickets as TicketsResource;
use App\Http\Resources\TicketsCollection;
use App\Http\Resources\AirlinesCollection;
use App\Http\Resources\CitiesCollection;
use Illuminate\Support\Facades\Input;
use Validator;

class SastiTicketsController extends Controller
{
  
    public function index(Request $r,$code)
    {
    	$agent = Agents::where('code',$code)->first();

    	$today = date("Y-m-d", strtotime("today"));
		$yesterday = date("Y-m-d", strtotime("yesterday"));



		$flight = SastiTickets::with('airline')->where('premium','!=',1)->where('status',1)->whereDate('out_bound_date','>=',$today)->where('cost_price','!=','');
		$flight = $flight->where('agents_id',$agent->id);
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
	

		if(!empty($r->sort)){
			if($r->sort == "low"){
				$flight = $flight->orderBy('cost_price','ASC');
			}else{
				$flight = $flight->orderBy('cost_price','DESC');
			} 

		}else{
			$flight = $flight->orderBy('out_bound_date','ASC');
		}

		$flight = $flight->get();
         return new TicketsCollection($flight);
                    
    }

    public function airlines($code)
    {
    	 $agent = Agents::where('code',$code)->first();
    	return new AirlinesCollection(Airlines::join('sasti_tickets','sasti_tickets.airlines_id','airlines.id')->where('sasti_tickets.agents_id',$agent->id)->orderBy('name','ASC')->get());
    }
    public function fromCities($code)
    {
    	return new CitiesCollection( Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.sasti_ticket',1)->orderBy('cities.name','ASC')->get());
    }
     public function toCities($code)
    {
    	return new CitiesCollection(Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.sasti_ticket',1)->orderBy('cities.name','ASC')->get());
    }

}