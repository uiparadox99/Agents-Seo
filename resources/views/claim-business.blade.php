@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style=";margin: 10px 0;    border-color: #070c39;border: 0">
                <h4 class="text-center text-uppercase mb-0 mt-1">Claim This business </h4>
                <h1 class="text-center text-capitalize" style="color: #070c39"><b>{{strtolower($business->business_name)}}</b></h1>

                <div class="card-body" style="padding: 0">
                  <ul class="nav nav-tabs" role="tablist">

                  <li class="nav-item">
                      <a class="nav-link {{!request()->has('register')?'active':''}}" data-toggle="tab" href="#menu2">Not a Member</a>
                  </li>
                    <li class="nav-item">
                      <a class="nav-link {{request()->has('register')?'active':''}}" data-toggle="tab" href="#menu1">Already Member</a>
                  </li>
              </ul>
              <div class="tab-content" style="border: 1px solid #f58220;border-top: 0; padding: 0px 0 20px 0px;">
                <div id="menu1" class="container tab-pane {{request()->has('register')?'fade active show':''}}"><br>
                   <form method="POST" action="{{ url('save-claim-business') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="biz_id" value="{{ $slug }}">



                    <div class=" row">
                        <label for="email"
                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <div class="form-group">

                                <input id="email" type="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="email" value="{{ old('email') }}" data-validation="required" autofocus>
                            </div>

                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class=" row">
                        <label for="password"
                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="password" type="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                name="password" data-validation="required">
                            </div>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary"
                            style="background-color: #070c39;border-color: #070c39;">
                            {{ __('Claim Now') }}
                        </button>

                    </div>
                </div>
            </form>
        </div>
        <div id="menu2" class="container tab-pane  {{!request()->has('register')?'fade active show':''}}"><br>
         <form method="POST" action="{{ url('save-claim-business') }}">
            {{ csrf_field() }}
            <input type="hidden" name="biz_id" value="{{ $slug }}">


            <div class=" row">
                <label for="first_name"
                class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <div class="form-group">

                        <input id="name" type="text"
                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        name="name" value="{{ old('name') }}" data-validation="required"
                        autofocus>
                    </div>

                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class=" row">
                <label for="email"
                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <div class="form-group">

                        <input id="email" type="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        name="email" value="{{ old('email') }}" data-validation="required" autofocus>
                    </div>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class=" row">
                <label for="password"
                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <div class="form-group">
                        <input id="password" type="password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                        name="password" data-validation="required">
                    </div>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
               <div class=" row">
                <label for="password"
                class="col-md-4 col-form-label text-md-right">{{ __(' Confirm Password') }}</label>

                <div class="col-md-6">
                    <div class="form-group">
                        <input id="confirm_password" type="password"
                        class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                        name="confirm_password" data-validation="required">
                    </div>
                    @if ($errors->has('confirm_password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('confirm_password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>



            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary"
                    style="background-color: #070c39;border-color: #070c39;">
                    {{ __('Claim Now') }}
                </button>

            </div>
        </div>
    </form>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
@endsection