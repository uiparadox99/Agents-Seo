<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\Visa;
use App\Section;
use Validator;
use Session;
use Hash;
use Auth;
use App\EmployeeHasCountries;
use Input;

class VisaController extends Controller
{
	protected $type = null;
	public function __construct() {

		$this->middleware(function ($request, $next)
		{
			$this->type = Auth::guard('admin')->user()->type;
			return $next($request);
		}); 
	}

	public function manageVisas()
	{
		$data['countries'] 	= Visa::distinct()->join('countries','countries.id','visas.countries_id')->select('visas.countries_id','visas.country_name','countries.is_home as country_home','countries.id as country_id')->groupBy('visas.countries_id','visas.country_name')->get();

		$assdata = EmployeeHasCountries::select('countries_id as country')->where('admins_id',Auth::guard('admin')->user()->id)->get();
		$assigned =array();
		foreach ($assdata  as $key => $value) {
			$assigned[] =  $value->country;
		}
		$data['assigned'] = $assigned;

		return view("admin.pages.manage-visas", $data);
	}

	public function addVisa()
	{
		$countries 		= Visa::distinct()->select('countries_id')->groupBy('countries_id')->get()->toArray();
		$data['country'] = Country::whereNotIn('id', $countries)->orderBy('country', 'ASC')->get();

		$data['section'] = Section::all();

		return view("admin.pages.add-visa", $data);
	}

	public function saveVisa(Request $req)
	{
		$validator = Validator::make(Input::all(), [
			'country' 	=> 'required',
			'title'		=> 'required',
		]);

		if ($validator->fails()) {
			Session::flash("error-msg", $validator->messages()->first());
			return redirect()->back()->withInput(Input::all());
		}	

		foreach ($req->id as $key => $id) {
			$visa 					= New Visa;
			$visa->countries_id 	= $req->country;
			$visa->country_name 	= slugify($req->country_name);
			$visa->sites_id 		= 0;
			$visa->sections_id 		= $id;
			$visa->title 			= secureData($req->title[$id]);
			$visa->slug 			= slugify($req->title[$id]);
			$visa->keywords 		= secureData($req->keywords[$id]);
			$visa->is_right  		= $req->position[$id];
			$visa->meta_title 		= secureData($req->meta_title[$id]);
			$visa->meta_desc 		= secureData($req->meta_desc[$id]);
			$visa->tags 			= secureData($req->tags[$id]);
			$visa->content 			= secureData($req->content[$id]);
			$isSave 				= $visa->save();
		}
		if ($isSave) {
			Session::flash("success-msg", "Completed Successfully.");
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
		}
		return redirect()->route('admin.manage-visas');
	}

	public function editVisa($id)
	{ 
		$visas 				= Visa::where('countries_id', $id)->withTrashed()->get();
		$data['sections'] 	= Section::all();
		$data['country'] 	= Country::where('id',$id)->first();
		$visa				= array();

		foreach ($visas as $v) {
			$visa[$v->sections_id] = $v;
		}

		$data['visa'] = $visa;

		return view("admin.pages.edit-visa", $data);
	}
	public function deleteVisa($id)
	{ 
		$country    = Country::where('id',$id)->delete();
		$visas 	    = Visa::where('countries_id', $id)->delete();

		if ($visas) {
			Session::flash("success-msg", "Deleted Successfully.");
		}else{
			Session::flash("error-msg", "Something went wrong. Try again.");
		}
		return redirect()->back();
	}

	public function updateVisa(Request $req)
	{

		foreach ($req->id as $key => $id) {

			if ($this->type == 'content-writer') {
				$visa 				= Visa::withTrashed()->where('id', $id)->first();
				$visa->content 		= secureData($req->content[$id]);
				$isSave 			= $visa->save();
			}

			if ($this->type == 'seo-team') {
				$visa 				= Visa::withTrashed()->where('id', $id)->first();
				$visa->keywords 	= secureData($req->keywords[$id]);
				$visa->is_right  	= $req->position[$id];
				$visa->meta_title 	= secureData($req->meta_title[$id]);
				$visa->meta_desc 	= secureData($req->meta_desc[$id]);
				$visa->tags 		= secureData($req->tags[$id]);
				$visa->content 		= secureData($req->content[$id]);
				$isSave 			= $visa->save();
			}

			if ($this->type == 'admin') {
				$visa 				= Visa::withTrashed()->where('id', $id)->first();
				$visa->title 		= secureData($req->title[$id]);
				$visa->slug 		= slugify($req->title[$id]);
				$visa->keywords 	= secureData($req->keywords[$id]);
				$visa->is_right  	= $req->position[$id];
				$visa->meta_title 	= secureData($req->meta_title[$id]);
				$visa->meta_desc 	= secureData($req->meta_desc[$id]);
				$visa->tags 		= secureData($req->tags[$id]);
				$visa->content 		= secureData($req->content[$id]);
				$isSave 			= $visa->save();
			}
		}

		if ($this->type == 'admin') {
			if (isset($req->new_id) && !is_null($req->new_id)) {

				foreach ($req->new_id as $key => $new_id) {
					$visa 					= New Visa;
					$visa->countries_id 	= $req->country;
					$visa->country_name 	= slugify($req->country_name);
					$visa->sites_id 		= 0;
					$visa->sections_id 		= $new_id;
					$visa->title 			= secureData($req->new_title[$new_id]);
					$visa->slug 			= slugify($req->new_title[$new_id]);
					$visa->keywords 		= secureData($req->new_keywords[$new_id]);
					$visa->is_right  		= $req->new_position[$new_id];
					$visa->meta_title 		= secureData($req->new_meta_title[$new_id]);
					$visa->meta_desc 		= secureData($req->new_meta_desc[$new_id]);
					$visa->tags 			= secureData($req->new_tags[$new_id]);
					$visa->content 			= secureData($req->new_content[$new_id]);
					$isSave 				= $visa->save();
				}	
			}
		}
		if ($req->ajax()) {
			return response()->json(["notify"=>true, "msg"=>"Success"]);
		}else{
			return redirect()->route('admin.manage-visas');
		}
	}
	public function deleteVisaSection(Request $r)
	{
		if ($r->delete = 'yes') {
			$delete = Visa::where('id',$r->id)->delete();
		}else{
			$delete = Visa::where('id',$r->id)->restore();
		}

		if ($delete) {
			return response()->json(["notify"=>true, "msg"=>"Success"]);
		}else{
			return response()->json(["notify"=>false, "msg"=>"error"]);
		}
	}
}
