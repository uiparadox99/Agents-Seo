@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
        	<form method="post" class="has-callback-validations content-box-agent"
            action="{{ route('user.save-packages') }}" enctype="multipart/form-data" >
            <h3 class="box-title text-center">Add Umrah Package  </h3>
            <hr>
            @csrf
            <input type="hidden" name="id"
            value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
            <div class="row">
                <div class="col-md-6">
                     <div class="row">
                
                
                <div class="form-group col-md-12">
                    <label for="">Title</label>
                    
                    <input type="text" name="name" class="form-control" id="title" placeholder="Package Title" data-validation="required"
                    value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">
                    
                </div>

                <div class="form-group col-md-12">
                    <div class="row">
                        
                        @if(isset($detail)&&!is_null($detail->image))
                        <div class="col-sm-12">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control" value="" onchange="readURL(this);">
                        </div>
                      
                        @else
                        <div class="col-sm-12 " >
                            <label for="">Image</label>
                            <input type="file" name="image" onchange="readURL(this);" class="form-control" data-validation="required" value="">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
      
            
            
            
                        @if(isset($prices) && $prices->count() > 0)
                        @foreach($prices as $p)
                        @if($p->section == 1)
                            <div class="row">
                                <input type="hidden" name="section[]" value="1">

                                @if(!empty($p->from) && !is_null($p->from) && !is_null($p->nights))
                                <div class="col-sm-6 form-group">
                                    <select class="form-control  visa-hide-fields hide-fields " name="airline[]">
                                        <option value="">Airline</option>
                                        @foreach($airlines as $a)
                                        <option value="{{ $a->id }}"
                                            {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                            {{ $a->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <select class="form-control  visa-hide-fields  hide-fields" name="from[]">
                                            <option value="">Flight From</option>
                                            @foreach($from as $a)
                                            <option value="{{ $a->name }}"
                                                {{ isset($p)&& $p->from == $a->name ?'selected':'' }}>{{ $a->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <div class="col-sm-6 form-group">
                                        <select class="form-control  visa-hide-fields  hide-fields" name="airline[]" style="display: none;">
                                            <option value="">Airline</option>
                                            @foreach($airlines as $a)
                                            <option value="{{ $a->id }}"
                                                {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                                {{ $a->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <select class="form-control  visa-hide-fields hide-fields" name="from[]" style="display: none;">
                                                <option value="">Flight From</option>
                                                @foreach($from as $a)
                                                <option value="{{ $a->name }}"
                                                    {{ isset($p)&& $p->from == $a->name ?'selected':'' }}>{{ $a->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    <div class="col-sm-12 form-group" style="text-align: right;">
                                        @if(!is_null($p->nights))
                                     <label class=" visa-hide-fields"><input type="checkbox" class="only_package" id="only_package" name="only_package" {{is_null($p->from)?'checked':''}}  value="1"> Only Package</label> 
                                     @else
                                       <label  class=" visa-hide-fields" style="display: none;"><input type="checkbox" class="only_package" id="only_package" name="only_package" {{is_null($p->from)?'checked':''}}  value="1"> Only Package</label> 
                                     @endif
                                     <label><input type="checkbox" class="only_visa" id="only_visa" name="only_visa" {{is_null($p->nights)?'checked':''}}  value="1"> Only Visa</label> 
                                 </div>
                          <!--       <div class="col-sm-6 form-group">
                                    <select class="form-control " name="to[]">
                                        <option value="">To</option>
                                        @foreach($to as $a)
                                        <option value="{{ $a->name }}"
                                            {{ isset($p)&& $p->to == $a->name ?'selected':'' }}>{{ $a->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> -->
                            </div>
                     
                            <div class="form-group">
                                <div class="row">
                                
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="price[]" placeholder="Price" class="form-control priceFormate"
                                        value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                                    </div>
                                           @if(!empty($p->nights) && !is_null($p->nights))
                                    <div class="col-sm-6 form-group">
                                        <select name="stars[]" class="form-control visa-hide-fields">
                                            <option value="">Hotel Stars</option>
                                              <option value="economy" {{ $p->stars == 'economy'?'selected':'' }}>Economy</option>
                                            <option value="1" {{ $p->stars == 1?'selected':'' }}>Economy Plus</option>
                                    
                           <!--          <option value="2" {{ $p->stars == 2?'selected':'' }}>2 Star</option> -->
                                    <option value="3" {{ $p->stars == 3?'selected':'' }}>3 Star</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4 Star</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5 Star</option>
                      <!--               <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option> -->
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                               <select class="form-control visa-hide-fields" name="nights[]">
                                   <option value="">Select Days</option>

                                @for ($x = 3; $x <= 30; $x++)
                                    <option value="{{$x}}" {{ isset($p)&&!is_null($p) && $p->nights == $x?'selected':'' }}>{{$x}} Days</option>
                                @endfor
                                <!-- <option value="10" {{ isset($p)&&!is_null($p) && $p->nights == '10'?'selected':'' }}>10 Days</option>
                                <option value="15" {{ isset($p)&&!is_null($p) && $p->nights == '15'?'selected':'' }}>15 Days</option>
                                <option value="21" {{ isset($p)&&!is_null($p) && $p->nights == '21'?'selected':'' }}>21 Days</option>
                                <option value="28" {{ isset($p)&&!is_null($p) && $p->nights == '28'?'selected':'' }}>28 Days</option> -->
                            </select>
                        </div>
                        @else
                         <div class="col-sm-6 form-group">
                                        <select name="stars[]" class="form-control visa-hide-fields" style="display: none;">
                                            <option value="">Hotel Stars</option>
                                            <option value="economy" {{ $p->stars == 'economy'?'selected':'' }}>Economy</option>
                                            <option value="1" {{ $p->stars == 1?'selected':'' }}>Economy Plus</option>
                                    
                                   <!--  <option value="2" {{ $p->stars == 2?'selected':'' }}>2 Star</option> -->
                                    <option value="3" {{ $p->stars == 3?'selected':'' }}>3 Star</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4 Star</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5 Star</option>
                      <!--               <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option> -->
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                               <select class="form-control visa-hide-fields" name="nights[]" style="display: none;">
                                <option value="">Select Days</option>
                                @for ($x = 3; $x <= 30; $x++)
                                    <option value="{{$x}}" {{ isset($p)&&!is_null($p) && $p->nights == $x?'selected':'' }}>{{$x}} Days</option>
                                @endfor
                                <!-- <option value="10" {{ isset($p)&&!is_null($p) && $p->nights == '10'?'selected':'' }}>10 Days</option>
                                <option value="15" {{ isset($p)&&!is_null($p) && $p->nights == '15'?'selected':'' }}>15 Days</option>
                                <option value="21" {{ isset($p)&&!is_null($p) && $p->nights == '21'?'selected':'' }}>21 Days</option>
                                <option value="28" {{ isset($p)&&!is_null($p) && $p->nights == '28'?'selected':'' }}>28 Days</option> -->
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
                @else
            
                    <div class="row">
                          <div class="col-sm-12 form-group" >
                         <label><input type="checkbox" class="only_visa" id="only_visa" name="only_visa"  value="1"> Only Visa</label> 
                         <span class=" visa-hide-fields"><label ><input type="checkbox" class="only_package" id="only_package"  value="1"> Only Package</label>  </span>
                     </div>
                        <input type="hidden" name="section[]" value="1">
                        <div class="col-sm-6 form-group">
                            <select class="form-control  visa-hide-fields hide-fields" name="airline[]">
                                <option value="">Airline</option>
                                @foreach($airlines as $a)
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <select class="form-control  visa-hide-fields hide-fields" name="from[]">
                                <option value="">Flight From</option>
                                @foreach($from as $a)
                                <option value="{{ $a->name }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="col-sm-3">
                            <select class="form-control hide-fields" name="to[]">
                                <option value="">To</option>
                                @foreach($to as $a)
                                <option value="{{ $a->name }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div> -->
                      
                 </div>

                <div class="row">

                    <div class="col-sm-12 form-group">
                        <input type="text" name="price[]" placeholder="Price" class="form-control priceFormate"
                        value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                    </div>
                    <div class="col-sm-6 form-group">
                        <select name="stars[]" class=" visa-hide-fields form-control">
                            <option value="">Hotel Stars</option>
                            <option value="economy">Economy </option>
                            <option value="1">Economy Plus</option>
                <!--             <option value="2">2 Star</option> -->
                            <option value="3">3 Star</option>
                            <option value="4">4 Star</option>
                            <option value="5">5 Star</option>
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <select class="form-control visa-hide-fields" name="nights[]">
                            <option value="">Select Days</option>
                            @for ($x = 3; $x <= 30; $x++)
                                    <option value="{{$x}}" {{ isset($p)&&!is_null($p) && $p->nights == $x?'selected':'' }}>{{$x}} Days</option>
                                @endfor
                            <!-- <option value="10" {{ isset($p)&&!is_null($p) && $p->nights == '10'?'selected':'' }}>10 Days</option>
                            <option value="15" {{ isset($p)&&!is_null($p) && $p->nights == '15'?'selected':'' }}>15 Days</option>
                            <option value="21" {{ isset($p)&&!is_null($p) && $p->nights == '21'?'selected':'' }}>21 Days</option>
                            <option value="28" {{ isset($p)&&!is_null($p) && $p->nights == '28'?'selected':'' }}>28 Days</option> -->
                        </select>
                                <!-- <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                    value=""> -->
                                </div>
                            </div>
                 
                        @endif
                             <!--    <div class="new_image"></div>
                                <div class="form-group text-center">
                                    
                                            <a href="javascript:void(0);" class="addmore  btn-primary btn"
                                                id="addmore">Add More</a>
                                            <div class="clearfix"></div>
                                      
                                        </div> -->
                                        <div class="form-group">

                                            <label>Description</label>
                                            
                                            <textarea class=" form-control" id="content"
                                            name="content1" rows="5">{{ isset($detail)&&!is_null($detail)?str_replace('<br />','',$detail->content1):'' }}</textarea>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><input type="checkbox" name="active" value="1" {{isset($detail)&&!is_null($detail) && $detail->active == 1?'checked':''}}> Active</label>
                                        </div>
                                        
                                        
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-5">
                                                <input type="submit" name="save" value="Save" class="btn btn-primary">
                                                <input type="reset" value="Reset" class="btn btn-default">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                     @if(isset($detail) && !is_null($detail->image))
                 

                                        <img class="file" src="{{ url('storage/uploads/packages/'.$detail->image) }}" alt="your image" style="width: 100%;" />

                                    @else
                        
                                        <img class="file" src="{{ url('images/placeholder.jpg') }}" alt="your image" style="width: 100%;" />
                             
                                    @endif
                                </div>
            </div>




        </form>
    </div>
</div>
</div>
</div>
@endsection
@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.alphanum/1.0.24/jquery.alphanum.min.js"></script>
<script type="text/javascript">
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
    $( document ).ready(function() {
        $('.priceFormate').numeric();
        $('#only_package').change(function(){
          var c = this.checked ? '1' : '0';
          if (c == 1) {
              $('.hide-fields').hide();
          }else{
              $('.hide-fields').show();
          }
      });
        $('#only_visa').change(function(){
          var c = this.checked ? '1' : '0';
          if (c == 1) {
              $('.visa-hide-fields').hide();
          }else{
              $('.visa-hide-fields').show();
          }
      });

    });
</script>
@endpush