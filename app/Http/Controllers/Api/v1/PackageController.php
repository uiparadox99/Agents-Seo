<?php

namespace App\Http\Controllers\Api\v1;

use App\Traits\RestApi;
use App\Utilities\ErrorStatusResponse;
use App\Utilities\GroceryValidator;
use App\Utilities\MobiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\Packages;
use App\Http\Resources\Package as PackageResource;
use App\Http\Resources\PackageCollection;
use Illuminate\Support\Facades\Input;
use Validator;

class PackageController extends Controller
{
  
    public function index(Request $r,$code)
    {
    	$agent = Agents::where('code',$code)->first();
         return new PackageResource(Packages::where('agents_id',$agent->id)->where('active',1)->first());
                    
    }
  

}