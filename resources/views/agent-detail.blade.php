@extends('layouts.master')
@section('content')

<section id="content" class="container agent-detail-main">
   <div class="row">
      <div class="col-md-9">
         @if(!empty($detail->cover) && $detail->cover_approved == '1' && CheckPermission($detail->id,'own_profile_picture'))
         <section id="content" class="agent-banner"
            style="background: url({{url('storage/uploads/agents/'.$detail->cover)}});background-repeat: no-repeat;    background-size: cover;background-position: center; background-color: #f0f0f0;    ">
            @else
            @if(!$detect->isMobile())
            <section id="content" class="agent-banner"
               style="background: url({{url('images/1920x712.jpg')}})  no-repeat;background-color: #fee07e; background-position: center bottom;      background-size: cover;  ">
               @else
               <section id="content" class="agent-banner"
                  style="background: url({{url('images/1920x712.jpg')}})  no-repeat;background-color: #fee07e; background-position: center bottom;    background-size:cover;  ">
                  @endif
                  @endif

                  <!-- <div class="overlay-on-detail pl-4 pr-4" style="     ">
               <div class="row">
                  <div class="col-md-10">
                     <h3 class="text-capitalize">{{strtolower($detail->business_name)}} </h3>
                     <p class="addressp number-style"> <i class="fa fa-map-marker-alt"></i>
                        @if(!$detect->isMobile()){{$detail->address}}@endif
                        {{$detail->city->name}}
                     </p>
                  </div>
                  @if(!$detect->isMobile())
                  <div class="col-md-2">
                     @if(empty($detail->users_id))
                     <a href="{{url('claim-business/'.$detail->slug)}}" rel="nofollow" class="btn btn-primary pull-right
                  "> Claim Business</a>
                     @endif
                  </div>
                  @endif
               </div>
               <div class="clearfix">
               </div>
            </div> -->

               </section>
               @if($detect->isMobile())
               @if(empty($detail->users_id))
               <br>
               <p>Do you own this business? <a href="{{url('claim-business/'.$detail->slug)}}" rel="nofollow"
                     style="margin-left:8px;" class="btn btn-primary">claim Now</a></p>
               @endif
               @endif


               <div style="" class="agent-detail-boxes">
                  <div class="row align-items-center row-gap-3">
                     <div class="col-md-11 text-center">
                         <div class="d-md-flex d-block align-items-center flex-wrap text-center">
                             <button class="btn btn-md btn-primary mr-3 mb-sm-0 mb-2">
                                @if(CheckPermission($detail->id,'verified_agent'))<i class="fa fa-check"></i> Verified Agent @else Basic Agent @endif</button>
                           <br>
                     
                        <h3 class="text-capitalize mb-0 agentDetailTitle text-center" style="width:85%;color:#ed8100">{{strtolower($detail->business_name)}} </h3>
                         </div>
                        <!--<p class="addressp number-style"> <i class="fa fa-map-marker-alt"></i>-->
                        <!--   @if(!$detect->isMobile()){{$detail->address}}@endif-->
                        <!--   {{$detail->city->name}}-->
                        <!--</p>-->
                     </div>


                     <div class="col-md-1 text-center">
                        @if(!$detect->isMobile())
                     @if(!is_null($detail->agentType))
                     @if( !empty($detail->agentType->image)) <img
                        src="{{url('storage/uploads/agents/'.$detail->agentType->image)}}"
                        style="width:70px;height:40px;" alt="{{$detail->agentType->name}}"> @else
                     {{!is_null($detail->agentType)?$detail->agentType->name:''}} @endif
                     @endif
                     @endif
                     </div>
                  </div>
                  <hr>
               <!--   <h5>-->
                   
                     
               <!--    @if(CheckPermission($detail->id,'recommended_status'))-->
               <!--<small style="color:green;float:right"><i class="fa fa-check" style="color:green"></i>-->
               <!--   {{$detail->recommended_status}}</small>-->
               <!--@endif -->

               <!--   </h5>-->

                  <div class="">
                     @if($detect->isMobile() && $detail->logo_approved == '1')
                     <div class="agent-detail-box">
                        <img src="{{url('storage/uploads/agents/'.$detail->logo)}}" width="100%" class="mb-3">
                     </div>
                     @endif
                     @if(!empty($detail->description))
                     <p>{!! $detail->description !!}</p>
                     @endif
                  </div>
               </div>
               @if(!is_null($detail->foreignJobs) && $detail->foreignJobs->count() > 0)
               <div style="" class="agent-detail-boxes">
                 <h3 class="text-capitalize mb-0">Foreign Jobs <a class="float-right btn btn-primary" href="{{url('foreign-jobs?agent='.$detail->id)}}" style="color:white !important">See All Jobs</a></h3>
                  <hr>

                  <div class="row">
                  @foreach($detail->foreignJobs->take(9) as $j)
                     <div class="col-md-4" style="">
                           <div class="job-box" style="min-height:140px;background:white">
                              <div class="row">
                                 <div class="col-md-12 ">
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
                                 
                                          @if(!empty($j->salary))
                                          <div class="row">
                                             <div class="col-md-6 col-6 pr-1">
                                                   <strong>Salary Offer</strong>
                                             </div>
                                             <div class="col-md-6  col-6 pl-1">
                                                   <p style="font-family:arial;"> {{$j->salary}}</p>
                                             </div>
                                          </div>
                                          @endif
                                          @if(!is_null($j->place_of_duty) && !empty($j->place_of_duty))
                                          <div class="row">
                                             <div class="col-md-6  col-6 pr-1">
                                                   <strong>Place of Duty</strong>
                                             </div>
                                             <div class="col-md-6  col-6 pl-1">
                                                   <p style="font-family:arial;text-transform:capitalize"> {{!is_null($j->place_of_duty)?strtolower($j->place_of_duty):''}}</p>
                                             </div>
                                          </div>
                                          @endif
                                          @if(!empty($j->grant_date))
                                          <div class="row">
                                             <div class="col-md-6  col-6 pr-1">
                                                   <strong>Grant Date</strong>
                                             </div>
                                             <div class="col-md-6  col-6 pl-1">
                                                   <p style="font-family:arial;"> {{!empty($j->grant_date)?date('d M Y',strtotime($j->grant_date)):''}}</p>
                                             </div>
                                          </div>
                                          @endif
                                       
                                          @if(auth()->check() && auth()->user()->type == 'agent')
                                       @else
                                          <div class="text-center" style="margin-top:8px;">
                                             <a href="https://beoe.gov.pk/foreign-jobs/{{$j->permission}}" class="btn btn-primary btn-sm" style="color:white !important;">Apply Now</a>
                                          </div>
                                       @endif
                                          <!-- <p><strong>City</strong> : {{$j->agentCity}}</p> -->

                                       </div>
                                 </div>
                              </div>
                              
                           </div>

                     </div>
                     @endforeach
                  </div>
               </div>
               @endif
               @if($detect->isMobile())
                @if ($detail->has_sastickets)
                <a class="btn btn-primary mb-3 btn-block btn-lg" href="{{url('sasti-tickets?from=&to=&agent='.$detail->id)}}" style="background-color:#f58220;border-color:#f58220">Available Sasti Tickets</a>
               @endif
               
               @if ($detail->has_flights)
                  <a class="btn btn-secondary mb-3 btn-block btn-lg" href="{{url('cheap-umrah-flights-from-pakistan?from=&to=&agent='.$detail->id)}}">Available Umrah Tickets</a>
               @endif
               <div class="box-hang-title">
                  <h3 class="">Contact Info</h3>
               </div>
               <div style="" class="agent-detail-boxes">

                  @if(CheckPermission($detail->id,'full_contact'))
                  @if(!empty($detail->email))
                  @php
                  $email = explode(',', $detail->email);
                  @endphp
                  @foreach($email as $e)
                  <p style="word-break: break-all;"><a href="mailto:{{$e}}" style="color: unset;"> <i
                           class="fa fa-envelope"></i> {{$e}}</a></p>
                  @endforeach
                  @endif
                  @endif
                  @if(!empty($detail->phone))
                  @php
                  $phone = explode(',', $detail->phone);
                  @endphp

                  @foreach($phone as $p)
                  <p class="number-style"><a href="tel:{{$p}}" style="color: unset;"> <i class="fa fa-phone-volume"></i>
                        {{str_replace('041','041-',$p)}}</a>
                  </p>
                  @endforeach
                  @endif
                  @if(CheckPermission($detail->id,'full_contact'))
                  @if(!empty($detail->mobile))
                  @php
                  $mobile = explode(',', $detail->mobile);
                  @endphp
                  @foreach($mobile as $key => $p)
                  @if($key == 1)
                  <p class="number-style"
                     style="background:#25D366; text-align: center;color:white;font-size:18px;    padding: 7px;"><a
                        href="https://wa.me/{{$p}}" rel="nofollow" style="color: unset;"> <i class="fab fa-whatsapp"
                           style="color:white"></i> whatsapp</a>
                  </p>
                  @else
                  <p class="number-style"><a href="tel:{{$p}}" rel="nofollow" style="color: unset;"> <i
                           class="fa fa-mobile"></i>
                        {{$p}}</a>
                  </p>
                  @endif
                  @endforeach
                  @endif
                  @endif
                  
               </div>
               @if(CheckPermission($detail->id,'short_contact'))
               <div class="box-hang-title">
                  <h3 class="">Address</h3>
               </div>
               <div style="" class="agent-detail-boxes">
                  @if(!empty($detail->address))
                  <p>
                     <i class="fa fa-building"></i> {{$detail->address}}
                     <!-- , {{!is_null($detail->city)?$detail->city->name:''}} -->
                  </p>
                  @endif
                  @if(!is_null($detail->city))
                  <p><i class="fa fa-map-marker-alt"></i> {{!is_null($detail->city)?$detail->city->name:''}}</p>
                  @endif
               </div>
               @endif
               <div class="box-hang-title">
                  <h3 class="">Social Media Profile</h3>
               </div>
               <div style="" class="agent-detail-boxes">


                  @if(!empty($detail->fax))
                  <p class="number-style" style="margin-bottom: 5px;"><strong>Fax</strong>: {{$detail->fax}}
                  </p>
                  @endif
                  @if(CheckPermission($detail->id,'full_contact'))
                  @if(!empty($detail->facebook))
                  <p style="margin-bottom: 5px;"> <a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}"
                        rel="nofollow" target="_blank"> <i class="fab fa-facebook-f"></i>
                        {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}</a>
                  </p>
                  @endif
                  @if(!empty($detail->twitter))
                  <p style="margin-bottom: 5px;"><strong><i class="fab fa-twitter"></i> </strong> <a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}}"
                        rel="nofollow"
                        target="_blank">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}}
                     </a></p>
                  @endif
                  @if(!empty($detail->linkedin))
                  <p style="margin-bottom: 5px;"><strong><i class="fab fa-linkedin"></i> </strong> <a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->linkedin)))}}"
                        target="_blank"
                        rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->linkedin)))}}
                     </a></p>
                  @endif
                  @if(!empty($detail->insta))
                  <p style="margin-bottom: 5px;"><strong><i class="fab fa-instagram"></i> </strong> <a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->insta)))}}"
                        target="_blank"
                        rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->insta)))}}
                     </a></p>
                  @endif
                  @if(!empty($detail->tiktok))
                  <p style="margin-bottom: 5px;"><strong><svg xmlns="http://www.w3.org/2000/svg" width="17px"
                           height="auto" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"
                           image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"
                           viewBox="0 0 449.45 515.38">
                           <path fill="#f58220" fill-rule="nonzero"
                              d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z" />
                        </svg> </strong> <a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->tiktok)))}}"
                        target="_blank"
                        rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->tiktok)))}}
                     </a></p>
                  @endif
                  @if(!empty($detail->youtube))
                  <p style="margin-bottom: 5px;"><strong><i class="fab fa-youtube"></i> </strong><a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}}"
                        rel="nofollow" target="_blank">
                        {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}}
                     </a>
                  </p>
                  @endif
                  @if(CheckPermission($detail->id,'whatsapp_message'))
                  @if(!empty($detail->whatsapp))
                  <p style="margin-bottom: 5px;"><strong><i class="fab fa-whatsapp"></i> </strong> <a
                        href="{{$detail->whatsapp}}" rel="nofollow" target="_blank">{{$detail->whatsapp}} </a></p>
                  @endif
                  @endif
                  @if(!empty($detail->website))
                  <p style="margin-bottom: 5px;"><strong><i class="fa fa-globe"></i></strong> <a
                        href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}"
                        target="_blank" rel="nofollow" style="color:unset">
                        {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}
                     </a>
                  </p>
                  @endif
                  @endif
               </div>
               @endif
               @if(CheckPermission($detail->id,'manage_umrah_packages') &&
               $detail->packages()->where('active',1)->count() >
               0)
               <div class="box-hang-title">
                  <h3 class="">Umrah Package</h3>
               </div>
               <div style="" class="agent-detail-boxes">
                  @php $package = $detail->packages()->where('active',1)->first(); @endphp
                  @if(!is_null($package))
                  <h3 class="m-0">{{ $package->name }} </h3>
                  <hr>
                  <img src="{{url('storage/uploads/packages/'.$package->image)}}" width="100%"
                     style="border-radius: 7px;object-fit: cover;margin-bottom: 10px;">

                  @else
                  <p class="text-center"> No Package Found</p>
                  @endif
               </div>
               @endif



               @if(!is_null($detail->agentDeals) && !empty($detail->agentDeals) &&
               $detail->agentDeals->where('active',1)->where('admin_approved',1)->count() >
               0)

               <!-- <div class="box-hang-title" id="deals">
         @foreach($detail->agentDeals()->where('active',1)->where('admin_approved',1)->take(10)->get() as $index =>
            $g)
            <h3 class="deal-title" data-slide="{{ $index }}">{{$g->name}}</h3>
            @endforeach
         </div> -->
               <div style="" class="agent-detail-boxes">
                  <h3 >Special Offers</h3>
                  <hr>

                <div class="d-sm-block d-none">
                  <div class="row mt-2">
                     @if(CheckPermission($detail->id,'10_promotions'))
                             @foreach($detail->agentDeals()->where('active',1)->where('admin_approved',1)->take(10)->get() as
                             $index
                             => $g)
                             <div class="col-md-4">
                                 <div class="bg-white p-3" style="border-radius: 10px;">
                                     
                                    <h5 class=""><b>{{$g->name}}</b></h5>
                                    <div class="social-share mt-1  mb-3">
                                       <span>Share this on:</span>
                                       <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('storage/uploads/agents/'.$g->image)) }}"
                                          target="_blank" class="btn btn-primary btn-sm detail-social-button">
                                          <i class="fab fa-facebook-f text-white"></i>
                                       </a>
                                       <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url('storage/uploads/agents/'.$g->image)) }}"
                                          target="_blank" class="btn btn-info btn-sm detail-social-button">
                                          <i class="fab fa-linkedin text-white"></i>
                                       </a>
                                       <a href="https://wa.me/?text=Check this out: {{ urlencode(url('storage/uploads/agents/'.$g->image)) }}"
                                          target="_blank" class="btn btn-success btn-sm detail-social-button">
                                          <i class="fab fa-whatsapp text-white"></i>
                                       </a>
                                    </div>
                                    <a href="{{url('storage/uploads/agents/'.$g->image)}}" target="_blank"><img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Special Offer"
                                       class="promotionImage w-100"></a>
                                 </div>
                             </div>
                             @endforeach
                        @endif
                    </div>
                  </div>
                  <div class="d-sm-none d-block">
                      @if(CheckPermission($detail->id,'10_promotions'))
                         <div class="slider responsive d-sm-none d-block">
                             @foreach($detail->agentDeals()->where('active',1)->where('admin_approved',1)->take(10)->get() as
                             $index
                             => $g)
                             
                                 <div class="bg-white p-3" style="border-radius: 10px;">
                                     
                                    <h5 class=""><b>{{$g->name}}</b></h5>
                                    <div class="social-share mt-1  mb-3">
                                       <span>Share this on:</span>
                                       <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('storage/uploads/agents/'.$g->image)) }}"
                                          target="_blank" class="btn btn-primary btn-sm detail-social-button">
                                          <i class="fab fa-facebook-f text-white"></i>
                                       </a>
                                       <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url('storage/uploads/agents/'.$g->image)) }}"
                                          target="_blank" class="btn btn-info btn-sm detail-social-button">
                                          <i class="fab fa-linkedin text-white"></i>
                                       </a>
                                       <a href="https://wa.me/?text=Check this out: {{ urlencode(url('storage/uploads/agents/'.$g->image)) }}"
                                          target="_blank" class="btn btn-success btn-sm detail-social-button">
                                          <i class="fab fa-whatsapp text-white"></i>
                                       </a>
                                    </div>
                                    <a href="{{url('storage/uploads/agents/'.$g->image)}}" target="_blank"><img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Special Offer"
                                       class="promotionImage w-100"></a>
                                 </div>
                             @endforeach
                        </div>
                        @endif
                  </div>
                  <!-- <div class="slider responsive">
            
               @if(CheckPermission($detail->id,'10_promotions'))
               @foreach($detail->agentDeals()->where('active',1)->where('admin_approved',1)->take(10)->get() as $index
               => $g)
               <div data-slick-index="{{ $index }}">
               <div class="social-share mt-3  mb-3">
                           <b>Share this on:</b>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('storage/uploads/agents/'.$g->image)) }}" target="_blank" class="btn btn-primary btn-sm">
                <i class="fab fa-facebook-f text-white"></i> 
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url('storage/uploads/agents/'.$g->image)) }}" target="_blank" class="btn btn-info btn-sm">
                <i class="fab fa-linkedin text-white"></i> 
            </a>
            <a href="https://wa.me/?text=Check this out: {{ urlencode(url('storage/uploads/agents/'.$g->image)) }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fab fa-whatsapp text-white"></i> 
            </a>
        </div>
                  <img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Special Offer" class="promotionImage">
               </div>
               @endforeach
               @endif
            </div> -->

               </div>
               @endif


               @if(!is_null($detail->agentGallery) && !empty($detail->agentGallery) &&
               $detail->agentGallery->where('active',1)->where('admin_approved',1)->count() > 0)
               <!-- <div class="box-hang-title">
                  <h3 class="">Gallery</h3>
               </div> -->
               <div style="" class="agent-detail-boxes d-none">
               <h3>Gallery</h3>
               <hr>
                  <div class="slider responsive">

                     @if(CheckPermission($detail->id,'15_gallery_pictures'))
                     @foreach($detail->agentGallery()->where('active',1)->where('admin_approved',1)->take(15)->get() as
                     $g)
                     <div>
                        <img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Los Angeles" style=""
                           class="galleryImage">
                     </div>
                     @endforeach
                     @endif
                  </div>

               </div>
               @endif

              
               <div style="" class="agent-detail-boxes" id="reviews">
                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                       
                    @if($detect->isMobile())
                      <h3 class="">Customer Reviews</h3>
                      @else
                      <h3 class="">Customer Reviews About {{strtolower($detail->business_name)}}</h3>
                    @endif
                      @if(auth()->check() )
                      @if(auth()->user()->id != $detail->users_id &&
                      is_null($detail->agentReviews()->where('users_id',auth()->user()->id)->first()) && auth()->user()->type != 'agent')
    
    
                      <button type="button" data-toggle="modal" data-target="#reviewModel"
                         class="btn btn-sm btn-success pull-right" style="float: right;color: #fff !important">Write
                         Review</button>
    
                      @endif
                      @else
                      <a href="{{url('login')}}" class="btn btn-sm btn-success pull-right"
                         style="float: right;color: #fff !important">Write Review</a>
                      @endif
                   </div>
               <hr>
                  @if(!is_null($detail->agentReviews) && $detail->agentReviews()->where('active',1)->count() > 0)
                  @foreach($detail->agentReviews()->where('active',1)->get() as $r)
                  <div class="row review-box">
                     @if(!is_null($r->user->agents) && count($r->user->agents) > 0)
                     <div class="col-md-3">
                        @if(!empty($r->user->agents()->first()->logo))
                        <img src="{{url('storage/uploads/agents/'.$r->user->agents()->first()->logo)}}"
                           style="width: 100%;height: 100px;object-fit: contain;    background: #f0f0f0;">
                        @else
                        <img src="{{url('images/placeholder.jpg')}}"
                           style="width: 100%;height: 100px;object-fit: cover;    background: #f0f0f0;">
                        @endif
                     </div>
                     <div class="col-md-9 rating-description">
                        <h3 class="text-capitalize">{{strtolower($r->user->agents()->first()->business_name)}}</h3>
                        @for ($i=1; $i <= $r->rating ; $i++)
                           <i class="fa fa-star" style="color: #f58220"></i>
                           @endfor
                           <p>{{$r->message}}</p>
                     </div>
                     @else
                     <div class="col-md-12">
                         <div class="d-flex align-items-center mb-2">
                            <h3 class="mb-0 mr-4">{{$r->user->name}}</h3>
                            @for ($i=1; $i <= $r->rating ; $i++)
                                <i class="fa fa-star" style="color: #f58220; margin-right: 3px;"></i>
                            @endfor
                         </div>
                           <p>{{$r->message}}</p>
                     </div>
                     @endif
                  </div>
                  @endforeach
                  @else
                  <p class="text-center">Not Reviewed Yet</p>
                  @endif
               </div>
               <?php if (!$detect->isMobile()): ?>
                  <div style="width: 100%;">
                     <ins class="adsbygoogle" style="display:inline-block;width:100%;height:120px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                     <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                     </script>
                  </div>
               <?php endif ?>

      </div>
      @if(!$detect->isMobile())
      <div class="col-md-3 col-pd" style="    padding: 0;">
         @else
         <div class="col-md-3 col-pd detail-sidebar">
            @endif
            @if(!$detect->isMobile())
            @if(!empty($detail->logo) && $detail->logo_approved == '1')
            <div class="content-box-agent">
               <img src="{{url('storage/uploads/agents/'.$detail->logo)}}" width="100%">
            </div>
            @endif
            @if ($detail->has_sastickets)
                <a class="btn btn-primary mb-3 mt-3 btn-block btn-lg" href="{{url('sasti-tickets?from=&to=&agent='.$detail->id)}}" style="background-color:#f58220;border-color:#f58220">Available Sasti Tickets</a>
            @endif
            
            @if ($detail->has_flights)
                <a class="btn btn-secondary mb-3 btn-block btn-lg" href="{{url('cheap-umrah-flights-from-pakistan?from=&to=&agent='.$detail->id)}}">Available Umrah Tickets</a>
            @endif
            <div class="box-hang-title mt-2">
               <h3 class="btn-block">Contact Info</h3>
            </div>
            <div class="agent-detail-boxes agent-detail-side-bar-links">

               @if(CheckPermission($detail->id,'full_contact'))
               @if(!empty($detail->email))
               @php
               $email = explode(',', $detail->email);
               @endphp
               @foreach($email as $e)
               <p style="    word-break: break-all;"><a href="mailto:{{$e}}" rel="nofollow" style="color: unset;"> <i
                        class="fa fa-envelope"></i> {{$e}}</a></p>
               @endforeach
               @endif
               @endif
               @if(!empty($detail->phone))
               @php
               $phone = explode(',', $detail->phone);
               @endphp

               @foreach($phone as $p)
               <p class="number-style"><a href="tel:{{$p}}" style="color: unset;"> <i class="fa fa-phone-volume"></i>
                     {{str_replace('041','041-',$p)}}</a>
               </p>
               @endforeach
               @endif
               
               @if(!empty($detail->address))
               <p>
                  <i class="fa fa-building"></i> {{$detail->address}}
                  <!-- , {{!is_null($detail->city)?$detail->city->name:''}} -->
               </p>
               @endif
               @if(!is_null($detail->city))
               <p><i class="fa fa-map-marker"></i> {{!is_null($detail->city)?$detail->city->name:''}}</p>
               @endif
               @if(CheckPermission($detail->id,'full_contact'))
               @if(!empty($detail->facebook))
               <p style="margin-bottom: 5px;"> <a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}"
                     target="_blank" rel="nofollow"> <i class="fab fa-facebook-f"></i>
                     {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}</a>
               </p>
               @endif
               @if(!empty($detail->twitter))
               <p style="margin-bottom: 5px;"><strong><i class="fab fa-twitter"></i> </strong> <a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}}"
                     target="_blank"
                     rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}}
                  </a></p>
               @endif
               @if(!empty($detail->linkedin))
               <p style="margin-bottom: 5px;"><strong><i class="fab fa-linkedin"></i> </strong> <a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->linkedin)))}}"
                     target="_blank"
                     rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->linkedin)))}}
                  </a></p>
               @endif
               @if(!empty($detail->insta))
               <p style="margin-bottom: 5px;"><strong><i class="fab fa-instagram"></i> </strong> <a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->insta)))}}"
                     target="_blank"
                     rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->insta)))}}
                  </a></p>
               @endif
               @if(!empty($detail->tiktok))
               <p style="margin-bottom: 5px;"><strong><svg xmlns="http://www.w3.org/2000/svg" width="17px" height="auto"
                        shape-rendering="geometricPrecision" text-rendering="geometricPrecision"
                        image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"
                        viewBox="0 0 449.45 515.38">
                        <path fill="#f58220" fill-rule="nonzero"
                           d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z" />
                     </svg> </strong> <a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->tiktok)))}}"
                     target="_blank"
                     rel="nofollow">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->tiktok)))}}
                  </a></p>
               @endif
               @if(!empty($detail->youtube))
               <p style="margin-bottom: 5px;"><strong><i class="fab fa-youtube"></i> </strong><a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}}"
                     target="_blank" rel="nofollow">
                     {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}}
                  </a></p>
               @endif
               @if(CheckPermission($detail->id,'whatsapp_message'))
               @if(!empty($detail->whatsapp))
               <p style="margin-bottom: 5px;"><strong><i class="fab fa-whatsapp"></i> </strong> <a
                     href="{{$detail->whatsapp}}" target="_blank" rel="nofollow">{{$detail->whatsapp}} </a></p>
               @endif
               @endif
               @if(!empty($detail->website))
               <p style="margin-bottom: 5px;"><strong><i class="fa fa-globe"></i></strong> <a
                     href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}"
                     target="_blank" rel="nofollow" style="color:unset">
                     {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}
                  </a></p>
               @endif
               @endif
               @if(!empty($detail->fax))
               <p class="number-style" style="margin-bottom: 5px;"><strong>Fax</strong>: {{$detail->fax}}
               </p>
               @endif
               @if(CheckPermission($detail->id,'full_contact'))
               @if(!empty($detail->mobile))
               @php
               $mobile = explode(',', $detail->mobile);
               @endphp
               @foreach($mobile as $key => $p)
               @if($key == 1)
               <p class="number-style"
                  style="background:#25D366; text-align: center;color:white;font-size:18px;    padding: 7px;"><a
                     href="https://wa.me/{{$p}}" rel="nofollow" style="color: unset;"> <i class="fab fa-whatsapp"
                        style="color:white"></i> whatsapp</a>
               </p>
               @else
               <p class="number-style"><a href="tel:{{$p}}" rel="nofollow" style="color: unset;"> <i
                        class="fa fa-mobile"></i>
                     {{$p}}</a>
               </p>
               @endif
               @endforeach
               @endif
               @endif
                  @if(!$detect->isMobile())
                        @if(empty($detail->users_id))
              
                        <a href="{{url('claim-business/'.$detail->slug)}}" rel="nofollow" class="btn btn-danger btn-block" style="color:white !important"> Claim Business</a>
                        @endif
                        @endif
            </div>

            <!-- @if(CheckPermission($detail->id,'short_contact'))
            <div class="box-hang-title mt-2">
               <h3 class="btn-block">Address</h3>
            </div>
            <div style="" class="agent-detail-boxes agent-detail-side-bar-links">

            </div>
            @endif
            <div class="box-hang-title mt-2">
               <h3 class="btn-block">Social Media Profile</h3>
            </div>
            <div style="" class="agent-detail-boxes agent-detail-side-bar-links">

                @if(!empty($detail->dsl_license))
         <p style="margin-bottom: 5px;"><strong>DSL License</strong>: {{$detail->dsl_license}}</p>
         @endif
         @if(!empty($detail->dsl_expairy))
         <p class="number-style" style="margin-bottom: 5px;"><strong>DSL License Expiry</strong>:
            {{$detail->dsl_expairy}}
         </p>
         @endif
         @if(!empty($detail->iata_license))
         <p style="margin-bottom: 5px;"><strong>IATA License</strong>: {{$detail->iata_license}}</p>
         @endif
         @if(!empty($detail->iata_expairy))
         <p class="number-style" style="margin-bottom: 5px;"><strong>IATA Expiry</strong>:
            {{$detail->iata_expairy}}
         </p>
         @endif
              
             
            </div>
            @endif -->

            @if(!is_null($detail->agentGallery) && !empty($detail->agentGallery) &&
               $detail->agentGallery->where('active',1)->where('admin_approved',1)->count() > 0)
               <div class="box-hang-title mt-2">
                   <h3 class="btn-block">Gallery</h3>
                </div>

               <div style="" class="agent-detail-boxes">
                  <div class="slider responsive">

                     @if(CheckPermission($detail->id,'15_gallery_pictures'))
                     @foreach($detail->agentGallery()->where('active',1)->where('admin_approved',1)->take(15)->get() as
                     $g)
                     <div>
                        <img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Los Angeles" style=""
                           class="galleryImage">
                     </div>
                     @endforeach
                     @endif
                  </div>

               </div>
              @endif

            @if(!is_null($detail->agentTimings) && $detail->agentTimings->count() > 0)
            <div class="box-hang-title mt-2">
               <h3 class="btn-block">Office Timing</h3>
            </div>
            <div style="" class="agent-detail-boxes">

               <div class="row">
                  @foreach($detail->agentTimings as $t)
                  <div class="col-6">
                     <p>{{$t->day}}</p>
                  </div>
                  <div class="col-6 pl-0 pr-0">
                     <p class="number-style"> @if(!empty($t->opening)) {{$t->opening}} - {{$t->closing}} @else Closed
                        @endif</p>
                  </div>
                  @endforeach
               </div>
            </div>
            @endif

            @if(!is_null($detail->agentJobs) && $detail->agentJobs->count() > 0)
            <div class="box-hang-title mt-2">
               <h3 class="btn-block">Staff Required</h3>
            </div>
            <div style="" class="slider responsive mb-3">
               @foreach($detail->agentJobs as $j)
               <div class="job-box mt-0">
                  <a href="{{url('job/'.$j->slug)}}">
                     <h4><strong style="margin-right:20px;"></strong>{{$j->jobCategory->name}}</h4>
                     <h4 style="background:#f58220;text-transform:capitalize;color:white"><strong
                           style="margin-right:25px;">Company
                           |</strong>{{$j->agent->business_name}}</h4>
                  </a>
                  <div class="job-detail">
                     <div class="row">
                        <div class="col-md-6">
                           <strong>Post Date</strong>
                        </div>
                        <div class="col-md-6">
                           <p style="font-family:arial;"> {{date('d M Y',strtotime($j->created_at))}}</p>
                        </div>
                     </div>
                     @if(!empty($j->offer))
                     <div class="row">
                        <div class="col-md-6">
                           <strong>Salary Offer</strong>
                        </div>
                        <div class="col-md-6">
                           <p style="font-family:arial;"> Rs {{$j->offer}}</p>
                        </div>
                     </div>
                     @endif
                     @if(!is_null($j->jobExperience))
                     <div class="row">
                        <div class="col-md-6">
                           <strong>Experience</strong>
                        </div>
                        <div class="col-md-6">
                           <p style="font-family:arial;"> {{!is_null($j->jobExperience)?$j->jobExperience->name:''}}</p>
                        </div>
                     </div>
                     @endif
                     <div class="row">
                        <div class="col-md-6">
                           <strong>Last Date of Apply</strong>
                        </div>
                        <div class="col-md-6">
                           <p style="font-family:arial;"> {{date('d M Y',strtotime($j->apply_date))}}</p>
                        </div>
                     </div>
                     <div class="text-center" style="margin-top:5px;">
                        <a href="{{url('applicant/'.$j->slug)}}" class="btn btn-success btn-xs btn-sm">Apply Now</a>
                     </div>

                     <!-- <p><strong>City</strong> : {{$j->agentCity}}</p> -->

                  </div>
               </div>
               @endforeach
            </div>
            @endif

         </div>
</section>
<div id="reviewModel" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Write Review </h4>
            <button type="button" class=" model-close-button pull-right btn btn-warning" data-dismiss="modal"><i
                  class="fa fa-times text-white"></i></button>
         </div>
         <div class="modal-body">
            <form action="{{url('save-review')}}" method="post" enctype="multipart/form-data" id="ratingForm">
               {{csrf_field()}}
               <input type="hidden" name="user_id" value="{{auth()->check()?auth()->user()->id:''}}">
               <input type="hidden" name="agent_id" value="{{$detail->id}}">
               <div class="">
                  <label for="">Attachemnt File</label>
                  <input type="file" class="form-control" name="attachment">
               </div>
               <div class="rating ">
                  <input type="radio" id="star5" name="rating" value="5" />
                  <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                  <input type="radio" id="star4" name="rating" value="4" />
                  <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                  <input type="radio" id="star3" name="rating" value="3" />
                  <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                  <input type="radio" id="star2" name="rating" value="2" />
                  <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                  <input type="radio" id="star1" name="rating" value="1" />
                  <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
               </div>
               <div class="clearfix"></div>
               <p id="ratingValidation" class="text-danger m-0"></p>
               <div class="form-group">
                  <textarea name="message" rows="4" class="form-control" placeholder="Message"></textarea>
               </div>
               <div class="text-center">
                  <button type="button" onClick="ValidateForm()" class="btn btn-primary">Submit</button>
               </div>
            </form>
         </div>
         <!--   <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->
      </div>
   </div>
</div>
@endsection
@push('script')
<script>
   function ValidateForm() {
      if ($('input[name="rating"]:checked').length == 0) {
         $('#ratingValidation').html("Rating is Required");
         return false;
      }
      $('#ratingForm').submit();
   }
   $('input[name="rating"]').click(function () {
      $('#ratingValidation').html(" ");
   });
   var $slider = $('.responsive');
   $slider.slick({
      dots: true,
      prevArrow: $('.prev'),
      nextArrow: $('.next'),
      infinite: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      responsive: [{
         breakpoint: 1024,
         settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
         }
      },
      {
         breakpoint: 600,
         settings: {
            slidesToShow: 2,
            slidesToScroll: 2
         }
      },
      {
         breakpoint: 480,
         settings: {
            slidesToShow: 1,
            slidesToScroll: 1
         }
      }
         // You can unslick at a given breakpoint now by adding:
         // settings: "unslick"
         // instead of a settings object
      ]
   });
   $('.deal-title').on('click', function () {
      var slideIndex = $(this).data('slide');
      $slider.slick('slickGoTo', slideIndex);
   });

</script>
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "TravelAgency",
            "@id": "{{ request()->url() }}#agency",
            "name": "{{ addslashes($detail->business_name) }}",
            "url": "{{ request()->url() }}",
            @if(!empty($detail->logo))
            "image": "{{ asset('uploads/agents/'.$detail->logo) }}",
            @endif
            @if(!empty($detail->phone) || !empty($detail->mobile))
            "telephone": "{{ !empty($detail->phone) ? $detail->phone : $detail->mobile }}",
            @endif
            @if(!empty($detail->email))
            "email": "{{ $detail->email }}",
            @endif
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ addslashes($detail->address ?? '') }}",
                "addressLocality": "{{ addslashes($detail->city->name ?? 'Pakistan') }}",
                "addressCountry": "PK"
            },
            "priceRange": "$$",
            "areaServed": "Pakistan"
        },
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://agents.com.pk/"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Travel Agents in Pakistan",
                    "item": "https://agents.com.pk/travel-agents-in-pakistan"
                },
                @if(!empty($detail->city))
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($detail->city->name) }}",
                    "item": "https://agents.com.pk/travel-agents-in-{{ $detail->city->slug }}"
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "name": "{{ addslashes($detail->business_name) }}",
                    "item": "{{ request()->url() }}"
                }
                @else
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($detail->business_name) }}",
                    "item": "{{ request()->url() }}"
                }
                @endif
            ]
        }
    ]
}
</script>
@endpush