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
            <h1 class="agent-city-search-heading" style="color: #070c39; font-size: 24px; margin-bottom: 15px;"><b>Travel Agents in {{isset($searchCity) &&
                    !empty($searchCity)?$searchCity->name:'Pakistan'}}</b> <button onclick="showverified()"
                    id="show_verified" class="btn btn-primary btn-sm" style="float: right;">Show Verified
                    Agents</button><button onclick="allverified()" id="all_agents" class="btn btn-warning btn-sm"
                    style="float: right;display: none;color: #fff">All Agents</button>
                <div class="clearfix"></div>
            </h1>
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
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 style="font-size: 26px; font-weight: 700; color: #070c39; margin-bottom: 8px;">Pakistan's Premier Travel Marketplace — Cheap Tickets, Tours & Verified Agents</h1>
            <p class="text-muted" style="font-size: 15px;">Compare wholesale flight fares, Umrah packages, and holiday deals uploaded directly by certified travel agents across Pakistan.</p>
        </div>
    </div>
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
                <a href="{{ route('umrah-packages') }}"><img src="{{url('/umrah-banner.jpeg')}}" alt="Umrah Packages Deals from Pakistan" class="w-100">
                    <!--<div class="img-btn-block">-->
                    <!--    <span>Umrah Packages</span>-->
                    <!--</div>-->
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-6 mb-30 mb-10 cpl">
            <div class="image-banner-block mb-30 mb-10">
                <a href="{{ route('flight') }}"><img src="{{url('/images/agents-image-02.jpg')}}" alt="Cheap Umrah Flight Tickets" class="w-100">
                    <div class="img-btn-block">
                        <span>Umrah Tickets</span>
                    </div>
                </a>
            </div>
            <div class="image-banner-block">
                <a href="{{ route('sasti-tickets') }}">
                    <img src="{{url('/images/agents-image-03.jpg')}}" alt="Sasti Tickets - Discounted Airfare Deals" class="w-100">
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

    <!-- Frequently Asked Questions (FAQ) Section -->
    <div class="row mt-5 mb-4">
        <div class="col-12">
            <div class="faq-section p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div class="text-center mb-4">
                    <span class="badge badge-primary px-3 py-2" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; background: #070c39;">Got Questions?</span>
                    <h2 class="mt-2" style="color: #070c39; font-weight: 700; font-size: 24px;">Frequently Asked Questions</h2>
                    <p class="text-muted" style="font-size: 14px;">Find quick answers about booking tickets, tour packages, agent verification, and registration.</p>
                </div>
                
                <div class="accordion" id="homepageFaqAccordion">
                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingOne" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How do I book a ticket or tour through an agent on this site?
                            </h3>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Agents.com.pk is a direct travel marketplace. You can browse live flight deals on our <a href="{{ route('sasti-tickets') }}">Sasti Tickets</a> page or explore <a href="{{ route('tour-packages') }}">Tour Packages</a> listed by certified travel agents. When you find an offer you like, contact the listing agent directly via phone, WhatsApp, or through their agency profile to finalize booking and receive your e-ticket or travel voucher.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingTwo" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Are the fares shown final or subject to change?
                            </h3>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Fares and package rates are uploaded directly by registered travel agents. While agents strive to keep their inventory updated, flight fares, seat availability, and foreign exchange rates can fluctuate dynamically until booking is confirmed and ticketed with the airline. We recommend confirming the real-time fare directly with the agent.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingThree" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How do I become a registered travel agent?
                            </h3>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Travel agents and tour operators can join by clicking the "Sign Up / Register" button. Provide your business registration, agency name, office address, contact details, and license info. Once verified by our team, you can immediately start uploading Sasti Tickets, Umrah packages, and tour offers to reach thousands of travelers across Pakistan.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingFour" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What payment methods are accepted?
                            </h3>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Payment is made directly to the registered travel agent handling your booking. Most agents accept secure bank transfers (online banking, IBFT), cash at their physical offices, credit/debit cards, and digital wallets like JazzCash and EasyPaisa. Agents.com.pk does not charge or handle traveler payments directly.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingFive" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Is there a cancellation or refund policy?
                            </h3>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Cancellation and refund policies depend on the specific airline's fare rules and the individual agent's terms. Most standard airline tickets are refundable or changeable subject to airline penalties and agent service fees. Always verify the cancellation window and refund terms with the agent prior to payment.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingSix" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How can I verify that a travel agent on this site is trustworthy?
                            </h3>
                        </div>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Agents.com.pk displays verified badges for certified travel agencies with physical office addresses, verified contact numbers, and Department of Tourist Services (DTS) / IATA credentials. You can also view customer reviews, agent ratings, and office locations directly on each agent's profile page.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingSeven" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Can I request custom Umrah or international tour itineraries?
                            </h3>
                        </div>
                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Yes! In addition to listed ready-made packages, you can reach out to any listed travel agent in your city to request tailored itineraries, customized hotel categories, private transport, and specific flight connections that fit your family or group budget.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="headingEight" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Does Agents.com.pk charge travelers any extra booking fees?
                            </h3>
                        </div>
                        <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#homepageFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                No. Agents.com.pk is completely free for travelers to browse, search, and connect with travel agents. There are no hidden platform charges, booking fees, or markups added by our platform.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</script> 
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ request()->url() }}#directory",
            "url": "{{ request()->url() }}",
            "name": "Travel Agents Directory in Pakistan | Agents.com.pk",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "description": "Directory of verified travel agents and tour operators across major cities in Pakistan."
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
                }
                @if(isset($searchCity) && !empty($searchCity))
                ,
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes(ucwords(str_replace('-', ' ', $searchCity))) }}",
                    "item": "{{ request()->url() }}"
                }
                @endif
            ]
        },
        {
            "@type": "FAQPage",
            "@id": "{{ request()->url() }}#faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "How do I book a ticket or tour through an agent on this site?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Agents.com.pk is a direct travel marketplace. You can browse live flight deals on our Sasti Tickets page or explore tour packages listed by certified travel agents. When you find an offer you like, contact the listing agent directly via phone, WhatsApp, or through their agency profile to finalize booking and receive your e-ticket or travel voucher."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Are the fares shown final or subject to change?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Fares and package rates are uploaded directly by registered travel agents. While agents strive to keep their inventory updated, flight fares, seat availability, and foreign exchange rates can fluctuate dynamically until booking is confirmed and ticketed with the airline. We recommend confirming the real-time fare directly with the agent."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How do I become a registered agent?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Travel agents and tour operators can join by clicking the 'Sign Up / Register' button. Provide your business registration, agency name, office address, contact details, and license info. Once verified by our team, you can immediately start uploading Sasti Tickets, Umrah packages, and tour offers to reach thousands of travelers across Pakistan."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What payment methods are accepted?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Payment is made directly to the registered travel agent handling your booking. Most agents accept secure bank transfers (online banking, IBFT), cash at their physical offices, credit/debit cards, and digital wallets like JazzCash and EasyPaisa. Agents.com.pk does not charge or handle traveler payments directly."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is there a cancellation/refund policy?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Cancellation and refund policies depend on the specific airline's fare rules and the individual agent's terms. Most standard airline tickets are refundable or changeable subject to airline penalties and agent service fees. Always verify the cancellation window and refund terms with the agent prior to payment."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How can I verify if a travel agent on this platform is licensed and trustworthy?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Agents.com.pk displays verified badges for certified travel agencies with physical office addresses, verified contact numbers, and Department of Tourist Services (DTS) / IATA credentials. You can also view customer reviews, agent ratings, and office locations directly on each agent's profile page."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I request custom Umrah or international tour itineraries?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes! In addition to listed ready-made packages, you can reach out to any listed travel agent in your city to request tailored itineraries, customized hotel categories, private transport, and specific flight connections that fit your family or group budget."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Does Agents.com.pk charge travelers any extra booking fees?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "No. Agents.com.pk is completely free for travelers to browse, search, and connect with travel agents. There are no hidden platform charges, booking fees, or markups added by our platform."
                    }
                }
            ]
        }
    ]
}
</script>
@endpush