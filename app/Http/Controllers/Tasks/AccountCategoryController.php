<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Session;
use App\TasksModels\AccountCategory;

class AccountCategoryController extends Controller
{
    public function index()
    {
        $data['categories'] = AccountCategory::orderBy('name', 'ASC')->get();
        return view('user.tasks.account-category.manage-account-categories', $data);
    }

    public function showAddForm()
    {
        return view('user.tasks.account-category.add-account-category');
    }

    public function save(Request $req)
    {
        $validator = Validator::make(Input::all(), [
            'name'      	=> 'required',
            'code' 	        => 'required',
            'for_supplier' 	=> 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (!is_null($req->id)) {
            $a    = AccountCategory::where('id', $req->id)->first();
        }else{
            $a    = New AccountCategory;
        }

        $a->name            = $req->name;
        $a->code            = $req->code;
        $a->for_supplier    = $req->for_supplier;
        $isSave             = $a->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/manage-accounts-categories');
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }
    }

    public function showEditForm($id)
    {
        $data['category'] = AccountCategory::where('id', $id)->first();

        return view('user.tasks.account-category.add-account-category', $data);
    }
}
