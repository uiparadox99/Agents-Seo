<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use App\TasksModels\Vendee;
use App\TasksModels\Transaction;
use App\TasksModels\TourPackage;
use App\TasksModels\UmrahSale;
use App\TasksModels\TravelInsurance;
use App\TasksModels\OtherSale;
use App\TasksModels\HotelSale;
class TransactionController extends Controller
{
    public function index(Request $req)
    {
        $data['parties'] 	= Vendee::where('status', 1)
            ->where('type', 'party')
            ->where('is_show_in_accounts', 1)
            ->orderBy('name', 'ASC')->get();

        $data['suppliers'] 	= Vendee::where('status', 1)
            ->where('type', 'supplier')
            ->where('is_show_in_accounts', 1)
            ->orderBy('name', 'ASC')->get();
       if (!is_null($req->suppliers_id) || !is_null($req->parties_id)){


        $data['transactions'] = Transaction::with('ticket')->whereNotNull('id');

        if (!is_null($req->suppliers_id)){
            $data['transactions'] = $data['transactions']->where(function($query) use ($req) {
                $query->where('from', $req->suppliers_id)
                ->orWhere('to', $req->suppliers_id);
            });
            $data['id']           = $req->suppliers_id;
        }
          if (!is_null($req->parties_id)){
            $data['transactions'] = $data['transactions']->where(function($query) use ($req) {
                $query->where('from', $req->parties_id)
                ->orWhere('to', $req->parties_id);
            });
            $data['id']           = $req->parties_id;
        }
        if (!is_null($req->date_start) && !is_null($req->date_end)){
            $data['transactions'] = $data['transactions']->whereDate('trans_date', '>=', date('Y-m-d', strtotime($req->date_start)));
            $data['transactions'] = $data['transactions']->whereDate('trans_date', '<=', date('Y-m-d', strtotime($req->date_end)));
        }
        $data['transactions'] = $data['transactions']->orderBy('trans_date', 'ASC')->orderBy('id', 'ASC')->paginate(50)->appends($req->except('page'));

/*
        $data['packages'] = TourPackage::whereNotNull('id');

        if (!is_null($req->suppliers_id)){
            $data['packages'] = $data['packages']->where('suppliers_id', $req->suppliers_id);
            $data['id']           = $req->suppliers_id;
        }
          if (!is_null($req->parties_id)){
            $data['packages'] = $data['packages']->where('parties_id', $req->parties_id);
            $data['id']           = $req->parties_id;
        }
        if (!is_null($req->date_start) && !is_null($req->date_end)){
            $data['packages'] = $data['packages']->whereDate('report_date', '>=', date('Y-m-d', strtotime($req->date_start)));
            $data['packages'] = $data['packages']->whereDate('report_date', '<=', date('Y-m-d', strtotime($req->date_end)));
        }
        $data['packages'] = $data['packages']->orderBy('report_date', 'ASC')->orderBy('id', 'ASC')->get();


        $data['umrah'] = UmrahSale::whereNotNull('id');

        if (!is_null($req->suppliers_id)){
            $data['umrah'] = $data['umrah']->where('suppliers_id', $req->suppliers_id);
            $data['id']           = $req->suppliers_id;
        }
          if (!is_null($req->parties_id)){
            $data['umrah'] = $data['umrah']->where('parties_id', $req->parties_id);
            $data['id']           = $req->parties_id;
        }
        if (!is_null($req->date_start) && !is_null($req->date_end)){
            $data['umrah'] = $data['umrah']->whereDate('report_date', '>=', date('Y-m-d', strtotime($req->date_start)));
            $data['umrah'] = $data['umrah']->whereDate('report_date', '<=', date('Y-m-d', strtotime($req->date_end)));
        }
        $data['umrah'] = $data['umrah']->orderBy('report_date', 'ASC')->orderBy('id', 'ASC')->get();

         $data['travel'] = TravelInsurance::whereNotNull('id');

        if (!is_null($req->suppliers_id)){
            $data['travel'] = $data['travel']->where('suppliers_id', $req->suppliers_id);
            $data['id']           = $req->suppliers_id;
        }
          if (!is_null($req->parties_id)){
            $data['travel'] = $data['travel']->where('parties_id', $req->parties_id);
            $data['id']           = $req->parties_id;
        }
        if (!is_null($req->date_start) && !is_null($req->date_end)){
            $data['travel'] = $data['travel']->whereDate('report_date', '>=', date('Y-m-d', strtotime($req->date_start)));
            $data['travel'] = $data['travel']->whereDate('report_date', '<=', date('Y-m-d', strtotime($req->date_end)));
        }
        $data['travel'] = $data['travel']->orderBy('report_date', 'ASC')->orderBy('id', 'ASC')->get();

          $data['sales'] = OtherSale::whereNotNull('id');

        if (!is_null($req->suppliers_id)){
            $data['sales'] = $data['sales']->where('suppliers_id', $req->suppliers_id);
            $data['id']           = $req->suppliers_id;
        }
          if (!is_null($req->parties_id)){
            $data['sales'] = $data['sales']->where('parties_id', $req->parties_id);
            $data['id']           = $req->parties_id;
        }
        if (!is_null($req->date_start) && !is_null($req->date_end)){
            $data['sales'] = $data['sales']->whereDate('report_date', '>=', date('Y-m-d', strtotime($req->date_start)));
            $data['sales'] = $data['sales']->whereDate('report_date', '<=', date('Y-m-d', strtotime($req->date_end)));
        }
        $data['sales'] = $data['sales']->orderBy('report_date', 'ASC')->orderBy('id', 'ASC')->get();
         $data['hotels'] = HotelSale::whereNotNull('id');

        if (!is_null($req->suppliers_id)){
            $data['hotels'] = $data['hotels']->where('suppliers_id', $req->suppliers_id);
            $data['id']           = $req->suppliers_id;
        }
          if (!is_null($req->parties_id)){
            $data['hotels'] = $data['hotels']->where('parties_id', $req->parties_id);
            $data['id']           = $req->parties_id;
        }
        if (!is_null($req->date_start) && !is_null($req->date_end)){
            $data['hotels'] = $data['hotels']->whereDate('report_date', '>=', date('Y-m-d', strtotime($req->date_start)));
            $data['hotels'] = $data['hotels']->whereDate('report_date', '<=', date('Y-m-d', strtotime($req->date_end)));
        }
        $data['hotels'] = $data['hotels']->orderBy('report_date', 'ASC')->orderBy('id', 'ASC')->get();*/


        }else{
            $data['transactions'] = null;
            $data['packages'] = null;
            $data['umrah'] = null;
            $data['travel'] = null;
            $data['sales'] = null;
            $data['hotels'] = null;
        }
        return view('user.tasks.transactions.transactions', $data);
    }
}
