@extends('layouts.master')

@section('content')
<section class="p-about com-padd">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
          <div class="text-center">
          @if($invalid_token || $alreadyActive)
            @if($invalid_token)
              <p><i class="fa fa-error" style="color:#4EAE49; font-size: 80px;" aria-hidden="true"></i></p>
               <h1 class="top10" style="color: #545454; font-size: 50px; font-weight: bolder;">Sorry..!</h1><br>
               <p>Your Token has been expired 
               generate new token for activation.</p>
               <p>
                <form action="{{url('send-register-token')}}" method="post">
                {{csrf_field()}}
                <div class="form-group col-md-6 col-md-offset-3">
                  <input type="email" name="email" class="validate form-control" placeholder="Enter your Email">
                </div>
                <div class="form-group">
                 <input type="submit" value="Re-Send Varification Email" class="btn 
                 btn-primary" >
                </div>
                </form>
             </p>
            @endif
            @if($alreadyActive)
               <p><i class="fa fa-check-circle-o" style="color:#4EAE49; font-size: 80px;" aria-hidden="true"></i></p>
               <h1 class="top10" style="color: #545454; font-size: 50px; font-weight: bolder;">Greate!</h1><br>
               <p>Your account <strong>{{$email}}</strong> is already Activated. Please click below button for login</p><br>
               <p>
                   <a href="{{url('login')}}" class="btn btn-success">Back to Login</a>
               </p>
            @endif
          @else
             <p><i class="fa fa-check-circle-o" style="color:#4EAE49; font-size: 80px;" aria-hidden="true"></i></p>
             <h1 class="top10" style="color: #545454; font-size: 50px; font-weight: bolder;">Congratulations!</h1><br>
             <p>Your account <strong>{{$email}}</strong> has been Activated successfully. Please click below button for login</p><br>
             <p>
                 <a href="{{url('login')}}" class="btn btn-success">Back to Login</a>
             </p>
          @endif
         </div>
        </div>
    </div>
</div>
</section>
@endsection
