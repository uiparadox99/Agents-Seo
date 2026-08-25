@extends('layouts.master')
@section('content')
<style type="text/css">
    .agent-search-bar-main {
        display: none;
    }
</style>
@include('includes.slider')

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

                            <input type="text" name="q" id="agent_name" class="form-control"
                                value="{{!empty(request()->get('q'))?request()->get('q'):''}}" placeholder="Agent Name">
                            <div class="input-group-append">
                                <span class="input-group-text" id="agent_name_search" onclick="filters()"
                                    style="cursor: pointer;    background: #f58220; color: #fff;"> <i
                                        class="fa fa-search"></i></span>
                            </div>
                        </div>
                        @else
                        <div class="form-group">

                            <input type="text" name="q" placeholder="Agent Name" id="agent_name" class="form-control"
                                value="{{!empty(request()->get('q'))?request()->get('q'):''}}">
                        </div>
                        <button type="button" id="agent_name_search" onclick="filters()"
                            class="btn btn-primary btn-block">Search</button>
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
                            <label for="type{{$c->id}}">{{$c->name}}</label>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <input type="hidden" name="verified" value="" id="show_verfified_agents">
            </form>
        </div>
        <div class="col-md-9">
            <h3 class="agent-city-search-heading" style="color: #070c39;"><b>Travel Agents in {{isset($searchCity) &&
                    !empty($searchCity)?$searchCity->name:'Pakistan'}}</b> <button onclick="showverified()"
                    id="show_verified" class="btn btn-primary btn-sm" style="float: right;">Show Verified
                    Agents</button><button onclick="allverified()" id="all_agents" class="btn btn-warning btn-sm"
                    style="float: right;display: none;color: #fff">All Agents</button>
                <div class="clearfix"></div>
            </h3>
            @if($agents->count() > 0)
            <div class=" endless-pagination" data-next-page="{{ $agents->nextPageUrl().'&q='.request()->get('q') }}">
                <div class="append-data" id="agentData">
                    @include('partials.agent-listing')
                </div>

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


 
<section id="content" class="container" style="padding-top: 20px;">
     @if($detect->isMobile())
   <p class="text-center">
       <a href="{{url('travel-airline-jobs')}}" style="text-decoration:underline;color:black">Airline Jobs</a> &nbsp; 
       <a href="{{url('foreign-jobs')}}" class="btn btn-sm btn-danger" style="color:white">Foreign Jobs</a> &nbsp; 
       <a href="{{url('travel-agent-jobs')}}" style="text-decoration:underline;color:black">Agents Jobs</a> 
       </p>
  @endif
    <div class="row">
        <div class="col-xl-4 col-md-6 col-6 cpr">
            <div class="image-banner-block mb-30 mb-sm-0 mb-10">
                <a href="{{ route('umrah-packages') }}"><img src="{{url('/umrah-banner.jpeg')}}" class="w-100">
                    <!--<div class="img-btn-block">-->
                    <!--    <span>Umrah Packages</span>-->
                    <!--</div>-->
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-6 mb-30 mb-10 cpl">
            <div class="image-banner-block mb-30 mb-10">
                <a href="{{ route('flight') }}"><img src="{{url('/images/agents-image-02.jpg')}}" class="w-100">
                    <div class="img-btn-block">
                        <span>Umrah Tickets</span>
                    </div>
                </a>
            </div>
            <div class="image-banner-block">
                <a href="{{ route('sasti-tickets') }}">
                    <img src="{{url('/images/agents-image-03.jpg')}}" class="w-100">
                    <div class="img-btn-block">
                        <span>Sasti Tickets</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12 col-md-6 col-6 cpr">
                    <div class="image-banner-block mb-30 mb-10">
                        <a href="{{ route('umrah-packages') }}">
                            <img src="{{url('/images/agents-image-04.jpg')}}" class="w-100">
                            <div class="img-btn-block">
                                <span>Umrah Packages</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-12 col-md-6 col-6 mb-10 cpl">
                    <div class="image-banner-block">
                         <a href="">
                            <img src="{{url('/images/agents-image-05.jpg')}}" class="w-100">
                            <div class="img-btn-block">
                               <span>Tour Packages</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="content" class="container" style="padding-top: 20px; margin-bottom:30px;">
    <div class="agents-city-section" style="">
                 <!--<h1 style="margin-bottom: 18px;" class="hero-title"><span  style="color: #f58220;">Looking</span> For Travel Agent ?  Search by <span style="color: #f58220;">Name</span></h1>-->
                            
                <form id="AgentSearchForm" class="position-relative" method="get" action="{{url('travel-agents-in-pakistan')}}">
                    <div class=" d-flex justify-space-between bg-white p-1" style="height: 68px; font-size:18px; border-radius:4px">
                        <input type="text" class="form-control border-0"
                            value="{{!empty(request()->get('q'))?request()->get('q'):''}}" id="agentbar"
                            autocomplete="off" name="q" placeholder="Search By Travel Agent Name" style="    height: 60px; font-size:18px">
                            
                        <button type="submit" class="btn btn-lg flex-shrink-0" style="background: #f58220;color: #fff;"> @if(!$detect->isMobile()) <i class="fa fa-search" style="margin-right: 10px"></i>
                        Search @else <i class="fa fa-search"></i> @endif</span></button>
                    </div>
                  
                </form>

        
    </div>
</section>
 @if($useful_links->count() > 0)
 <section id="content" class="container mb-4" >
    <h3 class="mb-4 text-center">Visa Verification & other useful links</h3>
    <div class="row align-items-center" style="margin-right: -5px;margin-left: -5px;">
        @foreach($useful_links as $j)
        @if($j->airport != 1)
        <div class="col-md-2 col-6" style="padding-left:5px;padding-right:5px;margin-bottom:5px;">
            <a href="{{$j->link}}" target="_blank" class="city-link" title="{{$j->name}}" style="    min-height: 90px;">
               @if(!is_null($j->img))
                <div class="row align-items-center">
                    <div class="col-5 pr-1">
                      <img src="{{ url('storage/uploads/links/'.$j->img) }}" style="width:100%;object-fit:cover;height:70px">
                    </div>
                    <div class="col-7 pl-1">
                           <h6 class="mb-0">{{$j->name}}</h6>
                    </div>
                </div>            
                @else
                     <div class="row align-items-center">
                    <div class="col-5 pr-1" style="height:70px">
                    </div>
                    <div class="col-7 pl-1">
                           <h6 class="mb-0">{{$j->name}}</h6>
                    </div>
                </div>
                @endif
            </a>
        </div>
        @endif
        @endforeach
    </div>
    <h3 class="mb-4 text-center">Flight Schedules</h3>
    <div class="row align-items-center" style="margin-right: -5px;margin-left: -5px;background:url('/fsd-int-airport.jpg');    padding: 50px 10px;
    background-size: cover;
    background-position: center;"> 
        @foreach($useful_links as $j)
        @if($j->airport == 1)
        <div class="col-md-3 col-6" style="padding-left:5px;padding-right:5px;margin-bottom:5px;">
            <a href="{{$j->link}}" target="_blank" class="city-link" title="{{$j->name}}" style="">
               @if(!is_null($j->img))
                <div class="row align-items-center">
                    <!--<div class="col-4 pr-1">-->
                    <!--  <img src="{{ url('storage/uploads/links/'.$j->img) }}" style="width:100%;object-fit:cover;height:70px">-->
                    <!--</div>-->
                    <div class="col-12">
                           <h6 class="mb-0">{!! str_replace('Flight','<br> Flight',$j->name) !!}</h6>
                    </div>
                </div>            
                @else
                     <div class="row align-items-center">
                    <!--<div class="col-4 pr-1" style="height:70px">-->
                    <!--</div>-->
                    <div class="col-12">
                           <h6 class="mb-0">{!! str_replace('Flight','<br> Flight',$j->name) !!}</h6>
                    </div>
                </div>
                @endif
            </a>
        </div>
        @endif
        @endforeach
    </div>
</section>
        @endif
@endif
@endsection
@push('script')
<script>
    function filters() {

        var formData = $("#filtersForm").serialize();
        $.ajax({
            url: "{{request()->fullUrl()}}",
            type: "GET",
            data: formData,
            beforeSend: function () {
                $('#loadmore').hide();
                $('#agentData').html('<p class="text-center" style="width:100%"><b><i class="fa fa-spinner fa-spin"></i> Loading Agents</b></p>');
            }

        }).done(function (data) {
            if (data.html == "") {
                $('#agentData').html('<p class="text-center" style="width:100%"><b>No Travel Agent Found</b></p>');
                return;
            }
            $('.endless-pagination').attr('data-next-page', data.next_page);
            $("#agentData").html(data.html);
            if (data.next_page !== null) {
                $('#loadmore').show();
            } else {
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
    $("#agent_name").keypress(function (e) {
        if (e.which == 13) {
            $('#agent_name_search').click();
        }
    });
    $(".agent-search-bar-main").remove();
    function fetchPosts() {

        var page = $('.endless-pagination').attr('data-next-page');

        if (page !== null) {



            $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Agents');
            $('#loadmore').prop('disabled', true);
            $.get(page, function (data) {

                $('.append-data').append(data.html);
                $('#loadmore').html('Load More Agents');
                $('#loadmore').prop('disabled', false);
                if (data.next_page !== null) {
                    $('#loadmore').show();
                } else {
                    $('#loadmore').hide();
                }
                $('.endless-pagination').attr('data-next-page', data.next_page);
            });


        }
    }
</script> @endpush