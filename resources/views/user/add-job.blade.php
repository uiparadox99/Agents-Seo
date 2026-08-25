@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>
        <div class="col-md-9 agent-main-box">
            <form method="post" class="has-callback-validations content-box-agent" action="{{ route('user.save-job') }}"
                enctype="multipart/form-data" id="myModal">
                @csrf
                <input type="hidden" name="type" value="{{request()->get('type')}}">
                <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail)?$detail->id:''}}">

          
                <div class="row">
                    <!-- <div class="form-group col-md-12">
                        <label for="">Job Title</label>
                        <input type="text" name="title" class="form-control" data-validation="required"
                            value="{{isset($detail) && !is_null($detail)?$detail->title:''}}">
                    </div> -->
                    <div class="form-group col-md-6">
                        <label for="">Job City</label>
                        <select name="city" id="" class="form-control" data-validation="required">
                            <option value="">Select</option>
                            @foreach($cities as $c)
                            <option value="{{$c->id}}"
                                {{isset($detail) && !is_null($detail) && $detail->agent_cities_id == $c->id ?'selected':'' }}>
                                {{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Job Designation</label>
                        <select name="category" id="" class="form-control" data-validation="required">
                            <option value="">Select</option>
                            @foreach($categories as $c)
                            <option value="{{$c->id}}"
                                {{isset($detail) && !is_null($detail) && $detail->job_category_id == $c->id ?'selected':'' }}>
                                {{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Job Experience</label>
                        <input type="text" name="experience" class="form-control" data-validation="required" value="{{isset($detail) && !is_null($detail)?$detail->experience:''}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Salary Offer</label>
                        <input type="text" maxlength="7" name="offer" class="form-control priceFormate"
                            value="{{isset($detail) && !is_null($detail)?$detail->offer:''}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Post Date</label>
                        <input type="text" name="post_date" class="form-control unidatepicker" data-validation="required"
                            value="{{isset($detail) && !is_null($detail)?$detail->post_date:''}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Last Apply Date</label>
                        <input type="text" name="apply_date" class="form-control datepicker" data-validation="required"
                            value="{{isset($detail) && !is_null($detail)?$detail->apply_date:''}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Post Url</label>
                        <input type="text" name="post_url" class="form-control " 
                            value="{{isset($detail) && !is_null($detail)?$detail->post_url:''}}">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-12">
                        <label for="">Requirements</label>
                        <textarea name="requirement" class="form-control editor"
                            data-validation="required">{{isset($detail) && !is_null($detail)?str_replace('<br />','',$detail->requirement):''}}</textarea>
                    </div>
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
@push('script')
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/jquery.alphanum/1.0.24/jquery.alphanum.min.js"></script>
<script>
   
    $(document).ready(function() {
        $('.priceFormate').numeric();
    });
$("#plan_id").change(function() {
    var plan = $('#plan_id option:selected').data('price');

    var period = $('#period option:selected').val();
    var price = plan * period;
    $('#price').html('Total Price : <strong>' + price + '</strong>');
    $('#subs_price').val(price);
});
$("#period").change(function() {
    var plan = $('#plan_id option:selected').data('price');

    var period = $('#period option:selected').val();
    var price = plan * period;
    $('#subs_price').val(price);
    $('#price').html('Total Price : <strong>' + price + '</strong>');
});
</script>
@endpush