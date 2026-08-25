<?php

namespace App\Http\Controllers\Api\v1;

use App\Traits\RestApi;
use App\Utilities\ErrorStatusResponse;
use App\Utilities\GroceryValidator;
use App\Utilities\MobiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UmrahHotels;
use App\Agents;
use App\Airlines;
use App\Cities;
use App\HotelCategory;
use App\Http\Resources\Hotels as HotelsResource;
use App\Http\Resources\HotelsCollection;
use App\Http\Resources\AirlinesCollection;
use App\Http\Resources\CitiesCollection;
use App\Http\Resources\HotelCategoryCollection;
use App\Http\Resources\SearchHotelsCollection;
use Illuminate\Support\Facades\Input;
use Validator;

class HotelsController extends Controller
{
  
    public function index(Request $r,$code)
    {
    	$agent = Agents::where('code',$code)->first();
	
		$today = date("Y-m-d", strtotime("today"));
		$yesterday = date("Y-m-d", strtotime("yesterday"));

		$hotel = UmrahHotels::join('hotels','hotels.id','umrah_hotels.hotels_id')->join('cities','cities.id','umrah_hotels.cities_id')->join('hotel_categories','hotels.hotel_category','hotel_categories.id')->whereDate('umrah_hotels.price_end','>=',$today)->where('umrah_hotels.active',1);
		$hotel = $hotel->where('umrah_hotels.agents_id',$agent->id);
		if (!empty($r->hotel)) {
			$hotel = $hotel->where('umrah_hotels.hotels_id',$r->hotel);
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
		
	
	
		$hotels = $hotel->select('umrah_hotels.*','hotels.name as hotel','cities.name as hotelcity','hotel_categories.name as type')->get(); 
	
         return new HotelsCollection($hotels);
                    
    }

    public function cities($code)
    {
    	return new CitiesCollection(Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.hotels',1)->select('cities.*')->orderBy('cities.name','ASC')->get());
    }
     public function list($code)
    {
    	$agent = Agents::where('code',$code)->first();
    	return new SearchHotelsCollection(UmrahHotels::join('hotels','hotels.id','umrah_hotels.hotels_id')->where('umrah_hotels.agents_id',$agent->id)->select('hotels.*')->orderBy('hotels.name','ASC')->groupBy('hotels.id')->get());
    }
      public function types($code)
    {
    	return new HotelCategoryCollection(HotelCategory::orderBy('id','DESC')->get());
    }
  

}