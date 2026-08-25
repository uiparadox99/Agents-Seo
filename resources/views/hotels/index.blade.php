@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-12">
                 @if(isset($agentDetail) && !is_null($agentDetail))
             <h2 class="text-capitalize mb-1 mt-3 pb-0 "><b>{{strtolower($agentDetail->business_name)}} Umrah Hotels</b></h2>
             <hr>
            @else
          
            <form  action="{{route('flight')}}" method="get"  id="filter" onsubmit="return false;">
                <div class="embassy-search mt-2 {{!$detect->isMobile()?'pb-2 pt-4':'pb-3 pt-3'}} " style="border: 2px solid #070c39;background: #070c39;color: #fff">
                    <div class="row">
                          <div class="col-md-4 form-group">
                             <!--    <label>Hotel Name</label> -->
                             <select name="hotel_name" class="form-control">
                                    <option value=""> Hotel</option>
                                    @foreach($searchotel as $h)
                                    <option value="{{$h->id}}">{{$h->name}}</option>
                                    @endforeach
                                </select>
                               <!--  <input type="text" name="hotel_name" class="form-control" placeholder="Hotel Name"> -->
                                
                            </div>
                              <div class="col-md-4 form-group">
                           <!--      <label>City</label> -->
                                   <select name="city" class="form-control">
                                    <option value="">City</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        <div class="col-md-4 text-center">
                    
                            <button   type="button" class="btn btn-primary search {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif --> Search Hotels </button>
                        </div>
                    </div>
                </div>
                @if(!$detect->isMobile())
                <div class="embassy-search filtersclass mt-2" style="border: 2px solid #070c39;">
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
                          <!--       <label>Hotel Star</label> -->
                                <select name="hotel_star" class="form-control" onchange="filters()">
                                    <option value="">Hotel Type</option>
                                   @foreach($types as $t)
                                   <option value="{{$t->id}}">{{$t->name}}</option>
                                   @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                               <!--  <label>Room Type</label> -->
                                <select name="room_type" class="form-control" onchange="filters()">
                                    <option value="">Room Type</option>
                                    <option value="double">Double</option>
                                    <option value="triple">Triple</option>
                                    <option value="quad">Quad</option>
                                    <option value="penta">Penta</option>
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                     <!--            <label>Meal Type</label> -->
                                <select name="meal_type" class="form-control" onchange="filters()">
                                    <option value="">Meal Type</option>
                                    <option value="room only">Room Only</option>
                                    <option value="breakfast">Breakfast</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="dinner">Dinner</option>  
                                </select>
                                
                            </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
            @else
            <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()"> @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to'))) {{request()->get('from')}} To {{request()->get('to')}} @else Search Hotel @endif <span style="float: right;"><i class="fas fa-arrow-down" ></i> Filters </span></div>
            <div id="mobileSearch" class=" filtersclass embassy-search mb-2" style="    border: 2px solid #070c39; display: none;">
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
                          <!--       <label>Hotel Star</label> -->
                             <select name="hotel_star" class="form-control" onchange="filters()">
                                    <option value="">Hotel Type</option>
                                   @foreach($types as $t)
                                   <option value="{{$t->id}}">{{$t->name}}</option>
                                   @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group">
                               <!--  <label>Room Type</label> -->
                                <select name="room_type" class="form-control" onchange="filters()">
                                    <option value="">Room Type</option>
                                    <option value="double">Double</option>
                                    <option value="triple">Triple</option>
                                    <option value="quad">Quad</option>
                                    <option value="penta">Penta</option>
                                </select>
                                
                            </div>
                            <div class="form-group">
                     <!--            <label>Meal Type</label> -->
                                <select name="meal_type" class="form-control" onchange="filters()">
                                    <option value="">Meal Type</option>
                                    <option value="room only">Room Only</option>
                                    <option value="breakfast">Breakfast</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="dinner">Dinner</option>  
                                </select>
                                
                            </div>
                </form>
            </div>
            @endif
           @endif
            @if($hotels->count() > 0)
            <div  data-next-page="{{ $hotels->nextPageUrl() }}"  class=" endless-pagination" >
              @if(!$detect->isMobile())
              <table class="table table-striped mt-4 text-center">
                <thead>
                  <tr>
                    <th width="25%">Hotel Name</th>
                    <th width="10%"> Double</th>  
                    <th width="10%">Tripple</th>
                    <th width="10%">Quad</th>
                    <th width="20%">Validity / Meal</th>
                    <th width="30%">Travel Agent</th>
                  </tr>
                </thead>
                <tbody  class="append-data"  id="agentPackgesData">
                    @include('partials.load-umrah-hotels')
                </tbody>
              </table>
              @else
               <div class="append-data"  id="agentPackgesData">
                @include('partials.load-umrah-hotels')
            </div>
            @endif
        </div>
            @if(!empty($hotels->nextPageUrl()))
                <div class="text-center">
                    <button id="loadmore" class="btn btn-default" onclick="fetchPosts()">Load More Tickets</button>
                    <div class="clearfix"></div>
                    <br>
                </div>
                @endif
           
            @else
            <br>
            <p class="text-center"><strong>No Hotel added by agents</strong></p>
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
          $('#agentPackgesData').html('<tr><td colspan="6"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
      }

  }).done(function(data)
  {
    if(data.html == ""){
       $('#agentPackgesData').html('<tr><td colspan="6"><b>No Record found</b></td></tr>');
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



        $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Tickets');
        $('#loadmore').prop('disabled',true);
        $.get(page, function(data){

            $('.append-data').append(data.html);
            $('#loadmore').html('Load More Tickets');
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