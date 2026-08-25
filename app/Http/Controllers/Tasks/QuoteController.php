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
class QuoteController extends Controller
{
	public function index(Request $r)
	{
		 $invoices    = Invoice::where('type','quotation');
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
		return view('user.tasks.quote.index',$data);
	}
    public function generate()
	{
		 $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
		 $data['tickets']    = Ticket::all();
		return view('user.tasks.quote.generate',$data);
	}
	public function edit($id)
	{
		 $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
		 $data['tickets']    = Ticket::all();
		 $in  = Invoice::find($id);
		 $data['ticket'] = (array)json_decode($in->data);
		 $data['invoice'] = $in;
		return view('user.tasks.quote.generate',$data);
	}

	public function save(Request $r)
	{
		if(!empty($r->id)){
			$in  = Invoice::find($r->id);
		}else{
			$in  = new Invoice;
		}
		$in->date = date('Y-m-d',strtotime($r->date));
        $in->type = 'quotation';
		$saveData  = $r->all();
		$saveData['remarks'] = nl2br($r->remarks);
		$saveData['flight_remarks'] = nl2br($r->flight_remarks);
/*		$in->total_ammount = $r->total;*/
		$in->data = json_encode($saveData);
		/*return view('pdf/invoice', $r->all());*/
		$in->save();
		Session::flash("success-msg", "Invoices Generated Successfully.");
		return redirect()->to('admin/manage-quotation');
		/*$pdf = PDF::loadView('pdf/invoice', $r->all());
		$name = $r->ref.' - invoice';
		return $pdf->download($name.'.pdf');*/
	}
	public function download($id)
	{	
		$in  = Invoice::find($id);
		$data = (array)json_decode($in->data);
		// return view('pdf/invoice', $data);
		$pdf = PDF::loadView('pdf/quotation', $data);
		$name = date('d M Y',strtotime($in->date)).' - Quotation';
		return $pdf->download($name.'.pdf');
	}
}
