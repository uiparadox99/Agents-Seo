@extends('layouts.master')
@section('content')
@include('includes.slider')
@if(isset($jobs) && !is_null($jobs))
<section id="content" class="container" style="padding-top: 20px;">

    <div class="text-center">

        <h1 class="mobileTitle">
            Find Jobs  {{!empty($searchCity)?'in '.$searchCity:''}} <a href="{{url('travel-airline-jobs')}}" class="float-right text-dark text-underline backtosearch">Back to Search</a></h1>
    </div>
  
    <div class="row">
        @if($jobs->count() > 0)
        @foreach($jobs as $j)
        <div class="col-md-4" style="">

            <div class="job-box" style="min-height:140px;">
                <div class="row">
                    <div class="col-md-4 text-center pt-lg-3 pt-0 pb-lg-0 pb-2  pr-lg-1 order-md-first order-2">
                        @if(!is_null($j->user) && !is_null($j->user->airline))
                            <img src="{{ url('storage/uploads/airline/'.$j->user->airline->img) }}" width="100px">
                        @endif
                        @if(auth()->check() && auth()->user()->type == 'agent')
                        @else
                            @if(!empty($j->post_url))
                                <div class="text-center" style="margin-top:8px;">
                                    <a href="{{$j->post_url}}" target="_blank" class="btn btn-success btn-xs btn-sm">Apply Now</a>
                                </div>
                            @else
                                <div class="text-center" style="margin-top:8px;">
                                    <a href="{{url('applicant/'.$j->slug)}}" class="btn btn-success btn-xs btn-sm">Apply Now</a>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-8 pl-lg-1">
                        <h4>{{!is_null($j->jobDesignation)?$j->jobDesignation->name:$j->title}}</h4>
                        @if(!is_null($j->agent))
                        <h4 style="text-transform:capitalize;"><a class="text-white"
                                href="{{url('agent/'.$j->agent->slug)}}"><strong style="margin-right:25px;">Company
                                    |</strong>{{$j->agent->business_name}}</a></h4>
                        @endif
                        <div class="job-detail">
                            <!--<div class="row">-->
                            <!--    <div class="col-md-6">-->
                            <!--        <strong>Post Date</strong>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-6">-->
                            <!--        <p style="font-family:arial;"> {{date('d M-->
                            <!--            Y',strtotime(!empty($j->post_date)?$j->post_date:$j->created_at))}}</p>-->
                            <!--    </div>-->
                            <!--</div>-->
                            @if(!empty($j->offer))
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <strong>Salary Offer</strong>
                                </div>
                                <div class="col-md-6  col-6">
                                    <p style="font-family:arial;"> {{$j->offer}}</p>
                                </div>
                            </div>
                            @endif
                            @if(!is_null($j->experience) && !empty($j->experience))
                            <div class="row">
                                <div class="col-md-6  col-6">
                                    <strong>Experience</strong>
                                </div>
                                <div class="col-md-6  col-6">
                                    <p style="font-family:arial;"> {{!is_null($j->experience)?$j->experience:''}}</p>
                                </div>
                            </div>
                            @endif
                            @if(!empty($j->apply_date))
                            <div class="row">
                                <div class="col-md-6  col-6">
                                    <strong>Last Date to Apply</strong>
                                </div>
                                <div class="col-md-6  col-6">
                                    <p style="font-family:arial;"> {{!empty($j->apply_date)?date('d M Y',strtotime($j->apply_date)):''}}</p>
                                </div>
                            </div>
                            @endif
                        

                            <!-- <p><strong>City</strong> : {{$j->agentCity}}</p> -->

                        </div>
                    </div>
                </div>
                
            </div>

        </div>
        @endforeach
        @else
        <h5 class="text-center text-block" style="width: 100%;"><b>No Jobs Found in
                {{!empty($searchCity)?$searchCity:''}}<b></h5>
        @endif
    </div>
</section>
@else
<div class="container">
    <div class="text-center mt-md-4 mt-2">
        <h1 class="text-capitalize mobileTitle">Search {{$type}} Jobs</h1>
    </div>
<form  method="get" action="{{url('agent-jobs')}}" class=" embassy-search mt-2 pb-3 pt-3 mt-md-4 mb-md-5 mt-2 mb-2"  style="border: 2px solid #070c39;background: #070c39;color: #fff">
    <div class="row" >
        <div class="col-md-2 mb-md-0 mb-2  cpr col-6">
            <!--<label for="">Job City</label>-->
            <select name="city" id="cities" class="form-control">
                <option value="">City</option>
                @foreach($citiesfilter as $c)
                <option value="{{$c->id}}"
                    {{request()->has('city') && request()->get('city') == $c->id ?'selected':'' }}>
                    {{$c->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 mb-md-0 mb-2  cpl col-6">
            <!--<label>Agents</label>-->
            <select class="form-control" name="agent">
                <option value="">Agent</option>
                @foreach($agents as $a)
                <option value="{{$a->id}}" {{request()->has('agent') && request()->get('agent') ==
                    $a->id?'selected':''}}>{{$a->business_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-md-0 mb-2  cpr col-6">
            <!--<label>Job Title</label>-->
            <input type="text" name="job_title" class="form-control"
                value="{{request()->has('job_title')?request()->get('job_title'):''}}" placeholder="Job Title">
        </div>
        <input type="hidden" name="type" value="{{request()->has('type')? request()->get('type'):(isset($type) && !empty($type)?$type:'')}}">
      
         
        <div class="col-md-3 mb-md-0 mb-2  cpl col-6">
            <!--<label>Category</label>-->
            <select class="form-control select2" name="job_categories">
                <option value="">Category</option>
                @foreach($categories as $a)
                <option value="{{$a->id}}" {{request()->has('job_categories') && request()->get('job_categories') ==
                    $a->id?'selected':''}}>{{$a->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <!--<label>&nbsp;</label>-->
            <button type="submit" class="btn btn-block btn-primary" style="background-color: #f58220;border-color: #f58220;">Search</button>
        </div>
        </div>

    </form>
    </div>
<section id="content" class="container" >
    
    <div class="row">
        <div class="col-md-6">
            <h3 class="mobileTitle">Jobs by Agents</h3>
            <div class="city-link">
                <div class="row">
                @foreach($agents as $a)
                 <div class="col-md-6">
                    <a href="{{url('agent-jobs?agent='.$a->id)}}" title="{{$a->business_name}}" class="text-dark" style="text-decoration:underline">{{$a->business_name}}</a>
                 </div>
                 @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="mobileTitle mt-md-0 mt-3">Jobs by Category</h3>
            <div class="city-link">
                <div class="row">
                @foreach($categories as $a)
                 <div class="col-md-6">
                    <a href="{{url('agent-jobs?job_categories='.$a->id)}}" title="{{$a->name}}"  class="text-dark" style="text-decoration:underline">{{str_limit($a->name,'27')}}</a>
                 </div>
                 @endforeach
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center mt-3 mb-3 mobileTitle">Jobs by Cities</h3>
    <div class="row mb-5" style="margin-right: -5px;margin-left: -5px;" >
        @if($cities->count() > 0)
        @foreach($cities as $j)

        <div class="col-md-3 " style="padding-left:5px;padding-right:5px;margin-bottom:5px;">
            <a href="{{url('agent-jobs-in-'.str_slug($j->name).'?'.http_build_query(request()->query()))}}" class="city-link" title="{{$j->name}}"><h5 class="mb-0">Jobs in {{$j->name}} <span
                    style="float: right;">{{$j->job_count}}</span></h5></a>
        </div>
        @endforeach
        @else
        <p class="text-center btn-block"><b>No Jobs</b></p>
        @endif
    </div>
</section>
@endif

@endsection