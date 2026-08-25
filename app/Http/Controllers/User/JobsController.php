<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgentJobs;
use App\JobApplicant;
use App\Agents;
use App\AgentCity;
use App\JobCategory;
use App\JobExperience;
use App\ForeignJobs;
use App\Country;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
use \Validator;
class JobsController extends Controller
{
    public function jobs(Request $r)
    {
        if($r->type == 'agent'){
        $agent  = Agents::where('users_id',auth()->user()->id)->first();
        if (is_null($agent)) {
            Session::flash("error-msg", "Please Add Business First");

            return redirect()->back();
        }
        $data['jobs'] =  AgentJobs::where('agents_id',$agent->id)->where('type',$r->type)->paginate(20);
        }else{
            
                $data['jobs'] =  AgentJobs::where('users_id',auth()->user()->id)->where('type',$r->type)->paginate(20);
        }
        return view('user.manage-jobs',$data);
    }
    public function addJob()
    {
        $data['cities'] = AgentCity::orderBy('name','ASC')->get();
        $data['categories'] = JobCategory::orderBy('name','ASC')->get();
        $data['experiences'] = JobExperience::orderBy('name','ASC')->get();
        return view('user.add-job',$data);
    }
    public function editJob($id)
    {
        $data['cities'] = AgentCity::orderBy('name','ASC')->get();
        $data['categories'] = JobCategory::orderBy('name','ASC')->get();
        $data['experiences'] = JobExperience::orderBy('name','ASC')->get();
        $data['detail'] =  AgentJobs::where('id',$id)->first();
        return view('user.add-job',$data);
    }
    public function saveJob(Request $r)
    {
        $validator = Validator::make(Input::all(), [
            'city'   => 'required',
            'category'   => 'required',
            'requirement'   => 'required',
            'apply_date'   => 'required',
          ]);
        
          if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
          }

          if(!empty($r->id)){
              $j = AgentJobs::where('id',$r->id)->first();
          }else{
              $j = new AgentJobs;
          }
          $category = JobCategory::where('id',$r->category)->first();
        //   $city = AgentCity::where('id',$r->city)->first();
          if($r->type == 'agent'){

              $agent  = Agents::where('users_id',auth()->user()->id)->first();
              $title = $category->name.' required at '.$agent->business_name;
              $agent_id = $agent->id;
            }else{
                $title = $category->name.'required';
            }
          $j->title = $title;
          $j->slug = str_slug($title);
          $j->offer = $r->offer;
          $j->type = $r->type;
          $j->post_url = $r->post_url;
          $j->requirement = nl2br($r->requirement);
          $j->post_date = date('Y-m-d',strtotime($r->post_date));
          $j->apply_date = date('Y-m-d',strtotime($r->apply_date));
          $j->job_experience_id = $r->experience;
          if($r->type == 'airline'){

              $j->users_id = auth()->user()->id;
        }else{
              $j->agents_id = $agent_id;

          }
          $j->agent_cities_id = $r->city;
          $j->job_category_id = $r->category;
          $saved = $j->save();
          if ($saved) {
            Session::flash("success-msg", "Job Added / Updated Successfully.");
           
            return redirect()->to('manage-agent-jobs?type='.$r->type);
           }else{
            Session::flash("success-msg", "There is an Error.");
           
            return redirect()->back();
           }
    }
     public function foreignJobs(Request $r)
    {
      
            
        $data['jobs'] =  ForeignJobs::where('agents_id',auth()->user()->agent->id)->paginate(20);
        
        return view('user.manage-foreign-jobs',$data);
    }
    public function addforeignJob()
    {
        $data['countries'] = Country::where('id','!=','3')->orderBy('country','ASC')->get();
        return view('user.add-foreign-job',$data);
    }
    public function editforeignJob($id)
    {
       $data['countries'] = Country::where('id','!=','3')->orderBy('country','ASC')->get();
        $data['detail'] =  ForeignJobs::where('id',$id)->first();
        return view('user.add-foreign-job',$data);
    }
    public function saveforeignJob(Request $r)
    {
        $validator = Validator::make(Input::all(), [
            'title'   => 'required',
            'country'   => 'required',
          ]);
        
          if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
          }

          if(!empty($r->id)){
              $j = ForeignJobs::where('id',$r->id)->first();
          }else{
              $j = new ForeignJobs;
          }
     
          $agent_id = auth()->user()->agent->id;
         
        $j->agents_id = $agent_id;

          $j->title = $r->title;
          $j->salary = $r->salary;
          $j->place_of_duty = $r->place_of_duty;
          $j->countries_id = $r->country;
           $j->permission = $r->permission;
          $j->agent_cities_id = auth()->user()->agent->city->id;
          $j->city = auth()->user()->agent->city->name;
          $saved = $j->save();
          if ($saved) {
            Session::flash("success-msg", "Job Added / Updated Successfully.");
           
            return redirect()->to('manage-agent-foreign-jobs?type='.$r->type);
           }else{
            Session::flash("success-msg", "There is an Error.");
           
            return redirect()->back();
           }
    }
    public function requests(Request $r)
    {
        // $agent  = Agents::where('users_id',auth()->user()->id)->first();
        // if (is_null($agent)) {
        //     Session::flash("error-msg", "Please Add Business First");

        //     return redirect()->back();
        // }
        $request = JobApplicant::select('job_applicant.*','job_category.name as category')->join('agent_jobs','agent_jobs.id','job_applicant.agent_jobs_id')->join('job_category','job_category.id','agent_jobs.job_category_id')->where('job_applicant.approved',1);
        if(!empty($r->id)){
            $request = $request->where('agent_jobs_id',$r->id);
        }
        $data['requests'] = $request->paginate(15);
        
        return view('user.requests',$data);
    }
    public function jobActive(Request $req)
{
    $visa           = AgentJobs::where('id', $req->id)->first();
    $visa->active  = $req->is_home;
    $isSave         = $visa->save();
    if ($isSave) {
        return response()->json(["notify"=>true, "msg"=>"Success"]);
    }else{
        return response()->json(["notify"=>false, "msg"=>"Fail"]);
    }
}
}