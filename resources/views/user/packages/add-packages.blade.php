@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
            <form method="post" class="has-callback-validations content-box-agent"
                action="{{ route('user.save-packages') }}" enctype="multipart/form-data">
                <h3 class="box-title text-center">Add Umrah Package </h3>
                <hr>
                @csrf
                <input type="hidden" name="id" value="{{ isset($detail)&&!is_null($detail) && !request()->has('copy')?$detail->id:'' }}">
                <div class="row">
                    <div class="col-md-4 offset-md-4">

                        @if(isset($detail) && !is_null($detail->image))
                        <img class="file" src="{{ url('storage/uploads/packages/'.$detail->image) }}" alt="your image"
                            style="width: 150px;" />
                        @else
                        <img class="file" src="{{ url('images/placeholder.jpg') }}" alt="your image"
                            style="width: 150px;" />
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="form-group col-md-4">
                        <div class="row">
                            @if(isset($detail)&&!is_null($detail->image))
                            <div class="col-sm-12">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control" value="" onchange="readURL(this);">
                            </div>
                            @else
                            <div class="col-sm-12 ">
                                <label for="">Image</label>
                                <input type="file" name="image" onchange="readURL(this);" class="form-control"
                                    data-validation="required" value="">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Title</label>
                        <input type="text" name="name" class="form-control" id="title" placeholder="Package Title"
                            data-validation="required" value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">
                    </div>
                    <div class="form-group col-md-4 pr-1 pl-1">
                        <label for="">Nights</label>
                        <input type="text" name="nights" class="form-control priceFormate" id="sector"
                            placeholder="Nights" data-validation="required"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->nights:'' }}">
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <h4 class="mb-2">Flight Detail</h4>
                        <hr>
                    </div>
                    <div class="col-sm-3 form-group ">
                        <label for="">Airline</label>
                        <select class="form-control" name="airlines_id">
                            <option value="">Airline</option>
                            @foreach($airlines as $a)
                            <option value="{{ $a->id }}" {{ isset($detail)&&!is_null($detail) && $a->id ==
                                $detail->airlines_id ? 'selected' : '' }}>{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-6 form-group">
                        <label>From</label>
                        <select id="from" class="form-control " data-validation="required" name="from" style="">
                            <option value=""> Select </option>
                            @foreach($from as $c)
                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->from ==
                                $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group  col-3 col-md-3">
                        <label>To</label>
                        <select id="to" class="form-control" data-validation="required" name="to" style="">
                            <option value=""> Select </option>
                            @foreach($cities as $c)
                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->to ==
                                $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class=" red-color">Via Location</label>
                        <select id="extra_from" class="form-control " name="extra_via" style="">
                            <option value=""> Select </option>
                            @foreach($via as $c)
                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->extra_via ==
                                $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-3 pr-1 d-none">
                                <label for="">Sector</label>
                                <input type="text" name="sector" class="form-control" id="sector"
                                    placeholder="Sector" data-validation="required"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->sector:'' }}">
                            </div> -->

                    <div class="form-group col-md-4 ">
                        <label for="">Flight #</label>
                        <input type="text" name="flight" class="form-control" id="flight" placeholder="Flight #"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->flight:'' }}">
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="">Date</label>
                        <input type="text" name="departure_date" class="form-control datepicker" id="departure_date"
                            placeholder="Departure Date"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->departure_date:'' }}">
                    </div>

                    <div class="form-group col-md-4 pl-1 pr-1">
                        <div class="row">
                            <div class="col-6 pr-1">
                                <label for="">DEP Time</label>
                                <input type="text" name="departure_time" class="form-control timeMask" id="departure_time"
                                    placeholder="DEP Time"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->departure_time:'' }}">
                            </div>
                            <div class="col-6 pl-1">
                                <label for="">ARR Time</label>
                                <input type="text" name="arrival_time" class="form-control timeMask" id="arrival_time"
                                    placeholder="ARR Time"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->arrival_time:'' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row via_fields" style="{{isset($detail) && !empty($detail->extra_flight_code1)?'':'display: none;'}}">
                    <div class="col-md-4 col-6 via-first form-group">
                        <label class=" via-first red-color"><span class="viaflightnumber"
                                style="color: #070c39;font-weight: 500"></span>&nbsp;</label>
                        <input type="text" class="form-control flightNumber number-style" pattern="[a-zA-Z0-9\s]+"
                            data-validation="required" maxlength="6" name="extra_flight_code1"
                            value="{{ isset($detail)  && !is_null($detail)?$detail->extra_flight_code1:''}}"
                            placeholder="Flight Number" />
                    </div>
                    <div class="col-md-4 col-6 via-first form-group">
                        <label class=" via-first red-color"><span class="secondFlight"></span> &nbsp;</label>
                        <input type="text" placeholder="DD-MMM-YYYY" class="form-control  number-style datepicker"
                            data-validation="required" id="extra_trancend_date" name="extra_trancend_date"
                            value="{{ isset($detail)  && !is_null($detail) && !empty($detail->extra_trancend_date)? date('d-M-Y', strtotime($detail->extra_trancend_date)) :''}}" />
                    </div>
                    <!--<div class="col-md-4 col-6 via-first form-group">-->
                    <!--   <label class=" via-first red-color"><span class="secondFlight"></span> &nbsp;</label>-->
                    <!--   <select class="form-control" name="extra_trancend_date" data-validation="required">-->
                    <!--   <option value="same" {{ isset($detail)  && !is_null($detail) && ($detail->extra_trancend_date == "same")?"selected='selected'":''}}>Same Day</option>-->
                    <!--   <option value="next" {{ isset($detail)  && !is_null($detail) && ($detail->extra_trancend_date == "next")?"selected='selected'":''}}>Next Day</option>-->
                    <!--   </select>-->
                    <!--</div>-->
                    <div class="col-md-2 col-6  pl-1 pr-1 via-first form-group">
                        <label class="via-first"><span class="secondDeparture"></span> Departure</label>
                        <input type="text" placeholder="HH:MM" data-validation="required"
                            class="form-control timeMask  number-style time-formate" name="extra_one_way_departure_h1"
                            value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_departure_time1)? date('H:i',strtotime($detail->extra_one_way_departure_time1)) : ''}}" />
                    </div>
                    <div class="col-md-2 col-6  pl-1 pr-1 form-group via-first">
                        <label class="via-first"><span class="secondArival"></span> Arrival </label>
                        <input type="text" placeholder="HH:MM" data-validation="required"
                            class="form-control timeMask  number-style time-formate" name="extra_one_way_arrival_h1"
                            value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_arrival_time1)? date('H:i',strtotime($detail->extra_one_way_arrival_time1)) :''}}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h4 class="mb-2">Return Detail</h4>
                        <hr>
                    </div>
                    <div class="form-group  col-3 col-md-4">
                        <label>From</label>
                        <select id="return_from" class="form-control" data-validation="required" name="return_from" style="">
                            <option value=""> Select </option>
                            @foreach($cities as $c)
                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->return_from ==
                                $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-6 form-group">
                        <label>To</label>
                        <select id="return_to" class="form-control " data-validation="required" name="return_to" style="">
                            <option value=""> Select </option>
                            @foreach($from as $c)
                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->return_to ==
                                $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4  form-group return-wrapper">
                        <label class="return-wrapper red-color">Via Location</label>
                        <select id="extra_r_from" class="form-control " name="extra_r_via">
                            <option value=""> Select </option>
                            @foreach($via as $c)
                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->extra_r_via
                                == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- <div class="form-group col-md-3 pr-1">
                                <label for="">Sector</label>
                                <input type="text" name="return_sector" class="form-control" id="return_sector"
                                    placeholder="Return Sector" data-validation="required"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->return_sector:'' }}">
                            </div> -->

                    <div class="form-group col-md-4">
                        <label for="">Flight #</label>
                        <input type="text" name="return_flight" class="form-control" id="flight" placeholder="Flight #"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->return_flight:'' }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Return Date</label>
                        <input type="text" name="return_departure_date" class="form-control datepicker"
                            id="return_departure_date" placeholder="Return Date"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->return_departure_date:'' }}">
                    </div>

                    <div class="form-group col-md-4  pl-1 pr-1">
                        <div class="row">
                            <div class="col-6 pr-1">
                                <label for="">DEP Time</label>
                                <input type="text" name="return_departure_time" class="form-control timeMask"
                                    id="return_departure_time" placeholder="DEP Time"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->return_departure_time:'' }}">
                            </div>
                            <div class="col-6 pl-1">
                                <label for="">ARR Time</label>
                                <input type="text" name="return_arrival_time" class="form-control timeMask"
                                    id="return_arrival_time" placeholder="ARR Time"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->return_arrival_time:'' }}">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row return_via_fields" style="{{isset($detail) && !empty($detail->extra_r_flight_code1)?'':'display: none;'}}">
                    <div class="col-md-4 col-6 form-group via-second">
                        <label class="via-second red-color"><span class="secondReturnFlight returnviaflightnumber"
                                style="color: #070c39;font-weight: 500"></span>&nbsp;</label>
                        <input type="text" class="form-control flightNumber number-style" pattern="[a-zA-Z0-9\s]+"
                            data-validation="required" maxlength="6" name="extra_r_flight_code1"
                            value="{{ isset($detail)  && !is_null($detail)?$detail->extra_r_flight_code1:''}}"
                            placeholder="Flight Number" />
                    </div>
                    <div class="col-md-4 col-6 via-second form-group">
                        <label>&nbsp;</label>
                        <input type="text" placeholder="DD-MMM-YYYY" class="form-control  number-style datepicker"
                            data-validation="required" id="extra_r_trancend_date" name="extra_r_trancend_date"
                            value="{{ isset($detail)  && !is_null($detail) && !empty($detail->extra_r_trancend_date)? date('d-M-Y', strtotime($detail->extra_r_trancend_date)) :''}}" />
                    </div>
                    <!--<div class="col-md-4 col-6 via-second">-->
                    <!--   <label>&nbsp;</label>-->
                    <!--   <select class="form-control" name="extra_r_trancend_date" data-validation="required">-->
                    <!--   <option value="same" {{ isset($detail)  && !is_null($detail) && $detail->extra_r_trancend_date == "same"?"selected='selected'":''}}>Same Day</option>-->
                    <!--   <option value="next" {{ isset($detail)  && !is_null($detail) && ($detail->extra_r_trancend_date == "next")?"selected='selected'":''}}>Next Day</option>-->
                    <!--   </select>-->
                    <!--</div>-->
                    <div class="col-md-2 col-6 form-group via-second">
                        <label class="via-second"><span class="secondReturnDeparture"></span> Departure</label>
                        <input type="text" placeholder="HH:MM" data-validation="required"
                            class="form-control timeMask number-style time-formate" name="extra_return_departure_h1"
                            value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_departure_time1)? date('H:i',strtotime($detail->extra_return_departure_time1))  :''}}" />
                    </div>
                    <div class="col-md-2 col-6 form-group via-second">
                        <label class="via-second"><span class="secondReturnArival"></span> Arrival</label>
                        <input type="text" placeholder="HH:MM" data-validation="required"
                            class="form-control timeMask number-style time-formate" name="extra_return_arrival_h1"
                            value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_arrival_time1)? date('H:i',strtotime($detail->extra_return_arrival_time1)) :''}}" />
                    </div>
                </div>
                <div class="row">


                    <div class="col-md-12">
                        <hr>
                        <h4 class="mb-2">Price Segments:</h4>
                        <hr>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Sharing</label>
                        <input type="text" maxlength="7" name="single_room" class="form-control priceFormate"
                            placeholder="price" value="{{ isset($detail)&&!is_null($detail)?$detail->shairing:'' }}">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Quad Room</label>
                        <input type="text" maxlength="7" name="quad_room" class="form-control priceFormate"
                            placeholder="price" value="{{ isset($detail)&&!is_null($detail)?$detail->quad_room:''}}">

                    </div>

                    <div class="form-group col-md-2">
                        <label for="">Triple Room</label>
                        <input type="text" maxlength="7" name="triple_room" class="form-control priceFormate"
                            placeholder="price" value="{{ isset($detail)&&!is_null($detail)?$detail->triple_room:''}}">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Double Room</label>
                        <input type="text" maxlength="7" name="double_room" class="form-control priceFormate"
                            placeholder="price" value="{{ isset($detail)&&!is_null($detail)?$detail->double_room:''}}">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Child With Bed</label>
                        <input type="text" maxlength="7" name="child_with_bed" class="form-control priceFormate"
                            placeholder="price"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->child_with_bed:''}}">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Child Without Bed</label>
                        <input type="text" maxlength="7" name="child_without_bed" class="form-control priceFormate"
                            placeholder="price"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->child_without_bed:''}}">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Infant</label>
                        <input type="text" maxlength="7" name="infant" class="form-control priceFormate"
                            placeholder="price" value="{{ isset($detail)&&!is_null($detail)?$detail->infant:''}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Hotel Name Makkah</label>
                        <select class="form-control selectcustom2" name="hotel_makkah" id="hotel_makkah" onchange="sethotel('hotel_makkah','similar_hotel_makkah')">
                            <option value="">Select</option>
                            @foreach($makkah_hotels as $a)
                            <option value="{{ $a->id }}" data-name="{{ $a->name }}"
                                data-image="{{ !empty($a->img)?url('storage/uploads/hotels/'.$a->img):'https://placehold.co/400' }}"
                                {{ isset($detail)&&!is_null($detail) && $a->id == $detail->hotel_makkah ? 'selected' :
                                '' }}>{{ $a->name }} {{!is_null($a->distance)?'('.$a->distance->name.')':''}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Hotel Name Madina</label>
                        <select class="form-control selectcustom3" name="hotel_madinah" id="hotel_madinah" onchange="sethotel('hotel_madinah','similar_hotel_madinah')">
                            <option value="">Select</option>
                            @foreach($madinah_hotels as $a)
                            <option value="{{ $a->id }}"  data-name="{{ $a->name }}"
                                data-image="{{ !empty($a->img)?url('storage/uploads/hotels/'.$a->img):'https://placehold.co/400' }}"
                                {{ isset($detail)&&!is_null($detail) && $a->id == $detail->hotel_madinah ? 'selected' :
                                '' }}>{{ $a->name }} {{!is_null($a->distance)?'('.$a->distance->name.')':''}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="">Package Type</label>
                        <select name="stars" class="form-control">
                            <option value="">Package Type</option>
                            <option value="economy" {{ isset($detail)&&!is_null($detail) && $detail->stars ==
                                'economy'?'selected':'' }}>Economy </option>
                            <option value="1" {{ isset($detail)&&!is_null($detail) && $detail->stars ==
                                '1'?'selected':'' }}>Economy Plus</option>
                            <option value="3" {{ isset($detail)&&!is_null($detail) && $detail->stars ==
                                '3'?'selected':'' }}>3 Star</option>
                            <option value="4" {{ isset($detail)&&!is_null($detail) && $detail->stars ==
                                '4'?'selected':'' }}>4 Star</option>
                            <option value="5" {{ isset($detail)&&!is_null($detail) && $detail->stars ==
                                '5'?'selected':'' }}>5 Star</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <h4 class="mb-2">Package Includes:</h4>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="">Handcarry</label>
                        <input type="text" name="carry_on" class="form-control" id="carry_on" placeholder="Carry on"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->carry_on:'' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Luggage</label>
                        <input type="text" name="luggage" class="form-control" id="luggage" placeholder="Luggage"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->luggage:'' }}">
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">Transport</label>
                        <select name="transport" class="form-control">
                            <option value="">Select</option>
                            <option value="Complete Transport" {{ isset($detail)&&!is_null($detail) && $detail->
                                transport == 'Complete Transport'?'selected':'' }}>Complete Transport</option>
                            <option value="Without Transport" {{ isset($detail)&&!is_null($detail) && $detail->transport
                                == 'Without Transport'?'selected':'' }}>Without Transport</option>
                            <option value="Partial Transport" {{ isset($detail)&&!is_null($detail) && $detail->transport
                                == 'Partial Transport'?'selected':'' }}>Partial Transport</option>
                        </select>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="" class="btn-block">&nbsp;</label>
                        <label><input type="checkbox" class="umrah_visa" id="umrah_visa" name="umrah_visa" value="1" {{
                                isset($detail)&&!is_null($detail) && $detail->umrah_visa == '1'?'checked':'' }}>
                            Umrah Visa</label>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="" class="btn-block">&nbsp;</label>
                        <label><input type="checkbox" class="shutle_service" id="shutle_service" name="shutle_service"
                                value="1" {{ isset($detail)&&!is_null($detail) && $detail->shutle_service ==
                            '1'?'checked':'' }}>
                            Shutle Services</label>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label><input type="checkbox" class="similar_hotel_makkah" id="similar_hotel_makkah" name="similar_hotel_makkah"
                                value="1" {{ isset($detail)&&!is_null($detail) && $detail->similar_hotel_makkah ==
                            '1'?'checked':'' }}>
                            Similar Makkah Hotel <span id="similarMakkah"></span></label>
                    </div>
                    <div class="col-sm-6 form-group">
                            <label><input type="checkbox" class="similar_hotel_madinah" id="similar_hotel_madinah" name="similar_hotel_madinah"
                                value="1" {{ isset($detail)&&!is_null($detail) && $detail->similar_hotel_madinah ==
                            '1'?'checked':'' }}>
                            Similar Madina Hotel <span id="similarMadina"></span></label>
                    </div>
                   

                    <div class="form-group col-sm-12">
                        <label>Remarks</label>
                        <textarea class=" form-control" id="content" name="content1"
                            rows="5">{{ isset($detail)&&!is_null($detail)?str_replace('<br />','',$detail->content1):'' }}</textarea>

                    </div>
                    <div class="form-group col-sm-12">
                        <label><input type="checkbox" name="active" value="1" {{isset($detail)&&!is_null($detail) &&
                                $detail->active == 1?'checked':''}}> Active</label>
                    </div>
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
<script type="text/javascript">

    function formatState(state) {
        if (!state.id) return state.text;

        var img = $(state.element).data('image');
        if (!img) return state.text;

        var $state = $(
            '<span><img src="' + img + '" style="height:20px; width:20px; margin-right:6px;" />' + state.text + '</span>'
        );
        return $state;
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#fileHtml').show();
                $('.file').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function () {
        $('#from, #to, #extra_from, #extra_r_from').on('change',
            function () {
                if ($('#from').val() == $('#to').val()) {
                    $(this).val("");
                    toastr["error"]('Departure and destination cities cannot be same');
                }

                if ($('#to').val() != "" && $('#from').val() != "" && ($('#extra_from').val() == $('#to').val() || $('#extra_from').val() == $('#from').val())) {
                    $(this).val("");
                    toastr["error"]('Via location connot be same with departure and destination');

                }

                if ($('#to').val() != "" && $('#from').val() != "" && ($('#extra_r_from').val() == $('#to').val() || $('#extra_r_from').val() == $('#from').val())) {
                    $(this).val("");
                    toastr["error"]('Via location connot be same with departure and destination');

                }
            }
        );
        $("#to").change(function () {
            var from = $('#from option:selected').val();
            var to = $('#to option:selected').val();
            var retrunfrom = $('#return_from').val(to);
            var via = $("#extra_from option:selected").val();
            if (via.length) {
                $('.firstflightNumber').text(from + ' To ' + via);
            } else {

                $('.firstflightNumber').text(from + ' To ' + to);
                $('.returnflightNumber').text(to + ' To ' + from);
            }
        });
        $("#from").change(function () {
            var from = $('#from option:selected').val();
            var via = $("#extra_from option:selected").val();
            var to = $('#to option:selected').val();
            var retrunto = $('#return_to').val(from);
            if (via.length) {
                $('.firstflightNumber').text(from + ' To ' + via);
            } else {

                $('.firstflightNumber').text(from + ' To ' + to);
                $('.returnflightNumber').text(to + ' To ' + from);
            }
        });
        $("#extra_from").change(function () {
            var from = $('#from option:selected').val();
            var to = $('#to option:selected').val();
            var via = $("#extra_from option:selected").val();
            $("#extra_r_from").val(via);
            if (via.length) {
                $('.returnflightNumber').text(to + ' To ' + via);
                $('.returnviaflightnumber').text(via + ' To ' + from);
                $('.return_via_fields').show('slow');
                $('.firstflightNumber').text(from + ' To ' + via);
                $('.viaflightnumber').text(via + ' To ' + to);
            } else {

                $('.firstflightNumber').text(from + ' To ' + to);

            }
        });
        $("#extra_r_from").change(function () {
            var from = $('#from option:selected').val();
            var to = $('#to option:selected').val();
            var via = $("#extra_r_from option:selected").val();
            if (via.length) {
                $('.returnflightNumber').text(to + ' To ' + via);
                $('.returnviaflightnumber').text(via + ' To ' + from);
            } else {

                $('.returnflightNumber').text(to + ' To ' + from);
            }
        });
        $("#extra_from").change(function () {
            var val = $("#extra_from option:selected").val();
            if (val.length) {
                $('.via_fields').show('slow');
            } else {
                $('.via_fields').hide('slow');
            }
        });
        $("#extra_r_from").change(function () {
            var val = $("#extra_r_from option:selected").val();
            if (val.length) {
                $('.return_via_fields').show('slow');
            } else {
                $('.return_via_fields').hide('slow');
            }
        });
        $('.selectcustom2').select2({
            templateResult: formatState,
            templateSelection: formatState
        });
        $('.selectcustom3').select2({
            templateResult: formatState,
            templateSelection: formatState
        });

        $('.priceFormate').numeric();
        $('#only_package').change(function () {
            var c = this.checked ? '1' : '0';
            if (c == 1) {
                $('.hide-fields').hide();
            } else {
                $('.hide-fields').show();
            }
        });
        $('#only_visa').change(function () {
            var c = this.checked ? '1' : '0';
            if (c == 1) {
                $('.visa-hide-fields').hide();
            } else {
                $('.visa-hide-fields').show();
            }
        });

    });
    $('#hotel_makkah').on('change', function () {
    sethotel('hotel_makkah', 'similarMakkah');
});

$('#hotel_madinah').on('change', function () {
    sethotel('hotel_madinah', 'similarMadina');
});
    function sethotel(selectId, targetId) {
    var selected = $('#' + selectId + ' option:selected');
    var hotelName = selected.data('name') || '';
    $('#' + targetId).html('('+hotelName+')');
}
</script>
@endpush