@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-3">
                @include('includes.user-sidebar')
            </div>

            <div class="col-md-9 agent-main-box">
                <form method="post" class="has-callback-validations content-box-agent"
                    action="{{ route('user.save-tour-packages') }}" enctype="multipart/form-data">
                    <h3 class="box-title text-center">Add Tour Package </h3>
                    <hr>
                    @csrf
                    <input type="hidden" name="id"
                        value="{{ isset($detail) && !is_null($detail) ? $detail->id : '' }}">
                    <div class="form-group">

                        @if (isset($detail) && !is_null($detail->image))
                        <img class="file" src="{{ url('storage/uploads/packages/' . $detail->image) }}"
                        alt="your image" style="width: 100%;height:250px;object-fit:contain" />
                     
                       
                        @endif
                  
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            @if (isset($detail) && !is_null($detail->image))
                                 <label for="">Image</label>
                                <input type="file" name="image" class="form-control" value=""
                                    onchange="readURL(this);">
                            @else
                                <label for="">Image</label>
                                <input type="file" name="image" onchange="readURL(this);" class="form-control"
                                    data-validation="required" value="">
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                placeholder="Package Title" data-validation="required"
                                value="{{ isset($detail) && !is_null($detail) ? $detail->title : '' }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Country</label>
                            <select class="form-control " name="country"  data-validation="required">
                                <option value="">Country</option>
                                    @foreach ($countries as $a)
                                <option value="{{ $a->country }}"
                                    {{ isset($detail) && !is_null($detail) && $detail->country == $a->country ? 'selected' : '' }}>
                                    {{ $a->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Nights</label>
                                    <input type="text" name="nights" maxlength="3" class="form-control nights priceFormate"
                                    placeholder="Nights" data-validation="required"
                                    value="{{ isset($detail) && !is_null($detail) ? $detail->nights : '' }}" onkeyup="changesDays()" onkeydown="changesDays()" onkeypress="changesDays()">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Days</label>
                                    <input type="text" name="days" readonly maxlength="3" class="form-control days priceFormate"
                                    placeholder="Days" data-validation="required"
                                    value="{{ isset($detail) && !is_null($detail) ? $detail->days : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Starting Price</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rs</span>
                                </div>
                                <input type="text" maxlength="7" name="price" class="form-control priceFormate"
                                    placeholder="price" data-validation="required"
                                    value="{{ isset($detail) && !is_null($detail) ? $detail->price : '' }}">
                            </div>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="" class="btn-block">&nbsp;</label>
                            <label><input type="checkbox" name="fix_dates" value="1" onchange="$('.dates_fields').toggle('slow')" {{isset($detail) && !is_null($detail) && !empty($detail->departure_date) && !empty($detail->return_date)?'checked':''}}> Fix Dates</label>
                        </div>
                      
                    </div>
                    <div class="dates_fields" style="display: {{isset($detail) && !is_null($detail) && !empty($detail->departure_date) && !empty($detail->return_date)?'block':'none'}}">
                    @if(isset($detail) && !is_null($detail) && !empty($detail->departure_date) && !empty($detail->return_date))
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Departure Date</label>
                            <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" name="departure_date"
                                class="form-control date  number-style" data-validation="required"  value="{{ isset($detail) && !is_null($detail) ? $detail->departure_date : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Return Date</label>
                            <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" name="return_date"
                                class="form-control date  number-style" data-validation="required"  value="{{ isset($detail) && !is_null($detail) ? $detail->return_date : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Seats</label>
                            <input type="text" name="seats" maxlength="3" class="form-control priceFormate"
                                placeholder="Seats" data-validation="required"
                                value="{{ isset($detail) && !is_null($detail) ? $detail->seats : '' }}">
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Departure Date</label>
                            <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" name="departure_date[]"
                                class="form-control date  number-style" data-validation="required" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Return Date</label>
                            <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" name="return_date[]"
                                class="form-control date  number-style" data-validation="required" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Seats</label>
                            <input type="text" name="seats[]" maxlength="3" class="form-control priceFormate"
                                placeholder="Seats">
                        </div>
                    </div>
                    <div class="new_dates"></div>
                    <div class="form-group text-center">

                        <a href="javascript:void(0);" class="addmore  btn-primary btn" id="addmore">Add more dates for
                            same pacakge</a>
                        <div class="clearfix"></div>

                    </div>
                    @endif
                    </div>
                    <h4 class="mb-2">Price Segments:</h4>
                    @if(isset($detail) && !is_null($detail) && !is_null($detail->pricings) && count($detail->pricings) > 0)
                    <input type="hidden" name="new_pricing" value="no">
                    @foreach ($detail->pricings as $p)
                    <div class="row">
                        <input type="hidden" name="pricing_id" value="{{$p->id}}">
                        <div class="form-group col-md-4">
                            <label for=""><b>Departure City</b></label>
                            <select class="form-control " name="departure_city[]" data-validation="required">
                                <option value="">City</option>
                                    @foreach ($from as $a)
                                    <option value="{{ $a->name }}" {{ $a->name == $p->city ? 'selected' : '' }}>{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Single Room</label>
                            <input type="text" maxlength="7" name="single_room[]" class="form-control priceFormate"
                            placeholder="price" 
                            value="{{ $p->single_room }}">

                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Dobule Room</label>
                            <input type="text" maxlength="7" name="double_room[]" class="form-control priceFormate"
                            placeholder="price" 
                            value="{{ $p->double_room}}">

                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Triple Room</label>
                            <input type="text" maxlength="7" name="triple_room[]" class="form-control priceFormate"
                            placeholder="price" 
                            value="{{ $p->triple_room}}">

                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Quad Room</label>
                            <input type="text" maxlength="7" name="quad_room[]" class="form-control priceFormate"
                            placeholder="price" 
                            value="{{ $p->quad_room}}">

                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Child With Bed</label>
                            <input type="text" maxlength="7" name="child_with_bed[]" class="form-control priceFormate"
                            placeholder="price" 
                            value="{{ $p->child_with_bed}}">

                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Child Without Bed</label>
                            <input type="text" maxlength="7" name="child_without_bed[]" class="form-control priceFormate"
                                    placeholder="price" 
                                    value="{{ $p->child_without_bed}}">

                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Infant</label>
                            <input type="text" maxlength="7" name="infant[]" class="form-control priceFormate"
                                    placeholder="price" 
                                    value="{{ $p->infant}}">

                        </div>
                      
                    </div>
                    
                    
                    @endforeach
                    @else
                    <input type="hidden" name="new_pricing" value="yes">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for=""><b>Departure City</b></label>
                            <select class="form-control " name="departure_city[]" data-validation="required">
                                <option value="">City</option>
                                    @foreach ($from as $a)
                                    <option value="{{ $a->name }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Single Room</label>
                            <input type="text" maxlength="7" name="single_room[]" class="form-control priceFormate"
                            placeholder="price" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Dobule Room</label>
                            <input type="text" maxlength="7" name="double_room[]" class="form-control priceFormate"
                            placeholder="price" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Triple Room</label>
                            <input type="text" maxlength="7" name="triple_room[]" class="form-control priceFormate"
                            placeholder="price" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Quad Room</label>
                            <input type="text" maxlength="7" name="quad_room[]" class="form-control priceFormate"
                            placeholder="price" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Child With Bed</label>
                            <input type="text" maxlength="7" name="child_with_bed[]" class="form-control priceFormate"
                            placeholder="price" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Child Without Bed</label>
                            <input type="text" maxlength="7" name="child_without_bed[]" class="form-control priceFormate"
                                    placeholder="price" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Infant</label>
                            <input type="text" maxlength="7" name="infant[]" class="form-control priceFormate"
                                    placeholder="price" >
                        </div>
                    </div>
                    <div class="new_prices"></div>
                    <div class="form-group text-center">

                        <a href="javascript:void(0);" class="addmorepricing  btn-primary btn" id="addmorepricing">Add More Prices</a>
                        <div class="clearfix"></div>

                    </div>
                    @endif
                    <h4 class="mb-2">Package Includes:</h4>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for=""><input type="checkbox" name="return_ticket" value="1" {{ isset($detail) && !is_null($detail) && $detail->return_ticket == 1?'checked' : '' }}> Return Ticket</label>
                            <select class="form-control " name="return_airline">
                                <option value="">Airline</option>
                                @foreach ($airlines as $a)
                                    <option value="{{ $a->name }}" {{ isset($detail) && !is_null($detail) && $detail->return_airline == $a->name?'selected' : '' }}>{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""><input type="checkbox" name="visit_visa" value="1" {{ isset($detail) && !is_null($detail) && $detail->visit_visa == 1?'checked' : '' }}> Visit Visa</label>
                            <input type="text" name="visit_visa_remarks" class="form-control" 
                            placeholder="Visit Visa Remarks" 
                            value="{{ isset($detail) && !is_null($detail) ? $detail->visit_visa_remarks : '' }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="btn-block">&nbsp;</label>
                            <label for=""><input type="checkbox" name="airport_pickdrop" value="1" {{ isset($detail) && !is_null($detail) && $detail->airport_pickdrop == 1?'checked' : '' }}> Airport Pick & Drop</label>
                        </div>
                        @php
                        $added_stars = [];
                        if(isset($detail) && !is_null($detail) && !empty($detail->hotel_stars)){
                            $added_stars = explode(',',$detail->hotel_stars);
                        }
                        @endphp
                        <div class="form-group col-md-4">
                            <label for="">Hotel Stars</label>
                            @for ($i = 1; $i <= 5; $i++)
                             <label class="mr-2"><input type="checkbox" name="hotel_stars[]" value="{{$i}}" {{ in_array($i,$added_stars)?'checked' : '' }}> {{$i}}</label>
                            @endfor
                        </div>
                    </div>
                    <div class="form-group">
                        <h4 class="mb-2">Tour Itinerary</h4>
                        <textarea name="tour_itinery"  rows="4" class="form-control editor">{{ isset($detail) && !is_null($detail) ? $detail->tour_itinery : '' }}</textarea>
                    </div>
                    {{-- @php
                    $days = [];
                    if(isset($detail) && !is_null($detail) && !empty($detail->tour_itinery)){
                        $days = explode(',,,,',$detail->tour_itinery);
                    }
                    @endphp
                    <div class="form-group">
                        <h4 class="mb-2">Tour Itinerary</h4>
                        <div class="row append_tour_days">
                       
                          @foreach ($days as $key => $d)
                          <div class="col-md-6">
                            <lable>Day {{$key + 1}}<label>
                            <textarea name="day[]"  rows="4" class="form-control editor">{{$d}}</textarea>
                        </div>
                          @endforeach
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label><input type="checkbox" name="active" value="1"
                                {{ isset($detail) && !is_null($detail) && $detail->active == 1 ? 'checked' : '' }}>
                            Active</label>
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
@endsection
@push('script')
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.alphanum/1.0.24/jquery.alphanum.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.date').datepicker({
                format: "d-M-yyyy",
                startDate: new Date(),
                autoclose: true,
            });


            var count = 2;
            $("#addmore").click(function() {

                var number_html =
                    '   <div class="row">\
                            <div class="form-group col-md-4">\
                                <label>Departure Date</label>\
                                <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" name="departure_date[]"\
                                    class="form-control date  number-style" />\
                            </div>\
                            <div class="form-group col-md-4">\
                                <label>Return Date</label>\
                                <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" name="return_date[]"\
                                    class="form-control date  number-style" />\
                            </div>\
                             <div class="form-group col-md-4">\
                            <label for="" class="btn-block">Seats  <a href="javascript:;" class="removeNo  btn-danger btn-sm " style="float:right" > &times;</a></label>\
                            <input type="text" name="seats[]" maxlength="3" class="form-control priceFormate"\
                                placeholder="Seats">\
                        </div>\
                        </div>';

                $(".new_dates").append(number_html);
                $('.priceFormate').numeric();
                $('.date').datepicker({
                    format: "d-M-yyyy",
                    startDate: new Date(),
                    autoclose: true,
                });
                count++;

                $(".removeNo").click(function() {
                    $(this).closest('.row').remove();
                    count--;

                    $("#addmore").show();
                });
            });

            var pricecount = 2;
            $("#addmorepricing").click(function() {

                var number_html =
                    '<hr> <div class="row">\
                        <div class="form-group col-md-4">\
                            <label for=""><b>Departure City</b></label>\
                            <select class="form-control " name="departure_city[]" data-validation="required">\
                                <option value="">City</option>\
                                    @foreach ($from as $a)\
                                    <option value="{{ $a->name }}">{{ $a->name }}</option>\
                                @endforeach\
                            </select>\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Single Room</label>\
                            <input type="text" maxlength="7" name="single_room[]" class="form-control priceFormate"\
                            placeholder="price" >\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Dobule Room</label>\
                            <input type="text" maxlength="7" name="double_room[]" class="form-control priceFormate"\
                            placeholder="price" >\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Triple Room</label>\
                            <input type="text" maxlength="7" name="triple_room[]" class="form-control priceFormate"\
                            placeholder="price" >\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Quad Room</label>\
                            <input type="text" maxlength="7" name="quad_room[]" class="form-control priceFormate"\
                            placeholder="price" >\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Child With Bed</label>\
                            <input type="text" maxlength="7" name="child_with_bed[]" class="form-control priceFormate"\
                            placeholder="price" >\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Child Without Bed</label>\
                            <input type="text" maxlength="7" name="child_without_bed[]" class="form-control priceFormate"\
                                    placeholder="price" >\
                        </div>\
                        <div class="form-group col-md-2">\
                            <label for="">Infant</label>\
                            <input type="text" maxlength="7" name="infant[]" class="form-control priceFormate"\
                                    placeholder="price" >\
                        </div>\
                    </div>';

                $(".new_prices").append(number_html);
                $('.priceFormate').numeric();
                pricecount++;

                $(".priceremoveNo").click(function() {
                    $(this).closest('.row').remove();
                    pricecount--;

                    $("#addmore").show();
                });
            });
        });
        function changesDays() {
            var nights = $('.nights').val();
            if(nights != ''){
            nights = parseInt(nights);
            var days = parseInt(nights + 1);
            $('.days').val(days);
            var html = '';
            for (let index = 1; index <= days; index++) {
                html+=' <div class="col-md-6">\
                            <lable>Day '+index+'<label>\
                             <textarea name="day[]"  rows="4" class="form-control editor"></textarea>\
                        </div>';
                
            }
            $(".append_tour_days").html(html);
            $("textarea.editor").ckeditor();
            }else{
                $('.days').val('');
            }
        }
    </script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#fileHtml').show();
                    $('.file').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {
            $('.priceFormate').numeric();
            $('#only_package').change(function() {
                var c = this.checked ? '1' : '0';
                if (c == 1) {
                    $('.hide-fields').hide();
                } else {
                    $('.hide-fields').show();
                }
            });
            $('#only_visa').change(function() {
                var c = this.checked ? '1' : '0';
                if (c == 1) {
                    $('.visa-hide-fields').hide();
                } else {
                    $('.visa-hide-fields').show();
                }
            });

        });
    </script>
@endpush
