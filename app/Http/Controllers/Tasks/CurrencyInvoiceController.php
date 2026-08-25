<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\Agents;
use App\TasksModels\Vendee;
use App\TasksModels\Ticket;
use App\TasksModels\Invoice;
use App\TasksModels\Permissions;
use App\TasksModels\PermissionHasAdmin;
use PDF;
class CurrencyInvoiceController extends Controller
{
	public function index(Request $r)
	{
		 $invoices    = Invoice::where('type','star_currency');
		 if (!empty($r->ref)) {
		 	 $invoices    = $invoices->where('ref',$r->ref);
		 }
		  if (!empty($r->date)) {
		 	 $invoices    = $invoices->where('date',date('Y-m-d',strtotime($r->date)));
		 }
		  if (!empty($r->passenger)) {
		 	 $invoices    = $invoices->where('data','LIKE','%'.$r->passenger.'%');
		 }
		 $data['invoices']    = $invoices->orderBy('date','DESC')->get();
		return view('user.tasks.currency-invoice.index',$data);
	}
    public function generate()
	{
		return view('user.tasks.currency-invoice.generate');
	}
	public function edit($id)
	{
		 $in  = Invoice::find($id);
		 $data['ticket'] = (array)json_decode($in->data);
		 $data['invoice'] = $in;
		return view('user.tasks.currency-invoice.generate',$data);
	}

	public function save(Request $r)
	{
		if(!empty($r->id)){
			$in  = Invoice::find($r->id);
		}else{
			$in  = new Invoice;
		}
        $in->ref = $r->ref;
		$in->date = date('Y-m-d',strtotime($r->date));
        $in->type = 'star_currency';
		$saveData  = $r->all();
		// $saveData['remarks'] = nl2br($r->remarks);
		$in->data = json_encode($saveData);
		$in->save();
		Session::flash("success-msg", "Invoices Generated Successfully.");
		return redirect()->to('admin/manage-currency-invoices');
	}
	public function download($id)
	{	
		$in  = Invoice::find($id);
		$data = (array)json_decode($in->data);
		// return view('pdf/currency_invoice', $data);
		$pdf = PDF::loadView('pdf/currency_invoice', $data);
		$name = $in->ref.' - Invoice';
		return $pdf->download($name.'.pdf');
	}
}
