@extends('layouts.master')
@section('content')
<style type="text/css">
    .agent-search-bar-main{
        display: none;
    }

</style>
@include('includes.slider')
<!-- @php $image =  isset($searchCity) && !empty($searchCity) && !empty($searchCity->image)? url("storage/uploads/agents/".$searchCity->image):url("images/1920x712.jpg"); @endphp

<section id="slider" style="background:  url('{{$image}}') no-repeat;  background-color: #fee07e; background-position: center bottom;" >

    <div class="container">

        <div class="search text-center" >



        </div>
    </div>
    
</section> -->
@if(isset($agents) && !is_null($agents))
<section id="content" class="container" style="padding-top: 20px;">
    <div class="row">
        <div class="col-md-3">
            <form action="{{request()->getRequestUri()}}" method="get" id="filtersForm" onsubmit="return false">
               
                @if(isset($searchCity) && !empty($searchCity))
                <div class="filter-box">
                    <h4 class="text-center" style="    font-size: 18px;">Sort Agent By Name</h4>


                    <div style="padding:8px;">
                        @if($detect->isMobile())
                        <div class="input-group input-group-lg">

                            <input type="text" name="q" id="agent_name" class="form-control" value="{{!empty(request()->get('q'))?request()->get('q'):''}}" placeholder="Agent Name">
                            <div class="input-group-append" >
                                <span class="input-group-text" id="agent_name_search" onclick="filters()" style="cursor: pointer;    background: #f58220; color: #fff;"> <i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                        
                            <input type="text" name="q" placeholder="Agent Name" id="agent_name" class="form-control"
                                value="{{!empty(request()->get('q'))?request()->get('q'):''}}">
                        </div>
                        <button type="button" id="agent_name_search" onclick="filters()" class="btn btn-primary btn-block">Search</button>
                        @endif
                    </div>
                </div>
                @endif
                @if(!$detect->isMobile())
                <div class="filter-box">
                    <h4 class="text-center" style="    font-size: 18px;">Agent Types</h4>
                    <ul style="height: 100%;overflow: hidden;">
                        @foreach($types as $c)
                        <li><input type="radio" name="type" value="{{$c->id}}" onchange="filters()" id="type{{$c->id}}"
                                {{!is_null(request()->get('type')) && request()->get('type') == $c->id?'checked':''}}>
                            <label for="type{{$c->id}}">{{$c->name}}</label></li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <input type="hidden" name="verified" value="" id="show_verfified_agents">
            </form>
        </div>
        <div class="col-md-9 ">
         <h3 class="agent-city-search-heading" style="color: #070c39;"><b>Travel Agents in {{isset($searchCity) && !empty($searchCity)?$searchCity->name:'Pakistan'}}</b> <button  onclick="showverified()" id="show_verified" class="btn btn-primary btn-sm" style="float: right;">Show Verified Agents</button><button  onclick="allverified()" id="all_agents" class="btn btn-warning btn-sm" style="float: right;display: none;color: #fff">All Agents</button> <div class="clearfix"></div></h3>
  
                   @if($agents->count() > 0)
                   <div class=" endless-pagination"  data-next-page="{{ $agents->nextPageUrl().'&q='.request()->get('q') }}">
                    <div class="append-data"  id="agentData">
                        @include('partials.agent-listing')
                    </div>
                  <!--   <div class="ajax-load text-center" style="display:none">
                      <p class="text-center"><img src="{{url('public/spinner.gif')}}" style="width: 150px" alt="loading more Agents">Loading More Agents</p>
                  </div> -->
                </div>
                @if(!empty($agents->nextPageUrl()))
                <div class="text-center">
                    <button id="loadmore" class="btn btn-default" onclick="fetchPosts()">Load More Agents</button>
                    <div class="clearfix"></div>
                    <br>
                </div>
                @endif
                           @else
            <p class="text-center"><strong>No Travel Agent Found</strong></p>
            @endif
                

         
        </div>
    </div>
</section>
@else
<section id="content" class="container" style="padding-top: 20px; margin-bottom:20px;">
    @if($detect->isMobile())
    <a href="{{ route('new-umrah-policy-2019') }}" class="  " style="color:unset;text-align:center;text-decoration:underline;    display: block;
    margin-bottom: 11px;
    font-weight: 700;  font-size: 19px;    color: red;">New Umrah Policy <span class="number-style">2019</span></a>
    @endif
    <div class="agents-city-section" style="">
        <div class="row">
            <div class="col-md-6">
               <div class="text-center">
                <h3 style="font-weight: 700; margin-bottom: 18px;font-size: 22px;">Search Travel Agent by <span style="color: #f58220;">Name</span></h3></div>
                <form id="AgentSearchForm" class="" method="get" action="{{url('travel-agents-in-pakistan')}}">
                    <div class="input-group input-group-lg  mb-3">
                        <input type="text" class="form-control"
                        value="{{!empty(request()->get('q'))?request()->get('q'):''}}" id="agentbar"
                        autocomplete="off" name="q" placeholder="Search By Name" style="    height: 40px;">
                        <div class="input-group-append" id="submitAgentSearch" style="cursor: pointer;     height: 40px;">
                            <span class="input-group-text" style="background: #f58220;color: #fff;"> @if(!$detect->isMobile()) <i class="fa fa-search"
                                style="margin-right: 10px"></i>
                                Search @else <i class="fa fa-search"></i> @endif</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                      <div class="text-center">
            <h3 style="font-weight: 700; margin-bottom: 18px;font-size: 22px;">Search Travel Agents by <span style="color: #f58220;">City</span> <!-- @if(!$detect->isMobile()) <a
                    href="{{url('travel-agents-in-pakistan/all')}}" class="btn btn-success btn-sm pull-right"
                    style="float:right">All Cities</a> @endif --></h3>
        </div>
        @if(isset($agentCities) && !is_null($agentCities))
         <div class="form-group">
            <select class="form-control " onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="" style="font-weight: 700">Select City</option>
                @foreach($agentCities as $e)
                <option value="{{url('travel-agents-in-'.str_slug($e->name))}}">{{$e->name}}</option>
                @endforeach
            </select>
        </div>
        @endif
                </div>
        </div>
{{--       
        <ul class="aplhabatic-list">
            <li><a href="{{url('travel-agents-in-pakistan/a')}}">A</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/b')}}">B</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/c')}}">C</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/d')}}">D</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/e')}}">E</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/f')}}">F</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/g')}}">G</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/h')}}">H</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/i')}}">I</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/j')}}">J</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/k')}}">K</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/l')}}">L</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/m')}}">M</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/n')}}">N</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/o')}}">O</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/p')}}">P</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/q')}}">Q</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/r')}}">R</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/s')}}">S</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/t')}}">T</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/u')}}">U</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/v')}}">V</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/w')}}">W</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/x')}}">X</a></li>
            <li class="y-style-on-mobile"><a href="{{url('travel-agents-in-pakistan/y')}}">Y</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/z')}}">Z</a></li>
        </ul> --}}
        <div class="clearfix"></div>
        @if($detect->isMobile())
        <div class="text-center">
            <a href="{{url('travel-agents-in-pakistan/all')}}" class="btn btn-success btn-sm "
                style="margin-bottom:10px;">All Cities</a>
        </div>
        @endif
    </div>
</section>

<section id="content" class="container">
    <div class="row">
        <div class="col-md-12 ">
            @if($types->count() > 0)
            <div class="row">
                @php
                $count = 0;
                @endphp
                @foreach ($types as $d)

                <div class="col-md-3 col-6">
                    <a href="{{url('travel-agents-in-'.str_slug($d->name))}}" class="blog-link" style="">
                        <div class="type-box" style="    ">
                            @if(!empty($d->image))
                            <img src="{{url('storage/uploads/agents/'.$d->image)}}" style="">
                            @else
                            <img src="{{url('images/placeholder.jpg')}}">
                            @endif
                            <div class="type-detail" style="">
                                <h4 style="">Travel Agents in <span style="color: #f58220;">{{$d->name}}</span>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                @if($detect->isMobile())
                @if($count == 3 || $count == 7 || $count == 11 )
                <div class="col-md-12">
                    <div style="margin-bottom: 15px">
                        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:130px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>

                @endif
                @else
                @if($count == 2 || $count == 8)
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div style="margin-bottom: 35px;">
                        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:200px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div style="margin-bottom: 25px;">
                        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:200px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                @endif
                @if($count == 14)
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div style="margin-bottom: 35px;">
                        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:200px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                @endif
                @endif
                @php $count++; @endphp
                @endforeach

            </div>
            @else
            <p class="text-center" style="    margin: 59px 0;
            background: #070c39;  color: white;"><strong>No Record Found</strong></p>
            @endif
        </div>
    </div>
</section>
@endif
@endsection
@push('script')
<script>
  function filters(){

    var formData = $("#filtersForm").serialize();
    $.ajax({
        url: "{{request()->fullUrl()}}",
        type: "GET",
        data: formData,
        beforeSend: function()
        {
             $('#loadmore').hide();
            $('#agentData').html('<p class="text-center" style="width:100%"><b><i class="fa fa-spinner fa-spin"></i> Loading Agents</b></p>');
        }

    }).done(function(data)
    {
        if(data.html == ""){
            $('#agentData').html('<p class="text-center" style="width:100%"><b>No Travel Agent Found</b></p>');
         return;
     }
      $('.endless-pagination').attr('data-next-page', data.next_page);
      $("#agentData").html(data.html);
      if(data.next_page !== null) {
        $('#loadmore').show();
    }else{
        $('#loadmore').hide();
    }
 });

}
function showverified() {
   $('#show_verfified_agents').val('1');
    $('#agent_name_search').click();
    $('#show_verified').hide();
    $('#all_agents').show();

}
function allverified() {
   $('#show_verfified_agents').val('0');
    $('#agent_name_search').click();
    $('#all_agents').hide();
    $('#show_verified').show();

}
$("#agent_name").keypress(function(e) {
    if(e.which == 13) {
       $('#agent_name_search').click();
    }
});
$( ".agent-search-bar-main" ).remove();
function fetchPosts() {

    var page = $('.endless-pagination').attr('data-next-page');

    if(page !== null) {



        $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Agents');
        $('#loadmore').prop('disabled',true);
        $.get(page, function(data){

            $('.append-data').append(data.html);
            $('#loadmore').html('Load More Agents');
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
</script> @endpush