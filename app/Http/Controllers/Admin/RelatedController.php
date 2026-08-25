<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RelatedSites;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use Input;

class RelatedController extends Controller
{
      public $filePath = 'storage/uploads/related';
      public function related(Request $r)
      {
      	$data['relatedSites'] = RelatedSites::all();
      	return view('admin.related.manage-related',$data);
      
      }
       public function save(Request $req){

        $validator = Validator::make(Input::all(), [
            'title'   => 'required',
            'link'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $related     = new RelatedSites;
        }else{
            $related     = RelatedSites::where('id',$req->id)->first();
        }

        if (!empty($req->logo)) {
            $filename = Input::file('logo')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('logo')->move($this->filePath, $fileNewName);

            $related->logo          = $fileNewName;
        }

        $related->title          = $req->title;
      /*  $related->description    = $req->description;*/
        $related->link           = $req->link;
        $isSave                     = $related->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.related');
    }
      public function editRelated($id){
        $data['detail'] = RelatedSites::where('id',$id)->first();
        return view("admin.related.add-related", $data);
    }
      public function deleteRelated($id){
        $delete = RelatedSites::where('id',$id)->delete();
         if ($delete) {
            Session::flash("success-msg", "deleted Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.related');
    }
    public function addRelated($value='')
    {
    	$data['categories'] = RelatedSites::all();
    	return view("admin.related.add-related",$data);
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
