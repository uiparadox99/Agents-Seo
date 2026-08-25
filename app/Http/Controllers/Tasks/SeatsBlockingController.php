<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\TasksModels\City;
use  App\Airlines as Airline;
use  App\Airlines as AirlineBlock;
use App\TasksModels\BlockedSeat;
use App\TasksModels\History;
use App\TasksModels\Party;
use DB;

class SeatsBlockingController extends Controller
{
    public function index($id)
	{
		$data['parties'] = Party::where('status', 1)->orderBy('name', 'ASC')->get();

            $data['r']   = AirlineBlock::select('a.name AS airline',
                  'a.logo',
                  'airlineseatsblockingdetails.*',
                  'from_city.name AS from_city',
                  'to_city.name AS to_city',
                  'extra_one_way_from_city1.name AS extra_from_1',
                  'extra_one_way_to_city1.name AS extra_to_1',
                  'extra_one_way_from_city2.name AS extra_from_2',
                  'extra_one_way_to_city2.name AS extra_to_2',
                  'extra_one_way_r_from_city1.name AS extra_r_from_1',
                  'extra_one_way_r_to_city1.name AS extra_r_to_1',
                  'extra_one_way_r_from_city2.name AS extra_r_from_2',
                  'extra_one_way_r_to_city2.name AS extra_r_to_2')
                              ->leftJoin('airlines as a', 'a.id', 'airlineseatsblockingdetails.airlines_id')
                              ->leftJoin('cities as from_city', 'from_city.id', 'airlineseatsblockingdetails.from_city_id')
                              ->leftJoin('cities as to_city', 'to_city.id', 'airlineseatsblockingdetails.to_city_id')
                              ->leftJoin('cities as extra_one_way_from_city1', 'extra_one_way_from_city1.id', 'airlineseatsblockingdetails.extra_from_city_id1')
                              ->leftJoin('cities as extra_one_way_to_city1', 'extra_one_way_to_city1.id', 'airlineseatsblockingdetails.extra_to_city_id1')
                              ->leftJoin('cities as extra_one_way_from_city2', 'extra_one_way_from_city2.id', 'airlineseatsblockingdetails.extra_from_city_id2')
                              ->leftJoin('cities as extra_one_way_to_city2', 'extra_one_way_to_city2.id', 'airlineseatsblockingdetails.extra_to_city_id2')
                              ->leftJoin('cities as extra_one_way_r_from_city1', 'extra_one_way_r_from_city1.id', 'airlineseatsblockingdetails.extra_r_from_city_id1')
                              ->leftJoin('cities as extra_one_way_r_to_city1', 'extra_one_way_r_to_city1.id', 'airlineseatsblockingdetails.extra_r_to_city_id1')
                              ->leftJoin('cities as extra_one_way_r_from_city2', 'extra_one_way_r_from_city2.id', 'airlineseatsblockingdetails.extra_r_from_city_id2')
                              ->leftJoin('cities as extra_one_way_r_to_city2', 'extra_one_way_r_to_city2.id', 'airlineseatsblockingdetails.extra_r_to_city_id2')
                              ->where('airlineseatsblockingdetails.id', $id)->first();

            $data['d'] = BlockedSeat::select('blocked_seats.*',
                             'u.name AS user_name',
                             'p.name AS party_name')
                        ->leftJoin('admins as u', 'u.id', 'blocked_seats.admins_id')
                        ->leftJoin('parties as p', 'p.id', 'blocked_seats.parties_id')
                        ->where('blocked_seats.airlineblockingdetails_id', $id)
                        ->where('isDeleted', '<>', 'yes')
                        ->orderBy('blocked_seats.seat_no')->get();
                        
            $data["pnData"]         = Party::where("status", 1)->get();
            $data["id"]             = $id;
            $data["bookingHistory"] = History::selectRaw(\DB::raw("history.activity_description, history.remarks, history.type, history.datetime as performedOn, u.name as performedBy, history.data"))
                    ->join("admins as u", "u.id", "=", "history.admins_id")
                    ->where("history.type", "LIKE", "%blocked_seat%")
                    ->where("history.airline_block_id", $id)
                    ->orderBy("history.datetime", "DESC")->get();

            $data["dat"] = BlockedSeat::selectRaw(\DB::raw("SUM(party_price) as total_price, SUM(advance) as received"))
            ->where("airlineblockingdetails_id", $id)
            ->where("isDeleted","!=", "YES")->first();
                   
		return view('user.tasks.seats-blocking.add-seats-blocking', $data);
	}
}
