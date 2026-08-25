<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Input;
use App\Http\Controllers\Controller;
use App\Country;
use App\Visa;
use App\Cities;
use App\Airlines;
use App\Agents;
use App\Fares;
use App\User;
use App\Packages;
use App\Embassy;
use App\PackagePrice;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
class FlyingController extends Controller
{
    public $filePath = 'storage/uploads/airline';
    public $packagePath = 'storage/uploads/packages';
    public $packageMobilePath = 'storage/uploads/packages/mobile';
    public $embassy = 'storage/uploads/embassy';
    public function resizeImage()
    {
        return view('resizeImage');
    }
    public function getCity(Request $r)
    {
        if(!empty($r->edit_id)){
            $city = Cities::where('id',$r->edit_id)->first();
            if($r->type == 'jobs'){
                $city->jobs = !empty($r->jobs) && $r->jobs == 1?'1':'0';
            }
             if($r->type == 'sasti_ticket'){
                $city->sasti_ticket = !empty($r->sasti_ticket) && $r->sasti_ticket == 1?'1':'0';
            }
             if($r->type == 'airport'){
                $city->airport = !empty($r->airport) && $r->airport == 1?'1':'0';
            }
            if($r->type == 'embassy'){
                $city->type = !empty($r->for_embassy) && $r->for_embassy == 1?'embassy':'';
            }
            $saved = $city->save();
             if($saved){
                Session::flash("success-msg",'Status Updated');
                return redirect()->back();
            }else{
                Session::flash("error-msg",'There is an error');
                return redirect()->back();
            }
        }
        $data['cities'] = Cities::all();

        return view("admin.pages.manage-cities", $data);
    }
    public function addCity()
    {
        $data['countries'] = Country::all();
        return view("admin.pages.add-cities", $data);
    }
    public function editCity($id)
    {

        $data['countries'] = Country::all();
        $data['detail'] = Cities::where('id', $id)->first();
        return view("admin.pages.add-cities", $data);
    }
    public function saveCity(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'city' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $city = new Cities;
        } else {
            $city = Cities::where('id', $req->id)->first();
        }

        $city->name = ucfirst($req->city);
        $city->countries_id = $req->country;
        $city->airport = !empty($req->airport) ? $req->airport : 0;
        $city->via = !empty($req->via) ? $req->via : 0;
        $city->sasti_ticket = !empty($req->sasti_ticket) ? $req->sasti_ticket : 0;
        $city->hotels = !empty($req->hotels) ? $req->hotels : 0;
        $city->jobs = !empty($req->jobs) ? $req->jobs : 0;
        if (!empty($req->type)) {
            $city->type = $req->type;
        }
        $isSave = $city->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.cities');
    }
    public function getAirline()
    {
        $data['airlines'] = Airlines::all();

        return view("admin.pages.manage-airlines", $data);
    }
    public function addAirline()
    {
        $data['countries'] = Country::all();
        return view("admin.pages.add-airline", $data);
    }
    public function editAirline($id)
    {

        $data['countries'] = Country::all();
        $data['detail'] = Airlines::where('id', $id)->first();
        return view("admin.pages.add-airline", $data);
    }
    public function saveAirline(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $airline = new Airlines;
            $user = User::where('email', $req->email)->first();
            if (!is_null($user)) {
                Session::flash("error-msg", 'User already exist with email');
                return redirect()->back()->withInput(Input::all());
            }
            $u = new User;
            $u->name = $req->user_name;
            $u->email = $req->email;
            if (!empty($req->password)) {
                $u->password = Hash::make($req->password);
                $u->visible_password = $req->password;
            }
            $u->verified = 1;
            $u->active = 1;
            $u->type = 'airline';
            $saved = $u->save();
            $airline->users_id = $u->id;
        } else {
            $airline = Airlines::where('id', $req->id)->first();
            if (empty($airline->users_id)) {
                $user = User::where('email', $req->email)->first();
                if (!is_null($user)) {
                    Session::flash("error-msg", 'User already exist with email');
                    return redirect()->back()->withInput(Input::all());
                }
                $u = new User;
                $u->name = $req->user_name;
                $u->email = $req->email;
                if (!empty($req->password)) {
                    $u->password = Hash::make($req->password);
                    $u->visible_password = $req->password;
                }
                $u->verified = 1;
                $u->active = 1;
                $u->type = 'airline';
                $saved = $u->save();
                $airline->users_id = $u->id;
            } else {
                $user = User::where('id', $airline->users_id)->first();
                if ($user->email != $req->email) {
                    $userdub = User::where('email', $req->email)->first();
                    if (!is_null($userdub)) {
                        Session::flash("error-msg", 'User already exist with email');
                        return redirect()->back()->withInput(Input::all());
                    }
                }
                $user->name = $req->user_name;
                $user->email = $req->email;
                if (!empty($req->password)) {
                    $user->password = Hash::make($req->password);
                    $user->visible_password = $req->password;
                }
                $user->verified = 1;
                $user->active = 1;
                $user->type = 'airline';
                $saved = $user->save();
            }
        }

        if (!empty($req->img)) {
            $filename = Input::file('img')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('img')->move($this->filePath, $fileNewName);

            $airline->img = $fileNewName;
        }

        $airline->name = $req->name;
        if (!empty($req->slug)) {
            $url = url('/');
            $slug = str_replace($url . '/airline/', '', $req->slug);
            $airline->slug = $slug;
        } else {
            $airline->slug = str_slug($req->name);
        }
        if (!empty($req->meta_title)) {
            $airline->meta_title = ucfirst($req->meta_title);
        }
        if (!empty($req->meta_description)) {
            $airline->meta_description = $req->meta_description;
        }
        $airline->countries_id = $req->country;
        $airline->content = $req->content;
        $airline->image_alt = $req->image_alt;
        $airline->custom_content = $req->custom_content;
        $isSave = $airline->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.airline');
    }
    public function addFares($id)
    {
        $data['fares'] = Fares::where('airlines_id', $id)->get();
        $data['cities'] = Cities::all();
        $data['airline'] = Airlines::where('id', $id)->first();
        return view("admin.pages.add-fares", $data);
    }
    public function saveFares(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        Fares::where('airlines_id', $req->airline_id)->delete();
        sleep(2);
        foreach ($req->from as $key => $value) {
            $fare = new Fares;
            $fare->from = $value;
            $fare->to = $req->to[$key];
            $fare->price = $req->price[$key];
            $fare->return = $req->return[$key];
            $fare->airlines_id = $req->airline_id;
            $isSave = $fare->save();
        }

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.airline');
    }
    public function getPackages(Request $r)
    {
        $p = Packages::where('id', '!=', '');
        if (!empty($r->name)) {
            $p = $p->where('name', 'LIKE', '%' . $r->name . '%');
        }
        if (!empty($r->agent)) {
            $p = $p->where('agents_id', $r->agent);
        }
        $data['packages'] = $p->get();
        $data['agents'] = Agents::join('umrah_packages', 'umrah_packages.agents_id', 'agents.id')->select('agents.*')->orderBy('agents.business_name', 'ASC')->get();
        return view("admin.pages.manage-packages", $data);
    }
    public function addPackages()
    {
        $data['countries'] = Country::all();
        $data['airlines'] = Airlines::orderBy('name', 'ASC')->get();
        $data['to'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', '!=', 'Pakistan')->where('cities.airport', 1)->orderBy('cities.name', 'ASC')->get();
        $data['from'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', 'Pakistan')->where('cities.airport', 1)->orderBy('cities.name', 'ASC')->get();
        $data['cities'] = Cities::all();
        $data['agents'] = Agents::select('id', 'business_name')->orderBy('business_name', 'ASC')->get();
        return view("admin.pages.add-packages", $data);
    }
    public function editPackages($id)
    {

        $data['detail'] = Packages::leftjoin('agents', 'agents.id', 'umrah_packages.agents_id')->leftjoin('agent_cities', 'agent_cities.id', 'agents.cities_id')->where('umrah_packages.id', $id)->select('umrah_packages.*', 'agents.business_name as agent_name', 'agents.slug as agent_slug', 'agent_cities.name as agent_city')->first();
        $airlineid = $data['detail']->id;
        $data['airlines'] = Airlines::orderBy('name', 'ASC')->get();
        $data['cities'] = Cities::all();
        $data['to'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', '!=', 'Pakistan')->where('cities.airport', 1)->orderBy('cities.name', 'ASC')->get();
        $data['from'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', 'Pakistan')->where('cities.airport', 1)->orderBy('cities.name', 'ASC')->get();
        $data['prices'] = PackagePrice::where('umrah_packages_id', $airlineid)->get();
        $data['agents'] = Agents::select('id', 'business_name')->orderBy('business_name', 'ASC')->get();
        return view("admin.pages.add-packages", $data);
    }
    public function deletePackage($id)
    {


        $delete = PackagePrice::where('umrah_packages_id', $id)->delete();
        $delete = Packages::where('id', $id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('admin.packages');
    }
    public function savePackages(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $airline = new Packages;
        } else {
            $airline = Packages::where('id', $req->id)->first();
        }

        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('image')->move($this->packagePath, $fileNewName);

            /*$image =  $req->file('image');
            dd($this->packagePath.'/'.$fileNewName);*/
            $image_resize = Image::make($this->packagePath . '/' . $fileNewName);
            $image_resize->resize(345, 166);
            $image_resize->save($this->packageMobilePath . '/' . $fileNewName);

            $airline->image = $fileNewName;
        }
        $agents = null;
        if (!empty($req->agent)) {
            $agents = Agents::where('slug', $req->agent)->first();
            if (is_null($agents)) {
                Session::flash("error-msg", 'Unknown Agent');
                return redirect()->back()->withInput(Input::all());
            }
        }


        $airline->name = $req->name;

        if (!empty($req->slug)) {
            $url = url('/');
            $slug = str_replace($url, '', $req->slug);
            $slug = str_replace('/', '', $req->slug);
            $airline->slug = $slug;
        } else {
            if (!is_null($agents)) {
                $airline->slug = $agents->slug . '-umrah-packages-from-' . str_slug($agents->city->name);
            } else {
                $airline->slug = str_slug($req->name);
            }

        }

        if (!empty($req->meta_title)) {
            $airline->meta_title = ucfirst($req->meta_title);
        }
        if (!empty($req->meta_description)) {
            $airline->meta_description = $req->meta_description;
        }
        if (!empty($req->agent)) {
            $airline->content1 = nl2br($req->content1);
        } else {
            $airline->content1 = $req->content1;
        }
        $airline->image_alt = $req->image_alt;
        $airline->content2 = $req->content2;
        $airline->content3 = $req->content3;
        $airline->content4 = $req->content4;
        $airline->custom_content = $req->custom_content;
        $airline->active = 1;
        if (!is_null($agents)) {
            $airline->agents_id = $agents->id;
        }

        $isSave = $airline->save();
        if ($isSave) {


            $delete = PackagePrice::where('umrah_packages_id', $airline->id)->delete();
            sleep(1);
            foreach ($req->price as $key => $value) {

                $price = new PackagePrice;
                $price->price = $value;
                $price->section = $req->section[$key];
                if ($req->only_visa == 1) {
                    $price->stars = null;
                    $price->nights = null;
                } else {
                    $price->stars = $req->stars[$key];
                    $price->nights = $req->nights[$key];
                }
                if ($req->only_package == 1) {

                    $price->airlines_id = null;
                    $price->from = null;
                    $price->to = null;
                } else {

                    $price->airlines_id = $req->airline[$key];
                    $price->from = $req->from[$key];
                    $price->to = $req->to[$key];
                }

                $price->umrah_packages_id = $airline->id;

                $price->save();

            }

            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.packages');
    }
    public function getEmbassy()
    {
        $data['embassy'] = Embassy::all();

        return view("admin.pages.manage-embassy", $data);
    }
    public function addEmbassy()
    {
        $data['cities'] = Cities::where('type', 'embassy')->orderby('name','ASC')->get();
        $data['countries'] = Country::all();
        return view("admin.pages.add-embassy", $data);
    }
    public function editEmbassy($id)
    {
        $data['cities'] = Cities::where('type', 'embassy')->orderby('name','ASC')->get();
        $data['countries'] = Country::all();
        $data['detail'] = Embassy::where('id', $id)->first();
        return view("admin.pages.add-embassy", $data);
    }
    public function saveEmbassy(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'title' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $embassy = new Embassy;
        } else {
            $embassy = Embassy::where('id', $req->id)->first();
        }


        $embassy->title = $req->title;
        $embassy->address = $req->address;
        $embassy->phone = $req->phone;
        $embassy->fax = $req->fax;
        $embassy->email = $req->email;
        $embassy->countries_id = $req->country;
        $embassy->cities_id = $req->cities_id;
        $embassy->website = $req->website;

        if (!empty($req->slug)) {
            $url = url('/');
            $slug = str_replace($url, '', $req->slug);
            $slug = str_replace('/', '', $slug);

            $embassy->slug = $slug;
        } else {
            $embassy->slug = str_slug($req->title);
        }
        if (!empty($req->meta_title)) {
            $embassy->meta_title = ucfirst($req->meta_title);
        }
        if (!empty($req->meta_description)) {
            $embassy->meta_description = $req->meta_description;
        }
        $isSave = $embassy->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.embassy');
    }
    public function loadAgents()
    {
        $agents = Agents::leftjoin('agent_cities', 'agent_cities.id', 'agents.cities_id')->select('agents.id', 'agents.business_name', 'agent_cities.name as city')->orderBy('business_name', 'ASC')->get();
        $view = view('admin.partials.load-agents', compact('agents'))->render();
        return response()->json(['html' => $view]);
    }
}
