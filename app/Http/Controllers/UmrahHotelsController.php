<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Airlines;
use App\UmrahHotels;
use App\Agents;
use App\Cities;
use App\Hotels;
use App\HotelCategory;
use App\AgentCity;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
use \Validator;
class UmrahHotelsController extends Controller
{
	public function index(Request $r,$code = null)
	{
		$today = date("Y-m-d", strtotime("today"));
		$yesterday = date("Y-m-d", strtotime("yesterday"));

		$hotel = UmrahHotels::join('hotels','hotels.id','umrah_hotels.hotels_id')->join('cities','cities.id','umrah_hotels.cities_id')->join('hotel_categories','hotels.hotel_category','hotel_categories.id')->whereDate('umrah_hotels.price_end','>=',$today)->where('umrah_hotels.active',1);
		if (!empty($r->hotel_name)) {
			$hotel = $hotel->where('umrah_hotels.hotels_id',$r->hotel_name);
		}

		if (!empty($r->city)) {
			$hotel = $hotel->where('umrah_hotels.cities_id',$r->city);
		}

		if (!empty($r->hotel_star)) {
	
			$hotel = $hotel->where('hotels.hotel_category',$r->hotel_star);
		}
		if (!empty($r->meal_type)) {
	
			$hotel = $hotel->where('umrah_hotels.meal_type',$r->meal_type);
		}
		if (!empty($r->room_type)) {
	
			$hotel = $hotel->where('umrah_hotels.room_type',$r->room_type);
		}
		if (!empty($r->agent)) {
	
			$hotel = $hotel->where('umrah_hotels.agents_id',$r->agent);
		}
		if (!is_null($code)) {
	       $agent = Agents::where('code',$code)->first();
	       $data['agentDetail'] = $agent;
	       $hotel = $hotel->where('umrah_hotels.agents_id',$agent->id);
		}
	
		$data['hotels'] = $hotel->select('umrah_hotels.*','hotels.name as hotel','cities.name as hotelcity','hotel_categories.name as type')->paginate(15); 
	

		$data['agents'] =  Agents::join('umrah_hotels','umrah_hotels.agents_id','agents.id')->where('umrah_hotels.active',1)->whereDate('umrah_hotels.price_end','>=',$today)->select('agents.*')->groupBy('agents.business_name')->orderBy('agents.business_name','ASC')->get();

			$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.hotels',1)->select('cities.*')->orderBy('cities.name','ASC')->get();

		$data['searchotel'] = UmrahHotels::join('hotels','hotels.id','umrah_hotels.hotels_id')->select('hotels.*')->orderBy('hotels.name','ASC')->groupBy('hotels.id')->get();
		$data['types'] = HotelCategory::orderBy('id','DESC')->get();

		if (isset($data['agentDetail']) && !is_null($data['agentDetail'])) {
			$data['meta_title'] = $data['agentDetail']->business_name . " — Umrah Hotels in Makkah & Madinah | Agents.com.pk";
			$data['meta_description'] = "Book verified Makkah & Madinah Umrah hotel deals by " . $data['agentDetail']->business_name . ". Best rates near Haram for double, triple, and quad sharing.";
		} else {
			$data['meta_title'] = "Umrah Hotels Near Haram Makkah & Madinah — Rates & Deals | Agents.com.pk";
			$data['meta_description'] = "Compare verified 3-star, 4-star, and 5-star Umrah hotels in Makkah and Madinah near Haram. Check real-time room rates (Double, Triple, Quad) from verified Pakistani travel agents.";
		}

		if($r->ajax()){
			$hotels = $data['hotels'];
			$view = view('partials.load-umrah-hotels',compact('hotels'))->render();
			return response()->json(['html'=>$view,'next_page' => $hotels->nextPageUrl()]);
		}else{
			return view('hotels.index',$data);
		}
	}
	
}
