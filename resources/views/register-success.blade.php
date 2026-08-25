@extends('layouts.master')

@section('content')
<section class="p-about com-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-8 " style="margin:50px auto 0 auto;">
                <div class="text-center">
                    <p><i class="fa fa-envelope" style="color:#4EAE49; font-size: 80px;" aria-hidden="true"></i></p>
                    <h1>Registration Complete!</h1> <br>
                    <p>Thank you for creating an account. A user activation link was emailed to
                        <strong>{{Session::get('temp_email')}}</strong>.<b style="color: red"> Check your Inbox or Spam folder.</b> Click the link in the email to activate and
                        complete your account verification.</p>
                    <br>
                    <p>
                        <a href="{{url('login')}}" class="btn btn-success">Back to Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection