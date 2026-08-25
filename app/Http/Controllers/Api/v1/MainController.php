<?php

namespace App\Http\Controllers\Api\v1;

use App\Traits\RestApi;
use App\Utilities\ErrorStatusResponse;
use App\Utilities\GroceryValidator;
use App\Utilities\MobiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\Http\Resources\Main as MainResource;
use App\Http\Resources\MainCollection;
use Illuminate\Support\Facades\Input;
use Validator;

class MainController extends Controller
{
  
    public function index(Request $r,$code)
    {
  
         return new MainResource(Agents::with('city')->with('agentType')->with('user')->with('agentDeals')->with('packages')->with('agentGallery')->with('agentJobs')->with('agentReviews')->with('agentTimings')->with('flights')->with('tickets')->with('hotels')->where('code',$code)->first());
                    
    }
    public function detail(Request $r,$code)
    {
  
         return new MainResource(Agents::with('city')->with('agentType')->with('user')->with('agentDeals')->with('packages')->with('agentGallery')->with('agentJobs')->with('agentReviews')->with('agentTimings')->with('flights')->with('tickets')->with('hotels')->where('code',$code)->first());
                    
    }

}