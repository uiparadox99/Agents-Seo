@extends('admin.layout.auth') 
@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="javascript:;"><b>Agents.com.pk</b></a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span> 
              @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span> 
              @endif
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control" name="password" placeholder="passwords">

                <span class="glyphicon glyphicon-lock form-control-feedback"></span> 
              @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span> 
              @endif
            </div>
            <div class="row">

                <div class="col-xs-4 col-xs-offset-8">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
</div>
@endsection