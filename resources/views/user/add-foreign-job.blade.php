@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>
        <div class="col-md-9 agent-main-box">
            <form method="post" class="has-callback-validations content-box-agent" action="{{ route('user.save-foreign-job') }}"
                enctype="multipart/form-data" id="myModal">
                @csrf
                <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail)?$detail->id:''}}">

          
                <div class="row">
                     <div class="form-group col-md-12">
                        <label for="">Job Title</label>
                        <input type="text" name="title" class="form-control" data-validation="required"
                            value="{{isset($detail) && !is_null($detail)?$detail->title:''}}">
                    </div> 
                    <div class="form-group col-md-6">
                        <label for="">Job Country</label>
                        <select name="country" id="" class="form-control" data-validation="required">
                            <option value="">Select</option>
                            @foreach($countries as $c)
                            <option value="{{$c->id}}"
                                {{isset($detail) && !is_null($detail) && $detail->countries_id == $c->id ?'selected':'' }}>
                                {{$c->country}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Salary</label>
                        <input type="text"  name="salary" class="form-control"
                            value="{{isset($detail) && !is_null($detail)?$detail->salary:''}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Place of Duty</label>
                        <input type="text" name="place_of_duty" class="form-control" data-validation="required"
                            value="{{isset($detail) && !is_null($detail)?$detail->place_of_duty:''}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Permission Number</label>
                          <div class="input-group">
                              <span class="input-group-text" id="basic-addon1">https://beoe.gov.pk/foreign-jobs/</span>
                                 <input type="text" name="permission" class="form-control" data-validation="required"
                                                    value="{{isset($detail) && !is_null($detail)?$detail->permission:''}}">
                            </div>
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