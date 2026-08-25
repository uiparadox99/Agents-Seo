@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Job
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                              <form method="post" class="has-callback-validations content-box-agent" action="{{ route('admin.save-jobs') }}"
                enctype="multipart/form-data" id="myModal">
                @csrf
                <input type="hidden" name="type" value="airline">
                <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail)?$detail->id:''}}">

          
                <div class="row">
                     <div class="form-group col-md-6">
                        <label for="">Airlines</label>
                        <select name="airline" id="" class="form-control" data-validation="required">
                            <option value="">Select</option>
                            @foreach($airlines as $c)
                            <option value="{{$c->users_id}}"
                                {{isset($detail) && !is_null($detail) && $detail->users_id == $c->users_id ?'selected':'' }}>
                                {{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-12">
                        <label for="">Job Title</label>
                        <input type="text" name="title" class="form-control" data-validation="required"
                            value="{{isset($detail) && !is_null($detail)?$detail->title:''}}">
                    </div> -->
                     <div class="form-group col-md-3">
                        <label for="">Countries</label>
                        <select name="countries_id" id="countries" class="form-control">
                            <option value="">Select</option>
                            @foreach($countries as $c)
                            <option value="{{$c->id}}"
                                {{isset($detail) && !is_null($detail) && $detail->countries_id == $c->id ?'selected':'' }}>
                                {{$c->country}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Job City</label>
                        <select name="city" id="cities" class="form-control" onchange="setCountry(this)">
                            <option value="">Select</option>
                            @foreach($cities as $c)
                            <option value="{{$c->id}}" data-country="{{$c->countries_id}}"
                                {{isset($detail) && !is_null($detail) && $detail->agent_cities_id == $c->id ?'selected':'' }}>
                                {{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Job Designation</label>
                        <select name="designation" id="" class="form-control" data-validation="required">
                            <option value="">Select</option>
                            @foreach($designations as $c)
                            <option value="{{$c->id}}"
                                {{isset($detail) && !is_null($detail) && $detail->job_designations_id == $c->id ?'selected':'' }}>
                                {{$c->name}} ({{!is_null($c->category)?$c->category->name:''}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Job Experience</label>
                        <input type="text" name="experience" class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->experience:''}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Salary Offer</label>
                        <input type="text" maxlength="20" name="offer" class="form-control priceFormate"
                            value="{{isset($detail) && !is_null($detail)?$detail->offer:''}}">
                    </div>
                    <!--<div class="form-group col-md-6">-->
                    <!--    <label for="">Post Date</label>-->
                    <!--    <input type="text" name="post_date" class="form-control unidatepicker" -->
                    <!--        value="{{isset($detail) && !is_null($detail)?$detail->post_date:''}}">-->
                    <!--</div>-->
                    <div class="form-group col-md-6">
                        <label for="">Last Apply Date</label>
                        <input type="text" name="apply_date" class="form-control datepicker" 
                            value="{{isset($detail) && !is_null($detail)?$detail->apply_date:''}}">
                    </div>
                         <div class="form-group col-md-4">
                        <label for="">No of Vacancies</label>
                        <input type="number" name="vacancies" class="form-control" max="999" 
                            value="{{isset($detail) && !is_null($detail)?$detail->vacancies:''}}">
                    </div>
                     <div class="form-group col-md-4">
                        <label for="">Qualification</label>
                        <input type="text" name="qualification" class="form-control" 
                            value="{{isset($detail) && !is_null($detail)?$detail->qualification:''}}">
                    </div>
                       <div class="form-group col-md-4">
                        <label for="">Age Limit</label>
                        <input type="text" maxlength="15" name="age_limit" class="form-control" 
                            value="{{isset($detail) && !is_null($detail)?$detail->age_limit:''}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Post Url</label>
                        <input type="text" name="post_url" class="form-control"
                            value="{{isset($detail) && !is_null($detail)?$detail->post_url:''}}">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-12">
                        <label for="">Requirements</label>
                        <textarea name="requirement" class="form-control editor">{{isset($detail) && !is_null($detail)?str_replace('<br />','',$detail->requirement):''}}</textarea>
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
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
$('.select2').select2();
$(".datepicker").datepicker({
    format: 'yyyy-mm-dd',
    changeYear: true
  });
  function setCountry(event){
      var country = $('#cities option:selected').data('country');
      $('#countries').val(country);
  }
</script>
@endpush