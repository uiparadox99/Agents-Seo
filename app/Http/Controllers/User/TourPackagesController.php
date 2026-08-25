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
use App\TourPackages as Packages;
use App\Agents;
use App\Embassy;
use App\TourPackagesPrices;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
class TourPackagesController extends Controller
{
    public $packagePath = 'storage/uploads/packages';
    public $packageMobilePath = 'storage/uploads/packages/mobile';
    public function resizeImage()
    {
        return view('resizeImage');
    }

    public function getPackages(Request $r)
    {
        $agent = Agents::where('users_id', auth()->user()->id)->first();
        if (is_null($agent)) {
            Session::flash("error-msg", "Please Add Business First");
            return redirect()->back();
        }
        $p = Packages::where('agents_id', $agent->id);

        if (!empty($r->name)) {
            $p = $p->where('title', 'LIKE', '%' . $r->name . '%');
        }
        if (!empty($r->from)) {
            $p = $p->where('departure_city', 'LIKE', '%' . $r->from . '%');
        }

        if (!empty($r->to)) {
            $p = $p->where('packages_price.to', 'LIKE', '%' . $r->to . '%');
        }

        if (!empty($r->airline)) {

            $p = $p->where('packages_price.airlines_id', $r->airline);
        }
        $data['packages'] = $p->paginate(15);



        $data['to'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', '!=', 'Pakistan')->where('cities.airport', 1)->orderBy('cities.name', 'ASC')->get();
        $data['from'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', 'Pakistan')->where('cities.airport', 1)->orderBy('cities.name', 'ASC')->get();
        $data['airlines'] = Airlines::orderBy('name', 'ASC')->get();
        if ($r->ajax()) {
            $packages = $data['packages'];
            $view = view('partials.agent-panel-tour-packages', compact('packages'))->render();
            return response()->json(['html' => $view]);
        } else {
            return view("user.tourPackages.manage-packages", $data);
        }
    }
    public function addPackages()
    {
        $data['countries'] = Country::orderBy('country', 'ASC')->get();
        $data['airlines'] = Airlines::orderBy('name', 'ASC')->get();
        $data['to'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', '!=', 'Pakistan')->where('cities.airport', 1)->select('cities.*')->orderBy('cities.name', 'ASC')->get();
        $data['from'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', 'Pakistan')->where('cities.airport', 1)->select('cities.*')->orderBy('cities.name', 'ASC')->get();
        return view("user.tourPackages.add-packages", $data);
    }
    public function editPackages($id)
    {

        $data['detail'] = Packages::where('id', $id)->first();
        $data['countries'] = Country::orderBy('country', 'ASC')->get();
        $data['airlines'] = Airlines::orderBy('name', 'ASC')->get();
        $data['to'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', '!=', 'Pakistan')->where('cities.airport', 1)->select('cities.*')->orderBy('cities.name', 'ASC')->get();
        $data['from'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', 'Pakistan')->where('cities.airport', 1)->select('cities.*')->orderBy('cities.name', 'ASC')->get();
        return view("user.tourPackages.add-packages", $data);
    }
    public function deletePackage($id)
    {


        $delete = Packages::where('id', $id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('user.tour-packages');
    }
    public function savePackages(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        $agent = Agents::where('users_id', auth()->user()->id)->first();

        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('image')->move($this->packagePath, $fileNewName);

            /*$image =  $req->file('image');
            dd($this->packagePath.'/'.$fileNewName);*/
            $image_resize = Image::make($this->packagePath . '/' . $fileNewName);
            $image_resize->resize(345, 166);
            $image_resize->save($this->packageMobilePath . '/' . $fileNewName);

        }

        if (is_null($req->id)) {
            if (!empty($req->fix_dates) && $req->fix_dates == 1) {


                foreach ($req->departure_date as $key => $dpd) {
                    $package = new Packages;


                    if (!empty($req->image)) {
                        $package->image = $fileNewName;
                    }
                    $package->title = $req->title;
                    $package->slug = slugify($req->title);
                    $package->nights = $req->nights;
                    $package->days = $req->days;
                    $package->departure_date = $dpd;
                    $package->return_date = $req->return_date[$key];
                    $package->seats = $req->seats[$key];
                    $package->price = $req->price;
                    $package->country = $req->country;

                   
                    $package->return_airline = $req->return_airline;
                    $package->visit_visa_remarks = $req->visit_visa_remarks;
                    $package->return_ticket = !empty($req->return_ticket) ? $req->return_ticket : '0';
                    $package->visit_visa = !empty($req->visit_visa) ? $req->visit_visa : '0';
                    $package->airport_pickdrop = !empty($req->airport_pickdrop) ? $req->airport_pickdrop : '0';
                    if(!empty($req->hotel_stars)){

                        $package->hotel_stars = implode(',', $req->hotel_stars);
                    }
                    $package->tour_itinery = $req->tour_itinery;
                    $package->agents_id = $agent->id;
                    $package->active = $req->active;
                    $isSave = $package->save();
                    if($isSave){
                        foreach ($req->departure_city as $dkey => $dc) {
                            $pp = new TourPackagesPrices;
                            $pp->city = $dc;
                            $pp->single_room = $req->single_room[$dkey];
                            $pp->double_room = $req->double_room[$dkey];
                            $pp->triple_room = $req->triple_room[$dkey];
                            $pp->quad_room = $req->quad_room[$dkey];
                            $pp->child_with_bed = $req->child_with_bed[$dkey];
                            $pp->child_without_bed = $req->child_without_bed[$dkey];
                            $pp->child_without_bed = $req->child_without_bed[$dkey];
                            $pp->infant = $req->infant[$dkey];
                            $pp->tour_packages_id = $package->id;
                            $priceSaved  = $pp->save();
                        }
                    }

                }
            } else {
                $package = new Packages;


                if (!empty($req->image)) {
                    $package->image = $fileNewName;
                }
                $package->title = $req->title;
                $package->slug = slugify($req->title);
                $package->nights = $req->nights;
                $package->days = $req->days;
                $package->price = $req->price;
                $package->country = $req->country;
                // $package->departure_city = $req->departure_city;
                // $package->single_room = $req->single_room;
                // $package->double_room = $req->double_room;
                // $package->triple_room = $req->triple_room;
                // $package->quad_room = $req->quad_room;
                // $package->child_with_bed = $req->child_with_bed;
                // $package->child_without_bed = $req->child_without_bed;
                // $package->child_without_bed = $req->child_without_bed;
                // $package->infant = $req->infant;
                $package->return_airline = $req->return_airline;
                $package->visit_visa_remarks = $req->visit_visa_remarks;
                $package->return_ticket = !empty($req->return_ticket) ? $req->return_ticket : '0';
                $package->visit_visa = !empty($req->visit_visa) ? $req->visit_visa : '0';
                $package->airport_pickdrop = !empty($req->airport_pickdrop) ? $req->airport_pickdrop : '0';
                if(!empty($req->hotel_stars)){

                    $package->hotel_stars = implode(',', $req->hotel_stars);
                }
                $package->tour_itinery = $req->tour_itinery;
                $package->agents_id = $agent->id;
                $package->active = $req->active;
                $isSave = $package->save();
                if($isSave){
                    foreach ($req->departure_city as $dkey => $dc) {
                        $pp = new TourPackagesPrices;
                        $pp->city = $dc;
                        $pp->single_room = $req->single_room[$dkey];
                        $pp->double_room = $req->double_room[$dkey];
                        $pp->triple_room = $req->triple_room[$dkey];
                        $pp->quad_room = $req->quad_room[$dkey];
                        $pp->child_with_bed = $req->child_with_bed[$dkey];
                        $pp->child_without_bed = $req->child_without_bed[$dkey];
                        $pp->child_without_bed = $req->child_without_bed[$dkey];
                        $pp->infant = $req->infant[$dkey];
                        $pp->tour_packages_id = $package->id;
                        $priceSaved  = $pp->save();
                    }
                }
            }


        } else {
            $package = Packages::where('id', $req->id)->first();
            if (!empty($req->image)) {

                $package->image = $fileNewName;
            }


            $package->title = $req->title;
            $package->slug = slugify($req->title);
            $package->nights = $req->nights;
            $package->days = $req->days;
            $package->price = $req->price;
            $package->country = $req->country;
            $package->seats = !empty($req->seats) && !is_array($req->seats)?$req->seats:'Not Fixed';
            $package->departure_date = $req->departure_date;
            $package->return_date = $req->return_date;
            // $package->departure_city = $req->departure_city;
            // $package->single_room = $req->single_room;
            // $package->double_room = $req->double_room;
            // $package->triple_room = $req->triple_room;
            // $package->quad_room = $req->quad_room;
            // $package->child_with_bed = $req->child_with_bed;
            // $package->child_without_bed = $req->child_without_bed;
            // $package->child_without_bed = $req->child_without_bed;
            // $package->infant = $req->infant;
            $package->return_airline = $req->return_airline;
            $package->visit_visa_remarks = $req->visit_visa_remarks;
            $package->return_ticket = !empty($req->return_ticket) ? $req->return_ticket : '0';
            $package->visit_visa = !empty($req->visit_visa) ? $req->visit_visa : '0';
            $package->airport_pickdrop = !empty($req->airport_pickdrop) ? $req->airport_pickdrop : '0';
            if(!empty($req->hotel_stars)){

                $package->hotel_stars = implode(',', $req->hotel_stars);
            }
            $package->tour_itinery = $req->tour_itinery;
            $package->agents_id = $agent->id;
            $package->active = $req->active;
            $isSave = $package->save();
            if($isSave){
                if($req->new_pricing == 'yes'){
                    foreach ($req->departure_city as $dkey => $dc) {
                        $pp = new TourPackagesPrices;
                        $pp->city = $dc;
                        $pp->single_room = $req->single_room[$dkey];
                        $pp->double_room = $req->double_room[$dkey];
                        $pp->triple_room = $req->triple_room[$dkey];
                        $pp->quad_room = $req->quad_room[$dkey];
                        $pp->child_with_bed = $req->child_with_bed[$dkey];
                        $pp->child_without_bed = $req->child_without_bed[$dkey];
                        $pp->child_without_bed = $req->child_without_bed[$dkey];
                        $pp->infant = $req->infant[$dkey];
                        $pp->tour_packages_id = $package->id;
                        $priceSaved  = $pp->save();
                    }
                }else{
                    foreach ($req->pricing_id as $dkey => $dc) {
                        $pp = TourPackagesPrices::where('id',$dc)->first();
                        $pp->city = $req->departure_city[$dkey];
                        $pp->single_room = $req->single_room[$dkey];
                        $pp->double_room = $req->double_room[$dkey];
                        $pp->triple_room = $req->triple_room[$dkey];
                        $pp->quad_room = $req->quad_room[$dkey];
                        $pp->child_with_bed = $req->child_with_bed[$dkey];
                        $pp->child_without_bed = $req->child_without_bed[$dkey];
                        $pp->child_without_bed = $req->child_without_bed[$dkey];
                        $pp->infant = $req->infant[$dkey];
                        $pp->tour_packages_id = $package->id;
                        $priceSaved  = $pp->save();
                    }
                }
            }
        }



        if ($isSave) {

            if (!empty($req->id)) {
                # code...
                Session::flash("success-msg", "Package Updated Successfully.");
            } else {

                Session::flash("success-msg", "Package Added Successfully.");
            }
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('user.tour-packages');
    }
    public function PackageActive(Request $req)
    {

        $visa = Packages::where('id', $req->id)->first();

        $visa->active = $req->is_home;
        $isSave = $visa->save();
        if ($isSave) {
            return response()->json(["notify" => true, "msg" => "Success"]);
        } else {
            return response()->json(["notify" => false, "msg" => "Fail"]);
        }
    }

}
