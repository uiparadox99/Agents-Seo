<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use App\Setting;
use App\Employee;
use App\Admin;
use App\Country;
use App\EmployeeHasCountries;
use Session;


class SettingController extends Controller
{
    public function generalSettings()
    {
        return view('admin.pages.general-settings');
    }

    public $filePath = 'storage/uploads/logo';

    public function saveGeneralSettings()
    {

        $valuesArray	= Input::except(["_token"]);

        foreach ($valuesArray as $key => $value) {

            $isAvail = Setting::where("key", $key)->first();

            if ($isAvail) {
                if ($key == 'logo') {
                    $filename   = Input::file('logo')->getClientOriginalName();
                    $value      = $fileNewName = time()."-".preg_replace('/\s/', '-',$filename);
                    Input::file('logo')->move($this->filePath, $fileNewName);
                }
                if (!is_array($value)){
                    Setting::where("key", $key)->update(["value" => $value]);
                }else{
                    Setting::where("key", $key)->update(["value" => implode(',', $value)]);
                }

            }else{

                if ($key == 'logo') {
                    $filename = Input::file('logo')->getClientOriginalName();
                    $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
                    Input::file('logo')->move($this->filePath, $fileNewName);

                }
                if (!is_array($value)){
                    Setting::create(["key" => $key, "value" => $value]);
                }else{

                    Setting::create(["key" => $key, "value" => implode(',', $value)]);
                }
            }
        }

        Session::flash("success-msg", 'Operation completed successfully');

        return redirect()->back();
    }
    public function assignEmbassy(Request $r)
    {
        $data['employees'] = Admin::where('type','!=','admin')->get();
        $data['countries'] = Country::all();
        $assdata = EmployeeHasCountries::select('countries_id as country')->where('admins_id',$r->employee)->get();
        $assigned =array();
        foreach ($assdata  as $key => $value) {
           $assigned[] =  $value->country;
       }
       $data['assigned'] = $assigned;

       $data['selectedEmployee'] = Admin::where('id',$r->employee)->first();
       return view('admin.pages.assign-embassies',$data);
   }
   public function saveAssign(Request $r)
   {
    $delete = EmployeeHasCountries::where('admins_id',$r->employee)->delete();

    foreach ($r->country as $key => $value) {
     $add  = new EmployeeHasCountries;
     $add->admins_id = $r->employee;
     $add->countries_id = $value;
     $saved = $add->save();
 }
 Session::flash("success-msg", 'Operation completed successfully');

 return redirect()->back();

}
}
