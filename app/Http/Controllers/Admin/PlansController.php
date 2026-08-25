<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Input;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Plan;
use App\AgentSubscription;
use App\Agents;
use App\PlansPermission;
use App\Transaction;
use App\PlanHasPlansPermission;
use Session;
use Validator;
use App\CompanyAccountsDetail;
use App\PlansPriceDiscount;
use Carbon\Carbon;
class PlansController extends Controller {
    
    public $cities = [];
    
    public function __construct() {
        $this->middleware('admin'); 
        $this->storage = storage_path()."/uploads/" ; 
    }    
    
    // Manage Plans
    
    public function managePlans() {
        
        $plans = Plan::where("active", "1")->get();
        return view('admin.Plans.manage-plans')->with("plans", $plans);
    }

    public function showPlan($id = 0) {
        $plan = "";
        if($id){
            $plan = Plan::where("id", $id)->first();
        }
        
        return view('admin.Plans.plan')->with("modal", $plan);
    }

    public function savePlan(Request $r) {
        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        if(!empty($r->id)){
            $d = Plan::find($r->id);
        }else{
            $d = new Plan ;
        }
        
        
        $d->name = $r->name;
        $d->description = $r->description;
        $d->active = 1;
        $d->save();
          
        $id = $d->id;
         if ($id) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route("admin.manage-plans"); 
    }
    public function managePermissions() {
        
        $plans = PlansPermission::where("active", "1")->orderBy('name','ASC')->get();
        return view('admin.Plans.manage-permission')->with("plans", $plans);
    }

    public function showPermission($id = 0) {
        $plan = "";
        if($id){
            $plan = PlansPermission::where("id", $id)->first();
        }
        
        return view('admin.Plans.permission')->with("modal", $plan);
    }

    public function savePermission(Request $r) {
        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        if(!empty($r->id)){
            $d = PlansPermission::find($r->id);
        }else{
            $d = new PlansPermission ;
        }
        
        $code = str_replace('-', '_', str_slug($r->name));
        $d->name = $r->name;
        if(empty($r->id)){
         $d->code =$code ;
        }
        $d->active = 1;
        $d->save();
          
        $id = $d->id;
         if ($id) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route("admin.manage-permission"); 
    }
    // Manage Cities
    
    public function managePlansPriceDiscount() {
        $showHistory = (Input::has("history") && Input::get("history") == true)? true : false;
        $ppd = PlansPriceDiscount::with("plan")->orderBy("created_at", "DESC");
        // if(!$showHistory){
        //     $ppd->limit(0, 5);
        // }
        $ppd = $ppd->get();
        return view('admin.Plans.manage-price')->with("plans", $ppd)->with("ppd", $ppd)->with("history", $showHistory);
    }

    public function showPrice($id = 0) {
        $ppd = null;
        if($id){
            $ppd = PlansPriceDiscount::where("id", $id)->first();
        }
        $plans = Plan::where("active", 1)->get();
        return view('admin.Plans.price')->with("modal", $ppd)
                                        ->with("plans",  $plans);
    }

    public function saveprice($id = 0) {
        
        $d = ($id > 0)? PlansPriceDiscount::find($id) : new PlansPriceDiscount; 
     
        $d->plan_id = Input::has("plan")? Input::get("plan") : 0;
        $d->price = Input::has("price")? Input::get("price") : 0;
        $d->price_2year = Input::has("price_2year")? Input::get("price_2year") : 0;
        $d->isDiscountActive = Input::has("activate_discount") && Input::get("activate_discount") ==  1? 1 : 0;
        // $d->discount_price = Input::has("discount_price")? Input::get("discount_price") : 0;
        $d->discount_percentage = Input::has("discount_percentage")? Input::get("discount_percentage") : 0;
        $d->discount_start_date = Input::has("discount_start_date")? Input::get("discount_start_date") : null;
        $d->discount_end_date = Input::has("discount_end_date")? Input::get("discount_end_date") : null;
        $d->active = 1;
        $d->save();
          
        $id = $d->id;
        if ($id) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route("admin.manage-price"); 
    }
    public function showPlanPermissions() {
        $plans = Plan::all();
        $perm = PlansPermission::all();
        $permAssoc = PlanHasPlansPermission::all();
        return view("admin.Plans.plan-permissions")->with("plans", $plans)->with("permissions", $perm)->with("permAssoc", $permAssoc);
    }
    
    public function savePlanPermissions(){
        
        foreach(Input::get("plan_id") as $id){
        PlanHasPlansPermission::where("plan_id", $id)->delete();
            foreach(Input::get("perm") as $key => $pp){
                if ($key == $id) {
                    foreach ($pp as $pp_id){
                        $ppa = new PlanHasPlansPermission;
                        $ppa->plan_id = $id;
                        $ppa->plans_permissions_id = $pp_id;
                        $ppa->save();
                    }
                }
            }
        }
        Session::put("success-msg", "Permissions updated");
        return back();
    }
    
    public function showSubscription(Request $r){
        // if(!HasPermission("CAN_MANAGE_SUBSCRIPTIONS")){
        //     abort(404);
        // }
        $subscribe = AgentSubscription::select('agent_subscriptions.*','transactions.status','transactions.payment')
        ->with('plan')
        ->join('transactions','transactions.subscription_id','agent_subscriptions.id')
        ->where('agent_subscriptions.plan_id','!=',5);
        if(!empty($r->agent_id)){
            $subscribe = $subscribe->where('agent_subscriptions.agents_id',$r->agent_id);
        }
        $subscribe = $subscribe->orderby('transactions.id','ASC')->groupby('agent_subscriptions.agents_id')->paginate('30');
        return view("admin.Plans.manage-subscription")->with("subscriptions", $subscribe);
    }
    
    public function showSubscriberForm($id = 0, $action=null){
        // if(!HasPermission("CAN_MANAGE_SUBSCRIPTIONS")){
        //     abort(404);
        // }
        $actionArray = array("renewal", "edit", "upgrade", "downgrade", "add");
        if ($id && !in_array($action, $actionArray)) {
            return redirect('admin/agents');
        }
        
        // Check if visited user is already subscribed
        $agent = AgentSubscription::where('agents_id', $id)->first();
        (!is_null($agent) && $action == "add")?$isAlready = true:$isAlready = false;

        if (is_null($agent) && $action != "add") {
            Session::put("error-msg", "Sorry this agent is not Subscribed");
            return redirect('admin/agents');
        }

        // Check if for current Packge and tel if already in state(upgrade or downgrade)
        if ($action == "upgrade" && !is_null($agent)) {
            ($agent->plans->name == "Platinum")?$alreadyUp = true: $alreadyUp = false;
            if ($alreadyUp) {
                Session::put("error-msg", "This agent is already in UpGraded Subscription");
                return redirect('admin/agents');
            }
        }
        if ($action == "downgrade" && !is_null($agent)) {
            ($agent->plans->name == "Golden")?$alreadyDown = true: $alreadyDown = false;
            if ($alreadyDown) {
                Session::put("error-msg", "This agent is already in DownGraded Subscription");
                return redirect('admin/agents');
            }
        }
          
        if($id){
            
            $this->subscriber = AgentSubscription::leftjoin('plan as splan','splan.id','agent_subscriptions.plan_id')->join("transactions", "transactions.subscription_id", "=", "agent_subscriptions.id")
                                ->where("agent_subscriptions.agents_id", $id)
                                ->first(['agent_subscriptions.agents_id as id','transactions.account_title as sender_account_title', 'transactions.account_number as sender_account_number', 'transactions.payment as payment', 'transactions.bank_name as sender_bank_name', 'transactions.receiver_account_title', 'agent_subscriptions.agents_id', 'agent_subscriptions.plan_id', 'agent_subscriptions.period', 'agent_subscriptions.active','transactions.status as payment_status','transactions.comment as comment','agent_subscriptions.expairy_date as expairy_date','splan.name as plan_name', 'status']);
                                // ->leftjoin('agent_subscriptions as l', "l.agents_id", "=", "agents.id")
            // dd($this->subscriber);
            $agents = Agents::leftjoin('agent_cities as city','city.id','agents.cities_id')->leftJoin('agent_subscriptions as s',"s.agents_id", "=", "agents.id")
                        ->where("agents.id", $id)
                        ->get(["agents.id", 's.period', "s.plan_id",'agents.business_name','city.name as city']);
        }
        else{
            $this->subscriber = NULL;
            $agents = Agents::leftjoin('agent_cities as city','city.id','agents.cities_id')->leftJoin('agent_subscriptions as s',"s.agents_id", "=", "agents.id")
                        ->where("s.agents_id","=", null)
                        ->get(["agents.id", 's.period', "s.plan_id",'agents.business_name','city.name as city']);
        }
      
        $company_accounts = CompanyAccountsDetail::all();

        $plans = Plan::all();
        return view("admin.Plans.subscriber")->with("modal",  $this->subscriber)->with("agents", $agents)->with("plans", $plans)->with("company_accounts", $company_accounts)->with("action", $action)->with("isAlready", $isAlready);
    }

    public function saveSubscription($id = 0, $action = null){
        $remainingAmount = 0;
        // if(!HasPermission("CAN_MANAGE_SUBSCRIPTIONS")){
        //     abort(404);
        // }
        $actionArray = array("renewal", "edit", "upgrade", "downgrade", "add");
        if (!in_array($action, $actionArray)) {
            abort(404);
        }

        if($action == "edit"){
            $required = "nullable";
        }else{
            $required = "required|unique:subscriptions,agent_id";
        }

        $validator = Validator::make(Input::all(), [
            'period'                 => 'required',
            'agent_id'               => '',
        ]);

        if ($validator->fails()) {
            Session::put("error-msg", "All fields are required");
            return redirect()->back()->withInput();
        }
        
        $d = ($id && $action != "add")? AgentSubscription::where("agents_id", $id)->first(): new AgentSubscription ;
        $t = ($id && $action == "edit")? Transaction::where("subscription_id", $d->id)->orderBy("id", "DESC")->first() : new Transaction;
        
        $agent_id = Input::has("agent_id")? Input::get("agent_id") : "";
        $status = Input::has("status")? Input::get("status") : "";
        $period = Input::has("period")? Input::get("period") : "";
        $plan_id = Input::has("plan_id")? Input::get("plan_id") : ""; 
        $expire_date = Input::has("expire_date")? Input::get("expire_date") : ""; 
        // $receive_payment = Input::has("receive_payment")? Input::get("receive_payment") : ""; 
        $receive_payment = Input::has("payment")? Input::get("payment") : ""; 
        $company_account_title = Input::has("company_account_title")? Input::get("company_account_title") : ""; 
        $sender_account_title = Input::has("sender_account_title")? Input::get("sender_account_title") : ""; 
        $sender_account_number = Input::has("sender_account_number")? Input::get("sender_account_number") : ""; 
        $sender_bank_name = Input::has("sender_bank_name")? Input::get("sender_bank_name") : ""; 
        $comment = Input::has("comment")? Input::get("comment") : ""; 

        // Generate Expire Date with Given Periods 
        
            // $expire_date = date('Y-m-d h:i:s', strtotime("+".$period." year"));
            $expire_date = date('Y-m-d h:i:s',strtotime($expire_date));
        

        $totalPrice = 0;
        if ($action != "add" && $action != "edit") {
            // 2 year plan
            // price 10,000
            // $usedDays = dateDifference(date('Y-m-d'), $d->start_date, "%a"); //-30 days

            $olRemainDays = date_diff(date_create(date('Y-m-d')),date_create($d->expairy_date)); // +30
            $olRemainDays = (int)$olRemainDays->format("%R%a");

            if ($olRemainDays > 0) {

                // $olRemainDays = date_diff(date('Y-m-d'), $d->expire_date, "%a"); // +30

                $getOldPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plan.id")
                        ->where("plan.id", $d->plan_id)
                        ->first();
                if ($getOldPrice->isDiscountActive) {
                    $oldPrice = $getOldPrice->price - ($getOldPrice->price * $getOldPrice->discount_percentage)/100;
                    $PricePerDay = round($oldPrice/30);
                }else{
                    $oldPrice = $getOldPrice->price;
                    $PricePerDay = round($oldPrice/30);
                }

                // Add record in Transaction Table
                // Geting Price of selected package
                $getPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plan.id")
                                ->where("plan.id", $plan_id)
                                ->first();
                if ($getPrice->isDiscountActive) {
                    $newPrice = $getPrice->price - ($getPrice->price * $getPrice->discount_percentage)/100;
                    $newPrice = $newPrice*$period;
                }else{
                    $newPrice = $getPrice->price*$period;
                }

                $expire_date = date('Y-m-d h:i:s', strtotime("+".$period." year"));
                
                $remainingAmount = $PricePerDay*$olRemainDays;

                $totalPrice = $newPrice-$remainingAmount;

            }else{
                $expire_date = date('Y-m-d h:i:s', strtotime("+".$period." year"));
            }

        }        

        // Add record in Transaction Table
        // Geting Price of selected package
        $getPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plan.id")
                        ->where("plan.id", $plan_id)
                        ->first();
        if ($getPrice->isDiscountActive) {
            $price = $getPrice->price - ($getPrice->price * $getPrice->discount_percentage)/100;
            $plan_price = $getPrice->price - ($getPrice->price * $getPrice->discount_percentage)/100;
            $discount = $getPrice->discount_percentage;
            $price = $price*$period;
        }else{
            $plan_price = $getPrice->price;
            $price = $getPrice->price*$period;
            $discount = 0;
        }

        if ($totalPrice != 0) {
            $price = $totalPrice;
        }

        // if (($receive_payment < $price && empty($comment)) || ($receive_payment > $price && empty($comment))) {
        //     Session::put("error-msg", "Comment is required, Price is lower/greater than total price.");
        //     return redirect()->back()->withInput();
        // }

        $d->agents_id = $agent_id;
        $d->plan_id = $plan_id;    
        $d->period = $period;
            $d->expairy_date = $expire_date;
        
        
        $d->active = Input::has("isActive")? Input::get("isActive") : "";
        
        $d->save();
        $dID = $d->id;
    
        $t->subscription_id = $dID;
        $t->payment = $receive_payment;
        $t->discount_percentage = $discount;
        $t->account_title = $sender_account_title;
        $t->account_number = $sender_account_number;
        $t->bank_name = $sender_bank_name;
        $t->receiver_account_title = $company_account_title;
        $t->comment = $comment;
        $t->plan_price = $plan_price;        

            $t->transaction_date = Carbon::today();
            $t->expire_date = $expire_date;
        

        $t->status = $status;
        $ID = $t->save();
        $tID = $t->id;

        if($ID){

            switch ($action) {
                case 'edit':
                    $this->msg = "Plan has been Updated successfully";
                    break;
                case 'downgrade':
                    $this->msg = "Subscription has been Down Graded successfully";
                    break;
                case 'renewal':
                    $this->msg = "Subscription has been Renew successfully";
                    break;
                case 'upgrade':
                    $this->msg = "Plan has been Up Graded successfully";
                    break;
                default:
                    $this->msg = "Plan has been activated successfully";
                    break;
            }

            $agent = Agents::find($agent_id);

            if($action != "edit"){
                $data = [
                            "plan_price"=>$plan_price,
                            "receive_payment"=>$receive_payment,
                            "discount"=>$discount,
                            "sender_account_title"=>$sender_account_title,
                            "sender_account_number"=>$sender_account_number,
                            "sender_bank_name"=>$sender_bank_name,
                            "expire_date"=>$expire_date,
                            "plan"=>$getPrice->name,
                            "period"=>$period,
                            "invoice"=>$tID,
                            "status"=>$status,
                            "price"=>$price,
                            "plan_price"=>$plan_price,
                            "remainingAmount"=>$remainingAmount,
                            "agent"=>$agent->business_name,
                        ];
                
                $subject = $this->msg. " | Travel Agents";
                
                // Mail::send('EmailTemplates.invoice-email-template', $data, function ($message) use ($subject, $agent) {
                //     $message->from(config("appconfig.from-email"), 'Travel Agent');
                //     $message->to($agent->primary_email, $agent->agentDetail()->first()->name)->subject($subject);
                // });
            }

            Session::flash("success-msg", $this->msg);
            return redirect()->route("admin.manage-subscription"); 
        }

    }

    function subscriptionDetail(){
  
        $id = Input::has("agent_id")?Input::get("agent_id"):"";
        $action = Input::has("action")?Input::get("action"):"";
        $plan_id = Input::has("plan_id")?Input::get("plan_id"):"";
        $period = Input::has("period")?Input::get("period"):"";
        $getPrice = $expire_date = null;
        $DiscountPrice = $remainingAmount = $totalPrice = $newPrice = 0;
        
        $d = ($id)? AgentSubscription::where("agents_id", $id)->first(): null;
        if ($action != "edit" && $action != "add") {

            // $usedDays = dateDifference(date('Y-m-d'), $d->start_date); //-30 days
            
            $olRemainDays = dateDifference(date('Y-m-d'), $d->expire_date); // +30
            if ($olRemainDays > 0) {

                $olRemainDays = dateDifference(date('Y-m-d'), $d->expire_date, "%a"); // +30
                // $getOldPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plans.id")
                //         ->where("plans.id", $d->plan_id)
                //         ->first();
                
                $getOldPrice = Transaction::where("subscription_id", $d->id)->where("status", "paid")->orderBy("id", "DESC")->first();

                if ($getOldPrice->discount_percentage > 0) {
                    $oldPrice = $getOldPrice->plan_price - ($getOldPrice->plan_price * $getOldPrice->discount_percentage)/100;
                    $PricePerDay = round($oldPrice/30);
                }else{
                    $oldPrice = $getOldPrice->plan_price; // 6000
                    $PricePerDay = round($oldPrice/30); // 200
                }

                // Add record in Transaction Table
                // Geting Price of selected package
                $getPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plan.id")
                                ->where("plan.id", $plan_id)
                                ->first();
                if ($getPrice->isDiscountActive) {
                    $DiscountPrice = $getPrice->price - ($getPrice->price * $getPrice->discount_percentage)/100;
                    $newPrice = $DiscountPrice*$period;
                }else{
                    $DiscountPrice = 0;
                    $newPrice = $getPrice->price*$period;
                }

                $expire_date = date('Y-m-d h:i:s', strtotime("+".$period." year"));
                
                $remainingAmount = $PricePerDay*$olRemainDays;
                $totalPrice = $newPrice-$remainingAmount;
                // die($remainingAmount);
            }else{                
                $getOldPrice = Transaction::where("subscription_id", $d->id)->where("status", "paid")->orderBy("id", "DESC")->first();

                if (!is_null($getOldPrice)) {
                    if ($getOldPrice->discount_percentage > 0) {
                        $oldPrice = $getOldPrice->plan_price - ($getOldPrice->plan_price * $getOldPrice->discount_percentage)/100;
                        $PricePerDay = round($oldPrice/30);
                    }else{
                        $oldPrice = $getOldPrice->plan_price; // 6000
                        $PricePerDay = round($oldPrice/30); // 200
                    }
                }else{
                    $PricePerDay = 0;
                    $oldPrice = 0;
                }

                // Add record in Transaction Table
                // Geting Price of selected package
                $getPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plan.id")
                                ->where("plan.id", $plan_id)
                                ->first();
                if ($getPrice->isDiscountActive) {
                    $DiscountPrice = $getPrice->price - ($getPrice->price * $getPrice->discount_percentage)/100;
                    $newPrice = $DiscountPrice*$period;
                }else{
                    $DiscountPrice = 0;
                    $newPrice = $getPrice->price*$period;
                }

                $expire_date = date('Y-m-d h:i:s', strtotime("+".$period." year"));
                
                $remainingAmount = $PricePerDay;
                $totalPrice = $newPrice-$remainingAmount;
                // die($remainingAmount);
            }
        }else{
                $remainingAmount = 0;
             // Add record in Transaction Table
                // Geting Price of selected package
                $getPrice = Plan::join("plans_price_discount", "plans_price_discount.plan_id", "=", "plan.id")
                                ->where("plan.id", $plan_id)
                                ->first();
                if ($getPrice->isDiscountActive) {
                    $DiscountPrice = $getPrice->price - ($getPrice->price * $getPrice->discount_percentage)/100;
                    $newPrice = $DiscountPrice*$period;
                }else{
                    $DiscountPrice = 0;
                    $newPrice = $getPrice->price*$period;
                }

                $expire_date = date('Y-m-d h:i:s', strtotime("+".$period." year"));

                $totalPrice = $newPrice-$remainingAmount;
        }
        return json_encode(["notify"=>true, "plan_price"=>!is_null($getPrice)?$getPrice->price:0, "discount_price"=>$DiscountPrice, "orignal_price"=>$newPrice, "expire_date"=>$expire_date, "remainingAmount"=>$remainingAmount, "finalPrice"=>$totalPrice, "period"=>$period]);

    }
    public function showInvoices($id){
        $invoices = Transaction::select('agents.business_name','transactions.*','agent_subscriptions.*')->join('agent_subscriptions','transactions.subscription_id','agent_subscriptions.id')->join('agents','agent_subscriptions.agents_id','agents.id')->where("transactions.subscription_id", $id)->orderBy("transactions.id", "DESC")->get();
        return view('admin.Plans.manage-invoices')->with("invoices",  $invoices);
    }   
}