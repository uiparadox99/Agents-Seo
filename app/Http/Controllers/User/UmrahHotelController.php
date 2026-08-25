<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\UmrahHotels;
use App\AgentCity;
use App\Cities;
use App\Hotels;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
use \Validator;
class UmrahHotelController extends Controller
{
	public function index(Request $r)
	{
		$agent  = Agents::where('users_id',auth()->user()->id)->first();
		if (is_null($agent)) {
			Session::flash("error-msg", "Please Add Business First");
			return redirect()->back();
		}
		$today = date("Y-m-d", strtotime("today"));
		$hotel = UmrahHotels::join('hotels','hotels.id','umrah_hotels.hotels_id')->join('cities','cities.id','umrah_hotels.cities_id')->where('umrah_hotels.agents_id',$agent->id);
	
		if (!empty($r->hotel_name)) {
			$hotel = $hotel->where('umrah_hotels.hotels_id',$r->hotel_name);
		}

		if (!empty($r->city)) {
			$hotel = $hotel->where('umrah_hotels.cities_id',$r->city);
		}

		if (!empty($r->hotel_star)) {
	
			$hotel = $hotel->where('hotel_star',$r->hotel_star);
		}
		if (!empty($r->meal_type)) {
	
			$hotel = $hotel->where('umrah_hotels.meal_type',$r->meal_type);
		}
		if (!empty($r->room_type)) {
	
			$hotel = $hotel->where('umrah_hotels.room_type',$r->room_type);
		}
		$data['hotels']  = $hotel->select('umrah_hotels.*','hotels.name as hotel','cities.name as hotelcity')->paginate(20); 
		$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.hotels',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['searchotel'] = UmrahHotels::join('hotels','hotels.id','umrah_hotels.hotels_id')->where('umrah_hotels.agents_id',$agent->id)->select('hotels.*')->orderBy('hotels.name','ASC')->groupBy('hotels.id')->get();
		$data['agent'] = $agent;
		if($r->ajax()){
			$hotels = $data['hotels'];
			$view = view('partials.agent-hotels',compact('hotels'))->render();
			return response()->json(['html'=>$view]);
		}else{
			return view('user.hotels.index',$data);
		}
	}
	public function addHotel()
	{
		$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.hotels',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['hotels'] = Hotels::orderBy('name','ASC')->get();
		return view('user.hotels.add',$data);
	}
	public function editHotel($id)
	{
		$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.hotels',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
		$data['detail']   =  UmrahHotels::where('id',$id)->first();
		$data['hotels'] = Hotels::orderBy('name','ASC')->get();
		return view('user.hotels.add',$data);
	}
	public function hotelActive(Request $req)
	{
	    $visa           = UmrahHotels::where('id', $req->id)->first();
	    $visa->active  = $req->is_home;
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
            'city'   => 'required',
            'hotel'   => 'required',
            'double'   => 'required',
            'tripple'   => 'required',
            'quad'   => 'required',
            'meal_type'   => 'required',
            'price_start'   => 'required',
            'price_end'   => 'required',
          ]);
        
          if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
          }

          if(!empty($r->id)){
              $j = UmrahHotels::where('id',$r->id)->first();
          }else{
              $j = new UmrahHotels;
          }
        //   $city = AgentCity::where('id',$r->city)->first();
        
          $agent  = Agents::where('users_id',auth()->user()->id)->first();
          $agent_id = $agent->id;

          $j->hotels_id = $r->hotel;
          $j->cities_id = $r->city;
          $j->hotel_star = $r->hotel_star;
          $j->agent_name = $r->agent_name;
          $j->double = $r->double;
          $j->tripple = $r->tripple;
          $j->quad = $r->quad;
          // $j->room_type = $r->room_type;
          $j->meal_type = $r->meal_type;
          $j->price_start =date("Y-m-d", strtotime(str_replace("/","-",$r->price_start)));;
          $j->price_end   = date("Y-m-d", strtotime(str_replace("/","-",$r->price_end)));;
          $j->agent_contact = $r->agent_contact;
          $j->persons = $r->persons;
          $j->agents_id = $agent_id;
          $j->active = 1;
          $saved = $j->save();
          if ($saved) {
          	if (!empty($r->id)) {
          		Session::flash("success-msg", "Hotel Updated Successfully.");
          	}else{
          		Session::flash("success-msg", "Hotel Added Successfully.");
          	}
            return redirect()->to('agent-umrah-hotels');
           }else{
            Session::flash("success-msg", "There is an Error.");
           
            return redirect()->back();
          }
	}
	public function loadHotels(Request $r)
	{       $hotels = Hotels::where('city',$r->city)->orderBy("name")->get();
			$view = view('partials.load-hotels',compact('hotels'))->render();
			return response()->json(['html'=>$view]);
	}
}
