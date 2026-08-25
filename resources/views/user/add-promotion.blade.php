@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box" >
        	 <form method="post" class="has-callback-validations content-box-agent" action="{{ route('user.save-promotion') }}" enctype="multipart/form-data" id="myModal" >
                                @csrf
                             
                    @if(isset($detail) && !is_null($detail))
                        <img src="{{url('storage/uploads/agents/'.$detail->image)}}"
                    style="width: 100%;height:200px;object-fit:contain">
                    @endif
                    <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail)?$detail->id:''}}">
                    <input type="hidden" name="type" value="{{request()->get('type')}}">
                     <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{isset($detail) && !is_null($detail)?$detail->name:''}}" data-validation="required">
                    </div>
                      @if(isset($detail) && !is_null($detail))
                    <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" >
                    </div>
                    @else
                         <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" data-validation="required">
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="">Offer Url</label>
                        <input type="text" class="form-control" name="url" value="{{isset($detail) && !is_null($detail)?$detail->url:''}}" data-validation="required">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control editor">{{isset($detail) && !is_null($detail)?$detail->description:''}}</textarea>
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