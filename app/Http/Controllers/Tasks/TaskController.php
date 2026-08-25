<?php

namespace App\Http\Controllers\Tasks;

use App\Agents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\Status;
use App\TasksModels\Vendee;
use App\TasksModels\Task;
use App\TasksModels\TaskHistory;
use App\TasksModels\TaskAttachment;
use App\TasksModels\TaskType;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->attachment  = storage_path("uploads/attachments");
    }

    public function index(Request $req)
    {
        $data['statuses']   = Status::where('type', 'task')->orderBy('name', 'ASC')->get();
        $data['taskTypes'] 	= TaskType::orderBy('name', 'ASC')->get();
        $data['admins'] 	= Agents::orderBy('business_name', 'ASC')->get();
        $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        
        $data['tasks'] 		= Task::with('attachment');
        if (!is_null($req->searched)){
            $data['searched'] = 'yes';
        }
        if (!is_null($req->inquiry_num)){
            $data['tasks'] 		= $data['tasks']->where('id', $req->inquiry_num);
            $data['searched'] = 'yes';
        }
        if (!is_null($req->admins_id) && $req->admins_id != 'all'){
            $data['adminAdded']     = Agents::where('id',$req->admins_id)->first();
            $data['tasks'] 		= $data['tasks']->where('admins_id', $req->admins_id);
            $data['searched'] = 'yes';
        }else if(auth()->guard('admin')->user()->type == 'employee' && $req->admins_id != 'all'){
             $data['tasks']         = $data['tasks']->where('admins_id', auth()->guard('admin')->user()->id);
        }
        if (!is_null($req->date_start)){
            $data['tasks'] 		= $data['tasks']->whereDate('created_at','>=', date('Y-m-d',  strtotime($req->date_start)));
            $data['searched'] = 'yes';
        }
        if (!is_null($req->date_end)){
            $data['tasks'] 		= $data['tasks']->whereDate('created_at', '<=', date('Y-m-d',  strtotime($req->date_start)));
            $data['searched'] = 'yes';
        }
        if (!is_null($req->statuses_id) && $req->statuses_id != 'all'){
               $data['statusAdded']     = Status::where('id',$req->statuses_id)->first();
            $data['tasks'] 		= $data['tasks']->where('last_status', $req->statuses_id);
            $data['searched'] = 'yes';
        }elseif(empty($req->statuses_id)){
             $data['tasks']         = $data['tasks']->where('last_status','!=',5)->where('last_status','!=',9);
        }
      /*  }elseif(empty($req->statuses_id) && $req->statuses_id != 'all'){
             $data['tasks']         = $data['tasks']->where('last_status',3);
        }*/
        if (!is_null($req->task_types_id)){
            $data['typeAdded']     = TaskType::where('id',$req->task_types_id)->first();
            $data['tasks'] 		= $data['tasks']->where('task_types_id', $req->task_types_id);
            $data['searched'] = 'yes';
        }
        if (!is_null($req->parties_id)){
             $data['partyAdded']     = Vendee::where('status', 1)->where('type', 'party')->where('id',$req->parties_id)->first();
            $data['tasks'] 		= $data['tasks']->where('vendees_id', $req->parties_id);
            $data['searched'] = 'yes';
        }
        if (!is_null($req->pax_name)){
            $data['tasks'] 		= $data['tasks']->where('pax_name', 'LIKE', $req->pax_name);
            $data['searched'] = 'yes';
        }
        if (!is_null($req->phone)){
            $data['tasks'] 		= $data['tasks']->where('phone', $req->phone);
            $data['searched'] = 'yes';
        }
        if (!is_null($req->position_type)){
            $data['tasks']      = $data['tasks']->where('task_type', $req->position_type);
            $data['searched'] = 'yes';
        }
        if(!isset($data['searched'])){
            $data['type_1_count'] 		= Task::where('task_type', 1)->where('last_status','!=',5)->count();
            $data['type_2_count'] 		= Task::where('task_type', 2)->where('last_status','!=',5)->count();
            $data['type_3_count'] 		= Task::where('task_type', 3)->where('last_status','!=',5)->count();
            $data['website_count'] 		= Task::where('last_status',9)->count();
            $data['all_count'] = $data['tasks']->count(); 
        }
        $data['tasks'] 		= $data['tasks']->orderBy('id', 'DESC')->paginate(25)->appends($req->except('page'));
        return view('user.tasks.tasks.manage-tasks', $data);
    }

    public function showAddForm()
    {
        $data['statuses']   = Status::where('type', 'task')->orderBy('name', 'ASC')->get();
        $data['taskTypes'] 	= TaskType::orderBy('name', 'ASC')->get();
        $data['parties'] 	= Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['tasks'] 		= Task::orderBy('id', 'DESC')->get();
            $data['admins']     = Agents::orderBy('business_name', 'ASC')->get();
        return view('user.tasks.tasks.add-task', $data);
    }
    public function showEditForm($id)
    {
        $data['detail'] = Task::with('history')->where('id',$id)->first();
        $data['statuses']   = Status::where('type', 'task')->orderBy('name', 'ASC')->get();
        $data['taskTypes']  = TaskType::orderBy('name', 'ASC')->get();
        $data['parties']    = Vendee::where('status', 1)->where('type', 'party')->orderBy('name', 'ASC')->get();
        $data['tasks']      = Task::orderBy('id', 'DESC')->get();
            $data['admins']     = Agents::orderBy('business_name', 'ASC')->get();
        return view('user.tasks.tasks.add-task', $data);
    }

    public function save(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'task_types_id' => 'required',
            'statuses_id' 	=> 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        if (!empty($req->id)) {
            $t = Task::where('id',$req->id)->first();
        }else{
            $t 				       = New Task;
        }
        $t->vendees_id 	       = $req->parties_id;
        $t->pax_name 	       = strtoupper($req->pax_name);
        $t->last_status        = $req->statuses_id;
        $t->task_types_id      = $req->task_types_id;
        $t->phone              = $req->phone;
        $t->task_type 		       = $req->type;
        $t->admins_id          = isset($req->admins_id) && !empty($req->admins_id)?$req->admins_id:auth()->guard('admin')->user()->id;
        $isSave 		       = $t->save();

        if ($isSave) {
            if (!empty($req->history_id)) {
                $ts                 = TaskHistory::where('id',$req->history_id)->first();
            }else{
                $ts                 = new TaskHistory;
            }
            
            $ts->remarks 		= nl2br($req->remarks);
            $ts->tasks_id 		= $t->id;
            $ts->statuses_id 	= $req->statuses_id;
            $ts->admins_id   	= isset($req->admins_id) && !empty($req->admins_id)?$req->admins_id:auth()->guard('admin')->user()->id;
            $isSave				= $ts->save();
        }

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-tasks');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }

    public function taskDetail($id)
    {
        $data['t'] 		    = Task::where('id', $id)->with('history')->first();
        $data['statuses']   = Status::orderBy('name', 'ASC')->where('type','task')->get();
        $data['history']    = TaskHistory::where('tasks_id', $id)->orderBy('id', 'DESC')->get();
        $data['id']         = $id;

        return view('user.tasks.tasks.task-detail', $data);
    }

    public function addAttachment($id)
    {
        $data['id']         = $id;
        $data['vendees_id'] = Task::where('id', $id)->first()->vendees_id;

        return view('user.tasks.tasks.add-attachment', $data);
    }

    public function saveAttachment(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'title' => 'required',
            'img'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        $t              = new TaskAttachment;
        $t->title       = $req->title;
        $t->is_private  = $req->is_private;
        $t->tasks_id    = $req->tasks_id;
        $t->vendees_id  = $req->vendees_id;

        if (Input::hasFile("img") && Input::file('img')->isValid()) {
            $filename   = time()."-".Input::file('img')->getClientOriginalName();
            $t->img     = $filename;
            Input::file('img')->move($this->attachment, $filename);
        }
        $isSave         = $t->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-tasks');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }

    public function taskStatus(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'statuses_id'   => 'required',
            'remarks'       => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        $ts 		 		= new TaskHistory;
        $ts->remarks 		= nl2br($req->remarks);
        $ts->tasks_id 		= $req->tasks_id;
        $ts->statuses_id    = $req->statuses_id;
        $ts->is_private 	= $req->is_private;
        $ts->admins_id   	= auth()->guard('admin')->user()->id;
        $isSave				= $ts->save();

        Task::where('id', $req->tasks_id)->update(["last_status" => $req->statuses_id]);

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->back();
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }

    }

}
