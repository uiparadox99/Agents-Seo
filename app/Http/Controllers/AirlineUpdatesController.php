<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AirlineUpdates;
use App\Airlines;
use App\AgentDeal;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use Input;
class AirlineUpdatesController extends Controller
{
    public function AirlineUpdates(Request $r)
    {
        $blog = AirlineUpdates::whereNotNull('id');
        if (!empty($r->q)) {
            $blog = $blog->where('title','LIKE','%'.$r->q.'%');
        }
        if (!empty($r->airline)) {
            $blog = $blog->where('airlines_id',$r->airline);
        }
        $data['updates'] = $blog->paginate(10);
        $data['airlines'] = Airlines::orderBy('name','ASC')->get();
        return view('airlineUpdates.airline-updates',$data);

    }
    public function AirlineUpdatesDetail($slug)
    {
        $data['detail'] = AirlineUpdates::where('slug',$slug)->first();
        $data['meta_title'] = $data['detail']->meta_title;
        $data['meta_description'] = $data['detail']->meta_description;
        return view('airlineUpdates.airline-updates-detail',$data);

    }
    
    public function specialOffers(Request $r)
    {
        $blog = AgentDeal::whereNotNull('airline_id')->where('active',1)->where('admin_approved',1);
        if (!empty($r->q)) {
            $blog = $blog->where('title','LIKE','%'.$r->q.'%');
        }
        if (!empty($r->airline)) {
            $blog = $blog->where('airline_id',$r->airline);
        }
        $data['updates'] = $blog->paginate(10);
        $data['airlines'] = Airlines::orderBy('name','ASC')->get();
        return view('airlineUpdates.special-offers',$data);

    }
    public function speciaofferDetail($slug)
    {
        $data['detail'] = AgentDeal::where('id',$slug)->first();
        return view('airlineUpdates.special-offer-detail',$data);

    }
}
