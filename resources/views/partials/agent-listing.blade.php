   @php
                $count = 0;
                @endphp
            @foreach ($agents as $d)
             @php $count++; @endphp
            @if(!$detect->isMobile())

           
                <div class="visas-agent-box" style="position: relative;">

                    <div class="row">
           
                        <div class="col-3" style="position: relative;">
                             <a href="{{url(!is_null($d->slug)?'agent/'.$d->slug:'')}}" class="blog-link">@if(!empty($d->logo) && $d->logo_approved == '1')
                            <img src="{{url('storage/uploads/agents/'.$d->logo)}}" style="width: 100%;height: 150px;object-fit: contain;">
                            @else
                            <img src="{{url('images/placeholder.jpg')}}" style="width: 100%;height: 150px">
                            @endif</a>
                                        @if(CheckPermission($d->id,'verified_agent'))
                            <div class="ribbon-agent ribbon-green">
                                        Verified Agent
                                       

                            </div>
                             @else
                                <div class="ribbon-agent">
                                        Non Verified
                                    </div>
                                        @endif

                        </div>
                        <div class="col-6 pr-0">
                            <div class="blog-detail">
                                                 
                               <a href="{{url(!is_null($d->slug)?'agent/'.$d->slug:'')}}" class="blog-link">  <h3  class="mb-2 agent-title text-capitalize">
                                    {{strtolower($d->business_name)}}</h3></a>
                                    
                                <ul class="agent-listing-link">

                                           @if(CheckPermission($d->id,'full_contact') && !empty($d->website))

                                    <li><a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$d->website)))}}" class="btn btn-block btn-primary  btn-sm " target="_blank">Website</a></li>
                                    @endif


                                    <li><a href="{{url(!is_null($d->slug)?'agent/'.$d->slug.'#deals':'')}}" class="btn  btn-block btn-sm btn-warning">Hot Deals</a></li>
                                                  @if(empty($d->users_id))
                                                          <li><a href="{{url('claim-business/'.$d->slug)}}" class="btn  btn-block btn-sm btn-danger">Claim Business</a></li>
                                                  @endif
                                   <div class="clearfix"></div>
                                </ul>
                             
                                <p class="mb-1"><i class="fa fa-map-marker-alt"></i> {{$d->address}} @if(!empty($d->address) && !empty($d->city->name)), @endif{{$d->city->name}}</p>
                                   @if(!empty($d->phone))
                                @php
                                $phone = explode(',', $d->phone);
                                @endphp
                                <div class="row">
                                    
                                 
                                    @foreach($phone as $p)
                                    <div class="col-md-6">
                                        
                                        <p class="mb-1"><a href="tel:{{$p}}" style="color: unset;"><i class="fa fa-phone-volume"></i> {{$p}}</a></p>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                              
                              
                            
                  
                              
                            </div>
                        </div>
                        <div class="col-3 text-center {{!is_null($d->agentType) &&
                                    !empty($d->agentType->image)?'pt-2':'pt-4'}}" style="    border-left: 2px dashed;">
                            @if(!is_null($d->agentType) &&
                                    !empty($d->agentType->image)) <img src="{{url('storage/uploads/agents/'.$d->agentType->image)}}"
                                        style="width:50px;height:40px;margin-bottom: 10px;" alt="{{$d->agentType->name}}"> @endif
                          <!--     @if(CheckPermission($d->id,'verified_agent'))
                            <p class="m-0 btn btn-success btn-sm btn-xs btn-block mb-2"> Verified Agent
                            </p>
                            @else
                            <p  class="m-0 btn btn-warning text-white btn-sm btn-xs btn-block mb-2"> Basic Agent
                            </p>
                            @endif -->
                                <div class="clearfix"></div>
                            {!! showRatingStars($d->agentReviews()->where('active',1)->avg('rating')) !!}
                            <p class="text-center mt-2 mb-2"><a href="{{url(!is_null($d->slug)?'agent/'.$d->slug.'#reviews':'')}}" style="color: #070c39">Write Review</a></p>
                            <a href="{{url(!is_null($d->slug)?'agent/'.$d->slug:'')}}" class="btn btn-primary btn-block btn-sm">More Info</a>
                        </div>
                   
                    </div>
      
                </div>
       

            @else
        
                <div class="visas-agent-box" style="">
                    <div class="row">
                
                        <div class="col-md-9 col-8 pr-0">
                            <div class="blog-detail">
                                                 
                               <a href="{{url(!is_null($d->slug)?'agent/'.$d->slug:'')}}" class="blog-link">  <h3 class="mt-0 mb-0 agent-title text-capitalize">
                                    {{strtolower($d->business_name)}}</h3></a>

                                      @if(CheckPermission($d->id,'verified_agent'))
                                <p style="color:green" class="m-0">@if(!is_null($d->agentType) &&
                                    !empty($d->agentType->image)) <img
                                        src="{{url('storage/uploads/agents/'.$d->agentType->image)}}"
                                        style="width:50px;height:40px;" alt="{{$d->agentType->name}}"> @endif <i class="fa fa-check" style="color:green"></i> Verified Agent
                                </p>
                                @else
                                <p  class="m-0">@if(!is_null($d->agentType) &&
                                    !empty($d->agentType->image)) <img
                                        src="{{url('storage/uploads/agents/'.$d->agentType->image)}}"
                                        style="width:50px;height:40px;" alt="{{$d->agentType->name}}"> @endif Basic Agent
                                </p>
                                @endif
                                <ul class="agent-listing-link">
                                        @if(CheckPermission($d->id,'full_contact') && !empty($d->website))

                                    <li><a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$d->website)))}}" class="btn btn-block btn-primary  btn-sm " target="_blank"  style="font-size: 12px;padding: 2px 0;">Website</a></li>
                                    @endif




                                    <li><a href="{{url(!is_null($d->slug)?'agent/'.$d->slug.'#deals':'')}}" style="font-size: 12px;padding: 2px 0;" class="btn  btn-block btn-sm btn-warning">Hot Deals</a></li>
                                                  @if(empty($d->users_id))
                                                          <li><a href="{{url('claim-business/'.$d->slug)}}" style="font-size: 12px;padding: 2px 0;" class="btn  btn-block btn-sm btn-danger">Claim </a></li>
                                                  @endif
                                   <div class="clearfix"></div>
                                </ul>
                             
                                <p><i class="fa fa-map-marker-alt"></i> {{$d->address}} @if(!empty($d->address) && !empty($d->city->name)), @endif {{$d->city->name}}</p>
                                      @if(!empty($d->phone))
                                @php
                                $phone = explode(',', $d->phone);
                                @endphp
                                <div class="row">
                                    
                                 
                                    @foreach($phone as $p)
                                    <div class="col-md-6">
                                        
                                        <p class="mb-1"><a href="tel:{{$p}}" style="color: unset;"><i class="fa fa-phone-volume"></i> {{$p}}</a></p>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            
                  
                              
                            </div>
                        </div>
                       
                        <div class="col-4">
                             <a href="{{url(!is_null($d->slug)?'agent/'.$d->slug:'')}}" class="blog-link">@if(!empty($d->logo) && $d->logo_approved == '1')
                            <img src="{{url('storage/uploads/agents/'.$d->logo)}}" style="width: 100%;">
                            @else
                            <img src="{{url('images/placeholder.jpg')}}" style="width: 100%;">
                            @endif</a>
                            <div style="font-size: 12px;" class="mt-1">
                                
                      
                            {!! showRatingStars($d->agentReviews()->where('active',1)->avg('rating')) !!}
                            <p class="text-center m-1"><a href="{{url(!is_null($d->slug)?'agent/'.$d->slug.'#reviews':'')}}" style="color: #070c39">Write Review</a></p>
                            <a href="{{url(!is_null($d->slug)?'agent/'.$d->slug:'')}}" class="btn btn-primary btn-block btn-sm">More Info</a>
                                  </div>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
 <!--            <div class="text-center col-md-12" style="    overflow: hidden;">
     {!! $agents->appends(request()->except('page'))->links() !!}
 </div> -->