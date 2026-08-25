<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Input;
use App\Http\Controllers\Controller;
use App\Country;
use App\Visa;
use App\Cities;
use App\Airlines;
use App\Fares;
use App\Section;
use App\Hotels;
use App\Packages;
use App\Agents;
use App\Embassy;
use App\PackagePrice;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
class PackagesController extends Controller
{
    public $packagePath = 'storage/uploads/packages';
    public $packageMobilePath = 'storage/uploads/packages/mobile';
      public function resizeImage()
    {
        return view('resizeImage');
    }
  
    public function getPackages(Request $r)
    {
        $agent  = Agents::where('users_id',auth()->user()->id)->first();
        if (is_null($agent)) {
            Session::flash("error-msg", "Please Add Business First");
            return redirect()->back();
        }
        $p = Packages::leftjoin('airlines','airlines.id','airlines_id')->where('umrah_packages.agents_id',$agent->id);

        if (!empty($r->name)) {
            $p = $p->where('umrah_packages.name','LIKE','%'.$r->name.'%');
        }
        if (!empty($r->from)) {
            $p = $p->where('umrah_packages.from','LIKE','%'.$r->from.'%');
        }


        if (!empty($r->airline)) {
    
            $p = $p->where('airlines_id',$r->airline);
        }
       $data['packages'] = $p->select('umrah_packages.*','umrah_packages.id as umrahId','airlines.name as airline')->groupBy('umrah_packages.id')->paginate(15);



         $data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
        $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
          $data['airlines']   = Airlines::orderBy('name','ASC')->get();
          if($r->ajax()){
            $packages = $data['packages'];
            $view = view('partials.agent-panel-packages',compact('packages'))->render();
            return response()->json(['html'=>$view]);
        }else{
        return view("user.packages.manage-packages", $data);
    }
    }
    public function addPackages()
    {
        $data['countries']  = Country::orderBy('country','ASC')->get();
        $data['airlines']   = Airlines::orderBy('name','ASC')->get();
         $data['makkah_hotels']   = Hotels::where('city',26)->orderBy('name','ASC')->get();
         $data['madinah_hotels']   = Hotels::where('city',5)->orderBy('name','ASC')->get();
         
        $data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        	$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries_id','190')->where('cities.sasti_ticket',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        		$data['via']   =  Cities::where('cities.sasti_ticket',1)->where('cities.via',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        return view("user.packages.add-packages", $data);
    }
    public function editPackages($id){

        $data['detail'] = Packages::where('id',$id)->first();

        $airlineid = $data['detail']->id;
        $data['airlines'] = Airlines::orderBy('name','ASC')->get();
          $data['makkah_hotels']   = Hotels::where('city',26)->orderBy('name','ASC')->get();
         $data['madinah_hotels']   = Hotels::where('city',5)->orderBy('name','ASC')->get();
         $data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        	$data['cities']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries_id','190')->where('cities.sasti_ticket',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        $data['prices'] = PackagePrice::where('umrah_packages_id',$airlineid)->get();
        	$data['via']   =  Cities::where('cities.sasti_ticket',1)->where('cities.via',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        return view("user.packages.add-packages", $data);
    }
    public function deletePackage($id){


        $delete = PackagePrice::where('umrah_packages_id',$id)->delete();
        $delete = Packages::where('id',$id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('user.packages');
    }
    public function savePackages(Request $req){

        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
            'image'   => 'mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }
        
        $agent  = Agents::where('users_id',auth()->user()->id)->first();
        
        if (!empty($req->active)) {

            $inactivell = Packages::where('agents_id',$agent->id)->where('active',1)->first();
            if (!is_null($inactivell)) {

                $inactivell->active = 0;
                $inactivell = $inactivell->save();

            }
        }

        if (is_null($req->id)) {
            $airline     = new Packages;
        }else{
            $airline     = Packages::where('id',$req->id)->first();
        }

        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('image')->move($this->packagePath, $fileNewName);

            /*$image =  $req->file('image');
            dd($this->packagePath.'/'.$fileNewName);*/
            $image_resize = Image::make($this->packagePath.'/'.$fileNewName);              
            $image_resize->resize(345, 166);
            $image_resize->save($this->packageMobilePath.'/'.$fileNewName);

            $airline->image          = $fileNewName;
        }


           $airline->name     = $req->name;
            $airline->sector   = $req->sector;
            $airline->nights   = $req->nights;
            $airline->from     = $req->from;
            $airline->airlines_id = $req->airlines_id;
            
            $airline->to                = $req->from;
            $airline->to                  = $req->to;
            $airline->extra_via                 = $req->extra_via;
            $airline->extra_flight_code1        = $req->extra_flight_code1;
            $airline->extra_trancend_date       = $req->extra_trancend_date;
            $airline->extra_one_way_departure_time1 = $req->extra_one_way_departure_h1;
            $airline->extra_one_way_arrival_time1   = $req->extra_one_way_arrival_h1;
            
            /* --- NEW RETURN VIA FIELDS --- */
            $airline->extra_r_via               = $req->extra_r_via;
            $airline->extra_r_flight_code1      = $req->extra_r_flight_code1;
            $airline->extra_r_trancend_date     = $req->extra_r_trancend_date;
            $airline->extra_return_departure_time1 = $req->extra_return_departure_h1;
            $airline->extra_return_arrival_time1   = $req->extra_return_arrival_h1;
        
            /* --- OUTBOUND FLIGHT DETAILS --- */
            $airline->flight              = $req->flight;
            $airline->departure_date      = $req->departure_date;
            $airline->departure_time      = $req->departure_time;
            $airline->arrival_time        = $req->arrival_time;
        
            /* --- RETURN FLIGHT DETAILS --- */
            $airline->return_sector           = $req->return_sector;
            $airline->return_airlines_id      = $req->return_airlines_id;
            $airline->return_flight           = $req->return_flight;
            $airline->return_departure_date   = $req->return_departure_date;
            $airline->return_departure_time   = $req->return_departure_time;
            $airline->return_arrival_time     = $req->return_arrival_time;
        
            /* PRICE DETAILS */
            $airline->shairing          = $req->single_room;
            $airline->double_room       = $req->double_room;
            $airline->triple_room       = $req->triple_room;
            $airline->quad_room         = $req->quad_room;
            $airline->child_with_bed    = $req->child_with_bed;
            $airline->child_without_bed = $req->child_without_bed;
            $airline->infant            = $req->infant;
        
            /* HOTELS */
            $airline->hotel_makkah  = $req->hotel_makkah;
            $airline->hotel_madinah = $req->hotel_madinah;
            $airline->stars         = $req->stars;
        
            /* PACKAGE INCLUDES */
            $airline->carry_on       = $req->carry_on;
            $airline->luggage        = $req->luggage;
            $airline->transport      = $req->transport;
            $airline->umrah_visa     = $req->umrah_visa ? 1 : 0;
            $airline->shutle_service = $req->shutle_service ? 1 : 0;
      
        if (!empty($req->meta_title)) {
            $airline->meta_title             = ucfirst($req->meta_title);
        }
        if (!empty($req->meta_description)) {
            $airline->meta_description       = $req->meta_description;
        }
        $airline->image_alt          = $req->image_alt;

       if (!empty($req->slug)) {
            $url = url('/');
            $slug = str_replace($url,'', $req->slug);
            $slug = str_replace('/','', $req->slug);
            $airline->slug               = $slug;
        }else{
            $airline->slug               = $agent->slug.'-umrah-packages-from-'.str_slug($agent->city->name);
        }


        $airline->content1          = $req->content1;
        $airline->content2          = $req->content2;
        $airline->content3          = $req->content3;
        $airline->content4          = $req->content4;
        $airline->custom_content    = $req->custom_content;

        $airline->agents_id          = $agent->id;
        $airline->active            = $req->active;
        $isSave                     = $airline->save();
       
        if ($isSave) {

            if (!empty($req->id)) {
                # code...
            Session::flash("success-msg", "Package Updated Successfully.");
            }else{

            Session::flash("success-msg", "Package Added Successfully.");
            }
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('user.packages');
    }
    public function PackageActive(Request $req)
    {

        $visa           = Packages::where('id', $req->id)->first();
      
        $visa->active  = $req->is_home;
        $isSave         = $visa->save();
        if ($isSave) {
            return response()->json(["notify"=>true, "msg"=>"Success"]);
        }else{
            return response()->json(["notify"=>false, "msg"=>"Fail"]);
        }
    }
   
}
