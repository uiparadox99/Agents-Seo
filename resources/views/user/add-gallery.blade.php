@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
        	 <form method="post" class="has-callback-validations content-box-agent" action="{{ route('user.save-gallery') }}" enctype="multipart/form-data" id="myModal">
                                @csrf
                            
                    <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" class="form-control" accept="image/*" name="image" data-validation="required">
                    <p class="text-danger number-style">Recommended Size 760x450</p>
                    </div>

                     <div class="row">
                        <div class="col-sm-6 col-sm-offset-5">
                            <input type="submit" name="save" value="Save" class="btn btn-primary">
                            <input type="reset" value="Reset" class="btn btn-default">
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection