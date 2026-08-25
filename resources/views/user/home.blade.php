@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        @if(auth()->user()->verified != 1)
        <div class="col-md-12">
            <div class="btn-danger btn-block mt-3 mb-0 p-2">
                <p class="mb-0 text-center">Your email is not verified please check your inbox</p>
            </div>
        </div>
        @endif
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box pt-0">
            @if(!is_null($detail))
            @if(!empty($detail->cover))
             <div class="agent-detail-box content-box-agent">
            <h5>Cover Photo (Recomended: 1920x600) <a href="{{url('user/edit-business/'.$detail->id)}}"
                                class="btn btn-sm btn-primary mb-2" style="float:right">Edit</a></h5>
            <img src="{{url('storage/uploads/agents/'.$detail->cover)}}" width="100%" class="agent-panel-cover">
            </div>

            @endif
            @if(!empty(auth()->user()->agents()->first()->logo) && $detect->isMobile())
              <div class="agent-detail-box content-box-agent">
                   <h5>Profile</h5>
                        <img src="{{url('storage/uploads/agents/'.auth()->user()->agents()->first()->logo)}}" width="100%" height="200px" style="object-fit: contain;">
                        </div>
                        @endif
            <div class="agent-detail-box content-box-agent">
      
                <div class="row">
                    <!--@if($detect->isMobile())-->
                    <!--<div class="col-md-12">-->
                    <!--    <img src="{{url('storage/uploads/agents/'.$detail->logo)}}" width="100%" height="200px" style="object-fit: contain;">-->
                    <!--</div>-->
                    <!--@endif-->
                    <div class="col-md-12">
                           <!-- @if(!CheckPermission($detail->id,'jobs') && $detect->isMobile())
                           <div class="text-center" style="width: 100%;padding: 6px 0;">
                               
                                                  
                                    <a href="{{url('preview-business/'.$detail->slug)}}" target="_blank"
                                class="btn btn-sm btn-primary" style="background: #f58220;border: none;">Your profile as Varified Agent</a>
                                    </div>
                                @endif -->
                        <h3 class="text-capitalize mb-3">{{ strtolower($detail->business_name) }}   @if(!$detect->isMobile()) <div class="d-inline"  style="float: right;"><a href="{{url('agent/'.$detail->slug)}}" target="_blank"
                                class="btn btn-sm btn-primary">Preview Profile</a> &nbsp;  <a href="{{url('user/edit-business/'.$detail->id)}}"
                                class="btn btn-sm btn-primary" >Edit
                                    Business</a> </div>@endif
                               
                            </h3>
                            @if($detect->isMobile())
                            <div class="text-center mb-3" ><a href="{{url('agent/'.$detail->slug)}}" target="_blank"
                                class="btn btn-sm btn-primary">Preview Profile</a> &nbsp;  <a href="{{url('user/edit-business/'.$detail->id)}}"
                                class="btn btn-sm btn-primary" >Edit
                                    Business</a> </div>
                            @endif
                            <table class="table table-striped table-bordered">
                            @if(!empty($detail->address))
                                <tr>
                                    <th>Address</th>
                                    <td>{{$detail->address}} ,
                                    {{!is_null($detail->city)?$detail->city->name:''}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->address))
                                <tr>
                                    <th>Type</th>
                                    <td>{{!is_null($detail->agentType)?$detail->agentType->name:''}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->email))
                                <tr>
                                    <th>Email</th>
                                    <td>{{$detail->email}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->phone))
                                <tr>
                                    <th>Phone</th>
                                    <td>{{$detail->phone}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->mobile))
                                @php
                                $whatsapp = '';
                                $mobileArray = explode(',', $detail->mobile);
                                $mobile = $mobileArray[0];
                                if(count($mobileArray) > 1){
                                  $whatsapp = $mobileArray[1];
                                }
                                @endphp
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{$mobile}}</td>
                                </tr>
                                 <tr>
                                    <th>Whatsapp</th>
                                    <td>{{$whatsapp}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->facebook))
                                <tr>
                                    <th>Facebook</th>
                                    <td><a rel="nofollow" href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}" target="_blank">{{$detail->facebook}}</a></td>
                                </tr>
                                @endif
                                @if(!empty($detail->twitter))
                                <tr>
                                    <th>Twitter</th>
                                    <td>{{$detail->twitter}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->whatsapp))
                                <tr>
                                    <th>Whatsapp</th>
                                    <td>{{$detail->whatsapp}}</td>
                                </tr>
                                @endif
                                @if(!empty($detail->website))
                                <tr>
                                    <th>Website</th>
                                    <td><a target="_blank" rel="nofollow" href="http://{{str_replace('http://','',str_replace('www','',str_replace('https://','',$detail->website)))}}">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}</a></td>
                                </tr>
                                @endif
                            </table>
                        
                    </div>
                </div>
             
                <div class="text-center">
                         <!-- @if(CheckPermission($detail->id,'1_gallery_picture') && !$detect->isMobile())
                                    <a href="{{url('preview-business/'.$detail->slug)}}" target="_blank"
                                class="btn btn-sm btn-primary" style="background: #f58220;border: none;">Your profile as Varified Agent</a>
                                @endif -->
                                
                </div>
            </div>
            @if( !empty($detail->secondary_phone) || !empty($detail->secondary_mobile) || !empty($detail->dsl_license) || !empty($detail->dsl_expairy) || !empty($detail->iata_license) || !empty($detail->iata_expairy) || !empty($detail->fax) ||  !empty($detail->facebook) || !empty($detail->twitter) || !empty($detail->whatsapp) || !empty($detail->website) || !empty($detail->description) )
            <div class="content-box-agent">



                <div class="row"> 

                    @if(!empty($detail->secondary_phone))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>Secondary Phone</strong></p>
                        <p class="number-style">{{$detail->secondary_phone}}</p>
                    </div>
                    @endif
                    @if(!empty($detail->secondary_mobile))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>Secondary Mobile</strong></p>
                        <p class="number-style"> {{$detail->secondary_mobile}}</p>
                    </div>
                    @endif
                    @if(!empty($detail->dsl_license))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>DTS License</strong></p>
                        <p>{{$detail->dsl_license}}</p>
                    </div>
                    @endif
                    @if(!empty($detail->dsl_expairy))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>DTS License Expiry</strong></p>
                        <p class="number-style">{{$detail->dsl_expairy}}</p>
                    </div>
                    @endif
                    @if(isset($detail)&&!is_null($detail->dtsAttachments()->where('active',1)->first()))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>DTS Attachment</strong></p>
                        <p class="number-style"><a href="{{url('storage/uploads/agents/'.$detail->dtsAttachments()->where('active',1)->first()->file)}}" target="_blank" class="btn btn-primary btn-sm">View file</a></p>
                    </div>
                    @endif
                    @if(!empty($detail->iata_license))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>IATA License</strong></p>
                        <p>{{$detail->iata_license}}</p>
                    </div>
                    @endif
                    @if(!empty($detail->iata_expairy))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>IATA Expiry</strong></p>
                        <p class="number-style"> {{$detail->iata_expairy}}</p>
                    </div>
                    @endif
                    @if(isset($detail)&&!is_null($detail->iata_attachment))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>IATA Attachment</strong></p>
                        <p class="number-style"><a href="{{url('storage/uploads/agents/'.$detail->iata_attachment)}}" target="_blank" class="btn btn-primary btn-sm">View file</a></p>
                    </div>
                    @endif
                    @if(!empty($detail->fax))
                    <div class="col-md-4 col-6">
                        <p style="margin-bottom: 5px;"><strong>Fax</strong></p>
                        <p> {{$detail->fax}}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="content-box-agent">



<div class="row"> 
                    @if(!empty($detail->description))
                    <div class="col-md-12">
                        <p style="margin-bottom: 5px;text-align:center"><strong>Description</strong></p>
                        <p>{!! $detail->description !!}</p>
                    </div>
                    @endif

                </div>
            </div>
            @endif
            @if(!is_null($detail->agentTimings) && $detail->agentTimings->count() > 0)
            <div class="content-box-agent">
                <h3 class="text-center">Office Timings</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p> <strong>Day </strong> </p>
                    </div>
                    <div class="col-md-4 col-4">
                        <p><strong>Opening </strong></p>
                    </div>
                    <div class="col-md-4 col-4">
                        <p> <strong>Closing </strong></p>
                    </div>

                </div>
                @foreach($detail->agentTimings as $t)
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p>{{$t->day}}</p>
                    </div>
                    <div class="col-md-4 col-4">
                        @if(!empty($t->opening))
                        <p class="number-style"> {{$t->opening}}</p>
                        @else
                        <p class="number-style"> Close</p>
                        @endif
                    </div>
                    <div class="col-md-4 col-4">
                        @if(!empty($t->closing))
                        <p class="number-style"> {{$t->closing}}</p>
                        @else
                        <p class="number-style"> Close</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @else
            <p style="box-shadow: 0 4px 15px 0 #dfdfdf;    padding: 10px 10px 15px 10px;margin: 10px 0;">Please Add Your
                Business <a href="{{url('add-business')}}" class="btn btn-primary pull-right btn-sm"
                    style="float: right;">Add Business</a>
                <div class="clearfix"></div>
            </p>
            @endif
        </div>
    </div>
</div>
@endsection