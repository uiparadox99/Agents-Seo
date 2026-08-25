@extends('layouts.master')
@section('content')
@include('includes.slider')
<div class="container">
    <div class="text-center mt-2">
        <h1 class="mobileTitle">Foreign Jobs {{!is_null($search_country)?'in '.$search_country:''}} {{!is_null($search_agent)?'by '.$search_agent:''}}</h1>
    </div>
<form  method="get" action="{{url('foreign-jobs')}}" class=" embassy-search mt-2 pb-3 pt-3 mt-md-4 mt-2 mb-md-4 mb-2"  style="border: 2px solid #070c39;background: #070c39;color: #fff">
    <div class="row" >
        <input type="hidden" name="country" value="{{request()->has('country')?request()->get('country'):''}}">
        <div class="col-md-3 mb-md-0 mb-2 cpr  col-6">
            <!--<label>Job Title</label>-->
            <input type="text" name="job_title" class="form-control"
                value="{{request()->has('job_title')?request()->get('job_title'):''}}" placeholder="Job Title">
        </div>
        <div class="col-md-3 mb-md-0 mb-2  cpl col-6">
            <!--<label>Place of Duty</label>-->
            <input type="text" name="place_of_duty" class="form-control"
                value="{{request()->has('place_of_duty')?request()->get('place_of_duty'):''}}" placeholder="Place of duty">
        </div>
        <div class="col-md-2 mb-md-0 mb-2 cpr  col-6"  style="{{request()->has('agent') && !empty(request()->get('agent'))?'display:none':''}}">
            <!--<label>Agents</label>-->
            <select class="form-control" name="agent">
                <option value="">Agent</option>
                @foreach($agents as $a)
                <option value="{{$a->id}}" {{request()->has('agent') && request()->get('agent') ==
                    $a->id?'selected':''}}>{{$a->business_name}}</option>
                @endforeach
            </select>
        </div>
        <div class=" col-md-2 mb-md-0 mb-2  cpl col-6">
            <!--<label for="">Agent City</label>-->
            <select name="agent_city" id="cities" class="form-control">
                <option value="">Agent City</option>
                @foreach($cities as $c)
                <option value="{{$c->id}}"
                    {{request()->has('agent_city') && request()->get('agent_city') == $c->id ?'selected':'' }}>
                    {{$c->name}}</option>
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
@if(isset($jobs) && !is_null($jobs))
<section id="content" class="container">

    <!--<div class="text-center">-->

    <!--    <h1>-->
    <!--        Find Foreign Jobs  <a href="{{url('foreign-jobs')}}" class="float-right text-dark text-underline" style="font-size:20px;margin-top:10px;text-decoration:underline">Back to Search</a></h1>-->
    <!--</div>-->
  
    <div class="cus-jobs-list">
        @if(!is_null($jobs))
        @foreach($jobs as $j)

            <div class="job-box {{!is_null($search_agent)?'withoutAgent':''}}" style="">
                    <!-- <div class="col-md-4 text-center pt-lg-3 pt-0 pb-lg-0 pb-2  pr-lg-1 order-md-first order-2">
                        @if(!is_null($j->user) && !is_null($j->user->airline))
                            <img src="{{ url('storage/uploads/airline/'.$j->user->airline->img) }}" width="100px">
                        @endif
                       
                    </div> -->
                        <h4 class="text-capitalize">{{strtolower($j->title)}}</h4>
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
                            
                                @if(!is_null($j->agent) && is_null($search_agent))
                                       
                                        <p style="font-family:arial;"> <strong>Employer:</strong> <a href="{{url('agent/'.$j->agent->slug)}}" class="text-dark">{{$j->agent->business_name}}</a></p>
                                
                                @endif
                                @if(!empty($j->salary))
                                        <p style="font-family:arial;"> <strong>Salary:</strong> {{$j->salary}}</p>
                                @endif
                                @if(!is_null($j->place_of_duty) && !empty($j->place_of_duty))
                                     
                                        <p style="font-family:arial;text-transform:capitalize">   <strong>Place of Duty:</strong> {{!is_null($j->place_of_duty)?strtolower($j->place_of_duty):''}}</p>
                                @endif
                                <!--@if(!is_null($j->agent) && is_null($search_agent))-->
                                <!--        <strong>Employer</strong>-->
                                <!--        <p style="font-family:arial;"> <a href="{{url('agent/'.$j->agent->slug)}}" class="text-dark">{{$j->agent->business_name}}</a></p>-->
                                
                                <!--@endif-->
                                <!--@if(!empty($j->salary))-->
                                <!--        <strong>Salary Offer</strong>-->
                                <!--        <p style="font-family:arial;"> {{$j->salary}}</p>-->
                                <!--@endif-->
                                <!--@if(!is_null($j->place_of_duty) && !empty($j->place_of_duty))-->
                                <!--        <strong>Place of Duty</strong>-->
                                <!--        <p style="font-family:arial;text-transform:capitalize"> {{!is_null($j->place_of_duty)?strtolower($j->place_of_duty):''}}</p>-->
                                <!--@endif-->
                            <!--@if(!empty($j->grant_date))-->
                            <!--<div class="row">-->
                            <!--    <div class="col-md-4  col-6">-->
                            <!--        <strong>Grant Date</strong>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-8  col-6">-->
                            <!--        <p style="font-family:arial;"> {{!empty($j->grant_date)?date('d M Y',strtotime($j->grant_date)):''}}</p>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--@endif-->
                        
                            @if(auth()->check() && auth()->user()->type == 'agent')
                        @else
                            <div class="text-center" style="margin-top:8px;">
                                <a href="https://beoe.gov.pk/foreign-jobs/{{$j->permission}}"  style="color:#f58220;text-decoration:underline">Verify This Job</a> &nbsp;
                                  @if(!is_null($j->agent))
                                <a href="{{url('agent/'.$j->agent->slug)}}" target="_blank" style="color:#0056b3;text-decoration:underline">Contact Agent</a>
                            @endif
                            </div>
                            
                        @endif
                            <!-- <p><strong>City</strong> : {{$j->agentCity}}</p> -->

                        </div>
                
            </div>

        @endforeach
        <div class="col-md-12 mt-4 mb-5 text-center">
            <div class="customPagination d-inline-block">
                
        {!! $jobs->links() !!}
            </div>
        </div>
        @else
        <h5 class="text-center text-block" style="width: 100%;"><b>No Jobs Found in
                {{!empty($searchCity)?$searchCity:''}}<b></h5>
        @endif
    </div>
</section>
@else

<section id="content" class="container" >
    
    <div class="row">
        <div class="col-md-12">
            <!--<h3>Jobs by Countries</h3>-->
            <div class="city-link pl-3 pr-3">
                <div class="row">
                @foreach($countries as $a)
                 <div class="col-md-4 col-6 cpl cpr">
                    <a href="{{url('foreign-jobs?country='.$a->id)}}" title="{{$a->country}}" class="text-dark" style="text-decoration:underline">{{$detect->isMobile()?str_limit($a->country,'15'):$a->country}} <span
                    style="float: right;">{{$a->jobs_count}}</span></a>
                 </div>
                 @endforeach
                </div>
            </div>
        </div>
     
    </div>
</section>
@endif

@endsection