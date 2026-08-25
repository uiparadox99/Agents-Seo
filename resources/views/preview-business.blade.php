@extends('layouts.master')
@section('content')

@if(!empty($detail->cover))
<section id="content" class="agent-banner"
   style="background: url({{url('storage/uploads/agents/'.$detail->cover)}});background-repeat: no-repeat;    background-size: cover;background-position: center; background-color: #f0f0f0;    ">
@else
<section id="content" class="agent-banner"
   style="background: url({{url('images/agent-detail-banner.jpeg')}});background-repeat: no-repeat;    background-size: contain;background-position: center; background-color: #bfe3e1;       ">
   @endif
   <div class="overlay-on-detail" style="     ">
      <div class="container">
         <div class="row">
            <div class="col-md-10">
               <h3 style="" class="text-capitalize">{{strtolower($detail->business_name)}} </h3>
               <p class="addressp number-style"> <i class="fa fa-map-marker"></i> @if(!$detect->isMobile()){{$detail->address}}@endif
                  {{$detail->city->name}}
               </p>
            </div>
            @if(!$detect->isMobile())
            <div class="col-md-2">
               @if(empty($detail->users_id))
               <a href="{{url('claim-business/'.$detail->slug)}}" class="btn btn-primary pull-right
                  ">claim Business</a>
               @endif
            </div>
            @endif
         </div>
         <div class="clearfix">
         </div>
      </div>
   </div>
</section>
<section id="content" class="container agent-detail-main">
   <div class="row">
   <div class="col-md-9">
      @if($detect->isMobile())
      @if(empty($detail->users_id))
      <p>Is this Business in Yours <a href="{{url('claim-business/'.$detail->slug)}}" style="margin-left:8px;"
         class="btn btn-primary">claim Now</a></p>
      @endif
      @endif
    
      <div class="box-hang-title" >
         <h3 class=""><i class="fa fa-check" ></i> Verified
            Agent
         </h3>
      </div>
      <div style="" class="agent-detail-boxes">
         <h3>
            About {{$detail->business_name}}
            <!--  <small style="color:green;float:right"></small> -->
            @if(CheckPermission($detail->id,'recommended_status'))
            <small style="color:green;float:right"><i class="fa fa-check" style="color:green"></i>
            {{$detail->recommended_status}}</small>
            @endif
            @if(!$detect->isMobile())
            @if(!is_null($detail->agentType))
            <span style="float:right">
               @if( !empty($detail->agentType->image)) <img
                  src="{{url('storage/uploads/agents/'.$detail->agentType->image)}}"
                  style="width:70px;height:40px;" alt="{{$detail->agentType->name}}"> @else
               {{!is_null($detail->agentType)?$detail->agentType->name:''}} @endif
               <!-- {{!is_null($detail->agentType)?$detail->agentType->name:''}} -->
            </span>
            @endif
            @endif
         </h3>
         <hr>
         <div class="row">
            @if($detect->isMobile())
             <div class="col-md-12">
              <img src="{{url('storage/uploads/agents/'.$detail->logo)}}" width="100%">
          </div>
            @endif
            @if(!empty($detail->description))
            <div class="col-md-12">
               <p>{!! $detail->description !!}</p>
            </div>
            @endif
         </div>
      </div>
       @if($detect->isMobile())
       <div class="box-hang-title" >
         <h3 class="">Contact Info</h3>
      </div>
        <div style="" class="agent-detail-boxes">
     

         @if(!empty($detail->email))
         @php
         $email = explode(',', $detail->email);
         @endphp
         @foreach($email as $e)
         <p><a href="mailto:{{$e}}" style="color: unset;"> <i class="fa fa-envelope"></i> {{$e}}</a></p>
         @endforeach
         @endif

         @if(!empty($detail->phone))
         <p class="number-style"><a href="tel:{{$detail->phone}}" style="color: unset;"> <i class="fa fa-phone-volume"></i>
            {{str_replace('041','041-',$detail->phone)}}</a>
         </p>
         @endif
     
       <!--   @if(!empty($detail->mobile))
         @php
         $mobile =  explode(',', $detail->mobile);
         @endphp
         @foreach($mobile as $p)
         <p class="number-style"><a href="tel:{{$p}}" style="color: unset;"> <i class="fa fa-mobile"></i>
            {{$p}}</a>
         </p>
         @endforeach
         @endif -->
      </div>
     
       <div class="box-hang-title" >
         <h3 class="">Address</h3>
      </div>
      <div style="" class="agent-detail-boxes">
         @if(!empty($detail->address))
         <p>
            <i class="fa fa-map-marker"></i> {{$detail->address}}
            <!-- , {{!is_null($detail->city)?$detail->city->name:''}} -->
         </p>
         @endif
         @if(!is_null($detail->city))
         <p><strong>City:</strong> {{!is_null($detail->city)?$detail->city->name:''}}</p>
         @endif
      </div>

      <div class="box-hang-title" >
         <h3 class="">Online Profile</h3>
      </div>
      <div style="" class="agent-detail-boxes">
        
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
         @if(!empty($detail->fax))
         <p class="number-style" style="margin-bottom: 5px;"><strong>Fax</strong>: {{$detail->fax}}
         </p>
         @endif
    
          @if(!empty($detail->facebook))
         <p style="margin-bottom: 5px;"> <a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}" target="_blank"> <i class="fab fa-facebook-f"></i> {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}</a></p>
         @endif
         @if(!empty($detail->twitter))
         <p style="margin-bottom: 5px;"><strong><i class="fab fa-twitter"></i> </strong> <a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}}" target="_blank">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}} </a></p>
         @endif 
         @if(!empty($detail->youtube))
         <p style="margin-bottom: 5px;"><strong><i class="fab fa-youtube"></i> </strong><a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}}" target="_blank"> {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}} </a></p>
         @endif
         @if(CheckPermission($detail->id,'whatsapp_message'))
         @if(!empty($detail->whatsapp))
         <p style="margin-bottom: 5px;"><strong><i class="fab fa-whatsapp"></i> </strong> <a href="{{$detail->whatsapp}}" target="_blank">{{$detail->whatsapp}} </a></p>
         @endif
         @endif
          @if(!empty($detail->website))
         <p style="margin-bottom: 5px;"><strong><i class="fa fa-globe"></i></strong> <a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}"
            target="_blank" style="color:unset"> {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}} </a></p>
         @endif
    
      </div>
       @endif
      @if(!is_null($detail->agentGallery) && !empty($detail->agentGallery) && $detail->agentGallery->where('active',1)->count() >
      0)
      <div class="box-hang-title" >
         <h3 class="">Gallery Images</h3>
      </div>
      <div style="" class="agent-detail-boxes">
         <div class="slider responsive">
           
            @foreach($detail->agentGallery()->where('active',1)->take(5)->get() as $g)
            <div>
               <img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Los Angeles"
                  style="" class="galleryImage">
            </div>
            @endforeach
          
         </div>
      </div>
      @endif
      @if(!is_null($detail->agentDeals) && !empty($detail->agentDeals) && $detail->agentDeals->where('active',1)->count() >
      0)
      <div class="box-hang-title" >
         <h3 class="">Spacial Promotions</h3>
      </div>
      <div style="" class="agent-detail-boxes">
         <!--       <h3>Promotions</h3>
            <hr> -->
         <div class="slider responsive">
        
            @foreach($detail->agentDeals()->where('active',1)->take(3)->get() as $g)
            <div>
               <img src="{{url('storage/uploads/agents/'.$g->image)}}" alt="Los Angeles"
                  class="promotionImage">
            </div>
            @endforeach
          
         </div>
      </div>
      @endif
      <div class="box-hang-title" >
         <h3 class="">Reviews</h3>
      </div>
      <div style="" class="agent-detail-boxes">
         @if(auth()->check() && auth()->user()->id != $detail->users_id)
         <h3>
            <button type="button" data-toggle="modal" data-target="#reviewModel"
               class="btn btn-sm btn-success pull-right" style="float: right;">Write Review</button>
         </h3>
         <hr>
         @endif
         @if(!is_null($detail->agentReviews) && $detail->agentReviews()->where('active',1)->count() > 0)
         @foreach($detail->agentReviews()->where('active',1)->get() as $r)
         <div class="row">
            <div class="col-md-12">
               <h3>{{$r->user->name}}</h3>
               @for ($i=1; $i <= $r->rating ; $i++)
               <i class="fa fa-star" style="color: #f58220"></i>
               @endfor
               <p>{{$r->message}}</p>
            </div>
         </div>
         @endforeach
         @else
         <p>Not Reviewed Yet</p>
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
   <div class="col-md-3 col-pd">
      @endif
              @if(!$detect->isMobile())
      @if(!empty($detail->logo))
      <img src="{{url('storage/uploads/agents/'.$detail->logo)}}" width="100%">
      @endif
      <?php if (!$detect->isMobile()): ?>
      <ins class="adsbygoogle" style="display:inline-block;width:280px;height:220px"
         data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
      <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
      <?php endif ?>
    
      <div class="agent-detail-boxes" style="margin-top: 10px;">
         <h3>Contact Info</h3>
         <hr>

         @if(!empty($detail->email))
         @php
         $email = explode(',', $detail->email);
         @endphp
         @foreach($email as $e)
         <p><a href="mailto:{{$e}}" style="color: unset;"> <i class="fa fa-envelope"></i> {{$e}}</a></p>
         @endforeach
         @endif

         @if(!empty($detail->phone))
         <p class="number-style"><a href="tel:{{$detail->phone}}" style="color: unset;"> <i class="fa fa-phone-volume"></i>
            {{str_replace('041','041-',$detail->phone)}}</a>
         </p>
         @endif
   
         <!-- @if(!empty($detail->mobile))
         @php
         $mobile =  explode(',', $detail->mobile);
         @endphp
         @foreach($mobile as $p)
         <p class="number-style"><a href="tel:{{$p}}" style="color: unset;"> <i class="fa fa-mobile"></i>
            {{$p}}</a>
         </p>
         @endforeach
         @endif -->
   
      </div>

      <div style="" class="agent-detail-boxes">
         <h3>Address</h3>
         <hr>
         @if(!empty($detail->address))
         <p>
            <i class="fa fa-map-marker"></i> {{$detail->address}}
            <!-- , {{!is_null($detail->city)?$detail->city->name:''}} -->
         </p>
         @endif
         @if(!is_null($detail->city))
         <p><strong>City:</strong> {{!is_null($detail->city)?$detail->city->name:''}}</p>
         @endif
      </div>
 
      <div style="" class="agent-detail-boxes">
         <h3>Online Profile</h3>
         <hr>
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
         @if(!empty($detail->fax))
         <p class="number-style" style="margin-bottom: 5px;"><strong>Fax</strong>: {{$detail->fax}}
         </p>
         @endif
       
           @if(!empty($detail->facebook))
         <p style="margin-bottom: 5px;"> <a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}" target="_blank"> <i class="fab fa-facebook-f"></i> {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->facebook)))}}</a></p>
         @endif
         @if(!empty($detail->twitter))
         <p style="margin-bottom: 5px;"><strong><i class="fab fa-twitter"></i> </strong> <a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}}" target="_blank">{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->twitter)))}} </a></p>
         @endif 
         @if(!empty($detail->youtube))
         <p style="margin-bottom: 5px;"><strong><i class="fab fa-youtube"></i> </strong><a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}}" target="_blank"> {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->youtube)))}} </a></p>
         @endif
         @if(CheckPermission($detail->id,'whatsapp_message'))
         @if(!empty($detail->whatsapp))
         <p style="margin-bottom: 5px;"><strong><i class="fab fa-whatsapp"></i> </strong> <a href="{{$detail->whatsapp}}" target="_blank">{{$detail->whatsapp}} </a></p>
         @endif
         @endif
          @if(!empty($detail->website))
         <p style="margin-bottom: 5px;"><strong><i class="fa fa-globe"></i></strong> <a href="http://{{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}}"
            target="_blank" style="color:unset"> {{str_replace('http://','',str_replace('www.','',str_replace('https://','',$detail->website)))}} </a></p>
         @endif
        
      </div>
         @endif

      <?php if (!$detect->isMobile()): ?>
      <ins class="adsbygoogle" style="display:inline-block;width:280px;height:220px"
         data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
      <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
      <?php endif ?>

      @if(!is_null($detail->agentTimings) && $detail->agentTimings->count() > 0)
      <div style="" class="agent-detail-boxes"  style="margin-top: 10px;">
         <h3>Timings</h3>
         <hr>
         <div class="row">
            @foreach($detail->agentTimings as $t)
            <div class="col-6">
               <p>{{$t->day}}</p>
            </div>
            <div class="col-6">
               <p class="number-style">{{$t->opening}} - {{$t->closing}}</p>
            </div>
            @endforeach
         </div>
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
            <form action="{{url('save-review')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="user_id" value="{{auth()->check()?auth()->user()->id:''}}">
               <input type="hidden" name="agent_id" value="{{$detail->id}}">
               <div class="form-group">
                  <label for="">Attachemnt File</label>
                  <input type="file" class="form-control" name="attachment">
               </div>
               <div class="rating">
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
               <div class="form-group">
                  <textarea name="message" rows="4" class="form-control"></textarea>
               </div>
               <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
   $('.responsive').slick({
       dots: true,
       prevArrow: $('.prev'),
       nextArrow: $('.next'),
       infinite: false,
       speed: 300,
       slidesToShow: 1,
       slidesToScroll: 1,
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
</script>
@endpush