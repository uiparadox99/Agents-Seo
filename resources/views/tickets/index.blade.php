@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">
    <div class="row pt-3">
        <div class="col-12 text-center mb-3">
            <h1 style="font-size: 26px; font-weight: 700; color: #070c39; margin-bottom: 8px;">
                Sasti Tickets — Cheap Flight Deals from Verified Travel Agents in Pakistan
            </h1>
            <p class="text-muted" style="font-size: 15px; max-width: 900px; margin: 0 auto;">
                Find and book low-cost domestic and international airline tickets. Compare live seat allocations, group fares, and special airline offers uploaded directly by certified travel agents across Pakistan.
            </p>
        </div>
    </div>
    @if(request()->has('to') || $filters->count() == 0)
    <div class="row">
        <div class="col-md-12">
            @if(isset($agentDetail) && !is_null($agentDetail))
                <h2 class="text-capitalize  mb-1 mt-3 pb-0 "><b>{{strtolower($agentDetail->business_name)}} Sasti Tickets</b>
                </h2>
                <hr>
            @else
              
                @if(!$detect->isMobile())
                  @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to'))) 
                    <h4 class="mt-3 text-center"><b>{{request()->get('from')}} to {{request()->get('to')}}</b> <a href="{{url('sasti-tickets')}}" class="btn btn-primary float-right">Back to Search</a></h4>
                    <hr>
                @endif
                    <form action="{{url('sasti-tickets')}}" method="get" id="filter" onsubmit="return false;">
                        <div style="display:none" class="embassy-search mt-2 {{!$detect->isMobile()?'pb-3 pt-3':'pb-3 pt-3'}} mt-4"
                            style="border: 2px solid #070c39;background: #070c39;color: #fff">
                            <h4 class="text-center mb-3">Search Sasti Ticket </h4>
                            <div class="row">
                                
                        
                            <div class=" form-group col-md-4">

                                <!--<input type="text" name="from" class="form-control" value="{{request()->has('from')??request()->get('from')}}" placeholder="From">-->
                                <select name="from" class="form-control">
                                    <option value="">From</option>
                                    @foreach($from as $c)
                                    <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') ==
                                        $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" form-group col-md-4">
                                <!--                      <label for=""><b>To</b></label> -->
                                <!--<input type="text" name="to" class="form-control" value="{{request()->has('to')??request()->get('to')}}" placeholder="To">-->

                                <select name="to" class="form-control">
                                    <option value="">To</option>
                                    @foreach($to as $c)
                                    <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') ==
                                        $c->name)?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn mb-3 btn-primary search {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif -->
                                Search Tickets </button>
                            </div>
                        
                            <div class="col-md-2">
                            <a type="button"  href="javascript:;" class="text-light text-underline text-center btn-block showAll {{!$detect->isMobile()?'btn-block':''}}" style="text-decoration:underline"><h5>Show
                                All Flights</h5></a>
                            </div>
                            
                            
            </div>
                        </div>
                        <div class="embassy-search mt-2 filtersclass" style="border: 2px solid #070c39;">
                                <div class="row">
                        <div class=" col-md-3">
                                <select name="sort" id="sort" class="form-control" onchange="filters()">
                                    <!--              <option value="">All</option> -->
                                    <option value="">Nearest Date</option>
                                    <option value="low">Low to high prices</option>
                                    <option value="high" {{ request()->has("sort") && request()->get("sort") == "high" ?
                                        "selected":"" }} >High to low prices</option>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="airline" class="form-control" id="airline" onchange="filters()">
                                    <option value="">Select Airline</option>
                                    @foreach($airlines as $a)
                                    <option value="{{$a->id}}" {{request()->has('airline') && request()->get('airline') ==
                                        $a->id?"selected":""}}>{{$a->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <!--    <label><b>By Month</b></label> -->
                                <select name="month" class="form-control" onchange="filters()">
                                    <option value="">By Month</option>
                                    <option value="01" {{request()->has('month') && request()->get('month') ==
                                        '01'?'selected':''}}>January</option>
                                    <option value="02" {{request()->has('month') && request()->get('month') ==
                                        '02'?'selected':''}}>February</option>
                                    <option value="03" {{request()->has('month') && request()->get('month') ==
                                        '03'?'selected':''}}>March</option>
                                    <option value="04" {{request()->has('month') && request()->get('month') ==
                                        '04'?'selected':''}}>April</option>
                                    <option value="05" {{request()->has('month') && request()->get('month') ==
                                        '05'?'selected':''}}>May</option>
                                    <option value="06" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>June</option>
                                    <option value="07" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>July</option>
                                    <option value="08" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>August</option>
                                    <option value="09" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>September</option>
                                    <option value="10" {{request()->has('month') && request()->get('month') ==
                                        '10'?'selected':''}}>October</option>
                                    <option value="11" {{request()->has('month') && request()->get('month') ==
                                        '11'?'selected':''}}>November</option>
                                    <option value="12" {{request()->has('month') && request()->get('month') ==
                                        '12'?'selected':''}}>December</option>
                                </select>
                            </div>
                        
                        
                            <div class=" col-md-3">
                                <select name="agent" class="form-control select2" onchange="filters()">
                                    <option value="">Agents</option>
                                    @foreach($agents as $c)
                                    <option value="{{$c->id}}" class="text-capitalize">{{ strtolower($c->business_name)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                @else
                <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()">
                    @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to')))
                        {{request()->get('from')}} To {{request()->get('to')}}
                    @else 
                        Search Ticket 
                    @endif 
                    <span style="float: right;"><i class="fas fa-arrow-down"></i> Filters </span>
                </div>
                    <div id="mobileSearch" class=" embassy-search mb-2 filtersclass"
                        style="    border: 2px solid #070c39; display: none;">
                        <form action="{{url('sasti-tickets')}}" method="get" id="filter" onsubmit="return false;">
                            <div class=" form-group col-md-4 d-none">

                                <!--<input type="text" name="from" class="form-control" value="{{request()->has('from')??request()->get('from')}}" placeholder="From">-->
                                <select name="from" class="form-control">
                                    <option value="">From</option>
                                    @foreach($from as $c)
                                    <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') ==
                                        $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" form-group col-md-4 d-none">
                                <!--                      <label for=""><b>To</b></label> -->
                                <!--<input type="text" name="to" class="form-control" value="{{request()->has('to')??request()->get('to')}}" placeholder="To">-->

                                <select name="to" class="form-control">
                                    <option value="">To</option>
                                    @foreach($to as $c)
                                    <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') ==
                                        $c->name)?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="sort" id="sort" class="form-control" onchange="filters()">
                                    <option value="">Nearest Date</option>
                                    <option value="low">Low to high prices</option>
                                    <option value="high" {{ request()->has("sort") && request()->get("sort") == "high" ?
                                        "selected":"" }} >High to low prices</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="airline" class="form-control" id="airline" onchange="filters()">
                                    <option value="">Airline</option>
                                    @foreach($airlines as $a)
                                    <option value="{{$a->id}}" {{request()->has('airline') && request()->get('airline') ==
                                        $a->id?"selected":""}}>{{$a->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <!--    <label><b>By Month</b></label> -->
                                <select name="month" class="form-control" onchange="filters()">
                                    <option value="">By Month</option>
                                    <option value="10" {{request()->has('month') && request()->get('month') ==
                                        '10'?'selected':''}}>October</option>
                                    <option value="11" {{request()->has('month') && request()->get('month') ==
                                        '11'?'selected':''}}>November</option>
                                    <option value="12" {{request()->has('month') && request()->get('month') ==
                                        '12'?'selected':''}}>December</option>
                                    <option value="01" {{request()->has('month') && request()->get('month') ==
                                        '01'?'selected':''}}>January</option>
                                    <option value="02" {{request()->has('month') && request()->get('month') ==
                                        '02'?'selected':''}}>February</option>
                                    <option value="03" {{request()->has('month') && request()->get('month') ==
                                        '03'?'selected':''}}>March</option>
                                    <option value="04" {{request()->has('month') && request()->get('month') ==
                                        '04'?'selected':''}}>April</option>
                                    <option value="05" {{request()->has('month') && request()->get('month') ==
                                        '05'?'selected':''}}>May</option>
                                    <option value="06" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>June</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="agent" class="form-control" onchange="filters()">
                                    <option value="">Agents</option>
                                    @foreach($agents as $c)
                                    <option value="{{$c->id}}" class="text-capitalize">{{strtolower($c->business_name)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            
                        </form>
                    </div>
                @endif
            @endif
            
        </div>
        <div class="col-md-12">
            @if($flights->count() > 0)
            <div data-next-page="{{ $flights->nextPageUrl() }}" class=" endless-pagination">
                @if(!$detect->isMobile())
                <table class="table  table-bordered mt-4 text-center">
                    <thead>
                        <tr>
                            <th width="10%">Airline</th>
                            <th>Flight No.</th>
                            <th>From</th>
                            <!--  <th>One Stop</th> -->
                            <th>To</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Conditions</th>
                            <th>Luggage</th>
                            <th width="15%">Travel Agent</th>
                        </tr>
                    </thead>
                    <tbody class="append-data" id="agentPackgesData">
                        @include('partials.load-flight')
                    </tbody>
                </table>
                @else
                <div class="append-data" id="agentPackgesData">
                    @include('partials.load-flight')
                </div>
                @endif

            </div>
            @if(!empty($flights->nextPageUrl()))
            <div class="text-center">
                <button id="loadmore" class="btn btn-default" onclick="fetchPosts()">Load More Tickets</button>
                <div class="clearfix"></div>
                <br>
            </div>
            @endif

            @else
            <br>
            <p class="text-center"><strong>No Ticket added by agents</strong></p>
            @endif
        </div>
    </div>
    @else
         @if(isset($agentDetail) && !is_null($agentDetail))
            <h2 class="text-capitalize mb-1 mt-3 pb-0 "><b>{{strtolower($agentDetail->business_name)}} Sasti Tickets</b>
            </h2>
            <hr>
            @else
            @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) &&
            !empty(request()->has('to'))) <h4 class="text-center mt-3"><b>{{request()->get('from')}} to
                    {{request()->get('to')}}</b></h4>
            <hr> @endif
            <form action="{{url('sasti-tickets')}}" method="get" id="filter">
                <div class="embassy-search mt-2 {{!$detect->isMobile()?'pb-3 pt-3':'pb-3 pt-3'}} mt-4"
                    style="border: 2px solid #070c39;background: #070c39;color: #fff">
                    <h4 class="text-center mb-3">Search Sasti Ticket </h4>
                    <div class="row">
                        
                 
                    <div class=" form-group col-md-4">

                        <!--<input type="text" name="from" class="form-control" value="{{request()->has('from')??request()->get('from')}}" placeholder="From">-->
                        <select name="from" class="form-control">
                            <option value="">From</option>
                            @foreach($from as $c)
                            <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') ==
                                $c->name?'selected':''}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" form-group col-md-4">
                        <!--                      <label for=""><b>To</b></label> -->
                        <!--<input type="text" name="to" class="form-control" value="{{request()->has('to')??request()->get('to')}}" placeholder="To">-->

                        <select name="to" class="form-control">
                            <option value="">To</option>
                            @foreach($to as $c)
                            <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') ==
                                $c->name)?'selected':''}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <button type="submit" class="btn mb-3 btn-primary search {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif -->
                        Search Tickets </button>
                    </div>
                  
                     <div class="col-md-2 col-6">
                    <a   href="{{url('sasti-tickets?from=&to=')}}" class="text-light text-underline text-center btn-block showAll {{!$detect->isMobile()?'btn-block':''}}" style="text-decoration:underline"><h5>Show
                        All Flights</h5></a>
                       </div>
                       
                       
      </div>
                </div>
             
            </form>
         
            @endif
     <div class="row mt-4">
        @foreach($filters as $f)
        <div class="col-md-3 mb-3 col-6">
           <a href="{{url('sasti-tickets?from='.$f->from_city.'&to='.$f->to_city.'&month='.$f->month.'&airline='.$f->airline.'&sort='.$f->sortby)}}" class="btn-block">
               <span class="ticketsCount">{{$f->sasti_tickets_count}} Flights</span>
                 <img src="{{url('storage/uploads/jobs/'.$f->image)}}" style="width: 100%;object-fit:cover;" class="filter-img">
           </a>
        </div>
        @endforeach
     </div>
    @endif

    <!-- Rich Informational Content Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="content-guide p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <h2 style="font-size: 22px; font-weight: 700; color: #070c39; margin-bottom: 15px;">
                    What Are "Sasti Tickets" on Agents.com.pk?
                </h2>
                <p style="font-size: 14px; line-height: 1.8; color: #444;">
                    In Pakistan's travel industry, <strong>"Sasti Tickets"</strong> (cheap air tickets) refers to exclusive, heavily discounted airfares that are not always available on general online flight booking engines. These fares stem from registered travel agencies and IATA tour operators purchasing bulk seat blocks, group allocations, seasonal Umrah charter quotas, and special airline promotional inventories. On <strong>Agents.com.pk</strong>, registered travel agents across Karachi, Lahore, Islamabad, Peshawar, Multan, and Faisalabad list their live ticket inventory directly, enabling travelers and corporate buyers to access wholesale flight pricing with zero intermediary commissions.
                </p>

                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="p-3" style="background: #f8f9fa; border-left: 4px solid #f58220; border-radius: 6px;">
                            <h3 style="font-size: 17px; font-weight: 600; color: #070c39; margin-bottom: 8px;">
                                <i class="fas fa-tags text-warning mr-1"></i> How Ticket Pricing Works
                            </h3>
                            <p style="font-size: 13.5px; line-height: 1.7; color: #555; margin-bottom: 0;">
                                Unlike traditional travel portals that inflate airfares with payment gateway charges and hidden platform fees, agents on our marketplace list net fares. Pricing is influenced by flight date proximity, route demand (such as Saudi Arabia for Umrah, UAE, UK, or domestic sectors like Karachi-Islamabad), baggage allowances (e.g. 20kg, 30kg, or 2-piece allotments), and direct vs. connecting routings. Travelers see the exact airline, flight number, baggage terms, and agent contact before committing to a booking.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="p-3" style="background: #f8f9fa; border-left: 4px solid #070c39; border-radius: 6px;">
                            <h3 style="font-size: 17px; font-weight: 600; color: #070c39; margin-bottom: 8px;">
                                <i class="fas fa-user-shield text-primary mr-1"></i> Why Book Through Registered Agents?
                            </h3>
                            <p style="font-size: 13.5px; line-height: 1.7; color: #555; margin-bottom: 0;">
                                Booking through certified Pakistani travel agents provides critical advantages: localized phone and WhatsApp support, flexible payment alternatives (including online bank transfers and physical office visits), personalized visa advice, and swift human assistance for ticket date changes, flight rescheduling, or emergency refunds.
                            </p>
                        </div>
                    </div>
                </div>

                <h3 class="mt-4" style="font-size: 18px; font-weight: 700; color: #070c39;">
                    How to Search and Book Sasti Tickets (Step-by-Step)
                </h3>
                <ol style="font-size: 14px; line-height: 1.8; color: #444; padding-left: 20px;">
                    <li><strong>Select Origin and Destination:</strong> Choose your departure city (e.g., Lahore, Karachi, Islamabad) and international/domestic arrival airport.</li>
                    <li><strong>Filter and Sort:</strong> Use our sorting filters to view flights by nearest date, lowest cost price, preferred airline (PIA, Airblue, Serene, Fly Jinnah, Saudia, Emirates, Qatar Airways), or specific travel month.</li>
                    <li><strong>Review Baggage & Stopover Details:</strong> Click on flight entries to inspect baggage weight allowances, stopover connection times, and departure/arrival schedules.</li>
                    <li><strong>Connect Direct with the Agent:</strong> Reach out to the listed agency via their direct phone number or WhatsApp button to verify real-time seat availability and lock in the fare.</li>
                    <li><strong>Pay & Receive E-Ticket:</strong> Complete payment directly to the agent's verified account and receive your authentic airline PNR and e-ticket instantly via WhatsApp or email.</li>
                </ol>

                <p style="font-size: 13.5px; color: #666; margin-top: 15px;">
                    Looking for full packages? Explore our <a href="{{ route('umrah-packages') }}">Cheap Umrah Packages</a>, browse <a href="{{ route('tour-packages') }}">International & Domestic Tour Packages</a>, or find top-rated <a href="{{ route('agents-in-pakistan') }}">Travel Agents in Pakistan</a>.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="faq-section p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <div class="text-center mb-4">
                    <span class="badge badge-warning px-3 py-2 text-white" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; background: #f58220;">Frequently Asked Questions</span>
                    <h2 class="mt-2" style="color: #070c39; font-weight: 700; font-size: 24px;">Sasti Tickets FAQ</h2>
                    <p class="text-muted" style="font-size: 14px;">Answers to common questions about finding, comparing, and booking cheap air tickets on Agents.com.pk.</p>
                </div>

                <div class="accordion" id="sastiTicketsFaqAccordion">
                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="stHeadingOne" style="cursor: pointer;" data-toggle="collapse" data-target="#stCollapseOne" aria-expanded="true" aria-controls="stCollapseOne">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How are the cheapest tickets found on this platform?
                            </h3>
                        </div>
                        <div id="stCollapseOne" class="collapse show" aria-labelledby="stHeadingOne" data-parent="#sastiTicketsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Sasti Tickets are sourced directly from registered travel agencies across Pakistan who hold bulk allocations, group seats, and wholesale airline contracts. By allowing agents to list their unbooked seats directly on our marketplace, travelers can access discounted fares that bypass conventional online booking markups.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="stHeadingTwo" style="cursor: pointer;" data-toggle="collapse" data-target="#stCollapseTwo" aria-expanded="false" aria-controls="stCollapseTwo">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Are prices updated in real time?
                            </h3>
                        </div>
                        <div id="stCollapseTwo" class="collapse" aria-labelledby="stHeadingTwo" data-parent="#sastiTicketsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Registered agents regularly update their available seats and prices in their agency dashboards. However, airline seat availability and fare classes can sell out quickly, especially during peak seasons such as Ramadan, Hajj, and school vacations. We always advise contacting the listing agent promptly to lock in the advertised rate.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="stHeadingThree" style="cursor: pointer;" data-toggle="collapse" data-target="#stCollapseThree" aria-expanded="false" aria-controls="stCollapseThree">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Can I negotiate a fare directly with the agent?
                            </h3>
                        </div>
                        <div id="stCollapseThree" class="collapse" aria-labelledby="stHeadingThree" data-parent="#sastiTicketsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Yes. Because Agents.com.pk connects you directly with the listing travel agent, you are free to discuss family discounts, group bookings, infant rates, or customized return dates directly with the agent via phone or WhatsApp.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="stHeadingFour" style="cursor: pointer;" data-toggle="collapse" data-target="#stCollapseFour" aria-expanded="false" aria-controls="stCollapseFour">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What travel documents are required to issue a ticket?
                            </h3>
                        </div>
                        <div id="stCollapseFour" class="collapse" aria-labelledby="stHeadingFour" data-parent="#sastiTicketsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                For domestic flights within Pakistan, you will need a valid Computerized National Identity Card (CNIC) or B-Form for minors. For international flights, a valid passport (with at least 6 months validity) and appropriate destination visa or visa-on-arrival eligibility is mandatory.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="stHeadingFive" style="cursor: pointer;" data-toggle="collapse" data-target="#stCollapseFive" aria-expanded="false" aria-controls="stCollapseFive">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What is the baggage allowance on Sasti Tickets?
                            </h3>
                        </div>
                        <div id="stCollapseFive" class="collapse" aria-labelledby="stHeadingFive" data-parent="#sastiTicketsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Baggage allowances vary by airline and fare class. Each listing on our table indicates whether check-in baggage is included (e.g. 20kg, 30kg, 2 pieces of 23kg, or hand-carry only). You can confirm the exact baggage allowance with the agent before ticketing.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="stHeadingSix" style="cursor: pointer;" data-toggle="collapse" data-target="#stCollapseSix" aria-expanded="false" aria-controls="stCollapseSix">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What happens if my flight is rescheduled or cancelled?
                            </h3>
                        </div>
                        <div id="stCollapseSix" class="collapse" aria-labelledby="stHeadingSix" data-parent="#sastiTicketsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                If an airline alters its flight schedule or cancels a departure, the issuing agent will assist you with free re-accommodation on the next available flight or process a full refund in accordance with the airline's involuntary change policy.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script type="text/javascript">
    function filters() {
        // $("#filter").submit();
        var formData = $("#filter").serialize();

        $.ajax({
            url: "{{request()->url()}}",
            type: "GET",
            data: formData,
            beforeSend: function () {
                $('#loadmore').hide();
                $('#agentPackgesData').html('<tr><td colspan="9"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
            }

        }).done(function (data) {
            if (data.html == "") {
                $('#agentPackgesData').html('<tr><td colspan="9"><b>No Record found</b></td></tr>');
                return;
            }
            $('.endless-pagination').attr('data-next-page', data.next_page);
            $("#agentPackgesData").html(data.html);
            if (data.next_page !== null) {
                $('#loadmore').show();
            } else {
                $('#loadmore').hide();
            }
        });
    }
    $(document).ready(function () {
        $(document).on('click', '.showDetail', function () {
            var d = $(this).parent().find('.show-dropdown');
            d.toggle();
        });
        $(document).on('click', '#expandmobileSearch', function () {

            $('#mobileSearch').toggle();
        });
        $(document).on('click', '.search', function () {
            $.each($(".filtersclass select option:selected"), function () {

                $(this).prop('selected', false); // <-- HERE
            });
            filters();
        });
        $(document).on('click', '.showAll', function () {
            $("#filter").trigger("reset");
            filters();
        });
    })

    function fetchPosts() {

        var page = $('.endless-pagination').attr('data-next-page');

        if (page !== null) {



            $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Tickets');
            $('#loadmore').prop('disabled', true);
            $.get(page, function (data) {

                $('.append-data').append(data.html);
                $('#loadmore').html('Load More Tickets');
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
@if(request()->has('to'))
<script>
    $(document).ready(function () {
        filters();
    })
</script>
@endif
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ request()->url() }}#webpage",
            "url": "{{ request()->url() }}",
            "name": "Sasti Tickets - Cheap Flight Deals in Pakistan | Agents.com.pk",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "description": "Compare discounted airfares, Umrah flight seats, and domestic/international tickets uploaded directly by registered Pakistani travel agents."
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
                    "name": "Sasti Tickets",
                    "item": "https://agents.com.pk/sasti-tickets"
                }
            ]
        },
        {
            "@type": "FAQPage",
            "@id": "{{ request()->url() }}#faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "How are the cheapest tickets found on this platform?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Sasti Tickets are sourced directly from registered travel agencies across Pakistan who hold bulk allocations, group seats, and wholesale airline contracts. By allowing agents to list their unbooked seats directly on our marketplace, travelers can access discounted fares that bypass conventional online booking markups."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Are prices updated in real time?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Registered agents regularly update their available seats and prices in their agency dashboards. However, airline seat availability and fare classes can sell out quickly, especially during peak seasons such as Ramadan, Hajj, and school vacations. We always advise contacting the listing agent promptly to lock in the advertised rate."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I negotiate a fare directly with the agent?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. Because Agents.com.pk connects you directly with the listing travel agent, you are free to discuss family discounts, group bookings, infant rates, or customized return dates directly with the agent via phone or WhatsApp."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What travel documents are required to issue a ticket?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "For domestic flights within Pakistan, you will need a valid Computerized National Identity Card (CNIC) or B-Form for minors. For international flights, a valid passport (with at least 6 months validity) and appropriate destination visa or visa-on-arrival eligibility is mandatory."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is the baggage allowance on Sasti Tickets?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Baggage allowances vary by airline and fare class. Each listing on our table indicates whether check-in baggage is included (e.g. 20kg, 30kg, 2 pieces of 23kg, or hand-carry only). You can confirm the exact baggage allowance with the agent before ticketing."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What happens if my flight is rescheduled or cancelled?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "If an airline alters its flight schedule or cancels a departure, the issuing agent will assist you with free re-accommodation on the next available flight or process a full refund in accordance with the airline's involuntary change policy."
                    }
                }
            ]
        }
    ]
}
</script>
@endpush