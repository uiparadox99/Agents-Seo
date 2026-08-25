<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
use App\Content;
use App\QuickLink;
use App\Country;
use App\Schengen;
use App\Hotels;
use App\Cities;
use App\HotelCategory;
use App\HotelDistance;
use App\Page;
use App\PackagePrice;
use App\UsefullLinks;
use App\VisasPolicy;
use Validator;
use Session;
use Hash;
use Input;

class ContentController extends Controller
{
    public $filePath = 'storage/uploads/policy';
    public $schengenPath = 'storage/uploads/schengen';
    public function addContent()
    {
        $data['section'] = Section::all();
        return view("admin.pages.add-content",$data);
    }

    public function manageContent()
    {
        $data['content'] = Content::join('sections','sections.id','=','content.section_id')->get();
        
        return view("admin.pages.manage-custom-content", $data);
    }

    public function saveContent(Request $req)
    {
    	$validator = Validator::make(Input::all(), [
            'page'   => 'required',
            'content'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $content     = new Content;
        }else{
            $content     = Content::where('id',$req->id)->first();
        }
        
        $content->section_id = $req->page;
        $content->content  = $req->content;
        $isSave         = $content->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('admin.manage-custom-content');
    }

    public function editContent($id)
    {
        $data['detail'] = Content::where('section_id', $id)->first();
        
        $data['section'] = Section::all();
        return view("admin.pages.add-content", $data);
    }
    public function deleteContent($id)
    {
         $delete = Content::where('section_id', $id)->delete();
        
         if ($delete) {
            Session::flash("success-msg", "Deleted Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('admin.manage-custom-content');
    }
    public function deletePrice($id)
    {
         $delete = PackagePrice::where('id', $id)->delete();
        
         if ($delete) {
            Session::flash("success-msg", "Deleted Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->back();
    }

    public function manageQuickLinks()
    {
        $data["quick_links"] = QuickLink::get();
        return view("admin.pages.manage-quick-links", $data);
    }

    public function addQuickLinks()
    {
        $data["quick_links"] = QuickLink::get();
        $data["sections"]  = Section::get();
        $data["country"]  = Country::get();
        return view("admin.pages.add-quick-links", $data);
    }

    public function saveQuickLinks(Request $r)
    {
        $sections = $r->sections_id;
        $countries = $r->country_id;
        foreach ($sections as $key => $s) {
            $isAvail = QuickLink::where("sections_id", $s)->where("countries_id", $countries[$key])->count();
            if($isAvail == 0){
                $ql = new QuickLink;
                $ql->sections_id = $s;
                $ql->countries_id = $countries[$key];
                $ql->save();
            }
        }
        return redirect()->back();
    }

    public function deleteQuickLinks($id)
    {
        $q = QuickLink::find($id);
        if(!is_null($q)){
            $q->delete();
            Session::flash("success-msg", "Record delete successfully");
        }else{
            Session::flash("error-msg", "Unable to delete record");
        }

        return redirect()->back();
    }
    public function managePage()
    {
        $data["pages"] = Page::all();
        return view("admin.pages.manage-page", $data);
    }

    public function addPage()
    {
        return view("admin.pages.add-page");
    }
    public function editPage($id)
    {
        $data['detail'] = Page::where('id',$id)->first();
        return view("admin.pages.add-page", $data);
    }

    public function savePage(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'page'   => 'required',
            'content'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $content     = new Page;
        }else{
            $content     = Page::where('id',$req->id)->first();
        }
        
        $content->page = $req->page;
        $content->content  = $req->content;
        $isSave         = $content->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('admin.manage-page');
    }
     public function manageLinks(Request $r)
    {
        if(!empty($r->active_id)){
            $up = UsefullLinks::where('id',$r->active_id)->first();
            $up->active = !empty($r->active) && $r->active == 1?1:0;
            $up->save();
            Session::flash("success-msg", "Updated Successfully.");
            return redirect()->back();
        }
        if(!empty($r->sidebar_id)){
            $up = UsefullLinks::where('id',$r->sidebar_id)->first();
            $up->show_in_sidebar = !empty($r->show_in_sidebar) && $r->show_in_sidebar == 1?1:0;
            $up->save();
            Session::flash("success-msg", "Updated Successfully.");
            return redirect()->back();
        }
         if(!empty($r->airport_id)){
            $up = UsefullLinks::where('id',$r->airport_id)->first();
            $up->airport = !empty($r->airport) && $r->airport == 1?1:0;
            $up->save();
            Session::flash("success-msg", "Updated Successfully.");
            return redirect()->back();
        }
        $data["links"] = UsefullLinks::all();
        return view("admin.pages.manage-links", $data);
    }

    public function addLinks()
    {
        return view("admin.pages.add-link");
    }
    public function editLinks($id)
    {
        $data['detail'] = UsefullLinks::where('id',$id)->first();
        return view("admin.pages.add-link", $data);
    }

    public function saveLinks(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
            'link'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $content     = new UsefullLinks;
            $content->active  = 1;
        }else{
            $content     = UsefullLinks::where('id',$req->id)->first();
        }
         if (!empty($req->img)) {
            $filename = Input::file('img')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('img')->move('storage/uploads/links', $fileNewName);

            $content->img          = $fileNewName;
        }
        $content->name = $req->name;
        $content->link  = $req->link;
        
        // $content->show_in_sidebar  =  !empty($req->show_in_sidebar) && $req->show_in_sidebar == 1?1:0;
        $isSave         = $content->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('admin.manage-links');
    }
    public function getPolicy($id)
    {

        if (!empty($id)) {
            $data['detail'] = VisasPolicy::where('id',$id)->first();
            return view("admin.pages.visa-policy", $data);
        }else{
            return view("admin.pages.visa-policy");
        }
    }
    public function savePolicy(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'heading'   => 'required',
            'date'      => 'required',
            'content'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $policy     = new VisasPolicy;
        }else{
            $policy     = VisasPolicy::where('id',$req->id)->first();
        }
        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $policy->image          = $fileNewName;
        }
        $policy->heading  = $req->heading;
        $policy->image_alt  = $req->image_alt;
        $policy->policy_date     = $req->date;
        $policy->content  = $req->content;
        $isSave            = $policy->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->to('admin/home');
    }
    public function getSchengen($id)
    {

        if (!empty($id)) {
            $data['detail'] = Schengen::where('id',$id)->first();
            $data['countries'] = Country::all();
            return view("admin.pages.schengen", $data);
        }else{
            $data['countries'] = Country::all();
            return view("admin.pages.schengen",$data);
        }
    }
    public function saveSchengen(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'heading'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $schengen     = new Schengen;
        }else{
            $schengen     = Schengen::where('id',$req->id)->first();
        }
        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('image')->move($this->schengenPath, $fileNewName);

            $schengen->image          = $fileNewName;
        }
        $country = implode(',', $req->country);
        $schengen->heading  = $req->heading;
        $schengen->image_alt  = $req->image_alt;
        $schengen->content1  = $req->content1;
        $schengen->content2  = $req->content2;
        $schengen->countries  = $country;
        $isSave            = $schengen->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->to('admin/home');
    }
    public function getUmrahPolicy2019($id)
    {

        if (!empty($id)) {
            $data['detail'] = VisasPolicy::where('id',$id)->first();
            return view("admin.pages.umrah-policy-2019", $data);
        }else{
            return view("admin.pages.umrah-policy-2019");
        }
    }
    public function saveUmrahPolicy2019(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'heading'   => 'required',
            'date'      => 'required',
            'content'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $policy     = new VisasPolicy;
        }else{
            $policy     = VisasPolicy::where('id',$req->id)->first();
        }
        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $policy->image          = $fileNewName;
        }
        $policy->heading  = $req->heading;
        $policy->image_alt  = $req->image_alt;
        $policy->policy_date     = $req->date;
        $policy->content  = $req->content;
        $policy->meta_title  = $req->meta_title;
        $policy->meta_description  = $req->meta_description;
        $isSave            = $policy->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->to('admin/home');
    }
    public function manageHotel(Request $r)
    {
        $hotels = Hotels::with(['category','distance','cityName']);
    
        if (!empty($r->name)) {
            $hotels->where('name','LIKE','%'.$r->name.'%');
        }
    
        if (!empty($r->city)) {
            $hotels->where('city', $r->city);
        }
    
        $data['hotels'] = $hotels->orderBy('id','DESC')->paginate(50)->appends($r->query());
    
        // City dropdown only for Makkah (26) & Madina (5)
        $data['cities'] = Cities::whereIn('id', [5, 26])->get();
    
        return view('admin.hotels.manage-hotels', $data);
    }
    public function addHotel()
    {
        $data['categories'] = HotelCategory::orderBy('name','ASC')->get();
        $data['distances'] = HotelDistance::orderBy('name','ASC')->get();
          $data['cities'] = Cities::whereIn('id', [5, 26])->orderBy('name')->get();
    
        return view('admin.hotels.add-hotel', $data);
    }
    public function editHotel($id)
    {
        $data['hotel'] = Hotels::where('id', $id)->firstOrFail();
        $data['categories'] = HotelCategory::orderBy('name','ASC')->get();
        $data['distances'] = HotelDistance::orderBy('name','ASC')->get();
          $data['cities'] = Cities::whereIn('id', [5, 26])->orderBy('name')->get();
    
        return view('admin.hotels.add-hotel', $data);
    }
    public function saveHotel(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'city' => 'required',
        ]);
    
        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput();
        }
    
        if (empty($req->id)) {
            $hotel = new Hotels();
        } else {
            $hotel = Hotels::find($req->id);
        }
         if (!empty($req->img)) {
            $filename = Input::file('img')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('img')->move('storage/uploads/hotels', $fileNewName);

            $hotel->img          = $fileNewName;
        }
        // Set fields
        $hotel->name = $req->name;
        $hotel->slug = str_slug($req->name);
        $hotel->distance_id = $req->distance_id;
        $hotel->address = $req->address;
        $hotel->city = $req->city;
        $hotel->phone = $req->phone;
        $hotel->status = $req->status;
        $hotel->hotel_type = $req->hotel_type;
        $hotel->hotel_category = $req->hotel_category;
        $hotel->hotel_facilities = $req->hotel_facilities;
    
        $saved = $hotel->save();
    
        if ($saved) {
            Session::flash("success-msg", !empty($req->id) ? "Hotel Updated Successfully" : "Hotel Added Successfully");
        } else {
            Session::flash("error-msg", "Something went wrong.");
        }
    
        return redirect()->route('admin.manage-hotels');
    }




}
