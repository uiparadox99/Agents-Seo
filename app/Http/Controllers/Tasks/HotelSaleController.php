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
use App\TasksModels\HotelSale;
use App\TasksModels\RoomTypes;
use App\Agents;
use DB;

class HotelSaleController extends Controller
{
    public function index(Request $req)
    {
         $data['parties']   = Vendee::where('status', 1)->where('type', 'party')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        $data['admins_id']  = Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
    $data['hotels']    = HotelSale::whereNotNull('id')->where('agents_id', auth()->user()->id);

        if (!is_null($req->hotel_name)){
            $data['hotels'] = $data['hotels']->where('hotel_name','LIKE','%'.$req->hotel_name.'%');
        }

        if (!is_null($req->party)){
            $data['hotels'] = $data['hotels']->where('parties_id', $req->party);
        }
        if (!is_null($req->supplier)){
            $data['hotels'] = $data['hotels']->where('suppliers_id', $req->supplier);
        }
          /* if (auth()->guard('admin')->user()->type == 'admin') {
              
            }else{
                $data['hotels'] = $data['hotels']->where('admins_id', auth()->guard('admin')->user()->id);
            }*/
              if (!is_null($req->staff)){
                    $data['hotels'] = $data['hotels']->where('admins_id', $req->staff);
                }
        if (!is_null($req->date_start)){
            $data['hotels'] = $data['hotels']->where('report_date','>=', date('Y-m-d',strtotime($req->date_start)));
        }
        if (!is_null($req->date_end)){
            $data['hotels'] = $data['hotels']->where('report_date','<=', date('Y-m-d',strtotime($req->date_end)));
        }
        $data['hotels'] = $data['hotels']->orderBy('id', 'DESC')->get();
    

        return view('user.tasks.hotelSale.manage-hotels', $data);
    }

    public function showAddForm()
    {
        $data['roomTypes'] 	= RoomTypes::orderBy('name', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->where('agents_id', auth()->user()->id)->get();
         $data['parties']   = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->where('agents_id', auth()->user()->id)->get();
           $data['admins']  = Agents::orderBy('business_name', 'ASC')->get();

        return view('user.tasks.hotelSale.add-hotel', $data);
    }

    public function saveForm(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'report_date'     => 'required',
            'passenger_name'     => 'required',
            'parties_id'     => 'required',
            'suppliers_id'     => 'required',
            'room_types_id'     => 'required',
            'hotel_name'     => 'required',
            'cost'     => 'required',
            'sale'     => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }


        if (!is_null($req->id)) {
            $h    = HotelSale::where('id', $req->id)->first();
        }else{
            $h    = New HotelSale;
        }
        $h->report_date = date('Y-m-d',strtotime($req->report_date));
        $h->passenger_name = $req->passenger_name;
        $h->hotel_name = $req->hotel_name;
        $h->phone = $req->phone;
        $h->check_in = $req->check_in;
        $h->check_out = $req->check_out;
        $h->cost = $req->cost;
        $h->sale = $req->sale;
        $h->profit = $req->profit;
        $h->remarks = $req->remarks;
        $h->parties_id = $req->parties_id;
        $h->suppliers_id = $req->suppliers_id;
        $h->agents_id               =  auth()->user()->id;
        $h->room_types_id = $req->room_types_id;
        $isSave = $h->save();
        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-hotel-sale');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }

    }

    public function showEditForm($id)
    {
          $data['roomTypes']    = RoomTypes::orderBy('name', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
         $data['parties']   = Vendee::where('status', 1)->where('type', 'party')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        $data['detail'] 	= HotelSale::where('id', $id)->first();
          $data['admins']   = Agents::orderBy('business_name', 'ASC')->get();

        return view('user.tasks.hotelSale.add-hotel', $data);
    }
}
