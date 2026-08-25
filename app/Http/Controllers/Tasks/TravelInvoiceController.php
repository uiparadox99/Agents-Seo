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
use App\TasksModels\TravelInvoice as Invoice;
use App\TasksModels\Permissions;
use App\TasksModels\PermissionHasAdmin;
use PDF;
class TravelInvoiceController extends Controller
{
	public function index(Request $r)
	{
		 $invoices    = Invoice::whereNotNull('id');
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
		return view('user.tasks.travel-invoice.index',$data);
	}
    public function generate()
	{
		 $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
		 $data['tickets']    = Ticket::all();
		return view('user.tasks.travel-invoice.generate',$data);
	}

	public function save(Request $r)
	{
		$in  = new Invoice;
		$in->ref = $r->ref;
		$in->date = date('Y-m-d',strtotime($r->date));
		$in->data = json_encode($r->all());
		// return view('pdf/travel-invoice', $r->all());
		$in->save();
		Session::flash("success-msg", "Invoices Generated Successfully.");
		return redirect()->to('admin/manage-travel-invoices');
		/*$pdf = PDF::loadView('pdf/invoice', $r->all());
		$name = $r->ref.' - invoice';
		return $pdf->download($name.'.pdf');*/
	}
	public function download($id)
	{	
		$in  = Invoice::find($id);
		$data = (array)json_decode($in->data);
		// return view('pdf/travel-invoice', $data);
		$pdf = PDF::loadView('pdf/travel-invoice', $data);
		$name = $in->ref.' - voucher';
		return $pdf->download($name.'.pdf');
	}
}
