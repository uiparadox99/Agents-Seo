<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
use Validator;
use Session;
use Hash;
use Input;

class SectionController extends Controller
{
    public function addSectionForm()
    {
    	return view("admin.pages.add-section");
    }

    public function manageSection()
    {
        $data['section'] = Section::all();
    	return view("admin.pages.manage-section", $data);
    }

    public function saveSection(Request $req)
    {
    	$validator = Validator::make(Input::all(), [
            'title'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $section     = new Section;
        }else{
            $section     = Section::where('id',$req->id)->first();
        }
        
        $section->title = $req->title;
        $section->open  = !empty($req->open)?$req->open:0;
        $isSave         = $section->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->route('admin.manage-section');
    }

    public function editSection($id)
    {
        $data['sec'] = Section::where('id', $id)->first();
        return view("admin.pages.add-section", $data);
    }
}
