<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agents;
use App\AgentType;
use App\AgentCity;
use App\AgentReview;
use App\User;
use App\JobApplicant;
use App\JobAttachment;
use App\AgentJobs;
use App\JobCategory;
use App\JobDesignation;
use App\Airlines;
use App\Cities;
use App\ForeignJobs;
use App\Visitor;
use App\Country;
use \Validator;
use Mail;
use Session;
use App\AgentSubscription;
use App\Transaction;
use DB;
use Auth;
use Hash;
use App\Mail\SendApplicant;
use Input;
use Illuminate\Support\Facades\Password;
use Jenssegers\Agent\Agent;
 use App\Mail\SendMail;
class AgentController extends Controller
{
    public $filePath = 'storage/uploads/agents';
    public $attachmentPath = 'storage/uploads/';
    public function agents(Request $r)
    {
         $detect         = new Agent();
          if(!empty($r->q) || !empty($r->type)){
             $agent = Agents::with('agentType')->with('agentReviews')->with('city')->where('active',1);
               
              if (!empty($r->type)) {

                $agent = $agent->where('agents.agent_type_id',$r->type);
              }
              if (!empty($r->q)) {
                $agent = $agent->where('business_name','LIKE','%'.$r->q.'%')->orWhere('address','LIKE','%'.$r->q.'%');
              }

             $data['agents'] = $agent->paginate(15);
             $data['types'] = AgentType::all();

             if($r->ajax()){

              $agents = $data['agents'];
              $view = view('partials.agent-listing',compact('agents'))->render();
              return (['html'=>$view,'next_page' => $agents->nextPageUrl()]);
            }
         }else{
              $data['agents'] = null;
              if($detect->isMobile()){
                $take = 16;
              }else{
                $take = 16;
              }
              $data['types'] = AgentCity::where('top_trending',1)->orderBy('top_number','ASC')->take($take)->get();
              $data['agentCities'] = AgentCity::join('agents','agents.cities_id','agent_cities.id')->orderBy('agent_cities.name','ASC')->select('agent_cities.*')->groupBy('agent_cities.id')->get();
         }
         
        return view('agents',$data);
          
    }
    public function agentCity($slug, Request $r)
    {
      
        $agent = Agents::leftjoin('agent_subscriptions','agent_subscriptions.agents_id','agents.id')->leftjoin('transactions','transactions.subscription_id','agent_subscriptions.id')->with('agentType')->with('city')->where('business_name','!=','');
        $city = unslug($slug);

        $city = AgentCity::where('name',$city)->first();
        if (is_null($city)) {
          return redirect()->to('/');
        }
        $agent = $agent->where('cities_id',$city->id);
        if (!empty($r->type)) {
            $agent = $agent->where('agents.agent_type_id',$r->type);
        }
        if (!empty($r->q)) {
            $agent = $agent->where(function($query) use ($r) {
                $query->where('agents.business_name', 'LIKE', '%' . $r->q . '%')
                      ->orWhere('address', 'LIKE', '%' . $r->q . '%');
            });
        }
         if (!empty($r->verified) && $r->verified == 1) {

         $agent = $agent->where('agent_subscriptions.plan_id',6);
         $agent = $agent->where('agent_subscriptions.active',1);
         $agent = $agent->where('transactions.status','paid');
       }
        $data['agents'] = $agent->orderBy('agents.business_name','ASC')->select('agents.*')->paginate(15);
     
        $data['types'] = AgentType::get();
        $data['cities'] = AgentCity::all();
        $data['searchCity'] = $city;
           if($r->ajax()){
           
            $agents = $data['agents'];

            $view = view('partials.agent-listing',compact('agents'))->render();
            return (['html'=>$view,'next_page' => $agents->nextPageUrl()]);
          }else{
        return view('agents',$data);
      }
        # code...
    }
    public function makeSlugs()
    {
          $movies  = Agents::chunk(50, function($inspectors) {
                foreach ($inspectors as $key => $value) {
                   $slug  = str_slug($value->business_name.(!is_null($value->city)?"-".$value->city->name:''));
                   $rec   = Agents::where('id',$value->id)->first();
                   $rec->slug  = $slug;
                   $rec->save();
               }
            });
          
    }
    public function phoneNumber()
    {
        $agents = Agents::all();
        foreach ($agents as $key => $agent) {
            $agentid =  $agent->id;
  
            $agentdata = DB::table(DB::raw('findchea_agent_data.phone_numbers'))->where('agent_id',$agentid)->get();
            $phone = array();
            foreach ($agentdata as $key => $value) {
                $phone[] = $value->phone_number;
            }
            $phone = implode(',', $phone);
            $agent->phone = $phone;
            $agent->save();
        }
        return redirect()->back()->with('success-msg', 'Phones updated successfully.');
    }
    public function SaveReview(Request $r)
    {
       $validator = Validator::make(Input::all(), [
            'rating'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        $review = new AgentReview;
        if (!empty($r->attachment)) {
            $filename = Input::file('attachment')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('attachment')->move($this->filePath, $fileNewName);
          
            $review->attachement          = $fileNewName;
          }
        $review->rating = $r->rating;
        $review->active = 0;
        $review->message = $r->message;
        $review->users_id = $r->user_id;
        $review->agents_id = $r->agent_id;
       $saved =  $review->save();
       if ($saved) {
          Session::flash("success-msg", "Review Send");
       }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->back();
    }
    public function activeReview(Request $req)
    {
        $visa           = AgentReview::where('id', $req->id)->first();
        $visa->active  = $req->is_home;
        $isSave         = $visa->save();
        if ($isSave) {
            return response()->json(["notify"=>true, "msg"=>"Success"]);
        }else{
            return response()->json(["notify"=>false, "msg"=>"Fail"]);
        }
    }
    public function claimBusiness($slug)
    {
        $data['slug'] = $slug; 
        $data['business'] = Agents::where('slug',$slug)->first();
       return view('claim-business',$data);
    }
     public function saveClaimedBusiness(){

    $validator = Validator::make(Input::all(), [
        'biz_id'                => 'required',
        'password'              => 'required|max:255',
        'email'                 => 'required|email'
    ]);


    if ($validator->fails()) {
      Session::flash("error-msg", $validator->messages()->first());
        return back()
        ->withErrors($validator)
        ->withInput();
    }

    $biz_id             = Input::has('biz_id')?Input::get('biz_id'):"";
    $name               = Input::has('name')?Input::get('name'):"";
    $email              = Input::has('email')?Input::get('email'):"";
    $password           = Input::has('password')?Input::get('password'):"";
    $confirm_password   = Input::has('confirm_password')?Input::get('confirm_password'):"";



         if (!empty($name) && !empty($confirm_password)) {

            $user = User::where("email",$email)->first();
            if (!is_null($user)) {
               Session::flash("error-msg", "Email Already Taken");
            return redirect()->to('claim-business/'.$biz_id.'?register=yes')->withInput();
            }
            if ($password != $confirm_password) {
                Session::flash("error-msg", "Password & Confirm Password Does Not Match");
            return redirect()->to('claim-business/'.$biz_id.'?register=yes')->withInput();
            }
          $token          = Password::getRepository()->createNewToken();
          $u = new User;
          $u->name          = $name;
          $u->email               = $email;
          $u->password            = Hash::make($password);
          $u->visible_password    = $password;
          $u->verified            = 0;
          $u->verification_token  = $token;
          $u->is_subscribe        = 0;
          $u->active              = 0;
          $isSave                 = $u->save();
          $data = [
                "name"      =>  $name,
                "email"     =>  $email,
                "token"     =>  $token
            ];
          Mail::to($email)->send(new SendMail($data));
        }else{
          $user = User::where("email",$email)->first();
          if (is_null($user)) {
            Session::flash("error-msg", "Email or password are not match ");
            return redirect()->to('claim-business/'.$biz_id)->withErrors('Email or password are not match')->withInput();
          }
         $check =  Hash::check($password, $user->password);

           if (!$check) {
            Session::flash("error-msg", "Email or password are not match");
            return redirect()->to('claim-business/'.$biz_id)->withInput();
          }
          // if ($user->verified != 1) {
          //    Session::flash("error-msg", "You Account is Not Verified ..Please Check You Inbox");
          //    return redirect()->back()->withInput();      
          //  }

            $check = Agents::where('users_id',$user->id)->first();
            if (!is_null($check)) {
               Session::flash("error-msg", "Business Already Registered With This Email");
                return redirect()->to('claim-business/'.$biz_id)->withInput();
            }
            $u = $user;
        }


    $biz = Agents::where('slug', $biz_id)->first();

    if (!is_null($biz)) {
        $biz->users_id          = $u->id;
        $biz->code               = generateCode();
        $bizSave                = $biz->save();
        if ($bizSave) {

          DB::statement('SET FOREIGN_KEY_CHECKS=0');
          $expire_date = date('Y-m-d h:i:s', strtotime("+100 year"));
          $subcription = new AgentSubscription;
          $subcription->period = '100';
          $subcription->plan_id = '5';
          $subcription->agents_id = $biz->id;
          $subcription->active = 1;
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
            $remember   = Input::has("remember")?true:false;
            if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password], $remember)) 
            {   
              Session::flash("success-msg", "Business has been claimed");
              return redirect()->to('/home');
            }else{
               Session::flash("error-msg", "Error While Login Please Login Again.");
               return redirect()->to('agent/'.$biz_id);
            }
        }else{
            Session::flash("error-msg", "Please try again");
            return redirect()->back();
        }
    }
}
public function cities($slug = 'all')
{
    if(!empty($slug) && $slug != 'all'){
    $data['cities'] = AgentCity::where('name','LIKE',$slug.'%')->orderBy('name','ASC')->get();
    }else{
    $data['cities'] = AgentCity::orderBy('name','ASC')->get();
    }
    $data['meta_title'] = 'Travel agents in Pakistan, Cheap Umrah Packages | '.ucfirst($slug);
    return view('cities',$data);
}
public function AgentDetail($slug)
{
    $today = date('Y-m-d');
    $data['detail'] = Agents::where('slug', $slug)->where('active',1)
    ->withCount([
        'tickets as has_sastickets' => function ($q) use ($today) {
            $q->where('seats', '>=', 1)
              ->where('out_bound_date', '>=', $today);
        },
        'flights as has_flights' => function ($q) use ($today) {
            $q->where('seats', '>=', 1)
              ->where('out_bound_date', '>=', $today);
        }
    ])
    ->first();
    if(is_null($data['detail'])){
        return redirect()->to('/');
    }
    
    $ip = request()->ip();
    $today = date('Y-m-d'); // example: 2025-02-15
    
    $already = Visitor::where('ip', $ip)->where('agents_id',$data['detail']->id)
        ->whereDate('created_at', $today)
        ->exists();
    
    if (!$already) {
    
        // $position = Location::get($ip);
    
        $v = new Visitor;
        $v->ip = $ip;
        // $v->location = isset($position) && !is_null($position)
        //     ? $position->cityName.', '.$position->countryName
        //     : '';
        // $v->browser = $agent->browser();
        // $v->platform = $agent->platform();
        // $v->device = $device_type;
        $v->header = request()->header('User-Agent');
        $v->agents_id = $data['detail']->id;
        $v->type = 'agent';
        $v->save();
    }
    $data['agent'] = $data['detail']; // expose as $agent so meta.blade.php generates unique per-agent title/description
    return view('agent-detail',$data);
}
public function previewBusiness($slug)
{
    $data['detail'] = Agents::where('slug',$slug)->first();
    if(is_null($data['detail'])){
        return redirect()->to('/');
    }
    return view('preview-business',$data);
}
public function foreignJobs(Request $r)
{

    // -------------------------
    // 1. Track Visitor
    // -------------------------
    $ip = $r->ip();
    $today = date('Y-m-d');

     $already = Visitor::where('ip', $ip)->where('type','foreign_job')
        ->whereDate('created_at', $today)
        ->exists();
    
    if (!$already) {
        $v = new Visitor;
        $v->ip = $ip;
        $v->header = request()->header('User-Agent');
        $v->type = 'foreign_job';
        $v->save();
    }

    // -------------------------
    // 2. SEARCH FILTER
    // -------------------------
    $data['jobs'] = null;
    $data['search_country'] = null;
    $data['search_agent'] = null;

    if ($r->hasAny(['job_title','agent_city','place_of_duty','agent','country'])) {

        $jobs = ForeignJobs::query();

        if ($r->job_title) {
            $jobs->where('title','LIKE','%'.$r->job_title.'%');
        }

        if ($r->agent_city) {
            $jobs->where('agent_cities_id', $r->agent_city);
        }

        if ($r->place_of_duty) {
            $jobs->where('place_of_duty','LIKE','%'.$r->place_of_duty.'%');
        }

        if ($r->agent) {
            $jobs->where('agents_id', $r->agent);
            $data['search_agent'] = Agents::where('id',$r->agent)->first()->business_name;
        }

        if ($r->country) {
            $jobs->where('countries_id', $r->country);
             $data['search_country'] = Country::where('id',$r->country)->first()->country;
        }

        $data['jobs'] = $jobs->orderBy('title')->paginate(30)->appends(request()->query());;
    }
    // -------------------------
    // 3. FILTER ONLY COUNTRIES WITH JOBS
    // -------------------------
    $data['countries'] = Country::withCount('foreign_jobs as jobs_count')
        ->has('foreign_jobs')
        ->orderBy('country')
        ->get();

    // -------------------------
    // 4. AGENTS WITH JOB COUNTS
    // -------------------------
    $data['agents'] = Agents::withCount('foreignJobs')
        ->has('foreignJobs')
        ->orderBy('business_name')
        ->get();

    // -------------------------
    // 5. CITIES WITH JOB COUNTS
    // -------------------------
    $data['cities'] = AgentCity::has('foreignJobs')
        ->orderBy('name')
        ->get();

    return view('jobs.foreign-jobs', $data);
}
public function jobs(Request $r)
{
   $ip = request()->ip();
    $today = date('Y-m-d'); // example: 2025-02-15
    
    $already = Visitor::where('ip', $ip)->where('type','job')
        ->whereDate('created_at', $today)
        ->exists();
    
    if (!$already) {
        $v = new Visitor;
        $v->ip = $ip;
        $v->header = request()->header('User-Agent');
        $v->type = 'job';
        $v->save();
    }
    // $data['jobs'] = AgentJobs::where('apply_date','>=',date('dd-mm-yyy'))->get();
    $cities = Cities::join('agent_jobs','agent_jobs.agent_cities_id','cities.id')->join('job_designations','job_designations.id','agent_jobs.job_designations_id')->where('cities.countries_id',3)->where('agent_jobs.active',1);
   
    $cities = $cities->whereNull('agent_jobs.agents_id')->whereNotNull('agent_jobs.users_id')->whereRaw(
    "STR_TO_DATE(agent_jobs.apply_Date, '%Y-%m-%d') >= CURDATE()"
);
    
    if(!empty($r->job_title)){
          $cities = $cities->where('agent_jobs.title','LIKE','%'.$r->job_title.'%');
      }
 
       if(!empty($r->job_categories)){
          $cities = $cities->where('job_designations.job_category_id',$r->job_categories);
      }
       if(!empty($r->city)){
          $cities = $cities->where('cities.id',$r->city);
      }
       if(!empty($r->country)){
            $cities = $cities->where(function ($q) use ($r) {
                $q->where('cities.countries_id', $r->country)
                  ->orWhere('countries_id', $r->country);   
            });
      }
       if(!empty($r->airline)){
          $cities = $cities->where('agent_jobs.users_id',$r->airline);
      }
    $data['cities'] = $cities->groupBy('cities.id')->orderBy('cities.name','ASC')->select('cities.*', DB::raw('COUNT(agent_jobs.id) as job_count'))->get();
    $data['citiesfilter'] = Cities::where('jobs',1)->orderBy('name','ASC')->get();
    $data['type'] = 'airline';
    $data['airlines'] = Airlines::whereNotNull('users_id')
    ->withCount([
        'agentJobs as jobs_count' => function ($query) {
            $query->whereRaw(
                "STR_TO_DATE(apply_Date, '%Y-%m-%d') >= CURDATE()"
            );
        }
    ])->having('jobs_count', '>', 0)
    ->orderBy('name')
    ->get();
       $data['countries'] = Country::select(
                                'countries.id',
                                'countries.country',
                                DB::raw('COUNT(agent_jobs.id) AS jobs_count')
                            )
                            ->leftJoin('cities', 'cities.countries_id', '=', 'countries.id')
                            ->leftJoin('agent_jobs', function ($join) {
                                $join->on('agent_jobs.countries_id', '=', 'countries.id')   // direct job → country
                                     ->orOn('agent_jobs.agent_cities_id', '=', 'cities.id'); // job → city → country
                            })->whereRaw(
                                "STR_TO_DATE(agent_jobs.apply_Date, '%Y-%m-%d') >= CURDATE()"
                            )
                            ->where('agent_jobs.active', 1)
                            ->whereNotNull('agent_jobs.users_id') // jobs must belong to an agent user
                            ->groupBy('countries.id')
                            ->havingRaw('COUNT(agent_jobs.id) > 0')
                            ->orderBy('countries.country', 'ASC')
                            ->get();
    $data['categories'] = JobCategory::withCount([
        'allJobs as jobs_count' => function ($query) {
            $query->whereRaw(
                "STR_TO_DATE(apply_Date, '%Y-%m-%d') >= CURDATE()"
            );
        }
    ])->having('jobs_count', '>', 0)->orderby('name')->get();

    return view('jobs.jobs',$data);
}
public function jobCity(Request $r,$slug = null)
{ 
      if(!is_null($slug)){
          $city = unslug($slug);
          $city = Cities::where('name',$city)->first();
          if (!is_null($city)) {
                $data['searchCity'] = $city->name;
                $city = $city->id;
                $jobs = AgentJobs::with('airlineCity')->join('job_designations','job_designations.id','agent_jobs.job_designations_id')->leftJoin('cities','cities.id','agent_jobs.agent_cities_id')->where('agent_cities_id',$city)->where('agent_jobs.active',1);
          }
      }else{
              $data['searchCity'] = '';
              $jobs = AgentJobs::with('airlineCity')->join('job_designations','job_designations.id','agent_jobs.job_designations_id')->leftJoin('cities','cities.id','agent_jobs.agent_cities_id')->where('agent_jobs.active',1);
      }

     $data['country'] = null;
      $jobs = $jobs->whereNull('agent_jobs.agents_id')->whereNotNull('agent_jobs.users_id')->whereRaw(
    "STR_TO_DATE(apply_Date, '%Y-%m-%d') >= CURDATE()"
);
      
      if(!empty($r->job_title)){
          $jobs = $jobs->where('agent_jobs.title','LIKE','%'.$r->job_title.'%');
      }
      if(!empty($r->job_categories)){
          $jobs = $jobs->where('job_designations.job_category_id',$r->job_categories);
      }
       if(!empty($r->job_categories)){
          $jobs = $jobs->where('job_designations.job_category_id',$r->job_categories);
      }
    if(!empty($r->city)){
          $jobs = $jobs->where('agent_cities_id',$r->city);
      }
       if(!empty($r->country)){
            $jobs = $jobs->where(function ($q) use ($r) {
                $q->where('cities.countries_id', $r->country)
                  ->orWhere('agent_jobs.countries_id', $r->country);
            });
             $data['country'] = Country::where('id',$r->country)->first();
      }
       if(!empty($r->airline)){
          $jobs = $jobs->where('agent_jobs.users_id',$r->airline);
      }
      $data['jobs'] = $jobs->get();
        $data['airlines'] = Airlines::whereNotNull('users_id')->orderby('name')->get();
         $data['categories'] = JobCategory::orderby('name')->get();
          $data['citiesfilter'] = Cities::where('jobs',1)->orderBy('name','ASC')->get();
      return view('jobs.jobs',$data);
}

public function agentJobs(Request $r)
{
   $ip = request()->ip();
    $today = date('Y-m-d'); // example: 2025-02-15
    
    $already = Visitor::where('ip', $ip)->where('type','agent_job')
        ->whereDate('created_at', $today)
        ->exists();
    
    if (!$already) {
        $v = new Visitor;
        $v->ip = $ip;
        $v->header = request()->header('User-Agent');
        $v->type = 'agent_job';
        $v->save();
    }
    // $data['jobs'] = AgentJobs::where('apply_date','>=',date('dd-mm-yyy'))->get();
    $cities = Cities::join('agent_jobs','agent_jobs.agent_cities_id','cities.id')->join('job_designations','job_designations.id','agent_jobs.job_designations_id')->where('agent_jobs.active',1);
    
    $cities = $cities->whereNotNull('agent_jobs.agents_id')->whereNull('agent_jobs.users_id');
  
    if(!empty($r->job_title)){
          $cities = $cities->where('agent_jobs.title','LIKE','%'.$r->job_title.'%');
      }
 
       if(!empty($r->job_categories)){
          $cities = $cities->where('job_designations.job_category_id',$r->job_categories);
      }
       if(!empty($r->city)){
          $cities = $cities->where('cities.id',$r->city);
      }
       if(!empty($r->agent)){
          $cities = $cities->where('agent_jobs.agents_id',$r->agent);
      }
    $data['cities'] = $cities->groupBy('cities.id')->orderBy('cities.name','ASC')->select('cities.*', DB::raw('COUNT(agent_jobs.id) as job_count'))->get();
    $data['citiesfilter'] = Cities::where('jobs',1)->where('countries_id',3)->orderBy('name','ASC')->get();
    $data['type'] = 'agent';
     $data['agents'] = Agents::join('agent_jobs','agent_jobs.agents_id','agents.id')->where('agents.active',1)->orderby('business_name')->get();
         $data['categories'] = JobCategory::orderby('name')->get();

    return view('jobs.agentJobs',$data);
}
public function agentJobCity(Request $r,$slug = null)
{ 
      if(!is_null($slug)){
          $city = unslug($slug);
          $city = Cities::where('name',$city)->first();
          if (!is_null($city)) {
                $data['searchCity'] = $city->name;
                $city = $city->id;
                $jobs = AgentJobs::with('airlineCity')->join('job_designations','job_designations.id','agent_jobs.job_designations_id')->where('agent_cities_id',$city)->where('agent_jobs.active',1);
          }
      }else{
              $data['searchCity'] = '';
              $jobs = AgentJobs::with('airlineCity')->join('job_designations','job_designations.id','agent_jobs.job_designations_id')->where('agent_jobs.active',1);
      }

      $jobs = $jobs->whereNotNull('agent_jobs.agents_id')->whereNull('agent_jobs.users_id');
      
      if(!empty($r->job_title)){
          $jobs = $jobs->where('agent_jobs.title','LIKE','%'.$r->job_title.'%');
      }
      if(!empty($r->job_categories)){
          $jobs = $jobs->where('job_designations.job_category_id',$r->job_categories);
      }
       if(!empty($r->job_categories)){
          $jobs = $jobs->where('job_designations.job_category_id',$r->job_categories);
      }
    if(!empty($r->city)){
          $jobs = $jobs->where('agent_cities_id',$r->city);
      }
       if(!empty($r->agent)){
          $jobs = $jobs->where('agent_jobs.agents_id',$r->agent);
      }
      $data['jobs'] = $jobs->get();
      $data['agents'] = Agents::join('agent_jobs','agent_jobs.agents_id','agents.id')->where('agents.active',1)->orderby('business_name')->get();
      $data['categories'] = JobCategory::orderby('name')->get();
      $data['citiesfilter'] = Cities::where('jobs',1)->where('countries_id',3)->orderBy('name','ASC')->get();
      return view('jobs.agentJobs',$data);
}
public function applicant($slug)
{
    $data['detail'] = AgentJobs::with('agentCity')->where('slug',$slug)->first();
    return view('jobs.applicant',$data);
}
public function jobDetail($slug)
    {
        $data['detail'] = AgentJobs::where('slug',$slug)->first();
        return view('jobs.detail',$data);
    }
    public function saveApplicant(Request $r)
    {
        
            $validator = Validator::make(Input::all(), [
                'name'   => 'required',
                'email'   => 'required',
                'number'   => 'required',
                'attachment1'   => 'mimes:jpeg,png,pdf',
                'attachment2'   => 'mimes:jpeg,png,pdf',
                'attachment3'   => 'mimes:jpeg,png,pdf',
              ]);
            
              if ($validator->fails()) {
                Session::flash("error-msg", $validator->messages()->first());
                return redirect()->back()->withInput(Input::all());
              }
    
         
                  $j = new JobApplicant;
                  $token          = Password::getRepository()->createNewToken();
                  $ip = $r->ip();
                 
              $j->name = $r->name;
              $j->email = $r->email;
              $j->number = $r->number;
              $j->approved = '0';
              $j->token = $token;
              $j->remarks = $r->remarks;
              $j->agent_jobs_id = $r->job_id;
              $saved = $j->save();
              if ($saved) {
                  $name = $r->name;
                  $email = $r->email;
                $data = [
                    "name"      =>  $name,
                    "email"     =>  $email,
                    "ip"     =>  $ip,
                    "token"     =>  $token
                ];
                Mail::to($email)->send(new SendApplicant($data));

                  if(!empty($r->attachment1)){
                    $t = new JobAttachment;
                    $filename = Input::file('attachment1')->getClientOriginalName();
                    $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
                    Input::file('attachment1')->move($this->attachmentPath, $fileNewName);
                    
                    $t->attachment          = $fileNewName;
                    $t->job_applicant_id = $j->id;
                    $saved = $t->save();
                  }
                  if(!empty($r->attachment2)){
                    $t = new JobAttachment;
                    $filename = Input::file('attachment2')->getClientOriginalName();
                    $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
                    Input::file('attachment2')->move($this->attachmentPath, $fileNewName);
                    
                    $t->attachment          = $fileNewName;
                    $t->job_applicant_id = $j->id;
                    $t->save();
                  }
                  if(!empty($r->attachment3)){
                    $t = new JobAttachment;
                    $filename = Input::file('attachment3')->getClientOriginalName();
                    $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
                    Input::file('attachment3')->move($this->attachmentPath, $fileNewName);
                    
                    $t->attachment          = $fileNewName;
                    $t->job_applicant_id = $j->id;
                    $t->save();
                      
                  }
                Session::flash("success-msg", "Request Saved");
               
                return redirect()->to('applicant-thanks');
               }else{
                Session::flash("success-msg", "There is an Error.");
               
                return redirect()->back();
               }
        
    }
    public function applicantThanks()
    {
        return view('applicant-thanks');
    }
    public function activateApplicant($token)
    {
        $a  = JobApplicant::where('token',$token)->first();
        $a->approved = '1';
        $saved =  $a->save();
        if($saved){
        Session::flash("success-msg", "Email Approved Request Send");
               
        return redirect()->to('/');
        }else{
        Session::flash("success-msg", "There is an Error.");
       
        return redirect()->to('/');
       }
    }

    public function getAgents(){
        $q = request()->input('query');
        // $data = Country::join('visas','visas.countries_id', '=', 'countries.id')->where('countries.country','LIKE','%'.$q.'%')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
        $data = Agents::where("business_name",'LIKE','%'.$q.'%')->where('active',1)->take(10)->get(["business_name", "slug"]);
        $countryResult = array();
        if ($data->count() > 0) {
            foreach ($data as $value) {
              $business_name = strtolower($value->business_name);
                $countryResult[] = array("name" => $business_name, "slug" => url('/')."/agent/".$value->slug);
            }

        }
        return response()->json($countryResult);


    }
    public function AgentCodesScript()
    {
      $agents = Agents::whereNotNull('users_id')->whereNull('code')->get();
      foreach ($agents as $key => $value) {
        $agent = Agents::where('id',$value->id)->first();
         $agent->code =  generateCode();
         $saved = $agent->save();
      }
        Session::flash("success-msg", "Code Generated Successfully");
      return redirect()->to('/');
    }
}
