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
use App\TasksModels\TourPackage;
use App\TasksModels\UmrahSale;
use App\TasksModels\TravelInsurance;
use App\TasksModels\OtherSale;
use App\TasksModels\HotelSale;
use App\Agents;
use DB;

class SearchController extends Controller
{
   
     public function search(Request $req)
    {
        $data['parties']    = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins_id']  = Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights']    = Flight::orderBy('name', 'ASC')->get();

        if (!is_null($req->date_start)){
            $start_date = date('Y-m-d',strtotime($req->date_start));
        }else{
            return view('user.tasks.search.index', $data);
        }

        if (!is_null($req->date_end)){
            $end_date = date('Y-m-d',strtotime($req->date_end));
        }
        if (!$req->type || ($req->type && $req->type == 'ticket')) {

            $data['tickets']    = Ticket::whereNotNull('id');
            if (!is_null($req->date_start)){
                $data['tickets'] = $data['tickets']->whereDate('report_date','>=', $start_date);
            }
            if (!is_null($req->date_end)){
                $data['tickets'] = $data['tickets']->whereDate('report_date','<=', $end_date);
            }

            if (!is_null($req->party)){
                $data['tickets'] = $data['tickets']->where('parties_id', $req->party);
            }
              if (!is_null($req->supplier)){
                $data['tickets'] = $data['tickets']->where('suppliers_id', $req->supplier);
            }
              if (!is_null($req->passenger)){
               $data['tickets'] = $data['tickets']->where(function($query) use ($req) {
                $query->where('given_name','LIKE','%'.$req->passenger.'%')
                ->orWhere('surname','LIKE','%'.$req->passenger.'%');
            });
            }
            if (!is_null($req->staff)){
                $data['tickets'] = $data['tickets']->where('admins_id', $req->staff);
            }
           /* if (auth()->guard('admin')->user()->type == 'admin') {
                
            }else{
                $data['tickets'] = $data['tickets']->where('admins_id', auth()->guard('admin')->user()->id);
            }*/
            $data['tickets'] = $data['tickets']->orderBy('id', 'DESC')->get();
        }else{
            $data['tickets'] = array();
        }



        if (!$req->type || ($req->type && $req->type == 'other_sales')) {
         $data['sales']    = OtherSale::whereNotNull('id');
         if (!is_null($req->party)){
            $data['sales'] = $data['sales']->where('parties_id', $req->party);
        }

        if (auth()->guard('admin')->user()->type == 'admin') {
            if (!is_null($req->staff)){
                $data['sales'] = $data['sales']->where('admins_id', $req->staff);
            }
        }else{
            $data['sales'] = $data['sales']->where('admins_id', auth()->guard('admin')->user()->id);
        }
        if (!is_null($req->passenger)){
         $data['sales'] = $data['sales']->where('passenger_name','LIKE','%'.$req->passenger.'%');
     }
        if (!is_null($req->date_start)){
            $data['sales'] = $data['sales']->whereDate('report_date','>=', $start_date);
        }
        if (!is_null($req->date_end)){
            $data['sales'] = $data['sales']->whereDate('report_date','<=', $end_date);
        }
        
        $data['sales'] = $data['sales']->orderBy('id', 'DESC')->get();
    }else{
        $data['sales'] = array();
    }
    if (!$req->type || ($req->type && $req->type == 'hotel_sales')) {
        $data['hotels']    = HotelSale::whereNotNull('id');

        if (!is_null($req->party)){
            $data['hotels'] = $data['hotels']->where('parties_id', $req->party);
        }
            if (!is_null($req->supplier)){
                $data['hotels'] = $data['hotels']->where('suppliers_id', $req->supplier);
            }
              if (!is_null($req->passenger)){
               $data['hotels'] = $data['hotels']->where('passenger_name','LIKE','%'.$req->passenger.'%');
            }
               if (!is_null($req->staff)){
                $data['hotels'] = $data['hotels']->where('admins_id', $req->staff);
            }
     /*   if (auth()->guard('admin')->user()->type == 'admin') {
         
        }else{
            $data['hotels'] = $data['hotels']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->date_start)){
            $data['hotels'] = $data['hotels']->whereDate('report_date','>=', $start_date);
        }
        if (!is_null($req->date_end)){
            $data['hotels'] = $data['hotels']->whereDate('report_date','<=', $end_date);
        }
        $data['hotels'] = $data['hotels']->orderBy('id', 'DESC')->get();
    }else{
        $data['hotels'] = array();
    }
    if (!$req->type || ($req->type && $req->type == 'tour_package')) {

        $data['packages']    = TourPackage::whereNotNull('id');
        if (!is_null($req->party)){
            $data['packages'] = $data['packages']->where('parties_id', $req->party);
        }
            if (!is_null($req->supplier)){
                $data['packages'] = $data['packages']->where('suppliers_id', $req->supplier);
            }
              if (!is_null($req->passenger)){
               $data['packages'] = $data['packages']->where('passenger_name','LIKE','%'.$req->passenger.'%');
            }
            if (!is_null($req->staff)){
                $data['packages'] = $data['packages']->where('admins_id', $req->staff);
            }
       /* if (auth()->guard('admin')->user()->type == 'admin') {
     
        }else{
            $data['packages'] = $data['packages']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->date_start)){
            $data['packages'] = $data['packages']->whereDate('report_date','>=', $start_date);
        }
        if (!is_null($req->date_end)){
            $data['packages'] = $data['packages']->whereDate('report_date','<=', $end_date);
        }
        $data['packages'] = $data['packages']->orderBy('id', 'DESC')->get();
    }else{
        $data['packages'] = array();
    }
    if (!$req->type || ($req->type && $req->type == 'umrah_sales')) {
        $data['umrah']    = UmrahSale::whereNotNull('id');

        if (!is_null($req->party)){
            $data['umrah'] = $data['umrah']->where('parties_id', $req->party);
        }
        if (!is_null($req->supplier)){
            $data['umrah'] = $data['umrah']->where('suppliers_id', $req->supplier);
        }
        if (!is_null($req->passenger)){
         $data['umrah'] = $data['umrah']->where('passenger_name','LIKE','%'.$req->passenger.'%');
        }
         if (!is_null($req->staff)){
            $data['umrah'] = $data['umrah']->where('admins_id', $req->staff);
        }
      /*  if (auth()->guard('admin')->user()->type == 'admin') {
         
        }else{
            $data['umrah'] = $data['umrah']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->date_start)){
            $data['umrah'] = $data['umrah']->whereDate('report_date','>=', $start_date);
        }
        if (!is_null($req->date_end)){
            $data['umrah'] = $data['umrah']->whereDate('report_date','<=', $end_date);
        }
        $data['umrah'] = $data['umrah']->orderBy('id', 'DESC')->get();
    }else{
        $data['umrah'] = array();
    }

    if (!$req->type || ($req->type && $req->type == 'travel_insurance')) {
        $data['travel']    = TravelInsurance::whereNotNull('id');

        if (!is_null($req->party)){
            $data['travel'] = $data['travel']->where('parties_id', $req->party);
        }
        if (!is_null($req->supplier)){
            $data['travel'] = $data['travel']->where('suppliers_id', $req->supplier);
        }
        if (!is_null($req->passenger)){
         $data['travel'] = $data['travel']->where('passenger_name','LIKE','%'.$req->passenger.'%');
     }
       if (!is_null($req->staff)){
                $data['travel'] = $data['travel']->where('admins_id', $req->staff);
            }
        /*if (auth()->guard('admin')->user()->type == 'admin') {
          
        }else{
            $data['travel'] = $data['travel']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->date_start)){
            $data['travel'] = $data['travel']->whereDate('report_date','>=', $start_date);
        }
        if (!is_null($req->date_end)){
            $data['travel'] = $data['travel']->whereDate('report_date','<=', $end_date);
        }
        $data['travel'] = $data['travel']->orderBy('id', 'DESC')->get();
    }else{
        $data['travel'] = array();
    }
       /* $data['data'] = array_merge($data['tickets'],$data['travel'],$data['umrah'],$data['packages'],$data['hotels'],$data['sales']);*/
        return view('user.tasks.search.index', $data);
    }
}
