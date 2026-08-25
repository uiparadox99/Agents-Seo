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
use App\HajjPackages as Packages;
use App\Agents;
use App\Embassy;
use App\PackagePrice;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
class HajjPackagesController extends Controller
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
        $p = Packages::join('packages_price','packages_price.umrah_packages_id','hajj_packages.id')->leftjoin('airlines','airlines.id','packages_price.airlines_id')->where('hajj_packages.agents_id',$agent->id);

        if (!empty($r->name)) {
            $p = $p->where('hajj_packages.name','LIKE','%'.$r->name.'%');
        }
        if (!empty($r->from)) {
            $p = $p->where('packages_price.from','LIKE','%'.$r->from.'%');
        }

        if (!empty($r->to)) {
            $p = $p->where('packages_price.to','LIKE','%'.$r->to.'%');
        }

        if (!empty($r->airline)) {
    
            $p = $p->where('packages_price.airlines_id',$r->airline);
        }
       $data['packages'] = $p->select('hajj_packages.*','hajj_packages.id  as umrahId','airlines.name as airline','packages_price.id as price_id','packages_price.from as price_from',
    'packages_price.to as price_to','packages_price.price')->groupBy('hajj_packages.id')->paginate(15);



         $data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
        $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
          $data['airlines']   = Airlines::orderBy('name','ASC')->get();
          if($r->ajax()){
            $packages = $data['packages'];
            $view = view('partials.agent-panel-packages',compact('packages'))->render();
            return response()->json(['html'=>$view]);
        }else{
            
        return view("user.hajjPackages.manage-packages", $data);
    }
    }
    public function addPackages()
    {
        $data['countries']  = Country::orderBy('country','ASC')->get();
        $data['airlines']   = Airlines::orderBy('name','ASC')->get();
        $data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        return view("user.hajjPackages.add-packages", $data);
    }
    public function editPackages($id){

        $data['detail'] = Packages::where('id',$id)->first();

        $airlineid = $data['detail']->id;
        $data['airlines'] = Airlines::orderBy('name','ASC')->get();
         $data['to']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','!=','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        $data['from']   =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->select('cities.*')->orderBy('cities.name','ASC')->get();
        $data['prices'] = PackagePrice::where('umrah_packages_id',$airlineid)->get();
        return view("user.hajjPackages.add-packages", $data);
    }
    public function deletePackage($id){


        $delete = PackagePrice::where('umrah_packages_id',$id)->delete();
        $delete = Packages::where('id',$id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('user.hajj-packages');
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


        $airline->name           = $req->name;
      
        if (!empty($req->meta_title)) {
            $airline->meta_title             = ucfirst($req->meta_title);
        }
        if (!empty($req->meta_description)) {
            $airline->meta_description       = $req->meta_description;
        }
        

       if (!empty($req->slug)) {
            $url = url('/');
            $slug = str_replace($url,'', $req->slug);
            $slug = str_replace('/','', $req->slug);
            $airline->slug               = $slug;
        }else{
            $airline->slug               = $agent->slug.'-umrah-packages-from-'.str_slug($agent->city->name);
        }
        $airline->content1          = $req->content1;
        $airline->image_alt          = $req->image_alt;
        $airline->content2          = $req->content2;
        $airline->content3          = $req->content3;
        $airline->agents_id          = $agent->id;
        $airline->content4          = $req->content4;
        $airline->custom_content    = $req->custom_content;
        $airline->active            = $req->active;
        $isSave                     = $airline->save();




       
        if ($isSave) {


            $delete     = PackagePrice::where('umrah_packages_id',$airline->id)->delete();
            sleep(1);
            foreach ($req->price as $key => $value) {
              
                    $price              = new PackagePrice;
                    $price->price       = $value;
                    $price->section     = $req->section[$key];
                    if ($req->only_visa == 1) {
                       $price->stars       = null;
                       $price->nights      = null;
                    }else{
                          $price->stars       = $req->stars[$key];
                          $price->nights      = $req->nights[$key];
                      }
                      if ($req->only_package == 1) {

                        $price->airlines_id = null;
                        $price->from        = null;
                        $price->to          = null;
                    }else{

                       $price->airlines_id = $req->airline[$key];
                       $price->from        = $req->from[$key];
                       $price->to          = $req->to[$key];
                   }

                    $price->umrah_packages_id = $airline->id;

                    $price->save();
                
            }
            if (!empty($req->id)) {
                # code...
            Session::flash("success-msg", "Package Updated Successfully.");
            }else{

            Session::flash("success-msg", "Package Added Successfully.");
            }
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('user.hajj-packages');
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
