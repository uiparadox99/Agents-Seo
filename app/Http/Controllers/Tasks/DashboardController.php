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
use App\TasksModels\ACSectors;
use App\TasksModels\ACAirlines;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->attachment  = storage_path("uploads/attachments");
    }

    public function index()
    {
        // ini_set ( 'max_execution_time' , '0' );
    //     $abc = range('a','z');
    //     foreach($abc as $letter){

      
    //     $token = base64_encode('BS7391:#StarHolidaysBS@7391_Live');
   

    //     $url = "http://api.brightsun.co.uk/api/BSFlight/AutoComplete/".$letter;
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_URL, $url);
       
      
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
    //     $headers = array(
    //        "Content-Type: application/json",
    //        'Authorization: Basic '.$token
    //     );
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
      
        
        
    //     //for debug only!
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
    //     $resp = curl_exec($curl);
    //     curl_close($curl);
    //    $data = json_decode($resp);
     
    //    foreach($data as $sec){
    //     $city = explode(',',$sec->AIRPORT)[0];
    //     $name = explode(',',$sec->AIRPORT)[1];
    //     if(!isset(explode(']',$name)[1])){
    //         $name = explode(',',$sec->AIRPORT)[2];
    //     }
    //     $fn = explode('[',$name)[0];
    //     $ln = explode(']',$name)[1];
    //     $fname = trim($fn.','.$ln);
    //     $code = explode(']',explode('[',$name)[1])[0];
    //     $already = ACSectors::where('code',$code)->first();
    //     if(is_null($already)){
    //         $ac = new ACSectors;
    //         $ac->code = $code;
    //         $ac->name = $fname;
    //         $ac->save();
    //     }
    //    }
    // }
        // $data = file_get_contents('http://localhost/task_management/public/arilines.json');
        // $data = json_decode($data);
        // foreach($data->data as $sec){
        //     $already = ACAirlines::where('code',$sec->Code)->first();
        //     if(is_null($already)){
        //         $ac = new ACAirlines;
        //         $ac->code = $sec->Code;
        //         $ac->name = $sec->Name;
        //         $ac->save();
        //     }
        // }
        
        $data['taskTypes'] 	= TaskType::orderBy('name', 'ASC')->get();
        return view('user.tasks.home',$data);
    }
}