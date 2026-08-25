@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9" style="padding: 0 5px;">
            <form method="post" class="has-callback-validations" action="{{ route('user.save-business') }}"
                enctype="multipart/form-data" id="myModal">

                @csrf
                <!-- @if(is_null($subscribed) || !isset($detail) && empty($detail))
                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #fff;">
               
                    <h3 class="text-center">Subscription</h3>
                    <hr>
                    <input type="hidden" name="price" id="subs_price">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Plan</label>
                            <select name="plan" id="plan_id" class="form-control" data-validation="required">
                                <option value="">Select</option>
                                @foreach($plans as $p)
                                <option {{request()->has('subscription') && request()->get('subscription') == $p->id ?'selected':''}} value="{{$p->id}}"
                                    data-price="{{!is_null($p->plansPriceDiscounts()->where('active',1)->first()) && !empty($p->plansPriceDiscounts()->where('active',1)->first())?$p->plansPriceDiscounts()->where('active',1)->first()->price:''}}">
                                    {{$p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Period</label>
                            <select name="period" id="period" class="form-control" data-validation="required">
                                @for($i = 1; $i<=12; $i++) <option value="{{$i}}" id="{{$i}}"
                                    {{!empty($modal)?$d->period == $i?"selected":"":""}}> {{$i}} Month</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <h3 id="price" class="text-center"></h3>
                  
                </div>
                @endif -->
                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #8fd88fb5;">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Business Name</label>
                            <input type="text" id="title" name="business_name" class="form-control"
                                data-validation="required"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->business_name:'' }}" style="text-transform:capitalize">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Owner Name </label><span style="float:right"><input type="checkbox" name="owner_name_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->owner_name_public == '1'?'checked':'' }}> Show publicly</span>
                            <input type="text" id="title" name="agent_name" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->agent_name:'' }}">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Address  </label>
                            <input type="text" id="title" name="address" class="form-control" data-validation="required"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->address:'' }}">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label>Country</label>

                            <select name="country" class="form-control" data-validation="required">
                                <option value="">Select</option>
                                @foreach($countries as $sec)
                                <option value="{{ $sec->id }}" {{ isset($detail) && !empty($detail->cities_id) && $detail->city->country->id == $sec->id ?'selected':($sec->id == 3?'selected':'') }}> {{ $sec->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label>City</label>

                            <select name="city" class="form-control" data-validation="required">
                                <option value="">Select</option>
                                @foreach($agentcities as $sec)
                                <option value="{{ $sec->id }}" data-country="{{$sec->country->id}}" {{ isset($detail) && !empty($detail->cities_id) && $detail->cities_id == $sec->id ?'selected':'' }}> {{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                                   @if(isset($detail)&&!is_null($detail) && !empty($detail->phone))
                        @php
                        $phone = explode(',', $detail->phone);
                   $count = 0;
                        @endphp
                        @foreach($phone as $p)
                        @php $count++; @endphp

                        @if(!empty($p))
                        <div class="col-sm-6 form-group">
                            <label>Phone {{$count}} </label>
                            <input type="number" id="title" name="phone[]" class="form-control number-style"
                            value="{{ $p }}"   data-validation="required" >
                        </div>
                        @if(count($phone) == 1)
                          <div class="col-sm-6 form-group">
                            <label>Phone 2</label>
                            <input type="number" id="title" name="phone[]" class="form-control number-style">
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @else
                        <div class="col-sm-6 form-group">
                            <label>Phone 1 </label>
                            <input type="number" id="title"   data-validation="required" name="phone[]" class="form-control number-style">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Phone 2</label>
                            <input type="number" id="title" name="phone[]" class="form-control number-style">
                        </div>
                        @endif
                        @if(isset($detail)&&!is_null($detail) && !empty($detail->mobile))
                        @php
                        $count = 0;
                        $mobile = explode(',', $detail->mobile);
                        @endphp
                        @foreach($mobile as $p)
                         @php $count++; @endphp

                        @if(!empty($p))
                        <div class="col-sm-6 form-group">
                            <label> @if($count == 2) whatsapp <small class="text-danger">(with country code)</small> @else Mobile {{$count}} @endif </label> 
                            <span style="float:right">
                            @if($count == 2)
                                <input type="checkbox" name="mobile_1_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->mobile_1_public == '1'?'checked':'' }}> Show publicly
                                @else
                                <input type="checkbox" name="address_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->address_public == '1'?'checked':'' }}> Show publicly
                                @endif
                            </span>
                            <input type="number" id="title" name="mobile[]" class="form-control  number-style"
                                data-validation="required" value="{{ $p }}"  maxlength="11">
                        </div>
                          <!-- @if(count($mobile) == 1)
                           <div class="col-sm-6 form-group">
                            <label>Whatsapp</label>
                            <input type="number" id="title" name="mobile[]" class="form-control number-style"
                               maxlength="11">
                        </div>
                          @endif -->
                        @endif
                        @endforeach
                        @else
                        <div class="col-sm-6 form-group">
                            <label>Mobile 1   </label> <span style="float:right"><input type="checkbox" name="mobile_1_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->mobile_1_public == '1'?'checked':'' }}>  Show publicly </span>
                            <input type="number" id="title"   data-validation="required" name="mobile[]" class="form-control number-style"
                              maxlength="11">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Whatsapp <small class="text-danger">(with country code)</small> </label>  <span style="float:right"><input type="checkbox" name="address_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->address_public == '1'?'checked':'' }}>  Show publicly </span>
                            <input type="number" id="title" name="mobile[]" class="form-control number-style"
                               maxlength="11" value="0092">
                        </div>
                        @endif
</div>
                      <!--   <div class="new_image row"></div>
                              <div class="form-group text-center">
                                          <a href="javascript:void(0);" class="addmore  btn-primary btn pull-right"
                                              id="addmore">Add More Mobile</a>
                                          <div class="clearfix"></div>
                              </div> -->
                     
<div class="row">
                        @if(isset($detail)&&!is_null($detail) && !empty($detail->email))
                        @php
                        $email = explode(',',$detail->email);
                        @endphp
                        @foreach($email as $e)
                        <div class="col-sm-6 form-group">
                            <label>Email </label>  <span style="float:right"><input type="checkbox" name="email_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->email_public == '1'?'checked':'' }}>  Show publicly </span>
                            <input type="text" id="title" name="email[]" class="form-control" value="{{$e}}">
                        </div>
                        @endforeach
                        @else
                        <div class="col-sm-6 form-group">
                            <label>Email </label> <span style="float:right"><input type="checkbox" name="email_public" value="1" {{ isset($detail)&&!is_null($detail) && $detail->email_public == '1'?'checked':'' }}>  Show publicly </span>
                            <input type="text" id="title" name="email[]" class="form-control" data-validation="email">
                        </div>
                        @endif
                        <div class="col-sm-6 form-group">
                            <label>Website</label>
                            <input type="text" id="title" name="website" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->website:'' }}">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Description  </label>
                            <textarea name="description" rows="4" class="form-control ">{{ isset($detail)&&!is_null($detail)?str_replace('<br />','',$detail->description):'' }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #7a7ea7b5;">
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label>Type</label>
                            <select name="type" class="form-control select2" data-validation="required">
                                <option value="">Select</option>
                                @foreach($types as $sec)
                                <option value="{{ $sec->id }}"
                                    {{ isset($detail)&& $detail->agent_type_id == $sec->id ?'selected':'' }}>
                                    {{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(isset($detail)&&!is_null($detail->dtsAttachments()->where('active',1)->first()))
                        <div class="col-sm-3 form-group pr-0">
                            <label>Attach DTS License</label>
                            <input type="file" id="title" name="dts_attachment" class="form-control">
                        </div>
                        <div class="col-sm-1 form-group">
                            <label for="">&nbsp;</label>
                            <p><a href="{{url('storage/uploads/agents/'.$detail->dtsAttachments()->where('active',1)->first()->file)}}" target="_blank" class="btn btn-primary btn-sm">View </a></p>
                        </div>
                        @else
                        <div class="col-sm-4 form-group">
                            <label>Attach DTS License</label>
                            <input type="file" id="title" name="dts_attachment" class="form-control">
                        </div>
                        @endif
                        @if(isset($detail)&&!is_null($detail->iata_attachment))
                        <div class="col-sm-3 form-group pr-0">
                            <label>Attach IATA License</label>
                            <input type="file" id="title" name="iata_attachment" class="form-control">
                        </div>
                        <div class="col-sm-1 form-group">
                            <label for="">&nbsp;</label>
                            <p><a href="{{url('storage/uploads/agents/'.$detail->iata_attachment)}}" target="_blank" class="btn btn-primary btn-sm">View</a></p>
                        </div>
                        @else
                        <div class="col-sm-4 form-group">
                            <label>Attach IATA License</label>
                            <input type="file" id="title" name="iata_attachment" class="form-control">
                        </div>
                        @endif
                        <div class="col-sm-6 form-group">
                            <label>IATA Number</label>
                            <input type="text" id="title" name="iata_license" class="form-control "
                                value="{{ isset($detail)&&!is_null($detail)?$detail->iata_license:'' }}">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>IATA Expiry Date</label>
                            <input type="text" id="title" name="iata_expairy" class="form-control datepicker number-style"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->iata_expairy:'' }}">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>DTS Number</label>
                            <input type="text" id="title" name="dsl_license" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->dsl_license:'' }}">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>DTS License Expiry Date</label>
                            <input type="text" id="title" name="dsl_expairy" class="form-control datepicker number-style"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->dsl_expairy:'' }}">
                        </div>
                        
                        <!-- <div class="col-sm-6 form-group">
                            <label>Recomended Status</label>
                            <input type="text" id="title" name="recomended_status" class="form-control "
                                value="{{ isset($detail)&&!is_null($detail)?$detail->recomended_status:'' }}">
                        </div> -->
                    </div>
                </div>
                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #e2c38ad9;">
                    <input type="hidden" name="id" value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">

                    <div class="row">





                        <!--    <div class="col-sm-4 form-group">
                                  <label>Secondary Phone</label>
                                  <input type="text" id="title" name="secondary_phone" class="form-control" value="{{ isset($detail)&&!is_null($detail)?$detail->secondary_phone:'' }}" >
                               </div>
                               <div class="col-sm-4 form-group">
                                  <label>Mobile</label>
                                  <input type="text" id="title" name="mobile" class="form-control"  value="{{ isset($detail)&&!is_null($detail)?$detail->mobile:'' }}" >
                               </div>
                                  <div class="col-sm-4 form-group">
                                  <label>Secondary Mobile</label>
                                  <input type="text" id="title" name="secondary_mobile" class="form-control" value="{{ isset($detail)&&!is_null($detail)?$detail->secondary_mobile:'' }}" >
                               </div> -->
                        <!-- <div class="col-sm-3 form-group">
                            <label>Fax</label>
                            <input type="text" id="title" name="fax" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->fax:'' }}">
                        </div> -->


                        <div class="col-sm-4 form-group">
                            <label>Facebook</label>
                            <input type="text" i name="facebook" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->facebook:'' }}">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Twitter</label>
                            <input type="text" i name="twitter" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->twitter:'' }}">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>YouTube</label>
                            <input type="text" i name="youtube" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->youtube:'' }}">
                        </div>
              
                        <div class="col-sm-4 form-group">
                            <label>Linkedin</label>
                            <input type="text" i name="linkedin" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->linkedin:'' }}">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Instagram</label>
                            <input type="text" i name="insta" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->insta:'' }}">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Tiktok</label>
                            <input type="text" i name="tiktok" class="form-control"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->tiktok:'' }}">
                        </div>
                    </div>
                </div>
                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #9ec9e4;">
                    <div class="row">
                        @if(isset($detail)&&!is_null($detail)?$detail->logo:'')
                        <div class="col-md-4">
                            <img src="{{url('storage/uploads/agents/'.$detail->logo)}}"
                                style="width: 100%;height: 200px">
                        </div>
                        @endif
                        @if(isset($detail)&&!is_null($detail)?$detail->cover:'')
                        <div class="col-md-8" id="addCover">
                            <img src="{{url('storage/uploads/agents/'.$detail->cover)}}"
                                style="width: 100%;height: 200px">
                        </div>
                        @endif
                    </div>
                    <div class="row">


                        <div class="col-sm-6 form-group">
                            <label>Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Cover</label>
                            <input type="file" name="cover" class="form-control coverField">
                        </div>
                    </div>
                </div>
                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #89b5bdd4;">
                    <div class="row">
                        <div class="col-sm-12">
                            <hr>

                            <h3>Timings</h3>
                        </div>
                        @if(isset($detail)&&!is_null($detail->agentTimings) && $detail->agentTimings->count() > 0)
                        <div class="col-4 ">
                        <label>Day</label>
                        </div>
                        <div class="col-4 ">
                        <label>Opening</label>
                        </div>
                        <div class="col-4 ">
                        <label>Closing</label>
                        </div>
                        @foreach($detail->agentTimings as $t)
                       
                        <div class="col-4 form-group">
                           
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="{{  $t->day }}"
                                readonly>
                        </div>
                        <div class="col-4 form-group">
                        <select name="opening[]" id="firstOpenTime" class="form-control number-style timming {{$t->day == 'Monday'?'monday_start':'start_timming'}}">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}" {{$i == $t->opening?'selected':''}}>{{ $i }}</option>
												@endforeach
											</select>
                       
                        </div>
                        <div class="col-4 form-group">
                        <select name="closing[]" id="firstCloseTime" class="form-control number-style timming  {{$t->day == 'Monday'?'monday_end':'end_timming'}} ">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}"  {{$i == $t->closing?'selected':''}}>{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        @endforeach
                        @else
                        <div class="col-4 form-group">
                            <label>Day</label>
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Monday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label>Opening</label>
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming monday_start">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <label>Closing</label>
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming monday_end">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Day</label> -->
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Tuesday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Opening</label> -->
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming start_timming">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Closing</label> -->
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Day</label> -->
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Wednesday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Opening</label> -->
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming start_timming">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Closing</label> -->
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Day</label> -->
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Thursday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Opening</label> -->
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming start_timming">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Closing</label> -->
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Day</label> -->
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Friday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Opening</label> -->
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming start_timming">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Closing</label> -->
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Day</label> -->
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Saturday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Opening</label> -->
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming start_timming">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Closing</label> -->
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Day</label> -->
                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Sunday" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Opening</label> -->
                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming start_timming">
												<option value="">Opening Time</option>
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        <div class="col-4 form-group">
                            <!-- <label>Closing</label> -->
                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
												<option value="Close">Close</option>
												<option value="00:00">00:00</option>
												@foreach(get_minutes("00:30", "23:00") as $i)
												<option value="{{ $i }}">{{ $i }}</option>
												@endforeach
											</select>
                        </div>
                        @endif

                    </div>
                 

                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-5">
                            <input type="submit" name="save" value="Save" class="btn btn-primary">
                            <input type="reset" value="Reset" class="btn btn-default">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@push('script')
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script>
    $(".timming").inputmask({"mask": "9:99"});
    $(".phone-number").inputmask({"mask": "999-999999999"});
    $(".mobile-number").inputmask({"mask": "9999-9999999"});
    var plan = $('#plan_id option:selected').data('price');

var period = $('#period option:selected').val();


   var price = plan * period;
   if(!isNaN(price)){
    $('#price').html('Total Price : <strong>' + price + '</strong>');
    $('#subs_price').val(price);
}

$("#plan_id").change(function() {
    var plan = $('#plan_id option:selected').data('price');
    var id = $('#plan_id option:selected').val();
    var period = $('#period option:selected').val();
    var price = plan * period;
    $('#price').html('Total Price : <strong>' + price + '</strong>');
    $('#subs_price').val(price);
    var url = "{{request()->url()}}";
    window.location.href = url+'?subscription='+id;
});


$("#period").change(function() {
    var plan = $('#plan_id option:selected').data('price');

    var period = $('#period option:selected').val();
    var price = plan * period;
    $('#subs_price').val(price);
    $('#price').html('Total Price : <strong>' + price + '</strong>');
});
$(".monday_start").change(function() {
    var time = $('.monday_start').val();
    $('.start_timming').val(time);
});
$(".monday_end").change(function() {
    var time = $('.monday_end').val();
    $('.end_timming').val(time);
});
var count = 2;
$("#addmore").click(function() {

    var number_html =
    '  <div class="col-sm-6 form-group">\
    <label style="display:block">Mobile <a href="javascript:;" class="removeNo  btn-danger btn-sm " style="float:right" > &times;</a></label>\
    <input type="text" id="title" name="mobile[]" class="form-control mobile-number number-style" data-validation="required">\
    </div> </div>';

    $(".new_image").append(number_html);
    $(".mobile-number").inputmask({"mask": "9999-9999999"});
    count++;

    $(".removeNo").click(function() {
        $(this).closest('.form-group').remove();
        count--;

        $("#addmore").show();
    });
});
if($('#addCover').length){
    $(".coverField").change(function(evt) {
     var files = evt.target.files;
  var reader = new FileReader();

  reader.onload = function(frEvent) {
      document.getElementById("addCover").innerHTML = '<img src="'+frEvent.target.result+'"   style="width: 100%;height: 200px" />';
  }
  reader.readAsDataURL(files[0]);
});
}
$(document).ready(function(){

    function filterCities() {
        let selectedCountry = $('select[name="country"]').val();

        $('select[name="city"] option').each(function(){
            let optionCountry = $(this).data('country');

            // Always keep "Select" option
            if ($(this).val() === "") {
                $(this).show();
                return;
            }

            if (optionCountry == selectedCountry) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Reset the selected city if hidden
        let selectedCity = $('select[name="city"]').val();
        let selectedCityCountry = $('select[name="city"] option:selected').data('country');

        if (selectedCity && selectedCityCountry != selectedCountry) {
            $('select[name="city"]').val("");
        }

        // Refresh select2 if you use it
        $('select[name="city"]').trigger('change.select2');
    }

    // Run when country changes
    $('select[name="country"]').on('change', filterCities);

    // Run once by default when page loads
    filterCities();
});

</script>
@endpush