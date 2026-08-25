<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AirlineUpdates;
use App\Airlines;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use Input;
class AirlineUpdatesController extends Controller
{
    public $filePath = 'storage/uploads/airlineupdates';
    public function index(Request $r)
    {
        $data['updates'] = AirlineUpdates::all();
        return view('admin.updates.manage-airline-updates',$data);
    }
     public function saveAirlineUpdates(Request $req){

      $validator = Validator::make(Input::all(), [
          'title'   => 'required',
          'content'   => 'required',
      ]);

      if ($validator->fails()) {
          Session::flash("error-msg", $validator->messages()->first());
          return redirect()->back()->withInput(Input::all());
      }

      if (is_null($req->id)) {
          $blog     = new AirlineUpdates;
      }else{
          $blog     = AirlineUpdates::where('id',$req->id)->first();
      }

      if (!empty($req->image)) {
          $filename = Input::file('image')->getClientOriginalName();
          $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
          Input::file('image')->move($this->filePath, $fileNewName);

          $blog->image          = $fileNewName;
      }

      $blog->title           = $req->title;
          $blog->slug               = str_slug($req->title);
      
      if (!empty($req->meta_title)) {
          $blog->meta_title         = ucfirst($req->meta_title);
      }
      if (!empty($req->meta_desc)) {
          $blog->meta_description       = $req->meta_desc;
      }
      $blog->content           = $req->content;
      $blog->date           = $req->date;
      $blog->airlines_id           = $req->airline;
      $blog->image_alt           = $req->image_alt;
      $isSave                     = $blog->save();

      if ($isSave) {
          Session::flash("success-msg", "Completed Successfully.");
      }else{
          Session::flash("error-msg", "Something went wrong. Try again.");
      }

      return redirect()->route('admin.airline-updates');
  }
    public function editAirlineUpdates($id){
      $data['detail'] = AirlineUpdates::where('id',$id)->first();
      $data['airlines'] = Airlines::all();
      return view("admin.updates.add-airline-update", $data);
  }
  public function addAirlineUpdates()
  {
      $data['airlines'] = Airlines::all();
      return view("admin.updates.add-airline-update",$data);
  }
}
