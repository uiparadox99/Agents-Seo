@extends('layouts.master')

@section('content')
<section class="p-about com-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-8 " style="margin:50px auto 0 auto;">
                <div class="text-center">
                    <p><i class="fa fa-envelope" style="color:#4EAE49; font-size: 80px;" aria-hidden="true"></i></p>
                    <h1>Request Send!</h1> <br>
                    <p>Your request has been submitted. Please check you inbox and click the link to verify your email then your request convery to agent.</p>
                    <br>
                    <!-- <p>
                        <a href="{{url('login')}}" class="btn btn-success">Back to Login</a>
                    </p> -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection