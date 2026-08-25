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
use App\TasksModels\VisaSale;
use App\TasksModels\VisaTypes;
use App\Country;
use App\TasksModels\TourPackage;
use App\TasksModels\UmrahSale;
use App\TasksModels\TravelInsurance;
use App\Agents;
use DB;

class TravelInsuranceController extends Controller
{
    public function index(Request $req)
    {
         $data['parties']   = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
         $data['admins_id']  = Agents::orderBy('business_name', 'ASC')->get();
         $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
         $data['travel']    = TravelInsurance::whereNotNull('id');

        if (!is_null($req->hotel_name)){
            $data['travel'] = $data['travel']->where('hotel_name','LIKE','%'.$req->hotel_name.'%');
        }

        if (!is_null($req->party)){
            $data['travel'] = $data['travel']->where('parties_id', $req->party);
        }
        if (!is_null($req->supplier)){
            $data['travel'] = $data['travel']->where('suppliers_id', $req->supplier);
        }
        /*if (auth()->guard('admin')->user()->type == 'admin') {
           
        }else{
            $data['travel'] = $data['travel']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->staff)){
            $data['travel'] = $data['travel']->where('admins_id', $req->staff);
        }
        if (!is_null($req->date_start)){
            $data['travel'] = $data['travel']->where('report_date','>=', date('Y-m-d',strtotime($req->date_start)));
        }
        if (!is_null($req->date_end)){
            $data['travel'] = $data['travel']->where('report_date','<=', date('Y-m-d',strtotime($req->date_end)));
        }
        $data['travel'] = $data['travel']->orderBy('id', 'DESC')->get();
    

        return view('user.tasks.travelInsurance.manage-travel-insurance', $data);
    }

    public function showAddForm()
    {
         $data['countries']    = Country::orderBy('country', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
         $data['parties']   = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
           $data['admins']  = Agents::orderBy('business_name', 'ASC')->get();

        return view('user.tasks.travelInsurance.add-travel-insurance', $data);
    }

    public function saveForm(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'report_date'     => 'required',
            'passenger_name'     => 'required',
            'parties_id'     => 'required',
            'suppliers_id'     => 'required',
            'cost'     => 'required',
            'sale'     => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if (!is_null($req->id)) {
            $h    = TravelInsurance::where('id', $req->id)->first();
        }else{
            $h    = New TravelInsurance;
        }
        $h->report_date = date('Y-m-d',strtotime($req->report_date));
        $h->passenger_name = $req->passenger_name;
        $h->phone = $req->phone;
        $h->cost = $req->cost;
        $h->sale = $req->sale;
        $h->profit = $req->profit;
        $h->remarks = $req->remarks;
        $h->parties_id = $req->parties_id;
        $h->suppliers_id = $req->suppliers_id;
        $h->admins_id       = $req->admins_id;
        $h->days = $req->days;
        $h->countries_id = $req->countries_id;
        $isSave = $h->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-travel-insurance');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }

    }

    public function showEditForm($id)
    {
          $data['countries']    = Country::orderBy('country', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
         $data['parties']   = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['detail'] 	= TravelInsurance::where('id', $id)->first();
          $data['admins']   = Agents::orderBy('business_name', 'ASC')->get();

        return view('user.tasks.travelInsurance.add-travel-insurance', $data);
    }
}
