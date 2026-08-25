<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TravelNews;
use App\Airlines;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use Input;
class TravelNewsController extends Controller
{
    public $filePath = 'storage/uploads/travelnews';
    public function index(Request $r)
    {
        $data['news'] = TravelNews::all();
        
        return view('admin.news.manage-travel-news',$data);
    }
     public function saveTravelNews(Request $req){

      $validator = Validator::make(Input::all(), [
          'title'   => 'required',
          'content'   => 'required',
      ]);

      if ($validator->fails()) {
          Session::flash("error-msg", $validator->messages()->first());
          return redirect()->back()->withInput(Input::all());
      }

      if (is_null($req->id)) {
          $blog     = new TravelNews;
      }else{
          $blog     = TravelNews::where('id',$req->id)->first();
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
          $blog->meta_description      = $req->meta_desc;
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

      return redirect()->route('admin.travel-news');
  }
    public function editTravelNews($id){
      $data['detail'] = TravelNews::where('id',$id)->first();
      $data['airlines'] = Airlines::all();
      return view("admin.news.add-travel-news", $data);
  }
  public function addTravelNews()
  {
    $data['airlines'] = Airlines::all();
      return view("admin.news.add-travel-news",$data);
  }
  
  public function SaveFeatured(Request $req)
  {
         $visa 			= Blogs::where('id', $req->id)->first();
      $visa->is_featured 	= $req->is_featured;
      $isSave 		= $visa->save();
      if ($isSave) {
          return response()->json(["notify"=>true, "msg"=>"Success"]);
      }else{
          return response()->json(["notify"=>false, "msg"=>"Fail"]);
      }
  }
}
