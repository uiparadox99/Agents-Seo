@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @if($detect->isMobile())
                <a href="{{url('agent-sasti-tickets?old=yes')}}" class="btn btn-warning btn-sm" style="margin:0 auto;color: #fff;    position: absolute;    top: 15px;">Tickets History</a>@endif
            @include('includes.user-sidebar')
        </div>
        <div class="col-md-9 agent-main-box">

            <h3>Sasti Tickets <a href="{{url('agent-add-sasti-ticket')}}" class="btn btn-primary" style="float:right">Add Ticket</a>  @if(!$detect->isMobile())<a href="{{url('agent-sasti-tickets?old=yes')}}" class="btn btn-warning" style="float:right;margin-right:10px;color: #fff">Tickets History</a> @endif </h3>
            
            @if($detect->isMobile())
            <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()"> Search Tickets <i class="fa fa-filter" style="float: right;"></i></div>
            <div class="content-box-agent" id="mobileSearch" style=" display: none;">
                @else
                <div class="content-box-agent">
                    @endif
                    <!--onsubmit="return false;"-->
                    <form method="get" id="filter"  action="{{url('agent-sasti-tickets')}}">
                        <div class="row">
                            <input type="hidden" name="old" value="{{request()->has('old')?request()->get('old'):''}}">
                            <div class="col-md-3 form-group">
                                <label>Airlines</label>
                                <select name="airline" class="form-control" onchange="filters()">
                                    <option value=""> Select</option>
                                    @foreach($airlines as $c)
                                    <option value="{{$c->id}}" {{request()->has('airline') && request()->get('airline') == $c->id?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>From</label>
                                <select name="from" class="form-control" onchange="filters()">
                                    <option value=""> Select</option>
                                    @foreach($from as $c)
                                    <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') == $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To</label>
                                <select name="to" class="form-control" onchange="filters()">
                                    <option value=""> Select</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->name}}" {{request()->has('to') && request()->get('to') == $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Type</label>
                                <select name="type" class="form-control" onchange="filters()">
                                    <option value=""> Select</option>
                                    <option value="one_way" {{request()->has('type') && request()->get('type') == 0?'selected':''}}>One Way</option>
                                    <option value="1" {{request()->has('type') && request()->get('type') == 1?'selected':''}}> Return</option>
                                </select>
                            </div>
                            <!--    <div class="col-md-3 form-group">
                                <label>By Date</label>
                                <input type="text" name="date" class="form-control datepicker" autocomplete="off" value="{{request()->has('date')?request()->get('date'):''}}">
                            </div>
                            -->
                            <!-- <div class="col-md-12 form-group text-center">
                                <button type="submit" class="btn btn-primary "><i class="fa fa-search" style="margin-right: 10px;"></i> Search</button>
                            </div> -->
                        </div>
                    </form>
                </div>
                @if(!is_null($agent->code))
                <p>Your Umrah Tickets mini website. <a href="{{route('agent-site-tickets',$agent->code)}}" target="_blank" id="copycontent" class="btn btn-warning text-white btn-sm">My Website</a>  <button  onclick="copy()" class="btn btn-primary btn-sm">Copy Link</button></p>
      
                @endif
                  @if($flights->count() > 0)
                    <div class="table-responsive ">
            <table class="table table-bordered " >
                <thead>
                    <tr >
                        <th width="10%">Airline</th>
                        <th> From</th>
                        <th> To</th>
                        <th> Via</th>
                        
                        <th> Price</th>
                        <th> Meals</th>
                        <th> Lauggage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody  id="agentPackgesData">
                    @include('partials.agent-sasti-tickets')
                </tbody>
            </table>
        </div>
        <div class="pagination">
            
        {!! $flights->appends(request()->query())->links() !!}
        </div>
        @endif
                @if($flights->count() == 0)
                    <div class="content-box-agent">
                        <p class="no-record">No Ticket Added</p>
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
    var formData = $("#filter").submit();
    //   var formData = $("#filter").serialize();
    // $.ajax({
    // url: "{{request()->url()}}",
    // type: "GET",
    // data: formData,
    // beforeSend: function()
    // {
    // $('#agentPackgesData').html('<tr><td colspan="10"class="text-center"><b><i class="fa fa-spinner fa-spin"></i> Loading...</b></td></tr>');
    // }
    // }).done(function(data)
    // {
    // if(data.html == ""){
    // $('#agentPackgesData').html('<tr><td colspan="10" class="text-center"><b>No Record found</b></td></tr>');
    // return;
    // }
    // $("#agentPackgesData").html(data.html);
    // });
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
    url: SITE_PATH + '/agent-sasti-ticket-active',
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