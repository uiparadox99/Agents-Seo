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

class TicketController extends Controller
{
    public function index(Request $req)
    {
        $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins_id'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers'] 	= Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights'] 	= Flight::orderBy('name', 'ASC')->get();
        $data['tickets']    = Ticket::whereNotNull('id')->where('agents_id',auth()->user()->id);

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
         /*  if (auth()->guard('admin')->user()->type == 'admin') {
               
            }else{
                $data['tickets'] = $data['tickets']->where('admins_id', auth()->guard('admin')->user()->id);
            }*/
        $data['tickets'] = $data['tickets']->orderBy('id', 'DESC')->get();
        return view('user.tasks.tickets.manage-tickets', $data);
    }

    public function showAddForm()
    {
        $data['parties'] 	= Vendee::with('passengers')->where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers'] 	= Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights']    = Flight::orderBy('name', 'ASC')->get();
        $data['airlines']   = Airline::orderBy('name', 'ASC')->get();
        $data['Ticektstatuses'] 	= Status::where('type','tickets')->orderBy('name', 'ASC')->get();
         $data['new_invoice_no'] = '';
        $no  = DB::select("SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'task_management'
            AND   TABLE_NAME   = 'tickets'");
 
        if ($no) {
             $data['new_invoice_no'] = $no[0]->AUTO_INCREMENT;
        }

        return view('user.tasks.tickets.add-ticket', $data);
    }

    public function saveTicket(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'ticket_no'     => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        $total_tax = $req->tax+$req->tax2+$req->tax3+$req->tax4;

        $dob = $req->dob;
        DB::beginTransaction();
        try{

            if (is_null($req->id)){
                $duplicateNo        = Ticket::where('ticket_no', $req->ticket_no)->first();
                if (!is_null($duplicateNo)) {
                    Session::flash("error-msg", 'Ticket Already Added');
                    return redirect()->back()->withInput(Input::all());
                }
                $t                  = New Ticket;
                $t->ticket_no       = $req->ticket_no;
                $t->sector          = strtoupper($req->sector);
                $t->pax_name        = strtoupper($req->pax_name);
                $t->phone           = $req->phone;
                $t->agents_id       = auth()->user()->id;
                $t->report_date     = $req->report_date;
                $t->flights_id      = $req->flights_id;
                $t->flights_id_2      = $req->flights_id_2;
                $t->flights_id_3      = $req->flights_id_3;
                $t->flights_id_4      = $req->flights_id_4;
                $t->airline_pnr      = strtoupper($req->airline_pnr);
                $t->gds               = strtoupper($req->gds);
                $t->travel_date     =   !empty($req->travel_date)?date('Y-m-d', strtotime($req->travel_date)):'';
                $t->travel_date_2     = !empty($req->travel_date_2)  && !empty($t->flights_id_2)?date('Y-m-d', strtotime($req->travel_date_2)):'';
                $t->travel_date_3     = !empty($req->travel_date_3)  && !empty($t->flights_id_3)?date('Y-m-d', strtotime($req->travel_date_3)):'';
                $t->travel_date_4     = !empty($req->travel_date_4)  && !empty($t->flights_id_4)?date('Y-m-d', strtotime($req->travel_date_4)):'';
                $t->agents_id       = auth()->user()->id;
                $t->parties_id      = $req->parties_id;
                $t->suppliers_id    = $req->suppliers_id;
                $t->airlines_id     = $req->airline;
                $t->given_name      = $req->given_name;
                $t->surname         = $req->surname;
                $t->title           = $req->title;
                $t->passport           = strtoupper($req->passport);
                $t->dob           = $dob;
                $t->save();

                $remarks     = $req->ticket_no.'/'.strtoupper($req->sector).'/'.$req->flights_id.'/'.strtoupper($req->pax_name);

                // $c                  = New CallLog;
                // $c->sector          = strtoupper($req->sector);
                // $c->travel_date     = date('Y-m-d', strtotime($req->report_date));
                // $c->booking_detail  = $remarks;
                // $c->call_date_time  = date('Y-m-d H:i');
                // $c->admins_id       = $req->admins_id;
                // $c->vendees_id      = $req->parties_id;
              
                // $c->flights_id      = $req->flights_id;
                // $c->tickets_id      = $t->id;
                // $c->save();

                $party       = Vendee::where('id', $req->parties_id)->first();
                $supplier    = Vendee::where('id', $req->suppliers_id)->first();


                if (!is_null($req->parties_id) && !is_null($req->suppliers_id)){

                    $to_current_balance             = $party->current_balance;
                    $from_current_balance           = $supplier->current_balance;

                    $trans                          = New Transaction;
                    $trans->to_current_balance      = $to_current_balance;
                    $trans->from_current_balance    = $from_current_balance;
                    $trans->trans_type              = 'ticket';
                    $trans->payment_mode            = '';
                    $trans->from                    = $req->parties_id;
                    $trans->to                      = $req->suppliers_id;
                    $trans->agents_id       = auth()->user()->id;
                    $trans->tickets_id              = $t->id;
                    $trans->trans_date              = $req->report_date;
                    $trans->fare                    = $req->fare;
                     $trans->tax                     = $req->tax;
                    $trans->tax2                     = $req->tax2;
                    $trans->tax3                     = $req->tax3;
                    $trans->tax4                     = $req->tax4;
                    $trans->total_tax               = $total_tax;
                    $trans->cost                    = $req->cost;
                    $trans->sale                    = $req->sale;
                    $trans->profit                  = $req->profit;
                    $trans->save();

                    $party->current_balance         = $to_current_balance - $req->sale;
                    $party->save();

                    $supplier->current_balance      = $from_current_balance + $req->cost;
                    $supplier->save();

                    //update cash in hand amount
                         $current_cash = Vendee::where('agents_id',auth()->user()->id)->where('name', 'CASH IN HAND')->first();
                if(is_null($current_cash)){
                    $current_cash = new Vendee;
                    $current_cash->name ='CASH IN HAND';
                    $current_cash->agents_id = auth()->user()->id;
                    $current_cash->current_balance = 0;
                    $ccSaved = $current_cash->save();
                }
                    if ($req->profit < 0){
                   
                        $current_cash->current_balance = $current_cash->current_balance - $req->profit;
                    }else{
                        
                        $current_cash->current_balance = $current_cash->current_balance + $req->profit;

                    }
                    $current_cash->save();
                }
            }else{

                $t              = Ticket::with('trans')->where('id', $req->id)->first();
                $party          = Vendee::where('id', $t->trans->from)->first();
                $supplier       = Vendee::where('id', $t->trans->to)->first();
                $current_cash   = Vendee::where('id', 1)->where('name', 'CASH IN HAND')->first();

                $party->current_balance         = $party->current_balance + $t->trans->sale;
                $party->save();

                $supplier->current_balance      = $supplier->current_balance - $t->trans->cost;
                $supplier->save();

                $current_cash->current_balance  = $current_cash->current_balance - $t->trans->profit;
                $current_cash->save();

                $party       = Vendee::where('id', $req->parties_id)->first();
                $supplier    = Vendee::where('id', $req->suppliers_id)->first();

                $t->ticket_no       = $req->ticket_no;
                $t->sector          = strtoupper($req->sector);
                $t->pax_name        = strtoupper($req->pax_name);
                $t->phone           = $req->phone;
                $t->agents_id       = auth()->user()->id;
                $t->flights_id      = $req->flights_id;
                $t->report_date     = $req->report_date;
                   $t->flights_id_2      = $req->flights_id_2;
                $t->flights_id_3      = $req->flights_id_3;
                $t->flights_id_4      = $req->flights_id_4;
                $t->airline_pnr      = strtoupper($req->airline_pnr);
                $t->gds               = strtoupper($req->gds);
                $t->travel_date     =   !empty($req->travel_date)?date('Y-m-d', strtotime($req->travel_date)):'';
                $t->travel_date_2     = !empty($req->travel_date_2) && !empty($t->flights_id_2)?date('Y-m-d', strtotime($req->travel_date_2)):'';
                $t->travel_date_3     = !empty($req->travel_date_3)  && !empty($t->flights_id_3)?date('Y-m-d', strtotime($req->travel_date_3)):'';
                $t->travel_date_4     = !empty($req->travel_date_4)  && !empty($t->flights_id_4)?date('Y-m-d', strtotime($req->travel_date_4)):'';
                $t->agents_id       = auth()->user()->id;
                $t->parties_id      = $req->parties_id;
                $t->suppliers_id    = $req->suppliers_id;
                 $t->airlines_id    = $req->airline;
                $t->given_name      = $req->given_name;
                $t->surname         = $req->surname;
                $t->title           = $req->title;
                $t->passport           = strtoupper($req->passport);
                $t->dob           = $dob;
                $t->save();

                $remarks     = $req->ticket_no.'/'.strtoupper($req->sector).'/'.$req->flights_id.'/'.strtoupper($req->pax_name);

                // $c                  = CallLog::where("tickets_id", $t->id)->first();
                // if (is_null($c)) {
                //     $c                  = new CallLog;
                //     $c->tickets_id                  = $t->id;
                // }
                //     $c->sector          = strtoupper($req->sector);
                //     $c->travel_date     = date('Y-m-d', strtotime($req->report_date));
                //     $c->booking_detail  = $remarks;
                //     $c->call_date_time  = date('Y-m-d H:i');
                //     $c->admins_id       = $req->admins_id;
                //     $c->vendees_id      = $req->parties_id;
                //     $c->flights_id      = $req->flights_id;
              
                // $c->save();

                if (!is_null($req->parties_id) && !is_null($req->suppliers_id)){

                    $FT = Transaction::where('id','<', $t->trans->id)->where('from', $party->id)->orderby('id','DESC')->first();
                    if (!is_null($FT)) {
                       $to_current_balance = $FT->to_current_balance - $FT->sale;
                   }else{
                       $to_current_balance             = $party->current_balance;
                   }
                   
                   $TT = Transaction::where('id','<', $t->trans->id)->where('to', $supplier->id)->orderby('id','DESC')->first();
                   

                   if (!is_null($TT)) {
                      $from_current_balance = $TT->from_current_balance  - $TT->cost;
                  }else{
                    
                    $from_current_balance           = $supplier->current_balance;
                }
                    
                    $trans                          = Transaction::where('id', $t->trans->id)->first();
                    $trans->to_current_balance      = $to_current_balance;
                    $trans->from_current_balance    = $from_current_balance;
                    $trans->trans_type              = 'ticket';
                    $trans->payment_mode            = '';
                    $trans->from                    = $req->parties_id;
                    $trans->to                      = $req->suppliers_id;
                    $trans->agents_id       = auth()->user()->id;
                    $trans->tickets_id              = $t->id;
                    $trans->trans_date              = $req->report_date;
                    $trans->fare                    = $req->fare;
                    $trans->tax                     = $req->tax;
                    $trans->tax2                     = $req->tax2;
                    $trans->tax3                     = $req->tax3;
                    $trans->tax4                     = $req->tax4;
                    $trans->total_tax               = $total_tax;
                    $trans->cost                    = $req->cost;
                    $trans->sale                    = $req->sale;
                    $trans->profit                  = $req->profit;
                    $trans->save();

                    $party->current_balance         = $to_current_balance - $req->sale;
                    $party->save();

                    $supplier->current_balance      = $from_current_balance + $req->cost;
                    $supplier->save();

                    //update cash in hand amount
                    if ($req->profit < 0){
                        $current_cash = Vendee::where('id', 1)->where('name', 'CASH IN HAND')->first();
                        $current_cash->current_balance = $current_cash->current_balance - $req->profit;
                        $current_cash->save();
                    }else if($req->profit > 0){
                        $current_cash = Vendee::where('id', 1)->where('name', 'CASH IN HAND')->first();
                        $current_cash->current_balance = $current_cash->current_balance + $req->profit;
                        $current_cash->save();

                    }
                }

            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            $msg = $e->getMessage();
            dd($e);
            Session::flash("error-msg", $msg);
            return redirect()->back()->withInput(Input::all());
        }
        if ($req->copy_form == 1) {
            $request = $req->all();
            unset($request['_token']);
            $request = http_build_query($request);
            return redirect()->to('admin/add-entry?'.$request);
        }else{
            return redirect()->route('manage-tickets');
        }

    }

    public function showEditForm($id)
    {
        $data['parties'] 	= Vendee::with('passengers')->where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers'] 	= Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights'] 	= Flight::orderBy('name', 'ASC')->get();
        $data['tickets'] 	= Ticket::with('trans')->where('id', $id)->first();
        $data['airlines']   = Airline::orderBy('name', 'ASC')->get();
         $data['Ticektstatuses']    = Status::where('type','tickets')->orderBy('name', 'ASC')->get();
          $data['new_invoice_no'] = '';
        $no  = DB::select("SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'task_management'
            AND   TABLE_NAME   = 'tickets'");
 
        if ($no) {
             $data['new_invoice_no'] = $no[0]->AUTO_INCREMENT;
        }

        return view('user.tasks.tickets.add-ticket', $data);
    }

     public function incomeReport(Request $req)
    {
        $data['parties']    = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['admins_id']  = Agents::orderBy('business_name', 'ASC')->get();
        $data['suppliers']  = Vendee::where('status', 1)->where('type', 'supplier')->orderBy('name', 'ASC')->get();
        $data['flights']    = Flight::orderBy('name', 'ASC')->get();

        if (!is_null($req->date_start)){
            $start_date = date('Y-m-d',strtotime($req->date_start));
        }else{
            return view('user.tasks.tickets.income-report', $data);
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

       /* if (auth()->guard('admin')->user()->type == 'admin') {
          
        }else{
            $data['sales'] = $data['sales']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
          if (!is_null($req->staff)){
                $data['sales'] = $data['sales']->where('admins_id', $req->staff);
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
       /* if (auth()->guard('admin')->user()->type == 'admin') {
            
        }else{
            $data['hotels'] = $data['hotels']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->staff)){
            $data['hotels'] = $data['hotels']->where('admins_id', $req->staff);
        }
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
        /*if (auth()->guard('admin')->user()->type == 'admin') {
           
        }else{
            $data['packages'] = $data['packages']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->staff)){
            $data['packages'] = $data['packages']->where('admins_id', $req->staff);
        }
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
       /* if (auth()->guard('admin')->user()->type == 'admin') {
         
        }else{
            $data['umrah'] = $data['umrah']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
        if (!is_null($req->staff)){
            $data['umrah'] = $data['umrah']->where('admins_id', $req->staff);
        }
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
       /* if (auth()->guard('admin')->user()->type == 'admin') {
          
        }else{
            $data['travel'] = $data['travel']->where('admins_id', auth()->guard('admin')->user()->id);
        }*/
          if (!is_null($req->staff)){
                $data['travel'] = $data['travel']->where('admins_id', $req->staff);
            }
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
        return view('user.tasks.tickets.income-report', $data);
    }
}
