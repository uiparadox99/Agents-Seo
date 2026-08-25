<?php

namespace App\Http\Controllers\Tasks;

use App\TasksModels\Vendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\Task;
use App\TasksModels\Flight;
use App\TasksModels\Transaction;
use App\TasksModels\TaskHistory;
use App\TasksModels\PartyAttachment;
use App\Agents;
use App\TasksModels\PartyPassengers;
use App\TasksModels\AccountCategory;

class PartyController extends Controller
{
	public function __construct()
	{
		$this->attachment  = storage_path("uploads/attachments");
	}
	public function index(Request $r)
	{
		$data['sectors'] = Flight::all();
		$party = Vendee::where('type', 'party')->where('agents_id', auth()->user()->id);
		if(!empty($r->party_name)){
			$party = $party->where('name','LIKE','%'.$r->party_name.'%');
		}
		if(!empty($r->party_number)){
			$party = $party->where('phone','LIKE','%'.$r->party_number.'%')->orwhere('phone_2','LIKE','%'.$r->party_number.'%')->orwhere('phone_3','LIKE','%'.$r->party_number.'%');
		}
		if(!empty($r->sector)){
			$party = $party->where('sector',$r->sector)->orwhere('sector_two',$r->sector);
		}
		$data['parties'] = $party->orderBy('name', 'ASC')->paginate(20);
		return view('user.tasks.parties.manage-parties', $data);
	}

	public function showAddForm()
	{
		$data['sectors'] = Flight::all();
        $data['categories'] = AccountCategory::where('for_supplier', 0)->orderBy('name', 'ASC')->get();
         $data['admins_id'] 	= Agents::orderBy('business_name', 'ASC')->get();
		return view('user.tasks.parties.add-party', $data);
	}

	public function detail($id)
	{ 
		$data['sectors'] = Flight::all();
		$data['party'] = Vendee::where('id',$id)->where('type', 'party')->first();
		$data['categories'] = AccountCategory::where('for_supplier', 0)->orderBy('name', 'ASC')->get();
		$data['passengers'] = PartyPassengers::where('vendees_id',$data['party']->id)->get();
		$data['attachments'] = PartyAttachment::where('vendees_id',$data['party']->id)->get();
		 $data['admins_id'] 	= Agents::orderBy('business_name', 'ASC')->get();
		$data['inquiry'] = Task::where('vendees_id',$data['party']->id)->get();
		return view('user.tasks.parties.detail', $data);
	} 

	public function saveParty(Request $req)
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
			$s->information             = $req->information;
		}else{
			$alreadyPhone = Vendee::where('phone',$req->phone)->first();
			if (!is_null($alreadyPhone)) {
				Session::flash("error-msg",'Phone Number Already Exists');
				return redirect()->back()->withInput(Input::all());
			}
			$s    = New Vendee;
		}

        $code                   = Vendee::where('account_categories_id', $req->category)->first();

		if (is_null($code)){
            $categoryCode       = AccountCategory::where('for_supplier', 0)->where('id', $req->category)->first()->code;
            $counter            = 1;
            $code               = $categoryCode;
        }else{
            $counter            = Vendee::where('account_categories_id', $req->category)
                ->max('counter');
            $categoryCode       = AccountCategory::where('for_supplier', 0)->where('id', $req->category)->first()->code;
            $counter            = $counter + 1;
            $code               = $categoryCode;
        }

		$s->name                    = $req->name;
		$s->phone                   = $req->phone;
		$s->phone_2                   = $req->phone_2;
		$s->phone_3                   = $req->phone_3;
		$s->email                   = $req->email;
		$s->is_show_in_accounts     = $req->is_show_in_accounts;
        $s->type                    = $req->type;
		$s->account_categories_id   = $req->category;
		$s->code                    = $code."-".$counter;
		$s->counter                 = $counter;
		$s->remarks                 = nl2br($req->remarks);
		$s->sector                  = $req->party_sector;
		$s->sector_two                  = $req->sector_two;
		$s->agents_id               =  auth()->user()->id;
		$isSave                     = $s->save();

		if (!empty($req->passengers) && $req->passengers == 'yes') {
			if (is_array($req->title) && count($req->title) > 0) {
				foreach ($req->title as $key => $title) {
					if (!empty($req->surname[$key])) {
					    if (!empty($req->passenger_id[$key])) {
					       $pass = PartyPassengers::where('id',$req->passenger_id[$key])->first();
					    }else{
					    	$pass =  new  PartyPassengers;
					    }
					    $pass->title = $title;
					    $pass->surname = $req->surname[$key];
					    $pass->given_name = $req->given_name[$key];
					    $pass->passport = $req->passport[$key];
					    $pass->dob = $req->dob[$key];
					    $pass->passport_expiry = $req->passport_expiry[$key];
					    $pass->vendees_id = $s->id;
					    $pass->save();
					}
				}
			}
			if (is_array($req->image) && count($req->image) > 0) {
				foreach ($req->image as $key => $image) {
					if(!empty($image)){
						$newI = new PartyAttachment;
						$filename   = time()."-".$image->getClientOriginalName();
						$newI->image     = $filename;
						$image->move($this->attachment, $filename);
						$newI->title = $req->image_title[$key];
						$newI->vendees_id = $s->id;
						$newI->save();
					}
					
				}
			}
		}
		if ($isSave) {
				
			if (empty($req->id) && is_null($req->id) && $req->task_Add == 'yes') {
				$t = new Task;
				$t->vendees_id 	       = $s->id;
				$t->last_status        = 7;
				$t->task_types_id      = 1;
				$t->pax_name 	       = $req->name;
				$t->phone              = $req->phone;
				$t->task_type 		   = 3;
				$t->agents_id               =  auth()->user()->id;
				$isSave 		       = $t->save();

				$ts                 = new TaskHistory;
				$ts->remarks 		= nl2br($req->remarks);
				$ts->tasks_id 		= $t->id;
				$ts->statuses_id 	= 7;
				$ts->agents_id               =  auth()->user()->id;
				$isSave				= $ts->save();

			}
			Session::flash("success-msg", "Completed Successfully.");
			if (empty($req->id)){
				return redirect()->route('manage-parties');
			}else{
				return redirect()->back();
			}
			
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showEditForm($id)
	{
		$data['sectors'] = Flight::all();
		$data['party']      = Vendee::where('id', $id)->first();
        $data['categories'] = AccountCategory::where('for_supplier', 0)->orderBy('name', 'ASC')->get();
		return view('user.tasks.parties.add-party', $data);
	}

	public function partyTransactions($id)
	{
        $data['transactions'] = Transaction::with('ticket')
            ->orWhere('to', $id)
            ->orWhere('from', $id)->orderBy('id', 'DESC')->get();
        $data['id']           = $id;
		$data['party']        = Vendee::where('id', $id)->first();
		return view('user.tasks.parties.party-transactions', $data);
	}

	public function showAddAmountForm($id)
	{
		$data['id'] = $id;
		return view('user.tasks.parties.add-amount', $data);
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

		$p                      = Vendee::where('id', $req->party_id)->first();

		$t->amount              = $req->amount;
		$t->current_balance     = $p->current_balance;
        $t->remarks             = $req->remarks;
		$t->payment_mode        = $req->payment_mode;
		$t->trans_date          = $req->trans_date;
		$t->parties_id          = $req->party_id;
		$t->type                = 'RECEIVED';
		$t->agents_id               =  auth()->user()->id;
		$isSaveTrans            = $t->save();

		$current_balance         = $p->current_balance - $req->amount;
        $p->current_balance      = $current_balance;
		$isSavePar               = $p->save();

		if ($isSaveTrans && $isSavePar) {
			Session::flash("success-msg", "Completed Successfully.");
			return redirect()->route('party-transactions', $req->party_id);
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
			return redirect()->back();
		}
	}

	public function showDeductAmountForm($id)
    {
       $data['id'] = $id;
       return view('user.tasks.parties.deduct-amount', $data);
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

        $p                      = Vendee::where('id', $req->party_id)->first();

        $t->amount              = $req->amount;
        $t->current_balance     = $p->current_balance;
        $t->remarks             = $req->remarks;
        $t->payment_mode        = $req->payment_mode;
        $t->trans_date          = $req->trans_date;
        $t->parties_id          = $req->party_id;
        $t->type                = 'PAID';
        $t->agents_id               =  auth()->user()->id;
        $isSaveTrans            = $t->save();

        $current_balance         = $req->amount + $p->current_balance;
        $p->current_balance      = $current_balance;
        $isSavePar               = $p->save();

        if ($isSaveTrans && $isSavePar) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->route('party-transactions', $req->party_id);
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }
    public function deleteAttachemnt($id)
    {
    	$party = PartyAttachment::where('id',$id)->first();
    	if (file_exists ('storage/uploads/attachments/'.$party->image)) {
    		# code...
    	unlink('storage/uploads/attachments/'.$party->image);
    	}
    	$party->delete();
    	 Session::flash("success-msg", "Deleted Successfully.");
    	   return redirect()->back();
    }
}
