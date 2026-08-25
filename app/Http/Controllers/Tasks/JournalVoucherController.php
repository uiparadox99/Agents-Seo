<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\Vendee;
use App\TasksModels\Transaction;
use Illuminate\Support\Facades\DB;

class JournalVoucherController extends Controller
{
    public function index()
    {
        $data['vendees'] 	= Vendee::where('status', 1)
            ->where('is_show_in_accounts', 1)
            ->orderBy('name', 'ASC')->get();

        return view('user.tasks.journal-voucher.journal-voucher', $data);
    }

    public function save(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'from'          => 'required',
            'to'            => 'required',
            'amount'        => 'required',
            'payment_mode'  => 'required',
            'trans_date'    => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        DB::beginTransaction();

        try{
            $admins_id = auth()->guard('admin')->user()->id;

            if (is_null($req->id)){
                if (!is_null($req->from) && !is_null($req->to)){

                    $from       = Vendee::where('id', $req->from)->first();
                    $to         = Vendee::where('id', $req->to)->first();

                    $trans                         = New Transaction;
                    $trans->from_current_balance   = $from->current_balance;
                    $trans->to_current_balance     = $to->current_balance;
                    $trans->from                   = $req->from;
                    $trans->to                     = $req->to;
                    $trans->amount                 = $req->amount;
                    $trans->payment_mode           = $req->payment_mode;
                    $trans->trans_type             = 'transfer';
                    $trans->admins_id              = $admins_id;
                    $trans->trans_date             = $req->trans_date;
                    $trans->from_remarks           = $req->from_remarks;
                    $trans->to_remarks             = $req->to_remarks;
                    $trans->save();

                    $from->current_balance       = $from->current_balance - $req->amount;
                    $from->save();

                    $to->current_balance         = $to->current_balance + $req->amount;
                    $to->save();

                }
            }else{

                if (!is_null($req->from) && !is_null($req->to)){

                    $trans      = Transaction::where('id', $req->id)->first();

                    $from       = Vendee::where('id', $trans->from)->first();
                    $to         = Vendee::where('id', $trans->to)->first();

                    $from->current_balance         = $from->current_balance + $trans->amount;
                    $from->save();

                    $to->current_balance           = $to->current_balance - $trans->amount;
                    $to->save();

                    $from       = Vendee::where('id', $req->from)->first();
                    $to         = Vendee::where('id', $req->to)->first();

                    $trans->from_current_balance   = $from->current_balance;
                    $trans->to_current_balance     = $to->current_balance;
                    $trans->from                   = $req->from;
                    $trans->to                     = $req->to;
                    $trans->amount                 = $req->amount;
                    $trans->payment_mode           = $req->payment_mode;
                    $trans->trans_type             = 'transfer';
                    $trans->admins_id              = $admins_id;
                    $trans->trans_date             = $req->trans_date;
                    $trans->from_remarks           = $req->from_remarks;
                    $trans->to_remarks             = $req->to_remarks;
                    $trans->save();

                    $from->current_balance       = $from->current_balance - $req->amount;
                    $from->save();

                    $to->current_balance         = $to->current_balance + $req->amount;
                    $to->save();

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
        Session::flash("success-msg", "Completed Successfully.");
        return redirect()->route('journal-voucher');
    }

    public function showEditForm($id){
        $data['trans']      = Transaction::where('id', $id)->first();

        $data['vendees'] 	= Vendee::where('status', 1)
            ->where('is_show_in_accounts', 1)
            ->orderBy('name', 'ASC')->get();

        return view('user.tasks.journal-voucher.journal-voucher', $data);
    }
}
