@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-12">
            @if(isset($agentDetail) && !is_null($agentDetail))
             <h1 class="text-capitalize mb-1 mt-3 pb-0 "><b>{{strtolower($agentDetail->business_name)}} Umrah Tickets</b></h1>
            @else
            @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to')))  
            <h1 class="text-center mt-3"><b>{{request()->get('from')}} To {{request()->get('to')}} Sasti Umrah Tickets</b></h1> 
            @else
               <h1 class="text-center mt-3 ticketsHeading"><b>Sasti Umrah Tickets</b></h1>
            @endif
            <form  action="{{route('flight')}}" method="get"  id="filter">
                  @if(!request()->has('airline') || !request()->has('from') || !request()->has('to'))
                <div class="embassy-search mt-2 {{!$detect->isMobile()?'pb-2 pt-4':'pb-3 pt-3'}} " style="border: 2px solid #070c39;background: #070c39;color: #fff">
                    <div class="row">
                        <div class="col-md-4 col-6 form-group">
                    <!--         <label for=""><b>From</b></label> -->
                            <select name="from" class="form-control">
                                <option value="">From</option>
                                @foreach($from as $c)
                                <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') == $c->name?'selected':''}}>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-6 form-group">
       <!--                      <label for=""><b>To</b></label> -->
                            <select name="to" class="form-control">
                                <option value="">To</option>
                                @foreach($to as $c)
                                <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') == $c->name)?'selected':''}}>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 text-center">
                    
                            <button  type="submit" class="btn search btn-primary {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif --> Search Flights </button>
                        </div>
                    </div>
                </div>
                @endif
                @if(!$detect->isMobile())
                     @if(request()->has('airline') || request()->has('from') || request()->has('to'))
                <div class="embassy-search mt-2 filtersclass" style="border: 2px solid #070c39;">
                    <div class="row">
                        <div class="col-md-3 ">
                            <select name="agent" class="form-control" onchange="filters()">
                                <option value="">Agents</option>
                                @foreach($agents as $c)
                                <option value="{{$c->id}}" class="text-capitalize" >{{ strtolower($c->business_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <!--    <label><b>By Month</b></label> -->
                            <select name="month" class="form-control" onchange="filters()" >
                                <option value="">By Month</option>
                                <option value="10" {{request()->has('month') && request()->get('month') == '10'?'selected':''}}>October</option>
                                <option value="11" {{request()->has('month') && request()->get('month') == '11'?'selected':''}}>November</option>
                                <option value="12" {{request()->has('month') && request()->get('month') == '12'?'selected':''}}>December</option>
                                <option value="01" {{request()->has('month') && request()->get('month') == '01'?'selected':''}}>January</option>
                                <option value="02" {{request()->has('month') && request()->get('month') == '02'?'selected':''}}>February</option>
                                <option value="03" {{request()->has('month') && request()->get('month') == '03'?'selected':''}}>March</option>
                                <option value="04" {{request()->has('month') && request()->get('month') == '04'?'selected':''}}>April</option>
                                <option value="05" {{request()->has('month') && request()->get('month') == '05'?'selected':''}}>May</option>
                                <option value="06" {{request()->has('month') && request()->get('month') == '06'?'selected':''}}>June</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="airline" class="form-control" id="airline" onchange="filters()" >
                                <option value="">Select Airline</option>
                                @foreach($airlines as $a)
                                <option value="{{$a->id}}" {{request()->has('airline') && request()->get('airline') == $a->id?"selected":""}}>{{$a->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sort" id="sort" class="form-control"  onchange="filters()" >
                   <!--              <option value="">All</option> -->
                                <option value=""  >Nearest Date</option>
                                <option value="low">Low to high prices</option>
                                <option value="high" {{ request()->has("sort") && request()->get("sort") == "high" ? "selected":"" }} >High to low prices</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                @endif
            </form>
            @else
            <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()"> @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to'))) {{request()->get('from')}} To {{request()->get('to')}} @else Filter Flights @endif <span style="float: right;"><i class="fas fa-arrow-down" ></i> Filters </span></div>
            <div id="mobileSearch" class=" embassy-search mb-2 filtersclass" style="    border: 2px solid #070c39; display: none;">
                <form  action="{{route('flight')}}" method="get"  id="filter" onsubmit="return false;">
                    <div class="form-group">
                        <select name="agent" class="form-control" onchange="filters()">
                            <option value="">Agents</option>
                            @foreach($agents as $c)
                            <option value="{{$c->id}}" class="text-capitalize" >{{strtolower($c->business_name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <!--    <label><b>By Month</b></label> -->
                        <select name="month" class="form-control"  onchange="filters()">
                            <option value="">By Month</option>
                            <option value="10" {{request()->has('month') && request()->get('month') == '10'?'selected':''}}>October</option>
                            <option value="11" {{request()->has('month') && request()->get('month') == '11'?'selected':''}}>November</option>
                            <option value="12" {{request()->has('month') && request()->get('month') == '12'?'selected':''}}>December</option>
                            <option value="01" {{request()->has('month') && request()->get('month') == '01'?'selected':''}}>January</option>
                            <option value="02" {{request()->has('month') && request()->get('month') == '02'?'selected':''}}>February</option>
                            <option value="03" {{request()->has('month') && request()->get('month') == '03'?'selected':''}}>March</option>
                            <option value="04" {{request()->has('month') && request()->get('month') == '04'?'selected':''}}>April</option>
                            <option value="05" {{request()->has('month') && request()->get('month') == '05'?'selected':''}}>May</option>
                            <option value="06" {{request()->has('month') && request()->get('month') == '06'?'selected':''}}>June</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="airline" class="form-control" id="airline"  onchange="filters()">
                            <option value="">Airline</option>
                            @foreach($airlines as $a)
                            <option value="{{$a->id}}" {{request()->has('airline') && request()->get('airline') == $a->id?"selected":""}}>{{$a->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="sort" id="sort" class="form-control"   onchange="filters()">
                          <option value=""  >Nearest Date</option>
                          <option value="low">Low to high prices</option>
                          <option value="high" {{ request()->has("sort") && request()->get("sort") == "high" ? "selected":"" }} >High to low prices</option>
                      </select>
                    </div>
                </form>
            </div>
            @endif
           @endif
            @if($flights->count() > 0)
              @if(request()->has('airline') || request()->has('from') || request()->has('to'))
               <a href="{{url('cheap-umrah-flights-from-pakistan')}}" class="float-right text-sm text-dark mt-3 mb-3 btn-block d-block text-right" style="font-size:16px"><i class="fa fa-undo"></i> Back to Search</a>
                 <div data-next-page="{{ $flights->nextPageUrl() }}" class=" endless-pagination">
                @if(!$detect->isMobile())
                <table class="table  table-bordered mt-4 text-center">
                    <thead>
                        <tr>
                            <th width="10%">Airline</th>
                            <th>Flight No.</th>
                            <th>From</th>
                            <!--  <th>One Stop</th> -->
                            <th>To</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Conditions</th>
                            <th>Luggage</th>
                            <th width="18%">Travel Agent</th>
                        </tr>
                    </thead>
                    <tbody class="append-data" id="agentPackgesData">
                        @include('partials.load-flight')
                    </tbody>
                </table>
                @else
                <div class="append-data" id="agentPackgesData">
                    @include('partials.load-flight')
                </div>
                @endif

            </div>
                @if(!empty($flights->nextPageUrl()))
                <div class="text-center">
                    <button id="loadmore" class="btn btn-default" onclick="fetchPosts()">Load More Flights</button>
                    <div class="clearfix"></div>
                    <br>
                </div>
                @endif
            @else
                <div class="row text-center mt-3">
                                        @if($all_flights->where('airlines_id',7)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=7') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/flydubai.png') }}" class="img-fluid" alt="Fly Dubai" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',7)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',8)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=8') }}"  style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/air-arabia.png') }}" class="img-fluid" alt="Air Arabia" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',8)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',20)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=20') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/salam-air.png') }}" class="img-fluid" alt="Salam Air" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',20)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',19)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=19') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/jazeera.png') }}" class="img-fluid" alt="Jazeera Airways" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',19)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                <!--<div class="col-md-12 mb-4"><h2>P                   akistan to KSA Direct Carriers</h2></div>-->
                @if($all_flights->where('airlines_id',1)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=1') }}" style="background:#f1f1f1;padding:12px; 10pxwidth:100%;display:block">
                            <img src="{{ asset('airlines/pia.png') }}" class="img-fluid" alt="PIA" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',1)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',2)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=2') }}" style="background:#f1f1f1;padding:12px; 10pxwidth:100%;display:block">
                            <img src="{{ asset('airlines/airblue.png') }}" class="img-fluid" alt="Air Blue" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',2)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',16)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=16') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/airsial.png') }}" class="img-fluid" alt="Air Sial" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',16)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',6)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=6') }}" style="background:#f1f1f1;padding:12px; 10pxwidth:100%;display:block">
                            <img src="{{ asset('airlines/saudia.png') }}" class="img-fluid" alt="Saudia Airlines" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',6)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',13)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=13') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/serene.png') }}" class="img-fluid" alt="Serene Air" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',13)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',17)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=17') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/flyjinnah.png') }}" class="img-fluid" alt="Fly Jinnah" style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',17)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',14)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=14') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/nasair.png') }}" class="img-fluid" alt="NAS Air"  style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',14)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif
                    @if($all_flights->where('airlines_id',24)->count())
                    <div class="col-md-3 col-6 mb-4">
                        <a href="{{ url('cheap-umrah-flights-from-pakistan?airline=24') }}" style="background:#f1f1f1;padding:15px 10px;width:100%;display:block">
                            <img src="{{ asset('airlines/airdeal.png') }}" class="img-fluid" alt="Air Deal"  style="object-fit:contain;width:100%;height:90px">
                            <h5 class="text-center mt-3 text-dark mb-0">{{$all_flights->where('airlines_id',24)->count()}} Flights</h5>
                        </a>
                    </div>
                    @endif

                </div>
              @endif
            @else
            <br>
            <p class="text-center"><strong>No flight added by agents</strong></p>
            @endif
        </div>
    </div>
</section>
@endsection
@push('script')
<script type="text/javascript">
   function filters(){
      var formData = $("#filter").serialize();

      $.ajax({
        url: "{{request()->url()}}",
        type: "GET",
        data: formData,
        beforeSend: function()
        {
              $('#loadmore').hide();
          $('#agentPackgesData').html('<p class="text-center" style="width:100%"><b><i class="fa fa-spinner fa-spin"></i> Loading...</b></p>');
      }

  }).done(function(data)
  {
    if(data.html == ""){
       $('#agentPackgesData').html('<p class="text-center" style="width:100%"><b>No Record found</b></p>');
       return;
   }
     $('.endless-pagination').attr('data-next-page', data.next_page);
   $("#agentPackgesData").html(data.html);
      if(data.next_page !== null) {
        $('#loadmore').show();
    }else{
        $('#loadmore').hide();
    }
});
}
$(document).ready(function () {
  $(document).on('click','.showDetail',function(){
     var d = $(this).parent().find('.show-dropdown');
     d.toggle();
 });
  $(document).on('click','#expandmobileSearch',function() {

     $('#mobileSearch').toggle();
 });
    $(document).on('click','.search',function() {
      $.each($(".filtersclass select option:selected"), function () {
      
        $(this).prop('selected', false); // <-- HERE
    });
      filters();
    });
})

function fetchPosts() {

     var page = $('.endless-pagination').attr('data-next-page');

    if(page !== null) {



        $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Flights');
        $('#loadmore').prop('disabled',true);
        $.get(page, function(data){

            $('.append-data').append(data.html);
            $('#loadmore').html('Load More Flights');
             $('#loadmore').prop('disabled',false);
              if(data.next_page !== null) {
                $('#loadmore').show();
              }else{
                $('#loadmore').hide();
              }
            $('.endless-pagination').attr('data-next-page', data.next_page);
        });


    }
}
</script>
@endpush