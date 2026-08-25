<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use \Validator;
use App\User;
use Auth;
use Input;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function login()
    {
     
        // $messages = [
        //     'required' => 'The :attribute field is required.',
        // ];
        $validator = Validator::make(Input::all(), [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            if (request()->ajax()) {
                return response()->json(['notify' => false, "msg" => "Email or password are not match"]);
            }
            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();
        }

        $email      = Input::has("email") ? Input::get("email") : "";
        $password   = Input::has("password") ? Input::get("password") : "";
        $remember   = Input::has("remember") ? true : false;

        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password], $remember)) 
        {   
            $user = Auth::guard('web')->user();

            if ($user->active === 0 || $user->active === '0') {
                Auth::guard('web')->logout();
                if (request()->ajax()) {
                    return response()->json(['notify' => false, "msg" => 'Your account is blocked or inactive by admin, Please contact administrator']);
                }
                Session::flash("error-msg", "Your account is blocked or inactive by admin, Please contact administrator");
                $validator->getMessageBag()->add('email', 'Your account is blocked or inactive by admin, Please contact administrator');
                return redirect('login')
                            ->withErrors($validator)
                            ->withInput();
            }

            $user_id = $user->id;
            $user_name = $user->name;
            $user_email = $user->email;
            $type = $user->type;
            Session::put("user_id", $user_id);
            Session::put("user_name", $user_name);
            Session::put("user_email", $user_email);

            if (request()->ajax()) {
                return response()->json(['notify' => true, "msg" => 'Login Successfully']);
            }
            if ($type == 'agent') {
                return redirect($this->redirectTo);
            } else {
                return redirect('/profile');
            }
        }

        if (request()->ajax()) {
            return response()->json(['notify' => false, "msg" => 'Email or password do not match']);
        }
        Session::flash("error-msg", "Email or password do not match");
        $validator->getMessageBag()->add('email', 'Email or password do not match');
        return redirect('login')->withInput(Input::except('password'))->withErrors($validator);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
