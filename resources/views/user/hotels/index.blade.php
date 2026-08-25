@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>
        <div class="col-md-9 agent-main-box">
            <h3>Umrah Hotels <a href="{{url('agent-add-umrah-hotel')}}" class="btn btn-primary" style="float:right">Add Hotel</a>   </h3>
            @if($detect->isMobile())
            <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()"> Search Hotel <i class="fa fa-filter" style="float: right;"></i></div>
            <div class="content-box-agent" id="mobileSearch" style=" display: none;">
                @else
                <div class="content-box-agent">
                    @endif
                    <form method="get" id="filter" onsubmit="return false;" action="{{url('agent-sasti-tickets')}}">
                        <div class="row">
                            <input type="hidden" name="old" value="{{request()->has('old')?request()->get('old'):''}}">
                            <div class="col-md-2 form-group">
                                <label>City</label>
                                <select name="city" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-5 form-group">
                                <label>Hotel Name</label>
                                <select name="hotel_name" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($searchotel as $h)
                                    <option value="{{$h->id}}">{{$h->name}}</option>
                                    @endforeach
                                </select>
                                
                                
                            </div>
                            
                            <!--  <div class="col-md-3 form-group">
                                <label>Hotel Star</label>
                                <select name="hotel_star" class="form-control">
                                    <option value="">Select</option>
                                    <option value="economy">Economy </option>
                                    <option value="economy plus">Economy Plus</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                                
                            </div> -->
                            
                            <div class="col-md-3 form-group">
                                <label>Meal Type</label>
                                <select name="meal_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="room only">Room Only</option>
                                    <option value="breakfast">Breakfast</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="dinner">Dinner</option>
                                </select>
                                
                            </div>
                            
                            
                            <div class="col-md-2 form-group ">
                                <label>&nbsp;</label>
                                <button onclick="filters()" class="btn btn-primary btn-block"><i class="fa fa-search" style="margin-right: 10px;"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if(!is_null($agent->code))
                <p>Your Umrah Hotels mini website. <a href="{{route('agent-umrah-hotels',$agent->code)}}" target="_blank"  id="copycontent" class="btn btn-warning text-white btn-sm">My Website</a>  <button  onclick="copy()" class="btn btn-primary btn-sm" >Copy Link</button></p>
                
                @endif
                @if($hotels->count() > 0)
                <div class="table-responsive ">
                    <table class="table table-bordered " >
                        <thead>
                            <tr >
                                <th width="41%">Hotel Name</th>
                                <!--    <th> Hotel Star</th>   -->
                                <th width="11%">Double</th>
                                <th width="11%">Tripple</th>
                                <th width="11%">Quad</th>
                                <th width="14%">Meal</th>
                                <!--       <th>Saudi Agent</th> -->
                                <th width="12%">Action</th>
                            </tr>
                        </thead>
                        <tbody  id="agentPackgesData">
                            @include('partials.agent-hotels')
                        </tbody>
                    </table>
                    {!! $hotels->links() !!}
                </div>
                @endif
                @if($hotels->count() == 0)
                <div class="content-box-agent">
                    <p class="no-record">No Hotel Added</p>
                </div>
                @endif
            </div>
        </div>
        
        
    </div>
    @endsection
    @push('script')
    <script type="text/javascript">
    $( document ).ready(function() {
    $('#expandmobileSearch').click(function() {
    $('#mobileSearch').toggle();
    });
    });
    function filters(){
    var formData = $("#filter").serialize();
    $.ajax({
    url: "{{request()->url()}}",
    type: "GET",
    data: formData,
    beforeSend: function()
    {
    $('#agentPackgesData').html('<tr><td colspan="10"class="text-center"><b><i class="fa fa-spinner fa-spin"></i> Loading...</b></td></tr>');
    }
    }).done(function(data)
    {
    if(data.html == ""){
    $('#agentPackgesData').html('<tr><td colspan="10" class="text-center"><b>No Record found</b></td></tr>');
    return;
    }
    $("#agentPackgesData").html(data.html);
    });
    }
    function addToHome(pointer) {
    var SITE_PATH = "{{ url('/') }}";
    var $this = $(pointer);
    var tr = $this.closest('tr');
    var id = tr.data('id');
    if ($this.is(':checked')) {
    var is_home = 1;
    } else {
    var is_home = 0;
    }
    $this.prop("disabled", true);
    $this.val("Processing..");
    $.ajax({
    url: SITE_PATH + '/agent-umrah-hotel-active',
    type: 'GET',
    data: {
    is_home: is_home,
    id: id
    },
    dataType: "JSON",
    success: function(data) {
    if (data.notify) {
    $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
    } else {
    $(".top" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
    }
    },
    error: function() {
    },
    complete: function() {
    $this.prop("disabled", false);
    }
    });
    }
    </script>
    @endpush