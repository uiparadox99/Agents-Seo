@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add/Edit {{request()->path() == 'admin/add-agent' || str_contains(request()->path(), 'admin/edit-agent')?'':'Foreign'}} Agent
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations"
                            action="{{ route('admin.save-agent') }}" enctype="multipart/form-data" id="myModal">
                             @if(request()->path() == 'admin/add-agent' || str_contains(request()->path(), 'admin/edit-agent'))
                             @else
                              <input type="hidden" name="is_foreign" value="1">
                             @endif
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    
                        
                            <div class="row">
                                @if(isset($detail)&&!is_null($detail)?$detail->logo:'')
                                <div class="col-md-4">
                                    <img src="{{url('storage/uploads/agents/'.$detail->logo)}}"
                                    style="width: 100%;height: 200px">
                                </div>
                                @endif
                                @if(isset($detail)&&!is_null($detail)?$detail->cover:'')
                                <div class="col-md-8">
                                    <img src="{{url('storage/uploads/agents/'.$detail->cover)}}"
                                    style="width: 100%;height: 200px">
                                </div>
                                @endif
                            </div>
                            <input type="hidden" name="edit_id"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                            <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #8fd88fb5;">
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Business Name</label>
                                        <input type="text" id="title" name="business_name" class="form-control"
                                        data-validation="required"
                                        value="{{ isset($detail)&&!is_null($detail)?$detail->business_name:'' }}">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Owner Name</label>
                                        <input type="text" id="title" name="agent_name" class="form-control"
                                        value="{{ isset($detail)&&!is_null($detail)?$detail->agent_name:'' }}">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Address</label>
                                        <input type="text" id="title" name="address" class="form-control" data-validation="required"
                                        value="{{ isset($detail)&&!is_null($detail)?$detail->address:'' }}">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>City</label>
                                        <select name="city" class="form-control select2" data-validation="required">
                                            <option value="">Select</option>
                                            @foreach($cities as $sec)
                                            <option value="{{ $sec->id }}"
                                                {{ isset($detail)&& $detail->cities_id == $sec->id ?'selected':'' }}>
                                                {{ $sec->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                    @if(isset($detail)&&!is_null($detail) && !empty($detail->phone))
                                    @php
                                    $phone = explode(',', $detail->phone);
                                    $count = 0;
                                    @endphp
                                    @foreach($phone as $p)
                                    @php $count++; @endphp
                                    @if(!empty($p))
                                    <div class="col-sm-6 form-group">
                                        <label>Phone {{$count}}</label>
                                        <input type="text" id="title" name="phone[]" class="form-control number-style"
                                        value="{{ $p }}"   data-validation="required" >
                                    </div>
                                    @if(count($phone) == 1)
                                    <div class="col-sm-6 form-group">
                                        <label>Phone 2</label>
                                        <input type="text" id="title" name="phone[]" class="form-control number-style">
                                    </div>
                                    @endif
                                    @endif
                                    @endforeach
                                    @else
                                    <div class="col-sm-6 form-group">
                                        <label>Phone 1</label>
                                        <input type="text" id="title"   data-validation="required" name="phone[]" class="form-control number-style">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Phone 2</label>
                                        <input type="text" id="title" name="phone[]" class="form-control number-style">
                                    </div>
                                    @endif
                                    @if(isset($detail)&&!is_null($detail) && !empty($detail->mobile))
                                    @php
                                    $mobile = explode(',', $detail->mobile);
                                       $count = 0;
                                    @endphp
                                    @foreach($mobile as $p)
                                  @php $count++; @endphp
                                    @if(!empty($p))
                                    <div class="col-sm-6 form-group">
                                        <label>Mobile {{$count}}</label>
                                        <input type="text" id="title" name="mobile[]" class="form-control  number-style"
                                        data-validation="required" value="{{ $p }}"  maxlength="11">
                                    </div>
                                    @if(count($mobile) == 1)
                                    <div class="col-sm-6 form-group">
                                        <label>Mobile 2</label>
                                        <input type="text" id="title" name="mobile[]" class="form-control number-style"
                                        maxlength="11">
                                    </div>
                                    @endif
                                    @endif
                                    @endforeach
                                    @else
                                    <div class="col-sm-6 form-group">
                                        <label>Mobile 1</label>
                                        <input type="text" id="title"  name="mobile[]" class="form-control number-style"
                                        maxlength="11">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Mobile 2</label>
                                        <input type="text" id="title" name="mobile[]" class="form-control number-style"
                                        maxlength="11">
                                    </div>
                                    @endif
                                </div>
                            <!--     <div class="new_image row"></div>
                            <div class="form-group text-center" style="text-align: center;">
                                <a href="javascript:void(0);" class="addmore  btn-primary btn pull-right"
                                id="addmore">Add More Mobile</a>
                                <div class="clearfix"></div>
                            </div>
                             -->
                                <div class="row">
                                    @if(isset($detail)&&!is_null($detail) && !empty($detail->email))
                                    @php
                                    $email = explode(',',$detail->email);
                                    @endphp
                                    @foreach($email as $e)
                                    <div class="col-sm-6 form-group">
                                        <label>Email</label>
                                        <input type="text" id="title" name="email[]" class="form-control" value="{{$e}}">
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col-sm-6 form-group">
                                        <label>Email</label>
                                        <input type="text" id="title" name="email[]" class="form-control">
                                    </div>
                                    @endif
                                    <div class="col-sm-6 form-group">
                                        <label>Website</label>
                                        <input type="text" id="title" name="website" class="form-control"
                                        value="{{ isset($detail)&&!is_null($detail)?$detail->website:'' }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Description</label>
                                        <textarea name="description" rows="4" class="form-control ">{{ isset($detail)&&!is_null($detail)?str_replace('<br />','',$detail->description):'' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #7a7ea7b5;">
                                <div class="row">
                                    <div class="col-sm-6 form-group">
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
                                        <div class="col-sm-6 form-group">
                                            <label>IATA License</label>
                                            <input type="text" id="title" name="iata_license" class="form-control "
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->iata_license:'' }}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>IATA License Expiry</label>
                                            <input type="text" id="title" name="iata_expairy" class="form-control datepicker number-style"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->iata_expairy:'' }}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>DTS License</label>
                                            <input type="text" id="title" name="dsl_license" class="form-control"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->dsl_license:'' }}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>DTS License Expiry</label>
                                            <input type="text" id="title" name="dsl_expairy" class="form-control datepicker number-style"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->dsl_expairy:'' }}">
                                        </div>
                                        @if(isset($detail)&&!is_null($detail))
                                        <div class="col-sm-4 form-group">
                                            <label>DTS Attachment</label>
                                            <input type="file" id="title" name="dts_attachment" class="form-control">
                                        </div>
                                        <?php if (!empty($detail->dts_attachment)): ?>
                                            <div class="col-sm-2 form-group">
                                                <label for="">&nbsp;</label>
                                                <p><a href="{{url('storage/uploads/agents/'.$detail->dts_attachment)}}" target="_blank" class="btn btn-primary btn-sm">View DTS File</a></p>
                                            </div>
                                        <?php endif ?>
                                        @else
                                        <div class="col-sm-6 form-group">
                                            <label>DTS Attachment</label>
                                            <input type="file" id="title" name="dts_attachment" class="form-control">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #e2c38ad9;">

                                    <div class="row">

                                        <div class="col-sm-3 form-group">
                                            <label>Facebook</label>
                                            <input type="text" id="title" name="facebook" class="form-control"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->facebook:'' }}">
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label>Twitter</label>
                                            <input type="text" id="title" name="twitter" class="form-control"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->twitter:'' }}">
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label>YouTube</label>
                                            <input type="text" id="title" name="youtube" class="form-control"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->youtube:'' }}">
                                        </div>

                                        <div class="col-sm-3 form-group">
                                            <label>WhatsApp</label>
                                            <input type="text" id="title" name="whatsapp" class="form-control"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->whatsapp:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0;    background: #9ec9e4;">

                                    <div class="row">


                                        <div class="col-sm-6 form-group">
                                            <label>Logo</label>
                                            <input type="file" name="logo" class="form-control">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Cover</label>
                                            <input type="file" name="cover" class="form-control">
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
                                        <div class="col-xs-4 ">
                                            <label>Day</label>
                                        </div>
                                        <div class="col-xs-4 ">
                                            <label>Opening</label>
                                        </div>
                                        <div class="col-xs-4 ">
                                            <label>Closing</label>
                                        </div>
                                        @foreach($detail->agentTimings as $t)

                                        <div class="col-xs-4 form-group">

                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="{{  $t->day }}"
                                            readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <select name="opening[]" id="firstOpenTime" class="form-control number-style timming {{$t->day == 'Monday'?'monday_start':'start_timming'}}">
                                                <option value="">Opening Time</option>
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}" {{$i == $t->opening?'selected':''}}>{{ $i }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <label>Day</label>
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Monday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <label>Closing</label>
                                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming monday_end">
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Day</label> -->
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Tuesday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Closing</label> -->
                                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Day</label> -->
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Wednesday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Closing</label> -->
                                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Day</label> -->
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Thursday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Closing</label> -->
                                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Day</label> -->
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Friday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Closing</label> -->
                                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Day</label> -->
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Saturday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Closing</label> -->
                                            <select name="closing[]" id="firstCloseTime" class="form-control number-style timming end_timming">
                                                <option value="Close">Close</option>
                                                <option value="00:00">00:00</option>
                                                @foreach(get_minutes("00:30", "23:00") as $i)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-4 form-group">
                                            <!-- <label>Day</label> -->
                                            <input type="text" id="title" name="day[]" class="form-control number-style" value="Sunday" readonly>
                                        </div>
                                        <div class="col-xs-4 form-group">
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
                                        <div class="col-xs-4 form-group">
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
                                             <label><input type="checkbox" name="active" value="1" {{isset($detail) && $detail->active == 1?'checked':''}}> Is Active?</label>
                                             </div>
                                        <div class="col-sm-6 col-sm-offset-5">
                                            <input type="submit" name="save" value="Save" class="btn btn-primary">
                                            <input type="reset" value="Reset" class="btn btn-default">
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                <div class="col-md-6">
                                    @if(isset($detail) && !empty($detail))
                                        @if(!is_null($detail->agentGallery))
                                            <h3>Gallery</h3>
                                            <hr>
                                            <div class="row">
                                                @foreach($detail->agentGallery as $r)
                                                <div class="col-md-6">
                                                   <div  style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 10px;margin-top: 10px;margin-bottom: 10px;" data-id="{{ $r->id }}"> 
                                               



                                                       <form id="submitactive" method="post" action="{{url('active-gallery')}}">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="id" value="{{$r->id}}">
                                                        <label style="width: 100%">  Active / Inactive <input type="checkbox" style="float: right;transform: scale(1.5);" name="active" value="1" onclick="submit() "  {{$r->active == 1?'checked':''}}> </label>
                                                    </form>

                                                <img src="{{url('storage/uploads/agents/'.$r->image)}}"
                                                style="width: 100%;height: 250px;">
                                            </div>
                                        </div>
                                        @endforeach
                                            </div>
                                        @endif
                                    @endif
                                    @if(isset($detail) && !empty($detail))
                                        @if(!is_null($detail->agentDeals))
                                            <h3>Promotions</h3>
                                            <hr>
                                            <div class="row">
                                                @foreach($detail->agentDeals as $r)
                                                <div class="col-md-6">
                                                   <div  style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 10px;margin-top: 10px;margin-bottom: 10px;" data-id="{{ $r->id }}"> 
                                               



                                                       <form id="submitactive" method="post" action="{{url('promotion-gallery')}}">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="id" value="{{$r->id}}">
                                                        <label style="width: 100%">  Active / Inactive <input type="checkbox" style="float: right;transform: scale(1.5);" name="active" value="1" onChange="submit() "  {{$r->active == 1?'checked':''}}> </label>
                                                    </form>

                                                <img src="{{url('storage/uploads/agents/'.$r->image)}}"
                                                style="width: 100%;">
                                            </div>
                                        </div>
                                        @endforeach
                                            </div>
                                        @endif
                                    @endif
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

</script>
@endpush