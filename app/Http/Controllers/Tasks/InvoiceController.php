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
class InvoiceController extends Controller
{
	public function index(Request $r)
	{
		 $invoices    = Invoice::whereNull('type')->where('agents_id',auth()->user()->id);
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
		return view('user.tasks.invoice.index',$data);
	}
    public function generate()
	{
		 $data['parties'] 	= Vendee::where('status', 1)->where('agents_id',auth()->user()->id)->where('type', 'party')->orderBy('name', 'ASC')->get();
		 $data['tickets']    = Ticket::where('agents_id',auth()->user()->id)->get();
		return view('user.tasks.invoice.generate',$data);
	}
	public function edit($id)
	{
		 $data['parties'] 	= Vendee::where('status', 1)->where('agents_id',auth()->user()->id)->where('type', 'party')->orderBy('name', 'ASC')->get();
		 $data['tickets']    = Ticket::where('agents_id',auth()->user()->id)->get();
		 $in  = Invoice::find($id);
		 $data['ticket'] = (array)json_decode($in->data);
		 $data['invoice'] = $in;
		return view('user.tasks.invoice.generate',$data);
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
		$saveData  = $r->all();
		$saveData['remarks'] = nl2br($r->remarks);
/*		$in->total_ammount = $r->total;*/
		$in->data = json_encode($saveData);
		$in->agents_id = auth()->user()->id;
		/*return view('pdf/invoice', $r->all());*/
		$in->save();
		Session::flash("success-msg", "Invoices Generated Successfully.");
		return redirect()->to('manage-invoices');
		/*$pdf = PDF::loadView('pdf/invoice', $r->all());
		$name = $r->ref.' - invoice';
		return $pdf->download($name.'.pdf');*/
	}
	public function downloadInvoice(Request $r)
	{	
		$in  = Invoice::find($r->id);
		$data = (array)json_decode($in->data);
		// return view('pdf/invoice', $data);
		$agent = Agents::where('users_id',auth()->user()->id)->first();
		$data['agent_logo'] = $agent->logo;
		$pdf = PDF::loadView('user.tasks.pdf.invoice', $data);
		$name = $in->ref.' - invoice';
		return $pdf->download($name.'.pdf');
	}
}
