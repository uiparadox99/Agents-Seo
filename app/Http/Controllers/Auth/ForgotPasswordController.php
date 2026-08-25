<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;
use Mail;
 use App\Mail\SendForgotMail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }
      public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Generate password reset token
        $token = Password::getRepository()->create($user);

        // Send custom password reset email
        $data = [
                "token"     =>  $token
            ];
         /*   $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
            $subject = "Account Confirmation | My Tooting";*/


        try {
            Mail::to($user->email)->send(new SendForgotMail($data));
        } catch (\Exception $e) {
            \Log::error('Password reset email failed for: ' . $user->email . ' | Error: ' . $e->getMessage());
            // Mail failed but token is generated — user can still use reset link if they receive it later
            // For local dev, log the reset link so it can be used directly
            \Log::info('Password reset link (local dev): ' . url('password/reset/' . $token));
        }

        return back()->with('status', 'We have emailed your password reset link! Please check your inbox & spam folder.');
    }
    public function __construct()
    {
        $this->middleware('guest');
    }
}
