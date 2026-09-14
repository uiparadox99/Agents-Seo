<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\AgentType;
use App\AgentDeal;
use App\AgentGallery;
use App\AgentTiming;
use App\AgentCity;
use App\JobCategory;
use App\AgentReview;
use App\AgentJobs;
use App\JobApplicant;
use App\JobExperience;
use App\AgentSubscription;
use App\Transaction;
use App\TicketsFilter;
use App\JobDesignation;
use App\Cities;
use App\Airlines;
use App\Country;
use Validator;
use Session;
use Hash;
use Auth;
use DB;
use Image;
use Input;
class AgentController extends Controller
{
    public $filePath = 'storage/uploads/agents';
    public $categoryPath = 'storage/uploads/jobs';
      public function agent(Request $r)
      {
        if(!empty($r->verify_agent)){
            $agent = Agents::where('id',$r->verify_agent)->first();
            $agent->verified = isset($r->verified) && !empty($r->verified)?$r->verified:0;
            $saved = $agent->save();
            Session::flash("success-msg", 'Agent Verified Successfull');
           return redirect()->back();
        }
        if(!empty($r->duplicated_id)){
            $agent = Agents::where('id',$r->duplicated_id)->first();
            $agent->duplicated = isset($r->duplicated) && !empty($r->duplicated)?$r->duplicated:0;
            $saved = $agent->save();
            Session::flash("success-msg", 'Agent Marked Duplicated Successfull');
           return redirect()->back();
        }
 
        $agent = Agents::with('agentType', 'city', 'user', 'dtsAttachments')
            ->withCount([
                'foreignJobs as foreign_jobs_Count',
                'visitors as total_visitors',
            ])
            ->leftJoin('users', 'agents.users_id', 'users.id');

        if(request()->path() == 'admin/agents'){
            $agent  = $agent->where('agents.is_foreign','!=',1); 
        }else{
             $agent  = $agent->where('agents.is_foreign',1); 
        }
        // Search filters
        if (!empty($r->business_name)) {
            $bName = trim(explode('(',$r->business_name)[0]);
            $agent->where('agents.business_name', 'LIKE', '%' . $bName . '%');
        }
        if(auth()->guard('admin')->user()->email == 'imran@agents.com.pk'){
             $agent  = $agent->where('agents.agent_type_id',3)->where('agents.active',0);
        }else{
               $agent  = $agent->where('agents.active',1); 
        }
        if (!empty($r->email)) {
            $agent->where('agents.email', 'LIKE', '%' . $r->email . '%');
        }
        
        if (!empty($r->agent_id)) {
            $agent->where('agents.id', $r->agent_id);
        }
        
        if (!empty($r->phone)) {
            $agent->where('agents.phone', 'LIKE', '%'.$r->phone.'%');
        }
        if (!empty($r->mobile)) {
            $agent->where('agents.mobile', 'LIKE', '%'.$r->mobile.'%');
        }
        
        if (!empty($r->city)) {
            $agent->where('agents.cities_id', $r->city);
        }
        
        if (!empty($r->agent_verified)) {
            $agent->where('agents.verified', $r->agent_verified);
        }
        
        if (!empty($r->type)) {
            $agent->where('agents.agent_type_id', $r->type);
        }
        
        if (!empty($r->verified) || $r->verified == 0) {
            $agent->where('agents.dts_verified', $r->verified);
        }
        
        if (!empty($r->claimed)) {
            if($r->claimed == 'no'){
                 $agent->whereNull('agents.users_id');
            }else if($r->claimed == 'yes'){
                    $agent->whereNotNull('agents.users_id');
            }
           
        }
        
        if (!empty($r->date)) {
            $date = date('Y-m-d', strtotime($r->date));
            $agent->where('agents.created_at', 'LIKE', '%' . $date . '%');
        }
        // Sorting
        // Only add today_visitors withCount when explicitly sorting by it
        // (it's expensive, so we avoid it for normal page loads)
        $needTodayVisitorsForSort = !empty($r->orderby) && in_array($r->orderby, ['todayVisitsAsc', 'todayVisitsDesc']);
        if ($needTodayVisitorsForSort) {
            $agent->withCount([
                'visitors as today_visitors' => function($q) {
                    $q->whereDate('created_at', date('Y-m-d'));
                }
            ]);
        }

        if (!empty($r->orderby)) {
            switch ($r->orderby) {
                case 'todayVisitsAsc':
                    $agent->orderBy('today_visitors', 'ASC');
                    break;
                case 'todayVisitsDesc':
                    $agent->orderBy('today_visitors', 'DESC');
                    break;
                case 'totalVisitsAsc':
                    $agent->orderBy('total_visitors', 'ASC');
                    break;
                case 'totalVisitsDesc':
                    $agent->orderBy('total_visitors', 'DESC');
                    break;
                case 'oepJobsAsc':
                    $agent->orderBy('foreign_jobs_Count', 'ASC');
                    break;
                case 'oepJobsDesc':
                    $agent->orderBy('foreign_jobs_Count', 'DESC');
                    break;
                case 'name':
                    $agent->orderBy('agents.business_name', 'ASC');
                    break;
                default:
                    $agent->orderBy('agents.id', 'DESC');
            }
        } else {
            $agent->orderBy('agents.id', 'DESC');
        }
        
        $data['agents'] = $agent->select(
                'agents.*',
                'users.visible_password as password',
                'users.email as user_email'
            )
            ->paginate(50)->appends(request()->query());

        // Compute today's visitor counts in a single fast query (instead of correlated subqueries)
        $todayDate = date('Y-m-d');
        $todayVisitorCounts = DB::table('visitors')
            ->select('agents_id', DB::raw('COUNT(*) as today_count'))
            ->whereDate('created_at', $todayDate)
            ->whereIn('agents_id', $data['agents']->pluck('id')->toArray())
            ->groupBy('agents_id')
            ->pluck('today_count', 'agents_id');

        // Inject today_visitors into each agent record
        foreach ($data['agents'] as $agentItem) {
            $agentItem->today_visitors = $todayVisitorCounts->get($agentItem->id, 0);
        }

         if(request()->path() == 'admin/agents'){
      	$data['cities'] = AgentCity::orderBy('name','ASC')->get();
         }else{
               	$data['cities'] = AgentCity::where('is_foreign',1)->orderBy('name','ASC')->get();
         }
        $data['types'] = AgentType::orderBy('name','ASC')->get();
      	return view('admin.agents.manage-agents',$data);
      
      }

       public function saveAgent(Request $req){

        $validator = Validator::make(Input::all(), [
          'business_name'   => 'required',
          'address'   => 'required',
          'type'   => 'required',
          'city'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        
       
        if (is_null($req->id)) {
          $already = Agents::where('business_name','=',$req->business_name)->first();
          if (!is_null($already)) {
           Session::flash("error-msg", 'Business already added with this business Name');
           return redirect()->back()->withInput(Input::all());
         }
         $agent     = new Agents;
         $agent->slug        = str_slug($req->business_name);
         $agent->code        = generateCode();
       }else{
            $already = Agents::where('business_name','=',$req->business_name)->where("id", "!=", $req->id)->first();
            if (!is_null($already)) {
               Session::flash("error-msg", 'Business already added with this business Name');
               return redirect()->back()->withInput(Input::all());
            }

            $agent     = Agents::where('id',$req->id)->first();

     }

        if (!empty($req->logo)) {
            $filename = Input::file('logo')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('logo')->move($this->filePath, $fileNewName);

            $agent->logo          = $fileNewName;
            $agent->logo_approved = 1;
        }
         if (!empty($req->cover)) {
            $filename = Input::file('cover')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('cover')->move($this->filePath, $fileNewName);

            $agent->cover          = $fileNewName;
            $agent->cover_approved = 1;
        }

        if (!empty($req->dts_attachment)) {
          $filename = Input::file('dts_attachment')->getClientOriginalName();
          $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
          Input::file('dts_attachment')->move($this->filePath, $fileNewName);

          $agent->dts_attachment          = $fileNewName;
        }

        $email = implode(',',array_filter($req->email));
        $mobile = implode(',',array_filter($req->mobile));
        $phone = implode(',',array_filter($req->phone));
        
        $agent->business_name        = strtolower($req->business_name);
        $agent->agent_name           = $req->agent_name;
        $agent->email           = $email;
        $agent->phone           = $phone;
        $agent->facebook           = $req->facebook;
        $agent->twitter           = $req->twitter;
        $agent->whatsapp           = $req->whatsapp;
        $agent->dsl_license           = $req->dsl_license;
        $agent->iata_license           = $req->iata_license;
        $agent->dsl_expairy           = $req->dsl_expairy;
        $agent->iata_expairy           = $req->iata_expairy;
        $agent->description           = nl2br($req->description);
        $agent->website           = $req->website;
        $agent->address           = $req->address;
        $agent->active           = isset($req->active) && $req->active == 1?1:0;
        $agent->is_foreign           = isset($req->is_foreign) && $req->is_foreign == 1?1:0;
        $agent->agent_type_id           = $req->type;
        $agent->cities_id           = $req->city;
        $agent->fax           = $req->fax;
        $agent->secondary_phone           = $req->secondary_phone;
        $agent->mobile           = $mobile;
        $agent->secondary_mobile           = $req->secondary_mobile;

        
        $isSave                     = $agent->save();

        if ($isSave) {

        	$delete = AgentTiming::where('agents_id',$req->id)->delete();
        	foreach ($req->day as $key => $value) {
        		
        		$timing = new AgentTiming;
        		$timing->day = $value;
        		$timing->opening = $req->opening[$key];
        		$timing->closing = $req->closing[$key];
        		$timing->agents_id = $agent->id;
        		$save = $timing->save();

        	}
          if (empty($req->id)) {
              DB::statement('SET FOREIGN_KEY_CHECKS=0');
              $expire_date = date('Y-m-d h:i:s', strtotime("+100 year"));
              $subcription = new AgentSubscription;
              $subcription->period = '100';
              $subcription->plan_id = '5';
              $subcription->agents_id = $agent->id;
              $subcription->active = 0;
              $subcription->expairy_date = $expire_date;
              $Ssaved = $subcription->save();
              if($Ssaved){
                $t = new Transaction;
                $t->subscription_id = $subcription->id;
                $t->payment = '0';
                $t->plan_price = '0';    
                $t->status = 'paid';    
                $tsaved =  $t->save();
              }
              DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
        	if (!empty($req->id)) {
        		Session::flash("success-msg", "Record Updated Successfully.");
        	}else{

            Session::flash("success-msg", "Record Added Successfully.");
        	}
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        if(isset($req->is_foreign) && $req->is_foreign == 1){
               return redirect()->to('admin/foreign-agents');
        }
        return redirect()->to('admin/agents');
    }
      public function editAgent($id){
  		$data['types'] = AgentType::orderBy('name','ASC')->get();
  		 if(str_contains(request()->path(), 'admin/edit-agent')){
  	    	$data['cities'] = AgentCity::orderBy('name','ASC')->get();
  		 }else{
  		     $data['cities'] = AgentCity::where('is_foreign',1)->orderBy('name','ASC')->get();
  		 }
        $data['detail'] = Agents::where('id',$id)->first();
        return view("admin.agents.add-agent", $data);
    }
    public function addAgent()
    {
    	$data['types'] = AgentType::orderBy('name','ASC')->get();
      	 if(request()->path() == 'admin/add-agent'){
          	$data['cities'] = AgentCity::orderBy('name','ASC')->get();
      	 }else{
      	     $data['cities'] = AgentCity::where('is_foreign',1)->orderBy('name','ASC')->get();
      	 }
    	return view("admin.agents.add-agent",$data);
    }
     public function agentType(Request $r)
      {
      	$data['agentTypes'] = AgentType::orderBy('name','ASC')->get();
      	return view('admin.agents.manage-agent-types',$data);
      
      }
       public function saveType(Request $req){

        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $agent     = new AgentType;
        }else{
            $agent     = AgentType::where('id',$req->id)->first();
        }

         if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $agent->image          = $fileNewName;
        }

       
        $agent->name        = $req->name;
        $agent->image_alt        = $req->image_alt;

        
        $isSave                     = $agent->save();

        if ($isSave) {
        	
        	if (!empty($req->id)) {
        		Session::flash("success-msg", "Record Updated Successfully.");
        	}else{

            Session::flash("success-msg", "Record Added Successfully.");
        	}
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.agent-types');
    }
      public function editType($id){
        $data['detail'] = AgentType::where('id',$id)->first();
        return view("admin.agents.add-type", $data);
    }
    public function addType()
    {
    	return view("admin.agents.add-type");
    }
     public function agentSubscription($id)
      {
        $data['subscriptions'] = AgentSubscription::where('agent_id',$id)->get();
        return view('admin.agents.manage-subscription',$data);
      
      }
       public function saveSubscription(Request $req){

        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
            'start_date'   => 'required',
            'end_date'   => 'required',
            'agent_id'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $agent     = new AgentSubscription;
        }else{
            $agent     = AgentSubscription::where('id',$req->id)->first();
        }


        $agent->name        = $req->name;
        $agent->slug        = str_slug($req->business_name);
        $agent->agent_name           = $req->agent_name;
        $agent->email           = $req->email;

        
        $isSave                     = $agent->save();

        if ($isSave) {

            $delete = AgentTiming::where('agents_id',$req->id)->delete();
            foreach ($req->day as $key => $value) {
                
                $timing = new AgentTiming;
                $timing->day = $value;
                $timing->opening = $req->opening[$key];
                $timing->closing = $req->closing[$key];
                $timing->agents_id = $agent->id;
                $save = $timing->save();

            }
            if (!empty($req->id)) {
                Session::flash("success-msg", "Record Updated Successfully.");
            }else{

            Session::flash("success-msg", "Record Added Successfully.");
            }
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->to('admin/agents');
    }
    public function agentReviews()
    {
        $data['reviews'] = AgentReview::all();
        return view("admin.agents.manage-reviews",$data);
    }
    public function agentPromotions(Request $r)
    {
        $promotion = AgentDeal::with('agent')->where(function($query) {
                        $query->where('admin_approved', 0)
                              ->orWhereNull('admin_approved');
                    });
        if(!empty($r->agent)){
            $promotion = $promotion->where('agents_id',$r->agent);
        }
        $data['promotions'] = $promotion->orderBy('id','DESC')->paginate(20);
      $data['agents'] = AgentDeal::with('agent')->where(function($query) {
                        $query->where('admin_approved', 0)
                              ->orWhereNull('admin_approved');
                    })->groupby('agents_id')->get();
        return view("admin.agents.manage-promotions",$data);
    }
    public function approvePromotion(Request $req)
    {
        $visa           = AgentDeal::where('id', $req->id)->first();
        $visa->admin_approved  = $req->is_home;
        $isSave         = $visa->save();
        if ($isSave) {
            return response()->json(["notify"=>true, "msg"=>"Success"]);
        }else{
            return response()->json(["notify"=>false, "msg"=>"Fail"]);
        }
    }
    public function agentGallery(Request $r)
    {
         $promotion = AgentGallery::with('agent')->where(function($query) {
                        $query->where('admin_approved', 0)
                              ->orWhereNull('admin_approved');
                    });
        if(!empty($r->agent)){
            $promotion = $promotion->where('agents_id',$r->agent);
        }
        $data['images'] = $promotion->orderBy('id','DESC')->paginate(20);
      $data['agents'] = AgentGallery::with('agent')->where(function($query) {
                        $query->where('admin_approved', 0)
                              ->orWhereNull('admin_approved');
                    })->groupby('agents_id')->get();
        return view("admin.agents.manage-gallery",$data);
    }
    public function imageApprove(Request $r)
    {
        if($r->cover_change){

            $agent = Agents::where('id',$r->agent_id)->first();
            $agent->cover_changed = '0';
            if($r->cover_change == 'reject'){
                $agent->cover_approved = '0';
                $agent->cover = null;
            }else{
                $agent->cover_approved = '1';
            }
            $saved = $agent->save();
            Session::flash("success-msg", "Record Updated Successfully.");
            return redirect()->back();
        }
        if($r->logo_change){
            $agent = Agents::where('id',$r->agent_id)->first();
            $agent->logo_changed = '0';
            if($r->logo_change == 'reject'){
                $agent->logo_approved = '0';
                $agent->logo = null;
            }else{
                $agent->logo_approved = '1';
            }
            $saved = $agent->save();
            Session::flash("success-msg", "Record Updated Successfully.");
            return redirect()->back();
        }
         $promotion = Agents::where(function($query) {
            $query->where('cover_changed', 1)
                  ->orwhere('logo_changed',1);
        });
        if(!empty($r->agent)){
            $promotion = $promotion->where('id',$r->agent);
        }
        $data['images'] = $promotion->orderBy('id','DESC')->paginate(20);
      $data['agents'] = Agents::where('cover_changed',1)->orwhere('logo_changed',1)->orderBy('business_name','ASC')->get();
    
        return view("admin.agents.manage-images-approval",$data);
    }
    public function approveGallery(Request $req)
    {
        $visa           = AgentGallery::where('id', $req->id)->first();
        $visa->admin_approved  = $req->is_home;
        $isSave         = $visa->save();
        if ($isSave) {
            return response()->json(["notify"=>true, "msg"=>"Success"]);
        }else{
            return response()->json(["notify"=>false, "msg"=>"Fail"]);
        }
    }
    public function agentCities(Request $r){
        $data['cities'] = AgentCity::where('is_foreign','!=',1)->orderBy("name", "ASC")->get();
        $data['foreign_cities'] = AgentCity::where('is_foreign',1)->orderBy("name", "ASC")->get();
        $data['numbers'] = AgentCity::pluck('top_number')->toArray();
        return view('admin.agents.manage-agent-cities',$data);
    
    }
    public function editCity($id){
        $data['detail'] = AgentCity::where('id',$id)->first();
         $data['countries'] = Country::all();
        return view("admin.agents.add-agent-city", $data);
    }
    public function addCity()
    {
        $data['countries'] = Country::all();
        return view("admin.agents.add-agent-city",$data);
    }
     public function saveCity(Request $req){

      $validator = Validator::make(Input::all(), [
          'name'   => 'required',
      ]);

      if ($validator->fails()) {
          Session::flash("error-msg", $validator->messages()->first());
          return redirect()->back()->withInput(Input::all());
      }

      if (is_null($req->id)) {
          $agent     = new AgentCity;
      }else{
          $agent     = AgentCity::where('id',$req->id)->first();
      }

   

      if (!empty($req->image)) {
        $filename = Input::file('image')->getClientOriginalName();
        $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
        Input::file('image')->move($this->filePath, $fileNewName);

        $agent->image          = $fileNewName;
    }
      $agent->name        = $req->name;
      $agent->is_foreign           = isset($req->countries_id) && $req->countries_id == 3?0:1;
      $agent->image_alt        = $req->image_alt;
      $agent->countries_id        = $req->countries_id;

      
      $isSave                     = $agent->save();

      if ($isSave) {
          
          if (!empty($req->id)) {
              Session::flash("success-msg", "Record Updated Successfully.");
          }else{

          Session::flash("success-msg", "Record Added Successfully.");
          }
      }else{
          Session::flash("error-msg", "Something went wrong. Try again.");
      }

      return redirect()->route('admin.agent-cities');
  }
  public function jobCategories(Request $r){
      if(!empty($r->delete_id)){
          DB::statement('SET FOREIGN_KEY_CHECKS=0;');
          $cat = JobCategory::where('id',$r->delete_id)->delete();
          DB::statement('SET FOREIGN_KEY_CHECKS=1;');
          if($cat){
                 Session::flash("success-msg", "Deleted Successfully.");
                    return redirect()->back();
          }
      }
    $data['categories'] = JobCategory::orderby('name')->get();
    return view('admin.agents.manage-job-category',$data);

}
public function editJobCategory($id){
    $data['detail'] = JobCategory::where('id',$id)->first();
    return view("admin.agents.add-job-category", $data);
}
public function addJobCategory()
{
    return view("admin.agents.add-job-category");
}
 public function saveJobCategory(Request $req){

  $validator = Validator::make(Input::all(), [
      'name'   => 'required',
  ]);

  if ($validator->fails()) {
      Session::flash("error-msg", $validator->messages()->first());
      return redirect()->back()->withInput(Input::all());
  }

  if (is_null($req->id)) {
      $already = JobCategory::where('name',$req->name)->first();
      if(!is_null($already)){
           Session::flash("error-msg", 'Already Added');
           return redirect()->back()->withInput(Input::all());
      }
      $agent     = new JobCategory;
  }else{
      $agent     = JobCategory::where('id',$req->id)->first();
  }

   if (!empty($req->image)) {
      $filename = Input::file('image')->getClientOriginalName();
      $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
      Input::file('image')->move($this->categoryPath, $fileNewName);

      $agent->image          = $fileNewName;
  }

 
  $agent->name        = $req->name;

  
  $isSave                     = $agent->save();

  if ($isSave) {
      
      if (!empty($req->id)) {
          Session::flash("success-msg", "Record Updated Successfully.");
      }else{

      Session::flash("success-msg", "Record Added Successfully.");
      }
  }else{
      Session::flash("error-msg", "Something went wrong. Try again.");
  }

  return redirect()->route('admin.job-categories');
}
  public function jobDesignations(Request $r){
    $data['categories'] = JobDesignation::orderby('name')->get();
    return view('admin.agents.manage-job-designation',$data);

}
public function editJobDesignation($id){
    $data['detail'] = JobDesignation::where('id',$id)->first();
    $data['categories'] = JobCategory::orderby('name')->get();
    return view("admin.agents.add-job-designation", $data);
}
public function addJobDesignation()
{
    $data['categories'] = JobCategory::orderby('name')->get();
    return view("admin.agents.add-job-designation",$data);
}
 public function saveJobDesignation(Request $req){

  $validator = Validator::make(Input::all(), [
      'name'   => 'required',
  ]);

  if ($validator->fails()) {
      Session::flash("error-msg", $validator->messages()->first());
      return redirect()->back()->withInput(Input::all());
  }

  if (is_null($req->id)) {
      $already = JobDesignation::where('name',$req->name)->first();
      if(!is_null($already)){
           Session::flash("error-msg", 'Already Added');
           return redirect()->back()->withInput(Input::all());
      }
      $agent     = new JobDesignation;
  }else{
      $agent     = JobDesignation::where('id',$req->id)->first();
  }

   if (!empty($req->image)) {
      $filename = Input::file('image')->getClientOriginalName();
      $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
      Input::file('image')->move($this->categoryPath, $fileNewName);

      $agent->image          = $fileNewName;
  }

 
  $agent->name        = $req->name;
  $agent->job_category_id = $req->category;

  
  $isSave                     = $agent->save();

  if ($isSave) {
      
      if (!empty($req->id)) {
          Session::flash("success-msg", "Record Updated Successfully.");
      }else{

      Session::flash("success-msg", "Record Added Successfully.");
      }
  }else{
      Session::flash("error-msg", "Something went wrong. Try again.");
  }

  return redirect()->route('admin.job-designations');
}
public function ticketFilters(Request $r){
    if(!empty($r->active_id)){
        $active = TicketsFilter::where('id',$r->active_id)->first();
        $active->active = !empty($r->active)?1:0;
        $saved = $active->save();
        if($saved){
            Session::flash("success-msg",'Record Updated');
      return redirect()->back()->withInput(Input::all());
        }else{
            Session::flash("error-msg",'There is an error');
      return redirect()->back()->withInput(Input::all());
        }
    }
    $data['categories'] = TicketsFilter::all();
   
    return view('admin.agents.manage-ticket-filters',$data);

}
public function editTicketFilter($id){
    $data['detail'] = TicketsFilter::where('id',$id)->first();
    	$data['airlines'] =  Airlines::orderBy('name','ASC')->get();
    $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.sasti_ticket',1)->orderBy('cities.name','ASC')->get();
	$data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.sasti_ticket',1)->orderBy('cities.name','ASC')->get();
    return view("admin.agents.add-ticket-filters", $data);
}
public function addTicketFilter()
{
     	$data['airlines'] =  Airlines::orderBy('name','ASC')->get();
    $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.sasti_ticket',1)->orderBy('cities.name','ASC')->get();
	$data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.sasti_ticket',1)->orderBy('cities.name','ASC')->get();
    return view("admin.agents.add-ticket-filters",$data);
}
 public function saveTicketFilter(Request $req){

  $validator = Validator::make(Input::all(), [
      'to_city'   => 'required',
  ]);

  if ($validator->fails()) {
      Session::flash("error-msg", $validator->messages()->first());
      return redirect()->back()->withInput(Input::all());
  }

  if (is_null($req->id)) {
     
      $agent     = new TicketsFilter;
  }else{
      $agent     = TicketsFilter::where('id',$req->id)->first();
  }

   if (!empty($req->image)) {
      $filename = Input::file('image')->getClientOriginalName();
      $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
      Input::file('image')->move($this->categoryPath, $fileNewName);

      $agent->image          = $fileNewName;
  }

 
  $agent->from_city        = $req->from_city;
  $agent->to_city        = $req->to_city;
  $agent->month        = $req->month;
  $agent->airline        = $req->airline;
  $agent->sortby        = $req->sortby;

  
  $isSave                     = $agent->save();

  if ($isSave) {
      
      if (!empty($req->id)) {
          Session::flash("success-msg", "Record Updated Successfully.");
      }else{

      Session::flash("success-msg", "Record Added Successfully.");
      }
  }else{
      Session::flash("error-msg", "Something went wrong. Try again.");
  }

  return redirect()->route('admin.ticket-filters');
}
  
public function dtsVerified(Request $req)
{
    $visa           = Agents::where('id', $req->id)->first();
    $visa->dts_verified  = $req->is_home;
    $isSave         = $visa->save();
    if ($isSave) {
        return response()->json(["notify"=>true, "msg"=>"Success"]);
    }else{
        return response()->json(["notify"=>false, "msg"=>"Fail"]);
    }
}
public function applicantApproved(Request $req)
{
    $visa           = JobApplicant::where('id', $req->id)->first();
    $visa->approved  = $req->is_home;
    $isSave         = $visa->save();
    if ($isSave) {
        return response()->json(["notify"=>true, "msg"=>"Success"]);
    }else{
        return response()->json(["notify"=>false, "msg"=>"Fail"]);
    }
}
public function manageJobs(Request $r)
{
    if(!empty($r->active_id)){
        $ag = AgentJobs::where('id',$r->active_id)->first();
        $ag->active = !empty($r->active) && $r->active == 1?'1':'';
        $saved = $ag->save();
        if($saved){
              Session::flash("success-msg",'Active Status Updated');
            return redirect()->back();
        }else{
            Session::flash("error-msg",'There is an error');
            return redirect()->back();
        }
    }
    $data['countries'] = Country::orderBy('country','ASC')->get();
    $data['cities'] = Cities::where('jobs',1)->orderBy('name','ASC')->get();
    $data['designations'] = JobDesignation::orderBy('name','ASC')->get();
    $data['experiences'] = JobExperience::orderBy('name','ASC')->get();
    $data['airlines'] = Airlines::whereNotNull('users_id')->orderBy('name','ASC')->get();
    $jobs = AgentJobs::where('type','airline');
    if(!empty($r->airline)){
        $jobs = $jobs->where('users_id',$r->airline);
    }
     if(!empty($r->countries_id)){
        $jobs = $jobs->where('countries_id',$r->countries_id);
    }
     if(!empty($r->airline)){
        $jobs = $jobs->where('users_id',$r->airline);
    }
     if(!empty($r->city)){
        $jobs = $jobs->where('agent_cities_id',$r->city);
    }
     if(!empty($r->designation)){
        $jobs = $jobs->where('job_designations_id',$r->designation);
    }
    $data['jobs'] = $jobs->get();
   return view("admin.agents.manage-jobs",$data);
}
public function addJob(Request $r)
{
    $data['cities'] = Cities::where('jobs',1)->orderBy('name','ASC')->get();
      $data['countries'] = Country::orderBy('country','ASC')->get();
    $data['designations'] = JobDesignation::orderBy('name','ASC')->get();
    $data['experiences'] = JobExperience::orderBy('name','ASC')->get();
    $data['airlines'] = Airlines::whereNotNull('users_id')->orderBy('name','ASC')->get();
   return view("admin.agents.add-job",$data);
}
public function editJob($id,Request $r)
{
        $data['countries'] = Country::orderBy('country','ASC')->get();
    $data['cities'] = Cities::where('jobs',1)->orderBy('name','ASC')->get();
    $data['designations'] = JobDesignation::orderBy('name','ASC')->get();
    $data['experiences'] = JobExperience::orderBy('name','ASC')->get();
    $data['airlines'] = Airlines::whereNotNull('users_id')->orderBy('name','ASC')->get();
    $data['detail'] = AgentJobs::where('id',$id)->first();
   return view("admin.agents.add-job",$data);
}
public function saveJob(Request $r)
    {
        $validator = Validator::make(Input::all(), [
            'designation'   => 'required',
          ]);
        
          if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
          }

          if(!empty($r->id)){
              $j = AgentJobs::where('id',$r->id)->first();
          }else{
              $j = new AgentJobs;
                   $j->active = 1;
          }
          $category = JobDesignation::where('id',$r->designation)->first();
        //   $city = AgentCity::where('id',$r->city)->first();
          if($r->type == 'agent'){

              $agent  = Agents::where('users_id',auth()->user()->id)->first();
              $title = $category->name.' required at '.$agent->business_name;
              $agent_id = $agent->id;
            }else{
                $title = $category->name;
            }
          $j->title = $title;
          $j->slug = str_slug($title);
          $j->offer = $r->offer;
          $j->type = $r->type;
          $j->post_url = $r->post_url;
          $j->vacancies = $r->vacancies;
          $j->age_limit = $r->age_limit;
          $j->qualification = $r->qualification;
          $j->requirement = nl2br($r->requirement);
          $j->post_date = !empty($r->post_date)?date('Y-m-d',strtotime($r->post_date)):'';
          $j->apply_date = !empty($r->apply_date)?date('Y-m-d',strtotime($r->apply_date)):'';
          $j->experience = $r->experience;
          $j->countries_id = $r->countries_id;
     
          if($r->type == 'airline'){

            $j->users_id = $r->airline;
        }else{
              $j->agents_id = $agent_id;

          }
          $j->agent_cities_id = $r->city;
          $j->job_designations_id = $r->designation;
          $saved = $j->save();
          if ($saved) {
            Session::flash("success-msg", "Job Added / Updated Successfully.");
           
            return redirect()->to('admin/manage-jobs');
           }else{
            Session::flash("success-msg", "There is an Error.");
           
            return redirect()->back();
           }
    }
public function applicants(Request $r)
{
    $request = JobApplicant::select('job_applicant.*','job_category.name as category')->join('agent_jobs','agent_jobs.id','job_applicant.agent_jobs_id')->join('job_category','job_category.id','agent_jobs.job_category_id');
    if(!empty($r->id)){
        $request = $request->where('agent_jobs_id',$r->id);
    }
    $data['requests'] = $request->paginate(15);
   return view("admin.agents.manage-applicants",$data);
}
public function jobExperience(Request $r){
    $data['experiences'] = JobExperience::all();
    return view('admin.agents.manage-job-experience',$data);

}
public function editJobExperience($id){
    $data['detail'] = JobExperience::where('id',$id)->first();
    return view("admin.agents.add-job-experience", $data);
}
public function addJobExperience()
{
    return view("admin.agents.add-job-experience");
}
 public function saveJobExperience(Request $req){

  $validator = Validator::make(Input::all(), [
      'name'   => 'required',
  ]);

  if ($validator->fails()) {
      Session::flash("error-msg", $validator->messages()->first());
      return redirect()->back()->withInput(Input::all());
  }

  if (is_null($req->id)) {
      $agent     = new JobExperience;
  }else{
      $agent     = JobExperience::where('id',$req->id)->first();
  }



 
  $agent->name        = $req->name;

  
  $isSave                     = $agent->save();

  if ($isSave) {
      
      if (!empty($req->id)) {
          Session::flash("success-msg", "Record Updated Successfully.");
      }else{

      Session::flash("success-msg", "Record Added Successfully.");
      }
  }else{
      Session::flash("error-msg", "Something went wrong. Try again.");
  }

  return redirect()->route('admin.job-experiences');
}
public function saveHomeListing(Request $req)
{
    $cat           = AgentCity::where('id', $req->id)->first();
    $cat->top_trending  = $req->is_home;
    $isSave         = $cat->save();
    if ($isSave) {
        return response()->json(["notify"=>true, "msg"=>"Success"]);
    }else{
        return response()->json(["notify"=>false, "msg"=>"Fail"]);
    }
}
public function saveHomeListingNumber(Request $req)
{
    $cat           = AgentCity::where('id', $req->id)->first();
    $cat->top_number  = $req->top;
    $isSave         = $cat->save();
    if ($isSave) {
        return response()->json(["notify"=>true, "msg"=>"Success"]);
    }else{
        return response()->json(["notify"=>false, "msg"=>"Fail"]);
    }
}
public function businessUnsetNumber($id)
{
   $unset = AgentCity::where('id',$id)->first();
   $unset->top_number = 0;
   $unset->save();

       Session::flash("success-msg", "Unset successfully");
   return redirect()->back(); 
}
public function getAgents(){
        $q = request()->input('query');
        // $data = Country::join('visas','visas.countries_id', '=', 'countries.id')->where('countries.country','LIKE','%'.$q.'%')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
        $data = Agents::join('agent_cities','agent_cities.id','agents.cities_id')->where('agents.active',1)->where("agents.business_name",'LIKE','%'.$q.'%')->get(["agents.business_name", "agents.slug", "agent_cities.name"]);
        $countryResult = array();
        if ($data->count() > 0) {
            foreach ($data as $value) {
              $name = $value->business_name.' ('.$value->name.')';
                $countryResult[] = array("name" => $name, "slug" => $value->slug);
            }

        }
        return response()->json($countryResult);


    }
    public function deleteagent($id)
    { 
      $visas      = Agents::where('id', $id)->delete();
      if ($visas) {
        Session::flash("success-msg", "Deleted Successfully.");
      }else{
        Session::flash("error-msg", "Something went wrong. Try again.");
      }
      return redirect()->back();
    }


}
