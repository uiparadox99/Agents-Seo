<?php

namespace App\Http\Controllers\Tasks;

use App\TasksModels\CallLog;
use App\TasksModels\Flight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\Vendee;
use App\TasksModels\Ticket;
use  App\Airlines as Airline;
use App\TasksModels\Transaction;
use App\TasksModels\Status;
use App\TasksModels\RoomTypes;
use App\TasksModels\VisaTypes;
use App\Country;
use App\TasksModels\HotelSale;
use App\TasksModels\TourPackage;
use App\TasksModels\UmrahSale;
use App\TasksModels\TravelInsurance;
use App\TasksModels\OtherSale;
use App\Agents;
use DB;

class DailySaleController extends Controller
{
    public function index(Request $req)
    {
        $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        $data['admins_id'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers'] 	= Vendee::where('status', 1)->where('type', 'supplier')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        $data['flights'] 	= Flight::orderBy('name', 'ASC')->get();
        $data['tickets']    = Ticket::whereNotNull('id')->where('agents_id', auth()->user()->id);
        


       
          if (!is_null($req->date_start)){
            $date = date('Y-m-d',strtotime($req->date_start));
            $data['tickets'] = $data['tickets']->whereDate('report_date','>=', $date);
        }
        if (!is_null($req->date_end)){
            $date = date('Y-m-d',strtotime($req->date_end));
            $data['tickets'] = $data['tickets']->whereDate('report_date','<=', $date);
        }
         if (!is_null($req->flight)){
            $data['tickets'] = $data['tickets']->where('flights_id', $req->flight);
        }

        if (!is_null($req->party)){
            $data['tickets'] = $data['tickets']->where('parties_id', $req->party);
        }
        if (!is_null($req->supplier)){
            $data['tickets'] = $data['tickets']->where('suppliers_id', $req->supplier);
        }
        if (!is_null($req->staff)){
            $data['tickets'] = $data['tickets']->where('admins_id', $req->staff);
        }
        $data['tickets'] = $data['tickets']->orderBy('id', 'DESC')->get();

        return view('user.tasks.tickets.manage-tickets', $data);
    }

    public function showAddForm()
    {
        $data['parties'] 	= Vendee::with('passengers')->where('agents_id', auth()->user()->id)->where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers'] 	= Vendee::where('status', 1)->where('agents_id', auth()->user()->id)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights']    = Flight::orderBy('name', 'ASC')->get();
        $data['airlines']   = Airline::orderBy('name', 'ASC')->get();
        $data['roomTypes']  = RoomTypes::orderBy('name', 'ASC')->get();
        $data['countries']  = Country::orderBy('country', 'ASC')->get();
        $data['visaTypes']  = VisaTypes::orderBy('name', 'ASC')->get();
        $data['new_invoice_no'] = '';
        $no  = DB::select("SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'myungjxp_agents'
            AND   TABLE_NAME   = 'tickets'");
 
        if ($no) {
             $data['new_invoice_no'] = $no[0]->AUTO_INCREMENT;
        }
         $data['Ticektstatuses']    = Status::where('type','tickets')->orderBy('name', 'ASC')->get();

        return view('user.tasks.daily.add-daily-sale', $data);
    }

    public function showEditForm($id)
    {
        $data['parties'] 	= Vendee::with('passengers')->where('status', 1)->where('agents_id', auth()->user()->id)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers'] 	= Vendee::where('status', 1)->where('agents_id', auth()->user()->id)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights'] 	= Flight::orderBy('name', 'ASC')->get();
        $data['tickets'] 	= Ticket::with('trans')->where('agents_id', auth()->user()->id)->where('id', $id)->first();
        $data['airlines']   = Airline::orderBy('name', 'ASC')->get();
        $data['roomTypes']  = RoomTypes::orderBy('name', 'ASC')->get();
        $data['countries']  = Country::orderBy('country', 'ASC')->get();
        $data['visaTypes']  = VisaTypes::orderBy('name', 'ASC')->get();
         $data['Ticektstatuses']    = Status::where('type','tickets')->orderBy('name', 'ASC')->get();
          $data['new_invoice_no'] = '';
        $no  = DB::select("SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'myungjxp_agents'
            AND   TABLE_NAME   = 'tickets'");
 
        if ($no) {
             $data['new_invoice_no'] = $no[0]->AUTO_INCREMENT;
        }

        return view('user.tasks.daily.add-daily-sale', $data);
    }
    public function logs()
    {

        $data['tickets'] =  Ticket::whereDate('created_at',date('Y-m-d',strtotime('today')))->where('agents_id', auth()->user()->id)->orWhereDate('updated_at',date('Y-m-d',strtotime('today')))->get();
        $data['hotels'] =  HotelSale::whereDate('created_at',date('Y-m-d',strtotime('today')))->where('agents_id', auth()->user()->id)->orWhereDate('updated_at',date('Y-m-d',strtotime('today')))->get();
        $data['packages'] =  TourPackage::whereDate('created_at',date('Y-m-d',strtotime('today')))->where('agents_id', auth()->user()->id)->orWhereDate('updated_at',date('Y-m-d',strtotime('today')))->get();
        $data['umrah'] =  UmrahSale::whereDate('created_at',date('Y-m-d',strtotime('today')))->where('agents_id', auth()->user()->id)->orWhereDate('updated_at',date('Y-m-d',strtotime('today')))->get();
        $data['travel'] =  TravelInsurance::whereDate('created_at',date('Y-m-d',strtotime('today')))->where('agents_id', auth()->user()->id)->orWhereDate('updated_at',date('Y-m-d',strtotime('today')))->get();
        $data['sales'] =  OtherSale::whereDate('created_at',date('Y-m-d',strtotime('today')))->where('agents_id', auth()->user()->id)->orWhereDate('updated_at',date('Y-m-d',strtotime('today')))->get();
         return view('user.tasks.logs.index', $data);
        // code...
    }
}
