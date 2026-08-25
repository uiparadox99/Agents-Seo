<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\ShowPackage;
use App\Transaction;
use App\AgentSubscription;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use DB;
use Input;

class ShowPackageController extends Controller
{
      public $filePath = 'storage/uploads/blogs';
     
     public function index(Request $r)
      {
        $data['shows'] = ShowPackage::join('agents','show_package.agents_id','agents.id')->select('show_package.*','agents.business_name as bis')->get();
        return view('admin.show.index',$data);
      
      }
       public function save(Request $req){

        $validator = Validator::make(Input::all(), [
            'agent'   => 'required',
            'expire'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $show     = new ShowPackage;
        }else{
            $show     = ShowPackage::where('id',$req->id)->first();
        }


        $show->agents_id           = $req->agent;
        $show->expire              = date("d-M-Y",strtotime($req->expire));
        $isSave                    = $show->save();


     
        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->back();
    }
    public function saveverified(Request $req){
             $subcription = AgentSubscription::where('agents_id',$req->agent)->first();
        if (!is_null($subcription)) {


                if ($subcription->plan_id == 5) {
                    if ($req->verified == 1 ) {
                         DB::statement('SET FOREIGN_KEY_CHECKS=0');
                         $expire_date = date('Y-m-d h:i:s', strtotime("+2 year"));
                         $subcription->period = '2';
                         $subcription->plan_id = '6';
                         $subcription->active = 1;
                         $subcription->expairy_date = $expire_date;
                         $Ssaved = $subcription->save();
                         if($Ssaved){
                            $t = Transaction::where('subscription_id',$subcription->id)->first();
                            $t->payment = '0';
                            $t->plan_price = '0';    
                            $t->status = 'paid';    
                            $tsaved =  $t->save();
                        }
                        DB::statement('SET FOREIGN_KEY_CHECKS=1');
                    }
            }elseif($subcription->plan_id == 6){
                if ($req->verified == 1 && $subcription->active != 1) {
                      $subcription->active = 1;
                      $Ssaved = $subcription->save();
                  }else{
                      $subcription->active = 0;
                      $Ssaved = $subcription->save();
                  }
              }
          }else{
           if ($req->verified == 1 ) {
                 DB::statement('SET FOREIGN_KEY_CHECKS=0');
                 $subcription = new AgentSubscription;
                 $expire_date = date('Y-m-d h:i:s', strtotime("+2 year"));
                 $subcription->period = '2';
                 $subcription->plan_id = '6';
                 $subcription->active = 1;
                 $subcription->agents_id = $req->agent;
                 $subcription->expairy_date = $expire_date;
                 $Ssaved = $subcription->save();
                 if($Ssaved){
                    $t = new Transaction;
                    $t->payment = '0';
                    $t->subscription_id = $subcription->id;
                    $t->plan_price = '0';    
                    $t->status = 'paid';    
                    $tsaved =  $t->save();
                }
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
        }
   
            Session::flash("success-msg", "Completed Successfully.");
       

        return redirect()->back();
    }
      public function edit($id){

        $data['detail'] = ShowPackage::where('id',$id)->first();
          $data['agents'] = Agents::join('umrah_packages','umrah_packages.agents_id','agents.id')->select('agents.*')->groupBy('agents.business_name')->get();
        return view("admin.show.add", $data);
    }
    public function add()
    {
           $today =  date("d-M-Y", strtotime("today"));
        $data['agents'] = Agents::join('umrah_packages','umrah_packages.agents_id','agents.id')->leftjoin('show_package','show_package.agents_id','agents.id')->whereNull('show_package.agents_id')->select('agents.*')->groupBy('agents.business_name')->get();

        return view("admin.show.add",$data);
    }
    public function SaveFeatured(Request $req)
    {
       $visa            = Blogs::where('id', $req->id)->first();
        $visa->is_featured  = $req->is_featured;
        $isSave         = $visa->save();
        if ($isSave) {
            return response()->json(["notify"=>true, "msg"=>"Success"]);
        }else{
            return response()->json(["notify"=>false, "msg"=>"Fail"]);
        }
    }
    public function delete(Request $req)
    {
          $deleted     = ShowPackage::where('agents_id',$req->agent)->delete();
           if ($deleted) {
            Session::flash("success-msg", "Disallowed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->back();
    }

}
