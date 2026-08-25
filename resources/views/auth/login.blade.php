@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5 mb-4">


        <div class="col-md-6 offset-md-3">
        <div class="card-header" style="background: #070c39;color: #fff;text-align:center;font-weight:700;font-size:22px;border-radius:12px 12px 0 0;"  onclick="$('.agent_type').val('agent'); $('.card-header').css('background','#070c39'); $(this).css('background','#f58220'); ">
                        {{ __('Login') }}
                    </div>
            <!-- <div class="row">
            <div class="col-4 pr-0">
                    <div class="card-header" style="background: #f58220;color: #fff;text-align:center;font-weight:700;font-size:22px;border-radius: 12px 0 0 0;cursor:pointer" onclick="$('.agent_type').val('user'); $('.card-header').css('background','#070c39'); $(this).css('background','#f58220'); ">
                        {{ __('User Login') }}
                    </div>
                </div> 
                <div class="col-4 pl-0 pr-0">
                  
                </div> 
                <div class="col-4 pl-0">
                    <div class="card-header" style="background: #070c39;color: #fff;text-align:center;font-weight:700;font-size:22px;border-radius: 0 12px 0 0;cursor:pointer"  onclick="$('.agent_type').val('airline'); $('.card-header').css('background','#070c39'); $(this).css('background','#f58220'); ">
                        {{ __('Airline Login') }}
                    </div>
                </div> 
            
            </div> -->

          
            <form method="POST" action="{{ route('login') }}" >
                @csrf
                <input type="hidden" name="type" class="agent_type" value="user">
                <div style="    padding: 13px;background:#f0f0f0;border-radius: 0 0 12px 12px;">
                    <div class="form-group">

                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                            value="{{ old('email') }}" data-validation="required" autofocus>


                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group ">
                        <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                        <input id="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                            data-validation="required">

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    @if($detect->isMobile())
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #070c39;border-color: #070c39;    padding: 5px 23px;">
                        {{ __('Login') }}
                    </button>
                    @else
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #070c39;border-color: #070c39;font-size:16px;    padding: 9px 42px;">
                        {{ __('Login') }}
                    </button>
                    @endif
                    <a href="{{url('register')}}" class="btn btn-primary mr-3"
                        style="background-color: #f58220;border-color: #f58220;font-size:16px;    padding: 9px 12px;float:right">
                        {{ __('Create New Account') }}
                            </a>

                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}" style="color: red;float:right">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>
            </form>
        </div>

    </div>
</div>
@endsection