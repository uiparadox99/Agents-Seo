<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\AgentType;
use App\AgentDeal;
use App\AgentReview;
use App\AgentSubscription;
use App\Cities;
use App\Plan;
use App\User;
use App\AgentTiming;
use App\Transaction;
use App\AgentCity;
use App\AgentGallery;
use App\PlansPermission;
use App\PlanHasPlansPermission;
use \Validator;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;

class SubscriptionController extends Controller
{
    public function subsription(Request $r)
    {
        $agent = Agents::where('users_id',auth()->user()->id)->first();
        if (is_null($agent)) {
          Session::flash("error-msg", "Please Add Business First");

          return redirect()->back();
      }
        $agent = $agent->id;
        
        $data['permissions'] = PlansPermission::where('active',1)->get();
        $data['permAssoc'] = PlanHasPlansPermission::all();
        $data['plans'] = Plan::where('active',1)->get();
        $data['subscriptions'] =  AgentSubscription::with('plan')->join('transactions','transactions.subscription_id','agent_subscriptions.id')->where('agent_subscriptions.agents_id',$agent)->select('agent_subscriptions.*','transactions.status','transactions.payment')->paginate(20);
        return view('user.manage-subscriptions',$data);
    }
    public function renewSubsription(Request $r)
    {
       $old =  AgentSubscription::join('transactions','transactions.subscription_id','agent_subscriptions.id')->where('agent_subscriptions.id',$r->id)->first();
       $agent = Agents::where('users_id',auth()->user()->id)->first();
       $agents_id = $agent->id;
 
       DB::statement('SET FOREIGN_KEY_CHECKS=0');
       $expire_date = date('Y-m-d h:i:s', strtotime("+".$old->period." year",strtotime($old->expairy_date)));
     
       $subcription = new AgentSubscription;
       $subcription->period = $old->period;
       $subcription->plan_id = $old->plan_id;
       $subcription->agents_id = $agents_id;
       $subcription->active = 0;
       $subcription->expairy_date = $expire_date;
       $Ssaved = $subcription->save();
       if($Ssaved){
         $t = new Transaction;
         $t->subscription_id = $subcription->id;
         $t->payment = $old->payment;
         $t->plan_price = $old->plan_price;    
         $t->status = 'unpaid';    
         $tsaved =  $t->save();
         Session::flash("success-msg", "Subscription Renewd Successfully.");
           
         return redirect()->to('agent-subscriptions');
       }else{
           Session::flash("success-msg", "There is an Error.");
          
           return redirect()->back();
          }
    }
    public function addSubsription()
    {
      $data['permissions'] = PlansPermission::where('active',1)->get();
        $data['permAssoc'] = PlanHasPlansPermission::all();
        $data['plans'] = Plan::where('active',1)->get();
        return view('user.add-subscription',$data);
    }
    public function saveSubscription(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'plan'   => 'required',
            'period'   => 'required',
          ]);
        
          if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
          }

          
        $agent = Agents::where('users_id',auth()->user()->id)->first();
        $agents_id = $agent->id;
    $delete = AgentSubscription::where('agents_id',$agents_id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $expire_date = date('Y-m-d h:i:s', strtotime("+".$req->period." year"));
        $subcription = new AgentSubscription;
        $subcription->period = $req->period;
        $subcription->plan_id = $req->plan;
        $subcription->agents_id = $agents_id;
        $subcription->active = 0;
        $subcription->expairy_date = $expire_date;
        $Ssaved = $subcription->save();
        if($Ssaved){
          $t = new Transaction;
          $t->subscription_id = $subcription->id;
          $t->payment = $req->price;
          $t->plan_price = $req->price;    
          if($req->plan == '5'){
           $t->status = 'paid'; 
          }else{   
           $t->status = 'unpaid';    
          }
          $tsaved =  $t->save();
          Session::flash("success-msg", "Subscription Added Successfully.");
           
          return redirect()->to('agent-subscriptions');
        }else{
            Session::flash("success-msg", "There is an Error.");
           
            return redirect()->back();
           }

    }
}
