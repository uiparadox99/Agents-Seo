<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agents;
use App\AgentType;
use App\AgentDeal;
use App\AgentReview;
use App\AgentSubscription;
use App\Cities;
use App\Plan;
use App\User;
use App\Country;
use App\Transaction;
use App\AgentTiming;
use App\AgentCity;
use App\AgentGallery;
use App\DtsAttachment;
use \Validator;
use Mail;
use Session;
use DB;
use Input;
use Auth;
use Hash;
class HomeController extends Controller
{
    public $filePath = 'storage/uploads/agents';
    public function index()
    {
        $data['detail'] = Agents::with('agentType')->with('city')->where('users_id', auth()->user()->id)->first();

        return view('user.home', $data);
    }
    public function profile()
    {
        $data['detail'] = auth()->user();

        return view('user.profile', $data);
    }
    public function addBusiness(Request $r)
    {

        $data['types'] = AgentType::where('name', '!=', 'UnKnown')->get();
        $data['countries'] = Country::orderby('country')->get();
        $data['agentcities'] = AgentCity::orderBy('name', 'ASC')->get();
        $data['plans'] = Plan::where('active', 1)->get();
        if (!empty($r->subscription)) {
            $plan = Plan::join('plan_has_plans_permissions', 'plan.id', 'plan_id')->join('plans_permissions', 'plans_permissions.id', 'plans_permissions_id')->where('plan.id', $r->subscription)->select('plans_permissions.code')->get();
            $permission = array();
            foreach ($plan as $key => $value) {
                $permission[] = $value->code;
            }
            $data['permissions'] = $permission;
        }
        $data['subscribed'] = null;
        return view("user.add-business", $data);
    }
    public function saveBusiness(Request $req)
    {

        $validator = Validator::make(Input::all(), [
            'business_name' => 'required',
            'address' => 'required',
            'type' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $already = Agents::where('business_name', '=', $req->business_name)->first();
            if (!is_null($already)) {
                Session::flash("error-msg", 'Business Already Added With this business Name');
                return redirect()->back()->withInput(Input::all());
            }

            $agent = new Agents;
            $agent->slug = str_slug($req->business_name);
            $agent->code = generateCode();
        } else {
            $already = Agents::where('id', '!=', $req->id)->where('business_name', '=', $req->business_name)->first();
            if (!is_null($already)) {
                Session::flash("error-msg", 'Business Already Added With this business Name');
                return redirect()->back()->withInput(Input::all());
            }
            $agent = Agents::where('id', $req->id)->first();

        }

        if (!empty($req->logo)) {
            $filename = Input::file('logo')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('logo')->move($this->filePath, $fileNewName);

            $agent->logo = $fileNewName;
            $agent->logo_changed = '1';
            $agent->logo_approved = '0';
        }
        if (!empty($req->cover)) {
            $filename = Input::file('cover')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('cover')->move($this->filePath, $fileNewName);

            $agent->cover = $fileNewName;
            $agent->cover_changed = '1';
            $agent->cover_approved = '0';
        }

        if (!empty($req->iata_attachment)) {
            $iatafilename = Input::file('iata_attachment')->getClientOriginalName();
            $value = $iatafileNewName = Guid() . "-" . preg_replace('/\s/', '-', $iatafilename);
            Input::file('iata_attachment')->move($this->filePath, $iatafileNewName);

            $agent->iata_attachment = $iatafileNewName;
        }
        $email = implode(',', array_filter($req->email));
        $mobile = implode(',', array_filter($req->mobile));
        $phone = implode(',', array_filter($req->phone));

        $agent->business_name = strtolower($req->business_name);

        $agent->agent_name = $req->agent_name;
        $agent->email = $email;
        $agent->users_id = auth()->user()->id;
        $agent->phone = $phone;
        $agent->facebook = $req->facebook;
        $agent->twitter = $req->twitter;
        $agent->insta = $req->insta;
        $agent->linkedin = $req->linkedin;
        $agent->tiktok = $req->tiktok;
        $agent->owner_name_public = is_null($req->owner_name_public) || empty($req->owner_name_public) || !$req->owner_name_public ? '0' : $req->owner_name_public;
        $agent->address_public = is_null($req->address_public) || empty($req->address_public) || !$req->address_public ? '0' : $req->address_public;
        $agent->phone_1_public = is_null($req->phone_1_public) || empty($req->phone_1_public) || !$req->phone_1_public ? '0' : $req->phone_1_public;
        $agent->mobile_1_public = is_null($req->mobile_1_public) || empty($req->mobile_1_public) || !$req->mobile_1_public ? '0' : $req->mobile_1_public;
        $agent->email_public = is_null($req->email_public) || empty($req->email_public) || !$req->email_public ? '0' : $req->email_public;
        $agent->description_public = is_null($req->description_public) || empty($req->description_public) || !$req->description_public ? '0' : $req->description_public;
        $agent->whatsapp = $req->whatsapp;
        $agent->dsl_license = $req->dsl_license;
        $agent->iata_license = $req->iata_license;
        $agent->dsl_expairy = $req->dsl_expairy;
        $agent->iata_expairy = $req->iata_expairy;
        $agent->description = nl2br($req->description);
        $agent->website = $req->website;
        $agent->address = $req->address;
        $agent->youtube = $req->youtube;
        $agent->recomended_status = $req->recomended_status;
        $agent->active = 1;
        $agent->agent_type_id = $req->type;
        $agent->cities_id = $req->city;
        $agent->fax = $req->fax;
        $agent->secondary_phone = $req->secondary_phone;
        $agent->mobile = $mobile;
        $agent->is_foreign = $req->country == 3?0:1;
        $agent->secondary_mobile = $req->secondary_mobile;


        $isSave = $agent->save();


        if ($isSave) {

            $delete = AgentTiming::where('agents_id', $req->id)->delete();
            foreach ($req->day as $key => $value) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                $timing = new AgentTiming;
                $timing->day = $value;
                $timing->opening = $req->opening[$key];
                $timing->closing = $req->closing[$key];
                $timing->agents_id = $agent->id;
                $save = $timing->save();
                DB::statement('SET FOREIGN_KEY_CHECKS=1');




            }

            if (!empty($req->dts_attachment)) {
                $filename = Input::file('dts_attachment')->getClientOriginalName();
                $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
                Input::file('dts_attachment')->move($this->filePath, $fileNewName);

                $non = DtsAttachment::where('agents_id', $agent->id)->update(['active' => 0]);
                if ($non || !$non) {
                    $dts = new DtsAttachment;
                    $dts->file = $fileNewName;
                    $dts->active = 1;
                    $dts->agents_id = $agent->id;
                    $savedts = $dts->save();
                }
            }
            if (empty($req->id)) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                $expire_date = date('Y-m-d h:i:s', strtotime("+100 year"));
                $subcription = new AgentSubscription;
                $subcription->period = '100';
                $subcription->plan_id = '5';
                $subcription->agents_id = $agent->id;
                $subcription->active = 1;
                $subcription->expairy_date = $expire_date;
                $Ssaved = $subcription->save();
                if ($Ssaved) {
                    $t = new Transaction;
                    $t->subscription_id = $subcription->id;
                    $t->payment = '0';
                    $t->plan_price = '0';
                    $t->status = 'paid';
                    $tsaved = $t->save();
                }
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
            if (!empty($req->id)) {
                Session::flash("success-msg", "Record Updated Successfully.");
            } else {

                $data = [
                    "business" => $agent->business_name,
                ];

                $myemail = auth()->user()->email;

                Mail::send('emails.business-add-success', $data, function ($message) use ($myemail) {
                    $message->subject('Business Added Successfully');
                    $message->from('noreply@agents.com.pk', 'Agents PK');
                    $message->to($myemail, 'Business Added');
                });

                Session::flash("success-msg", "Record Added Successfully.");
            }
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();
        }

        return redirect()->to('/home');
    }
    public function editBusiness($id)
    {
        $data['types'] = AgentType::all();
        $data['agentcities'] = AgentCity::orderBy('name', 'ASC')->get();
        $data['detail'] = Agents::where('id', $id)->first();
           $data['countries'] = Country::orderby('country')->get();
        $data['plans'] = Plan::where('active', 1)->get();
        $subscription = AgentSubscription::where('agents_id', $id)->first();
        if (!is_null($subscription)) {
            $plan = Plan::join('plan_has_plans_permissions', 'plan.id', 'plan_id')->join('plans_permissions', 'plans_permissions.id', 'plans_permissions_id')->where('plan.id', $subscription->plan_id)->select('plans_permissions.code')->get();
            $permission = array();
            foreach ($plan as $key => $value) {
                $permission[] = $value->code;
            }
            $data['permissions'] = $permission;
            $data['subscribed'] = $subscription;
        } else {
            $plan = Plan::join('plan_has_plans_permissions', 'plan.id', 'plan_id')->join('plans_permissions', 'plans_permissions.id', 'plans_permissions_id')->where('plan.id', request()->get('subscription'))->select('plans_permissions.code')->get();
            $permission = array();
            foreach ($plan as $key => $value) {
                $permission[] = $value->code;
            }
            $data['permissions'] = $permission;
            $data['subscribed'] = null;
        }
        return view("user.add-business", $data);
    }
    public function changePassword()
    {
        return view("user.change-password");
    }
    public function saveChangePassword(Request $req)
    {
        $validator = Validator::make(Request()->all(), [
            'password' => 'required',
            'old_password' => 'required',
            'confirm_password' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('error-msg', 'ERROR: ' . $validator->messages()->first());
            return redirect()->back()->withInput(Request()->all());
        }
        if (!empty($req->old_password)) {
            $customer = User::where('id', $req->id)->first();
            $check = Hash::check($req->old_password, $customer->password);

            if (!$check) {
                Session::flash('error-msg', 'ERROR: Current Password did not match');
                return redirect()->back()->withInput(Request()->all());
            }
        }
        if ($req->password != $req->confirm_password) {
            Session::flash('error-msg', 'ERROR: Password & Confirm Password did not match');
            return redirect()->back()->withInput(Request()->all());
        }
        $customer = User::where('id', $req->id)->first();
        $customer->visible_password = $req->password;
        $customer->password = Hash::make($req->password);
        $save = $customer->save();
        if ($save) {
            Session::flash("success-msg", "Password Changed Successfully.");

            return redirect()->to('/home');
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }
    public function reviews()
    {
        $business = Agents::where('users_id', auth()->user()->id)->first();
        if (!is_null($business)) {
            $data['reviews'] = AgentReview::where('agents_id', $business->id)->paginate(15);
            return view('user.reviews', $data);
        } else {
            Session::flash("error-msg", "Please Add Business First");

            return redirect()->back();
        }
    }
    public function agentGallery()
    {
        $business = Agents::where('users_id', auth()->user()->id)->first();
        if (!is_null($business)) {
            $data['gallery'] = AgentGallery::where('agents_id', $business->id)->orderBy('active', 'DESC')->paginate(15);
            $data['count'] = AgentGallery::where('agents_id', $business->id)->where('active', 1)->count();
            return view('user.gallery', $data);
        } else {
            Session::flash("error-msg", "Please Add Business First");

            return redirect()->back();
        }
    }
    public function addGallery()
    {
        return view('user.add-gallery');
    }
    public function saveGallery(Request $r)
    {
        $validator = Validator::make(Request()->all(), [
            'image' => 'mimes:jpeg,jpg,png|required',
        ]);
        if ($validator->fails()) {
            Session::flash('error-msg', 'ERROR: ' . $validator->messages()->first());
            return redirect()->back()->withInput(Request()->all());
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $i = new AgentGallery;
        if (!empty($r->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $i->image = $fileNewName;
        }
        $business = Agents::where('users_id', auth()->user()->id)->first();
        $i->agents_id = $business->id;
        $saved = $i->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        if ($saved) {
            Session::flash("success-msg", "Image Added Successfully.");

            return redirect()->to('agent-gallery');
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }
    public function deleteGallery($id)
    {
        $delete = AgentGallery::where('id', $id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Image Deleted Successfully.");

            return redirect()->back();
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }

    public function agentPromotions(Request $r)
    {
        if($r->type == 'agent'){
            $business = Agents::where('users_id', auth()->user()->id)->first();
            if (is_null($business)) {
                Session::flash("error-msg", "Please Add Business First");
                return redirect()->back();
            }
              
            $data['promotions'] = AgentDeal::where('agents_id', $business->id)->paginate(15);
            $data['count'] = AgentDeal::where('agents_id', $business->id)->where('active', 1)->count();
        }else{
            $data['promotions'] = AgentDeal::where('airline_id', auth()->user()->airline->id)->paginate(15);
            $data['count'] = AgentDeal::where('airline_id', auth()->user()->airline->id)->where('active', 1)->count();
        }
      

        return view('user.promotions', $data);
      
    }
    public function addPromotion()
    {
        return view('user.add-promotion');
    }
    public function editPromotion($id)
    {

        $data['detail'] = AgentDeal::where('id', $id)->first();

        return view('user.add-promotion', $data);
    }
    public function savePromotion(Request $r)
    {
        if (empty($r->id)) {
            $validator = Validator::make(Request()->all(), [
                'image' => 'mimes:jpeg,jpg,png|required',
            ]);
            if ($validator->fails()) {
                Session::flash('error-msg', 'ERROR: ' . $validator->messages()->first());
                return redirect()->back()->withInput(Request()->all());
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if (!empty($r->id)) {
            $i = AgentDeal::where('id', $r->id)->first();
        } else {
            $i = new AgentDeal;
        }

        if (!empty($r->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $i->image = $fileNewName;
        }
        $i->name = $r->name;
        if($r->type == 'agent'){
            $business = Agents::where('users_id', auth()->user()->id)->first();
            $i->agents_id = $business->id;
        }else{
            $i->airline_id = auth()->user()->airline->id;
        }
        $i->description = $r->description;
        $i->url = $r->url;
        $saved = $i->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        if ($saved) {
            Session::flash("success-msg", "Image Added Successfully.");

            return redirect()->to('agent-promotions?type='.$r->type);
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }
    public function deletePromotion($id)
    {
        $delete = AgentDeal::where('id', $id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Image Deleted Successfully.");

            return redirect()->back();
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }
    public function activeGallery(Request $r)
    {
        $agent = AgentGallery::where('id', $r->id)->first();
        $agent->active = $r->active;
        $saved = $agent->save();
        if ($saved) {
            Session::flash("success-msg", "Image Active Successfully.");

            return redirect()->back();
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }
    public function activePromotions(Request $r)
    {
        $agent = AgentDeal::where('id', $r->id)->first();
        $agent->active = $r->active;
        $saved = $agent->save();
        if ($saved) {
            Session::flash("success-msg", "Promotions Active Successfully.");

            return redirect()->back();
        } else {
            Session::flash("success-msg", "There is an Error.");

            return redirect()->back();
        }
    }


}