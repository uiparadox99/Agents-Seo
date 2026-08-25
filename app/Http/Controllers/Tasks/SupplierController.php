<?php

namespace App\Http\Controllers\Tasks;

use App\TasksModels\Vendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\AccountCategory;
use App\TasksModels\Transaction;

class SupplierController extends Controller
{
    public function index()
    {
    	$data['suppliers'] = Vendee::where('type', 'supplier')->where('agents_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
    	return view('user.tasks.suppliers.manage-suppliers', $data);
    }

    public function showAddForm()
    {
        $data['categories'] = AccountCategory::where('for_supplier', 1)->orderBy('name', 'ASC')->get();
    	return view('user.tasks.suppliers.add-supplier', $data);
    }

    public function saveSupplier(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        
        if (!is_null($req->id)) {
            $s    = Vendee::where('id', $req->id)->first();
        }else{
            $s    = New Vendee;
        }

        $code                   = Vendee::where('account_categories_id', $req->category)->first();

        if (is_null($code)){
            $categoryCode       = AccountCategory::where('for_supplier', 1)->where('id', $req->category)->first()->code;
            $counter            = 1;
            $code               = $categoryCode;
        }else{
            $counter            = Vendee::where('account_categories_id', $req->category)
                ->max('counter');
            $categoryCode       = AccountCategory::where('for_supplier', 1)->where('id', $req->category)->first()->code;
            $counter            = $counter + 1;
            $code               = $categoryCode;
        }

        $s->name                    = strtoupper($req->name);
        $s->is_show_in_accounts     = $req->is_show_in_accounts;
        $s->type                    = $req->type;
        $s->account_categories_id   = $req->category;
        $s->code                    = $code."-".$counter;
        $s->counter                 = $counter;
        $s->counter                 = $counter;
        $s->agents_id               =  auth()->user()->id;
        $isSave                     = $s->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->route('manage-suppliers');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }

    public function showEditForm($id)
    {
        $data['supplier']   = Vendee::where('id', $id)->first();
        $data['categories'] = AccountCategory::where('for_supplier', 1)->orderBy('name', 'ASC')->get();
        return view('user.tasks.suppliers.add-supplier', $data);
    }

    public function supplierTransactions($id)
    {
        $data['transactions'] = Transaction::with('ticket')->where('agents_id', auth()->user()->id)
            ->orWhere('to', $id)
            ->orWhere('from', $id)->orderBy('id', 'DESC')->get();
        $data['id']           = $id;
        $data['supplier']     = Vendee::where('id', $id)->first();

        return view('user.tasks.suppliers.supplier-transactions', $data);
    }

    public function showAddAmountForm($id)
    {
        $data['id'] = $id;
        return view('user.tasks.suppliers.add-amount', $data);
    }

    public function saveAmount(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'amount'        => 'required',
            'payment_mode'  => 'required',
            'trans_date'    => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        
        if (!is_null($req->id)) {
            $t    = Transaction::where('id', $req->id)->first();
        }else{
            $t    = New Transaction;
        }

        $s                      = Vendee::where('id', $req->sup_id)->first();
        
        $t->amount              = $req->amount;
        $t->current_balance     = $s->current_amount;
        $t->remarks             = $req->remarks;
        $t->payment_mode        = $req->payment_mode;
        $t->trans_date          = $req->trans_date;
        $t->suppliers_id        = $req->sup_id;
        $t->type                = 'RECEIVED';
        $t->agents_id               =  auth()->user()->id;
        $isSaveTrans            = $t->save();

        $current_balance        = $req->amount - $s->current_balance;
        $s->current_balance     = $current_balance;
        $isSaveSup              = $s->save();

        if ($isSaveTrans && $isSaveSup) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->route('supplier-transactions', $req->sup_id);
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }

    public function showDeductAmountForm($id)
    {
       $data['id'] = $id;
       return view('user.tasks.suppliers.deduct-amount', $data);
    }

    public function deductAmount(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'amount'        => 'required',
            'trans_date'    => 'required',
            'remarks'       => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        
        if (!is_null($req->id)) {
            $t    = Transaction::where('id', $req->id)->first();
        }else{
            $t    = New Transaction;
        }

        $s                      = Vendee::where('id', $req->sup_id)->first();
        
        $t->amount              = $req->amount;
        $t->current_balance     = $s->current_balance;
        $t->remarks             = $req->remarks;
        $t->payment_mode        = $req->payment_mode;
        $t->trans_date          = $req->trans_date;
        $t->suppliers_id        = $req->sup_id;
        $t->type                = 'PAID';
        $t->agents_id               =  auth()->user()->id;
        $isSaveTrans            = $t->save();

        $current_balance        = $req->amount + $s->current_balance;
        $s->current_balance     = $current_balance;
        $isSaveSup              = $s->save();

        if ($isSaveTrans && $isSaveSup) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->route('supplier-transactions', $req->sup_id);
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }
}
