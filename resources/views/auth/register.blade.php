@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5 mb-4">


        <div class="col-md-6 offset-md-3">
            <div class="row">
            <!--<div class="col-6 pr-0">-->
            <!--        <div class="card-header" style="background: #f58220;color: #fff;text-align:center;font-weight:700;font-size:22px;border-radius: 12px 0 0 0;cursor:pointer" onclick="$('.agent_type').val('user'); $('.card-header').css('background','#070c39'); $(this).css('background','#f58220'); ">-->
            <!--            {{ __('User Register') }}-->
            <!--        </div>-->
            <!--    </div> -->
                <div class="col-12 ">
                    <div class="card-header" style="background: #070c39;color: #fff;text-align:center;font-weight:700;font-size:22px;border-radius:0;border-left:1px solid #f58220;cursor:pointer"  onclick="$('.agent_type').val('agent'); $('.card-header').css('background','#070c39'); $(this).css('background','#f58220'); ">
                        {{ __('Agent Register') }}
                    </div>
                </div> 
                <!--<div class="col-4 pl-0">-->
                <!--    <div class="card-header" style="background: #070c39;color: #fff;text-align:center;font-weight:700;font-size:22px;border-radius: 0 12px 0 0;cursor:pointer"  onclick="$('.agent_type').val('airline'); $('.card-header').css('background','#070c39'); $(this).css('background','#f58220'); ">-->
                <!--        {{ __('Airline Register') }}-->
                <!--    </div>-->
                <!--</div> -->
            
            </div>

          
            <form method="POST" action="{{ route('register') }}" style="    padding: 13px;background:#f0f0f0;border-radius: 0 0 12px 12px;">
                        @csrf
<div  class="row">
                        <input type="hidden" name="type" class="agent_type" value="agent">
                        <div class="form-group  col-sm-12">
                            <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>

                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" data-validation="required" autofocus>
                       
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group  col-sm-12">
                            <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" data-validation="email">
                          
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group  col-sm-12">
                            <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" data-validation="required">
                
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group  col-sm-12">
                            <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" data-validation="required">
                           
                        </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" style="background-color: #070c39;border-color: #070c39;">
                                    {{ __('Register Now') }}
                                </button>
                            </div>
                            </div>
                    </form>
        </div>

    </div>
</div>
@endsection