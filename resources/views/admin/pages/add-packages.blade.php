@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Packages
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations" action="{{ route('admin.save-packages') }}" enctype="multipart/form-data">



                            @csrf
                            <input type="hidden" name="id"
                            value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                            @if(request()->has('agent') || !empty($detail->agents_id))
                            <p class="ajax-load" style="text-align: center;display: none;">Loading..</p>
                            <div class="row">

                             <div class="form-group col-md-4">
                                <label for="">Agent</label>
                                <input type="hidden" name="agent" id="hiddenAgent" value="{{isset($detail)&&!is_null($detail)?$detail->agent_slug:'UnKown Not Found' }}">
                                <input type="text" data-validation="required" name="agentBusiness" id="agentbar" class="form-control" autocomplete="off"   placeholder="Agent" value="{{ isset($detail)&&!is_null($detail)?$detail->agent_name.' ('.$detail->agent_city.')':'' }}">
                               <!--  <select name="agent" id="agents" class="form-control select2" >

                                </select> -->

                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Title</label>

                                <input type="text" name="name" class="form-control" id="title" placeholder="Package Title" data-validation="required"
                                value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">

                            </div>

                            <div class="form-group col-md-4">
                                <div class="row">

                                    @if(isset($detail)&&!is_null($detail->image))
                                    <div class="col-sm-6">
                                        <label for="">Image</label>
                                        <input type="file" name="image" class="form-control" value="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img src="{{ url('storage/uploads/packages/'.$detail->image) }}"
                                        width="100%" style="height: 100px;object-fit: contain;">
                                    </div>
                                    @else
                                    <div class="col-sm-12">
                                        <label for="">Image</label>
                                        <input type="file" name="image" class="form-control" data-validation="required" value="">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        @if(isset($prices) && $prices->count() > 0)
                        @foreach($prices as $p)
                        @if($p->section == 1)
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="section[]" value="1">

                                @if(!empty($p->from) && !is_null($p->from) && !is_null($p->nights))
                                <div class="col-sm-4 form-group">
                                    <select class="form-control  visa-hide-fields hide-fields " name="airline[]">
                                        <option value="">Airline</option>
                                        @foreach($airlines as $a)
                                        <option value="{{ $a->id }}"
                                            {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                            {{ $a->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4 form-group">
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
                                    <div class="col-sm-4 form-group">
                                        <select class="form-control  visa-hide-fields  hide-fields" name="airline[]" style="display: none;">
                                            <option value="">Airline</option>
                                            @foreach($airlines as $a)
                                            <option value="{{ $a->id }}"
                                                {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                                {{ $a->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group">
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
                                    <div class="col-sm-4" style="text-align: right;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="checkbox-box text-center">
                                                  @if(!is_null($p->nights))
                                                  <label class=" visa-hide-fields"><input type="checkbox" class="only_package" id="only_package" name="only_package" {{is_null($p->from)?'checked':''}}  value="1"> Only Package</label> 
                                                  @else
                                                  <label  class=" visa-hide-fields" style="display: none;"><input type="checkbox" class="only_package" id="only_package" name="only_package" {{is_null($p->from)?'checked':''}}  value="1"> Only Package</label> 
                                                  @endif
                                              </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="checkbox-box text-center">
                                                      <span><label><input type="checkbox" class="only_visa" id="only_visa" name="only_visa" {{is_null($p->nights)?'checked':''}}  value="1"> Only Visa</label> </span>
                                                </div>
                                            </div>
                                        </div>
                                      
                                   
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
                                
                                    <div class="col-sm-4">
                                        <input type="text" name="price[]" placeholder="Price" class="form-control priceFormate"
                                        value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                                    </div>
                                           @if(!empty($p->nights) && !is_null($p->nights))
                                    <div class="col-sm-4">
                                        <select name="stars[]" class="form-control visa-hide-fields">
                                            <option value="">Hotel Stars</option>
                                              <option value="economy" {{ $p->stars == 'economy'?'selected':'' }}>Economy</option>
                                            <option value="1" {{ $p->stars == 1?'selected':'' }}>Economy Plus</option>
                                    
                                    <option value="2" {{ $p->stars == 2?'selected':'' }}>2 Star</option>
                                    <option value="3" {{ $p->stars == 3?'selected':'' }}>3 Star</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4 Star</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5 Star</option>
                      <!--               <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option> -->
                                </select>
                            </div>
                            <div class="col-sm-4">
                               <select class="form-control visa-hide-fields" name="nights[]">
                                <option value="">Select Days</option>
                                <option value="10" {{ isset($p)&&!is_null($p) && $p->nights == '10'?'selected':'' }}>10 Days</option>
                                <option value="15" {{ isset($p)&&!is_null($p) && $p->nights == '15'?'selected':'' }}>15 Days</option>
                                <option value="21" {{ isset($p)&&!is_null($p) && $p->nights == '21'?'selected':'' }}>21 Days</option>
                                <option value="28" {{ isset($p)&&!is_null($p) && $p->nights == '28'?'selected':'' }}>28 Days</option>
                            </select>
                        </div>
                        @else
                         <div class="col-sm-4">
                                        <select name="stars[]" class="form-control visa-hide-fields" style="display: none;">
                                            <option value="">Hotel Stars</option>
                                            <option value="economy" {{ $p->stars == 'economy'?'selected':'' }}>Economy</option>
                                            <option value="1" {{ $p->stars == 1?'selected':'' }}>Economy Plus</option>
                                    
                                    <option value="2" {{ $p->stars == 2?'selected':'' }}>2 Star</option>
                                    <option value="3" {{ $p->stars == 3?'selected':'' }}>3 Star</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4 Star</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5 Star</option>
                      <!--               <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                    <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                    <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option> -->
                                </select>
                            </div>
                            <div class="col-sm-4">
                               <select class="form-control visa-hide-fields" name="nights[]" style="display: none;">
                                <option value="">Select Days</option>
                                <option value="10" {{ isset($p)&&!is_null($p) && $p->nights == '10'?'selected':'' }}>10 Days</option>
                                <option value="15" {{ isset($p)&&!is_null($p) && $p->nights == '15'?'selected':'' }}>15 Days</option>
                                <option value="21" {{ isset($p)&&!is_null($p) && $p->nights == '21'?'selected':'' }}>21 Days</option>
                                <option value="28" {{ isset($p)&&!is_null($p) && $p->nights == '28'?'selected':'' }}>28 Days</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
                @else
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="section[]" value="1">
                        <div class="col-sm-4">
                            <select class="form-control  visa-hide-fields hide-fields" name="airline[]">
                                <option value="">Airline</option>
                                @foreach($airlines as $a)
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 ">
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
                        <div class="col-sm-4" style="text-align: right;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="checkbox-box text-center">
                                         <span class=" visa-hide-fields"><label ><input type="checkbox" class="only_package" id="only_package"  value="1"> Only Package</label> </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="checkbox-box text-center">
                                     <span><label><input type="checkbox" class="only_visa" id="only_visa" name="only_visa"  value="1"> Only Visa</label> </span>
                                    </div>
                                </div>
                            </div>
                          
                     
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                  
                    <div class="col-sm-4">
                        <input type="text" name="price[]" placeholder="Price" class="form-control priceFormate"
                        value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                    </div>
                    <div class="col-sm-4">
                        <select name="stars[]" class=" visa-hide-fields form-control">
                            <option value="">Hotel Stars</option>
                            <option value="economy">Economy </option>
                            <option value="1">Economy Plus</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control visa-hide-fields" name="nights[]">
                                    <option value="">Select Days</option>
                                    <option value="10" {{ isset($p)&&!is_null($p) && $p->nights == '10'?'selected':'' }}>10 Days</option>
                                    <option value="15" {{ isset($p)&&!is_null($p) && $p->nights == '15'?'selected':'' }}>15 Days</option>
                                    <option value="21" {{ isset($p)&&!is_null($p) && $p->nights == '21'?'selected':'' }}>21 Days</option>
                                    <option value="28" {{ isset($p)&&!is_null($p) && $p->nights == '28'?'selected':'' }}>28 Days</option>
                                </select>
                                <!-- <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                    value=""> -->
                                </div>
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

                                            <label>Content</label>
                                            
                                            <textarea class=" form-control" id="content"
                                            name="content1" rows="5">{{ isset($detail)&&!is_null($detail)?str_replace('<br />','',$detail->content1):'' }} Umrah visa
Makkah Hotel
Madinah Hotel
Return Air Ticket
Full by BUS transport
Makkah & Madinah Ziyarat</textarea>
                                            
                                        </div>
                                        
                                        

                                        @else

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-1 col-md-offset-2">
                                                    <label for="">Name</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="name" class="form-control" id="title" required=""
                                                    value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-1 col-md-offset-2">
                                                    <label for="">Image</label>
                                                </div>
                                                @if(isset($detail)&&!is_null($detail->image))
                                                <div class="col-sm-3">
                                                    <input type="file" name="image" class="form-control" value="">
                                                </div>
                                                <div class="col-sm-3">
                                                    <img src="{{ url('storage/uploads/packages/'.$detail->image) }}"
                                                    width="30%">
                                                </div>
                                                @else
                                                <div class="col-sm-6">
                                                    <input type="file" name="image" class="form-control" required="" value="">
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-1 col-md-offset-2">
                                                    <label for="">Image Alt</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="image_alt" class="form-control" id="image_alt" 
                                                    value="{{ isset($detail)&&!is_null($detail)?$detail->image_alt:'' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-1 col-md-offset-2">
                                                    <label>Content 1</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <textarea class="editor form-control" id="content"
                                                    name="content1">{{ isset($detail)&&!is_null($detail)?$detail->content1:'' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($prices) && $prices->count() > 0)
                                        @foreach($prices as $p)
                                        @if($p->section == 1)
                                        <div class="form-group">
                                            <div class="row">
                                                <input type="hidden" name="section[]" value="1">
                                                <div class="col-md-1 col-md-offset-2">
                                                    <label for="">Airline</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control " name="airline[]">
                                                        <option value="">Airline</option>
                                                        @foreach($airlines as $a)
                                                        <option value="{{ $a->id }}"
                                                            {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                                            {{ $a->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <select class="form-control " name="from[]">
                                                            <option value="">From</option>
                                                            @foreach($cities as $a)
                                                            <option value="{{ $a->name }}"
                                                                {{ isset($p)&& $p->from == $a->name ?'selected':'' }}>{{ $a->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <select class="form-control " name="to[]">
                                                            <option value="">To</option>
                                                            @foreach($cities as $a)
                                                            <option value="{{ $a->name }}"
                                                                {{ isset($p)&& $p->to == $a->name ?'selected':'' }}>{{ $a->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a href="{{ route('admin.delete-price', $p->id) }}"
                                                            class="btn btn-danger btn-sm btn-xs"
                                                            onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                            class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1 col-md-offset-2">
                                                            <label>Pricing</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" name="price[]" placeholder="Price" class=" priceFormate form-control"
                                                            value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select name="stars[]" class="form-control">
                                                                <option value="">Hotel Stars</option>
                                                                <option value="1" {{ $p->stars == 1?'selected':'' }}>1</option>
                                                                <option value="2" {{ $p->stars == 2?'selected':'' }}>2</option>
                                                                <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                                                <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                                                <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                                            value="{{ isset($p)&&!is_null($p)?$p->nights:'' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                                @else
                                                <div class="form-group">
                                                    <div class="row">
                                                        <input type="hidden" name="section[]" value="1">
                                                        <div class="col-md-1 col-md-offset-2">
                                                            <label for="">Airline</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select class="form-control " name="airline[]">
                                                                <option value="">Airline</option>
                                                                @foreach($airlines as $a)
                                                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select class="form-control " name="from[]">
                                                                <option value="">From</option>
                                                                @foreach($cities as $a)
                                                                <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select class="form-control " name="to[]">
                                                                <option value="">To</option>
                                                                @foreach($cities as $a)
                                                                <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1 col-md-offset-2">
                                                            <label>Pricing</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" name="price[]" placeholder="Price" class="priceFormate form-control"
                                                            value="">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select name="stars[]" class="form-control">
                                                                <option value="">Hotel Stars</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                                            value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="new_image"></div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-9">
                                                            <a href="javascript:void(0);" class="addmore  btn-primary btn pull-right"
                                                            id="addmore">Add More</a>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1 col-md-offset-2">
                                                            <label>Content 2</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <textarea class="editor form-control"
                                                            name="content2">{{ isset($detail)&&!is_null($detail)?$detail->content2:'' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(isset($prices) && $prices->count() > 0)
                                                @foreach($prices as $p)
                                                @if($p->section == 2)
                                                <div class="form-group">
                                                    <div class="row">
                                                        <input type="hidden" name="section[]" value="2">
                                                        <div class="col-md-1 col-md-offset-2">
                                                            <label for="">Airline</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select class="form-control " name="airline[]">
                                                                <option value="">Airline</option>
                                                                @foreach($airlines as $a)
                                                                <option value="{{ $a->id }}"
                                                                    {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                                                    {{ $a->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <select class="form-control " name="from[]">
                                                                    <option value="">From</option>
                                                                    @foreach($cities as $a)
                                                                    <option value="{{ $a->name }}"
                                                                        {{ isset($p)&& $p->from == $a->name ?'selected':'' }}>{{ $a->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <select class="form-control " name="to[]">
                                                                    <option value="">To</option>
                                                                    @foreach($cities as $a)
                                                                    <option value="{{ $a->name }}"
                                                                        {{ isset($p)&& $p->to == $a->name ?'selected':'' }}>{{ $a->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a href="{{ route('admin.delete-price', $p->id) }}"
                                                                    class="btn btn-danger btn-sm btn-xs"
                                                                    onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                                    class="fa fa-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-1 col-md-offset-2">
                                                                    <label>Pricing</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" name="price[]" placeholder="Price" class="priceFormate form-control"
                                                                    value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="stars[]" class="form-control">
                                                                        <option value="">Hotel Stars</option>
                                                                        <option value="1" {{ $p->stars == 1?'selected':'' }}>1</option>
                                                                        <option value="2" {{ $p->stars == 2?'selected':'' }}>2</option>
                                                                        <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                                                        <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                                                        <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                                                    value="{{ isset($p)&&!is_null($p)?$p->nights:'' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <input type="hidden" name="section[]" value="2">
                                                                <div class="col-md-1 col-md-offset-2">
                                                                    <label for="">Airline</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control " name="airline[]">
                                                                        <option value="">Airline</option>
                                                                        @foreach($airlines as $a)
                                                                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control " name="from[]">
                                                                        <option value="">From</option>
                                                                        @foreach($cities as $a)
                                                                        <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control " name="to[]">
                                                                        <option value="">To</option>
                                                                        @foreach($cities as $a)
                                                                        <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-1 col-md-offset-2">
                                                                    <label>Pricing</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" name="price[]" placeholder="Price" class="priceFormate form-control"
                                                                    value="">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="stars[]" class="form-control">
                                                                        <option value="">Hotel Stars</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                                                    value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="new_image2"></div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <a href="javascript:void(0);" class="addmore2  btn-primary btn pull-right"
                                                                    id="addmore2">Add More</a>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-1 col-md-offset-2">
                                                                    <label>Content 3</label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea class="editor form-control"
                                                                    name="content3">{{ isset($detail)&&!is_null($detail)?$detail->content3:'' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(isset($prices) && $prices->count() > 0)
                                                        @foreach($prices as $p)
                                                        @if($p->section == 3)
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <input type="hidden" name="section[]" value="3">
                                                                <div class="col-md-1 col-md-offset-2">
                                                                    <label for="">Airline</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control " name="airline[]">
                                                                        <option value="">Airline</option>
                                                                        @foreach($airlines as $a)
                                                                        <option value="{{ $a->id }}"
                                                                            {{ isset($p)&& $p->airlines_id == $a->id ?'selected':'' }}>
                                                                            {{ $a->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <select class="form-control " name="from[]">
                                                                            <option value="">From</option>
                                                                            @foreach($cities as $a)
                                                                            <option value="{{ $a->name }}"
                                                                                {{ isset($p)&& $p->from == $a->name ?'selected':'' }}>{{ $a->name }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <select class="form-control " name="to[]">
                                                                            <option value="">To</option>
                                                                            @foreach($cities as $a)
                                                                            <option value="{{ $a->name }}"
                                                                                {{ isset($p)&& $p->to == $a->name ?'selected':'' }}>{{ $a->name }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <a href="{{ route('admin.delete-price', $p->id) }}"
                                                                            class="btn btn-danger btn-sm btn-xs"
                                                                            onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                                            class="fa fa-trash"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 col-md-offset-2">
                                                                            <label>Pricing</label>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" name="price[]" placeholder="Price" class="form-control priceFormate"
                                                                            value="{{ isset($p)&&!is_null($p)?$p->price:'' }}">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <select name="stars[]" class="form-control">
                                                                                <option value="">Hotel Stars</option>
                                                                                <option value="1" {{ $p->stars == 1?'selected':'' }}>1</option>
                                                                                <option value="2" {{ $p->stars == 2?'selected':'' }}>2</option>
                                                                                <option value="3" {{ $p->stars == 3?'selected':'' }}>3</option>
                                                                                <option value="4" {{ $p->stars == 4?'selected':'' }}>4</option>
                                                                                <option value="5" {{ $p->stars == 5?'selected':'' }}>5</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                                                            value="{{ isset($p)&&!is_null($p)?$p->nights:'' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <input type="hidden" name="section[]" value="3">
                                                                        <div class="col-md-1 col-md-offset-2">
                                                                            <label for="">Airline</label>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <select class="form-control " name="airline[]">
                                                                                <option value="">Airline</option>
                                                                                @foreach($airlines as $a)
                                                                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <select class="form-control " name="from[]">
                                                                                <option value="">From</option>
                                                                                @foreach($cities as $a)
                                                                                <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <select class="form-control " name="to[]">
                                                                                <option value="">To</option>
                                                                                @foreach($cities as $a)
                                                                                <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 col-md-offset-2">
                                                                            <label>Pricing</label>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" name="price[]" placeholder="Price" class="form-control"
                                                                            value="">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <select name="stars[]" class="form-control">
                                                                                <option value="">Hotel Stars</option>
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" name="nights[]" placeholder="Days" class="form-control"
                                                                            value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="new_image3"></div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-9">
                                                                            <a href="javascript:void(0);" class="addmore3  btn-primary btn pull-right"
                                                                            id="addmore3">Add More</a>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 col-md-offset-2">
                                                                            <label>Content 4</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <textarea class="editor form-control"
                                                                            name="content4">{{ isset($detail)&&!is_null($detail)?$detail->content4:'' }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-8 col-sm-offset-2">
                                                                    <h4 class="m-t-0 header-title m-b-10"><b>Seo Detail</b></h4>
                                                                    <hr>

                                                                    <div class="seo-preview">
                                                                        <h3 id="preview_title">{{isset($detail)?$detail->meta_title:''}}</h3>
                                                                        <h5 id="preview_url">{{isset($detail)?url('/').'/'.$detail->slug:''}}</h5>
                                                                        <p id="preview_description">{{isset($detail)?$detail->meta_description:''}}</p>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="">Meta Title<span class="star">*</span></label>
                                                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                                                        value="{{isset($detail)?$detail->meta_title:''}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Slug<span class="star">*</span></label>
                                                                        <input type="text" class="form-control" id="slug" name="slug"
                                                                        value="{{isset($detail)?$detail->slug:''}}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Meta Description<span class="star">*</span></label>
                                                                        <textarea name="meta_description" id="meta_description" cols="30" rows="5"
                                                                        class="form-control ">{{isset($detail)?$detail->meta_description:''}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 col-md-offset-2">
                                                                            <label>Custom Content</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <textarea class=" form-control"
                                                                            name="custom_content">{{ isset($detail)&&!is_null($detail)?$detail->custom_content:'' }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-sm-offset-5">
                                                                        <button type="submit" name="save"  class="btn btn-primary">Save</button>
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
                                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.alphanum/1.0.24/jquery.alphanum.min.js"></script>
                                <script type="text/javascript">
                                    $( document ).ready(function() {

                                        // $.ajax({
                                        //     url: SITE_PATH +"/load-agents",
                                        //     type: "GET",
                                        //     beforeSend: function()
                                        //     {
                                        //         $('.ajax-load').show();
                                        //     }

                                        // }).done(function(data)
                                        // {
                                        //     if(data.html == " "){
                                        //         $('.ajax-load').html("No more records found");
                                        //         return;
                                        //     }
                                        //     $('.ajax-load').hide();
                                        //     $("#agents").append(data.html);
                                        //     $('.select2').select2();
                                        // });
                                        $('.priceFormate').numeric();
                                        $('#only_package').change(function(){
                                            var c = this.checked ? '1' : '0';
                                            if (c == 1) {
                                                $('.hide-fields').hide();
                                                $('#content').val('Umrah visa\nMakkah Hotel\nMadinah Hotel\nFull by BUS transport\nMakkah & Madinah Ziyarat');
                                            }else{
                                                $('.hide-fields').show();
                                                $('#content').val('Umrah visa\nMakkah Hotel\nMadinah Hotel\nReturn Air Ticket\nFull by BUS transport\nMakkah & Madinah Ziyarat');
                                            }
                                            
                                         });
                                        $('#only_visa').change(function(){
                                            var c = this.checked ? '1' : '0';
                                            if (c == 1) {
                                                $('.visa-hide-fields').hide();
                                                $('#content').val('Umrah visa');
                                            }else{
                                                $('.visa-hide-fields').show();
                                                $('#content').val('Umrah visa\nMakkah Hotel\nMadinah Hotel\nReturn Air Ticket\nFull by BUS transport\nMakkah & Madinah Ziyarat');
                                            }
                                     });

                                    });
                                </script>
                                @if(!request()->has('agent'))
                                <script type="text/javascript">
                                    var count = 2;
                                    $("#addmore").click(function() {

                                        var number_html =
                                        '<div class="expended_html"> <div class="form-group"> <div class="row">   <input type="hidden" name="section[]" value="1"><div class="col-md-1 col-md-offset-2"><label for="">Airline</label>  </div>  <div class="col-sm-2"><select class="form-control " name="airline[]"><option value="">Airline</option>@foreach($airlines as $a) <option value="{{ $a->id }}" >{{ $a->name }}</option>@endforeach </select></div><div class="col-sm-2">    <select class="form-control " name="from[]" ><option value="">From</option>@foreach($cities as $a)<option value="{{ $a->name }}" >{{ $a->name }}</option>@endforeach </select></div> <div class="col-sm-2">    <select class="form-control " name="to[]"><option value="">To</option>@foreach($cities as $a)         <option value="{{ $a->name }}">{{ $a->name }}</option> @endforeach </select> </div> </div></div> <div class="form-group"> <div class="form-group"><div class="row"> <div class="col-md-1 col-md-offset-2"><label>Pricing</label> </div> <div class="col-sm-2"> <input type="text" name="price[]" placeholder="Price" class="form-control"  value="{{ isset($p)&&!is_null($p)?$p->price:'
                                        ' }}" > </div><div class="col-sm-2"><select name="stars[]" class="form-control"><option value="">Hotel Stars</option><option value="1">1</option>option value="2">2</option><option value="3">3</option>option value="4">4</option><option value="5">5</option></select></div><div class="col-sm-2"> <input type="text" name="nights[]" placeholder="Days" class="form-control"  value="{{ isset($p)&&!is_null($p)?$p->nights:'
                                        ' }}" ></div><div class="col-sm-2"><a href="javascript:;" class="removeNo  btn-danger btn-sm " style="margin-bottom:5px" > &times;</a></div></div></div></div>';

                                        $(".new_image").append(number_html);

                                        count++;

                                        $(".removeNo").click(function() {
                                            $(this).closest('.expended_html').remove();
                                            count--;

                                            $("#addmore").show();
                                        });
                                    });
                                    $("#addmore2").click(function() {

                                        var number_html =
                                        '<div class="expended_html"> <div class="form-group"> <div class="row">   <input type="hidden" name="section[]" value="2"><div class="col-md-1 col-md-offset-2"><label for="">Airline</label>  </div>  <div class="col-sm-2"><select class="form-control " name="airline[]"><option value="">Airline</option>@foreach($airlines as $a) <option value="{{ $a->id }}" >{{ $a->name }}</option>@endforeach </select></div><div class="col-sm-2">    <select class="form-control " name="from[]" ><option value="">From</option>@foreach($cities as $a)<option value="{{ $a->name }}" >{{ $a->name }}</option>@endforeach </select></div> <div class="col-sm-2">    <select class="form-control " name="to[]"><option value="">To</option>@foreach($cities as $a)         <option value="{{ $a->name }}">{{ $a->name }}</option> @endforeach </select> </div> </div></div> <div class="form-group"> <div class="form-group"><div class="row"> <div class="col-md-1 col-md-offset-2"><label>Pricing</label> </div> <div class="col-sm-2"> <input type="text" name="price[]" placeholder="Price" class="form-control"  value="{{ isset($p)&&!is_null($p)?$p->price:'
                                        ' }}" > </div><div class="col-sm-2"><select name="stars[]" class="form-control"><option value="">Hotel Stars</option><option value="1">1</option>option value="2">2</option><option value="3">3</option>option value="4">4</option><option value="5">5</option></select></div><div class="col-sm-2"> <input type="text" name="nights[]" placeholder="Days" class="form-control"  value="{{ isset($p)&&!is_null($p)?$p->nights:'
                                        ' }}" ></div><div class="col-sm-2"><a href="javascript:;" class="removeNo  btn-danger btn-sm " style="margin-bottom:5px" > &times;</a></div></div></div></div>';

                                        $(".new_image2").append(number_html);

                                        count++;

                                        $(".removeNo").click(function() {
                                            $(this).closest('.expended_html').remove();
                                            count--;

                                            $("#addmore").show();
                                        });
                                    });
                                    $("#addmore3").click(function() {

                                        var number_html =
                                        '<div class="expended_html"> <div class="form-group"> <div class="row">   <input type="hidden" name="section[]" value="3"><div class="col-md-1 col-md-offset-2"><label for="">Airline</label>  </div>  <div class="col-sm-2"><select class="form-control " name="airline[]"><option value="">Airline</option>@foreach($airlines as $a) <option value="{{ $a->id }}" >{{ $a->name }}</option>@endforeach </select></div><div class="col-sm-2">    <select class="form-control " name="from[]" ><option value="">From</option>@foreach($cities as $a)<option value="{{ $a->name }}" >{{ $a->name }}</option>@endforeach </select></div> <div class="col-sm-2">    <select class="form-control " name="to[]"><option value="">To</option>@foreach($cities as $a)         <option value="{{ $a->name }}">{{ $a->name }}</option> @endforeach </select> </div> </div></div> <div class="form-group"> <div class="form-group"><div class="row"> <div class="col-md-1 col-md-offset-2"><label>Pricing</label> </div> <div class="col-sm-2"> <input type="text" name="price[]" placeholder="Price" class="form-control"  value="{{ isset($p)&&!is_null($p)?$p->price:'
                                        ' }}" > </div><div class="col-sm-2"><select name="stars[]" class="form-control"><option value="">Hotel Stars</option><option value="1">1</option>option value="2">2</option><option value="3">3</option>option value="4">4</option><option value="5">5</option></select></div><div class="col-sm-2"> <input type="text" name="nights[]" placeholder="Days" class="form-control"  value="{{ isset($p)&&!is_null($p)?$p->nights:'
                                        ' }}" ></div><div class="col-sm-2"><a href="javascript:;" class="removeNo  btn-danger btn-sm " style="margin-bottom:5px" > &times;</a></div></div></div></div>';

                                        $(".new_image3").append(number_html);

                                        count++;

                                        $(".removeNo").click(function() {
                                            $(this).closest('.expended_html').remove();
                                            count--;

                                            $("#addmore").show();
                                        });
                                    });
                                </script>
                                <script type="text/javascript">
                                    $(document).on('keyup', '#title', function() {
                                        var title = $('#title').val();
                                        var title = title.charAt(0).toUpperCase() + title.slice(1);
                                        $('#meta_title').val(title);
                                        var html = '<span>' + title.substr(0, 55) + '</span><span style="color:red">' + title.substr(55, 1000) +
                                        '</span>'
                                        $('#preview_title').html(html);
                                        var slug = title;
                                        slug = slug.toLowerCase();
                                        slug = slug.replace(/ /g, '-');
                                        slug = slug.replace(/[^\w-]+/g, '');
    // $('#slug').val(MAIN_PATH + '/' + slug);
    $('#preview_url').html(MAIN_PATH + '/' + slug);

});
                                    $(document).on('keyup', '#meta_title', function() {
                                        var title = $('#meta_title').val();
                                        var html = '<span>' + title.substr(0, 55) + '</span><span style="color:red">' + title.substr(55, 1000) +
                                        '</span>'
                                        $('#preview_title').html(html);
                                        var slug = title;
                                        slug = slug.toLowerCase();
                                        slug = slug.replace(/ /g, '-');
                                        slug = slug.replace(/[^\w-]+/g, '');


                                    });
                                    $(document).on('keyup', '#slug', function() {
                                        var title = $('#slug').val();
                                        var slug = title;
                                        slug = slug.replace(MAIN_PATH, '');
                                        slug = slug.toLowerCase();
                                        slug = slug.replace(/ /g, '-');
                                        slug = slug.replace(/[^\w-]+/g, '');
                                        $('#preview_url').html(MAIN_PATH + '/' + slug);

                                    });
                                    $(document).on('keyup', '#meta_description', function() {
                                        var data = $('#meta_description').val();
                                        var html = '<span>' + data.substr(0, 155) + '</span><span style="color:red">' + data.substr(155, 1000) +
                                        '</span>';
                                        $('#preview_description').html(html);

                                    });
                                    var $textarea = $("#content");


                                    CKEDITOR.instances[$textarea.attr('name')].on('key', function(e) {
                                        var data = CKEDITOR.instances[$textarea.attr('name')].getData();
                                        data = data.replace(/(<([^>]+)>)/ig, "");
                                        $('#meta_description').val(data);
                                        var html = '<span>' + data.substr(0, 155) + '</span><span style="color:red">' + data.substr(155, 1000) +
                                        '</span>';
                                        $('#preview_description').html(html);
                                    });
                                </script>
                                @endif
                                @endpush