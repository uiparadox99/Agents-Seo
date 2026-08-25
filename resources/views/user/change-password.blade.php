@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
            <form method="POST" action="{{url('save-change-password')}}" enctype="multipart/form-data" class="row content-box-agent">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{auth()->user()->id}}">
                <div class="form-group col-md-6">
                    <div class="">
                        <label>Current Password</label>
                        <input type="password" name="old_password" value="{{old('old_password')}}"
                            class="validate form-control" data-validation="required">
                        @if ($errors->has('old_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="">
                        <label>New Password</label>
                        <input type="password" name="password" value="{{old('password')}}" class="validate form-control"
                            data-validation="required">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" value="{{old('confirm_password')}}"
                            class="validate form-control" data-validation="required">
                        @if ($errors->has('confirm_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12">
                    <div class="">
                        <input type="submit" value="Change Password" class="btn btn-primary "> <input type="reset" name="" value="Reset" class="btn bt-default"> </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection