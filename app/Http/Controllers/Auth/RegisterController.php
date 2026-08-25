<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Mail;
use Hash;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);
    }

    function activate($token){
        $inActive       = User::Where("verification_token", $token)->Where("active", 0)->first();
        $alreadyActive  = User::Where("verification_token", $token)->Where("active", 1)->first();

        if($inActive){
            User::Where("verification_token", $token)->Where("active", 0)->update(['active'=>1, "verified"=>1]);
            return view("account-activation")->with("email", $inActive->email)->with("invalid_token", false)->with("alreadyActive", false)->with("inActive", false);
        }

        if ($alreadyActive) {
            return view("account-activation")->with("invalid_token", false)->with("alreadyActive", true)->with("inActive", false)->with("email", $alreadyActive->email);
        }

        return view("account-activation")->with("invalid_token", true)->with("alreadyActive", false)->with("inActive", false);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        Log::info('Registration started for email: ' . $request->get('email'));
      
        $validator = Validator::make($request->all(), [
            'name'            => 'required|max:255',
            'email'                 => 'required|email|max:255|unique:users',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        
        if ($validator->fails()) {
            Log::info('Registration validation failed for: ' . $request->get('email'));
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        $name     = $request->get('name', "");
        $email          = $request->get('email', "");
        $password       = $request->get('password', "");
        $type       = $request->get('type', "");
        $token          = Str::random(60);
 
      
        $u = new User;
        $u->name          = $name;
        $u->email               = $email;
        $u->password            = Hash::make($password);
        $u->visible_password    = $password;
        $u->verified            = 1;
        $u->verification_token  = $token;
        $u->is_subscribe        = 0;
        $u->active              = 1;
        $u->type = !empty($type) ? $type : 'agent';
        
        Log::info('Saving user: ' . $email);
        $isSave                 = $u->save();
        

        if($isSave){
            Log::info('User saved successfully: ' . $email);
            $data = [
                "name"      =>  $name,
                "email"     =>  $email,
                "token"     =>  $token
            ];

            try {
                Log::info('Sending registration mail to: ' . $email);
                Mail::to($email)->send(new SendMail($data));
                Log::info('Mail sent successfully to: ' . $email);
            } catch (\Exception $e) {
                Log::error('Mail sending failed for: ' . $email . ' Error: ' . $e->getMessage());
            }

            Session::put("temp_email", $email);
            Session::flash("status", "Thank you for register");

            return redirect("success");
        }else{
            Log::error('User save failed for: ' . $email);
            return redirect()->back()->withInput($request->all());
        }

        
    }
}
