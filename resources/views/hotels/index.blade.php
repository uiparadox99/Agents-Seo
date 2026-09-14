@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-12">
            @if(isset($agentDetail) && !is_null($agentDetail))
                <h1 class="text-capitalize mb-1 mt-3 pb-0 font-weight-bold" style="font-size: 26px; color: #070c39;"><b>{{strtolower($agentDetail->business_name)}} Umrah Hotels in Makkah &amp; Madinah</b></h1>
                <p class="text-muted mb-3" style="font-size: 14px;">Browse and book verified Umrah hotel accommodation in Makkah and Madinah directly with {{ ucwords(strtolower($agentDetail->business_name)) }}.</p>
                <hr>
            @else
                <div class="mt-3 mb-2">
                    <h1 class="font-weight-bold mb-1" style="font-size: 26px; color: #070c39;">Umrah Hotels in Makkah &amp; Madinah Near Haram</h1>
                    <p class="text-muted mb-2" style="font-size: 14px;">Compare verified room rates (Double, Triple, Quad, Sharing), meal plans, and distance from Masjid Al-Haram &amp; Masjid An-Nabawi listed by certified travel agents across Pakistan.</p>
                </div>
          
            <form  action="{{route('flight')}}" method="get"  id="filter" onsubmit="return false;">
                <div class="embassy-search mt-2 {{!$detect->isMobile()?'pb-2 pt-4':'pb-3 pt-3'}} " style="border: 2px solid #070c39;background: #070c39;color: #fff">
                    <div class="row">
                          <div class="col-md-4 form-group">
                             <!--    <label>Hotel Name</label> -->
                             <select name="hotel_name" class="form-control">
                                    <option value=""> Hotel</option>
                                    @foreach($searchotel as $h)
                                    <option value="{{$h->id}}">{{$h->name}}</option>
                                    @endforeach
                                </select>
                               <!--  <input type="text" name="hotel_name" class="form-control" placeholder="Hotel Name"> -->
                                
                            </div>
                              <div class="col-md-4 form-group">
                           <!--      <label>City</label> -->
                                   <select name="city" class="form-control">
                                    <option value="">City</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        <div class="col-md-4 text-center">
                    
                            <button   type="button" class="btn btn-primary search {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif --> Search Hotels </button>
                        </div>
                    </div>
                </div>
                @if(!$detect->isMobile())
                <div class="embassy-search filtersclass mt-2" style="border: 2px solid #070c39;">
                    <div class="row">
                        <div class="col-md-3 ">
                            <select name="agent" class="form-control" onchange="filters()">
                                <option value="">Agents</option>
                                @foreach($agents as $c)
                                <option value="{{$c->id}}" class="text-capitalize" >{{ strtolower($c->business_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                           <div class="col-md-3">
                          <!--       <label>Hotel Star</label> -->
                                <select name="hotel_star" class="form-control" onchange="filters()">
                                    <option value="">Hotel Type</option>
                                   @foreach($types as $t)
                                   <option value="{{$t->id}}">{{$t->name}}</option>
                                   @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                               <!--  <label>Room Type</label> -->
                                <select name="room_type" class="form-control" onchange="filters()">
                                    <option value="">Room Type</option>
                                    <option value="double">Double</option>
                                    <option value="triple">Triple</option>
                                    <option value="quad">Quad</option>
                                    <option value="penta">Penta</option>
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                     <!--            <label>Meal Type</label> -->
                                <select name="meal_type" class="form-control" onchange="filters()">
                                    <option value="">Meal Type</option>
                                    <option value="room only">Room Only</option>
                                    <option value="breakfast">Breakfast</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="dinner">Dinner</option>  
                                </select>
                                
                            </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
            @else
            <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()"> @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to'))) {{request()->get('from')}} To {{request()->get('to')}} @else Search Hotel @endif <span style="float: right;"><i class="fas fa-arrow-down" ></i> Filters </span></div>
            <div id="mobileSearch" class=" filtersclass embassy-search mb-2" style="    border: 2px solid #070c39; display: none;">
                <form  action="{{route('flight')}}" method="get"  id="filter" onsubmit="return false;">
                    <div class="form-group">
                        <select name="agent" class="form-control" onchange="filters()">
                            <option value="">Agents</option>
                            @foreach($agents as $c)
                            <option value="{{$c->id}}" class="text-capitalize" >{{strtolower($c->business_name)}}</option>
                            @endforeach
                        </select>
                    </div>
                   
                           <div class="form-group">
                          <!--       <label>Hotel Star</label> -->
                             <select name="hotel_star" class="form-control" onchange="filters()">
                                    <option value="">Hotel Type</option>
                                   @foreach($types as $t)
                                   <option value="{{$t->id}}">{{$t->name}}</option>
                                   @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group">
                               <!--  <label>Room Type</label> -->
                                <select name="room_type" class="form-control" onchange="filters()">
                                    <option value="">Room Type</option>
                                    <option value="double">Double</option>
                                    <option value="triple">Triple</option>
                                    <option value="quad">Quad</option>
                                    <option value="penta">Penta</option>
                                </select>
                                
                            </div>
                            <div class="form-group">
                     <!--            <label>Meal Type</label> -->
                                <select name="meal_type" class="form-control" onchange="filters()">
                                    <option value="">Meal Type</option>
                                    <option value="room only">Room Only</option>
                                    <option value="breakfast">Breakfast</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="dinner">Dinner</option>  
                                </select>
                                
                            </div>
                </form>
            </div>
            @endif
           @endif
            @if($hotels->count() > 0)
            <div  data-next-page="{{ $hotels->nextPageUrl() }}"  class=" endless-pagination" >
              @if(!$detect->isMobile())
              <table class="table table-striped mt-4 text-center">
                <thead>
                  <tr>
                    <th width="25%">Hotel Name</th>
                    <th width="10%"> Double</th>  
                    <th width="10%">Tripple</th>
                    <th width="10%">Quad</th>
                    <th width="20%">Validity / Meal</th>
                    <th width="30%">Travel Agent</th>
                  </tr>
                </thead>
                <tbody  class="append-data"  id="agentPackgesData">
                    @include('partials.load-umrah-hotels')
                </tbody>
              </table>
              @else
               <div class="append-data"  id="agentPackgesData">
                @include('partials.load-umrah-hotels')
            </div>
            @endif
        </div>
            @if(!empty($hotels->nextPageUrl()))
                <div class="text-center">
                    <button id="loadmore" class="btn btn-default" onclick="fetchPosts()">Load More Hotels</button>
                    <div class="clearfix"></div>
                    <br>
                </div>
                @endif
           
            @else
            <br>
            <p class="text-center"><strong>No Hotel added by agents</strong></p>
            @endif
        </div>
    </div>

    {{-- INFORMATIONAL CONTENT & GUIDE FOR UMRAH HOTELS --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card p-4 mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff;">
                <div class="row align-items-center mb-4">
                    <div class="col-md-8">
                        <span class="badge px-3 py-2 text-white mb-2" style="font-size: 12px; letter-spacing: 0.5px; background: #f58220; text-transform: uppercase;">Pilgrim Accommodation Guide</span>
                        <h2 class="font-weight-bold mb-2" style="color: #070c39; font-size: 24px;">Complete Guide to Booking Umrah Hotels in Makkah &amp; Madinah</h2>
                        <p class="text-muted mb-0" style="font-size: 15px; line-height: 1.7;">
                            Securing the right hotel accommodation is one of the most vital components of a smooth and rewarding spiritual journey. Whether you require a luxury 5-star suite directly facing the Kaaba or a cost-effective 3-star sharing room with reliable 24/7 shuttle service, Agents.com.pk connects you directly with verified travel agents across Pakistan offering genuine hotel vouchers and real-time rates.
                        </p>
                    </div>
                    <div class="col-md-4 text-center mt-3 mt-md-0">
                        <div class="p-3" style="background: #f8f9fc; border-radius: 10px; border: 1px dashed #cbd5e1;">
                            <h4 class="font-weight-bold mb-1" style="color: #070c39; font-size: 18px;">Need Complete Package?</h4>
                            <p class="text-muted small mb-2">Bundle your hotel with visa, flights &amp; Ziyarat for maximum savings.</p>
                            <a href="{{ url('cheap-umrah-packages') }}" class="btn btn-sm px-3 py-2 text-white" style="background: #070c39; border: none; font-weight: 600;">View Umrah Packages</a>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 h-100" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <div class="d-flex align-items-center mb-2">
                                <span class="d-inline-flex align-items-center justify-content-center text-white mr-2" style="width: 36px; height: 36px; border-radius: 50%; background: #070c39; font-size: 16px;">
                                    <i class="fas fa-kaaba"></i>
                                </span>
                                <h3 class="font-weight-bold mb-0" style="font-size: 16px; color: #070c39;">Makkah Hotels Near Haram</h3>
                            </div>
                            <p class="text-muted small mb-2" style="line-height: 1.6;">
                                Choose from world-renowned properties in the Abraj Al Bait (Clock Tower) and Jabal Omar complexes—such as Swissôtel, Fairmont, Pullman Zamzam, Mövenpick, and Dar Al Eiman. Enjoy 0 to 150-meter walking proximity to King Abdulaziz and King Fahd gates.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="p-3 h-100" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <div class="d-flex align-items-center mb-2">
                                <span class="d-inline-flex align-items-center justify-content-center text-white mr-2" style="width: 36px; height: 36px; border-radius: 50%; background: #f58220; font-size: 16px;">
                                    <i class="fas fa-mosque"></i>
                                </span>
                                <h3 class="font-weight-bold mb-0" style="font-size: 16px; color: #070c39;">Madinah Markazia Hotels</h3>
                            </div>
                            <p class="text-muted small mb-2" style="line-height: 1.6;">
                                In the sacred city of the Prophet (ﷺ), select top Markazia properties (North and South courtyards) like Anwar Al Madinah Mövenpick, Oberoi, Dar Al Taqwa, and Pullman Zamzam Madinah, situated within easy walking steps of the Green Dome and Rawdah.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="p-3 h-100" style="background: #f8fafc; border-radius: 8px; border: 1px solid #edf2f7;">
                            <div class="d-flex align-items-center mb-2">
                                <span class="d-inline-flex align-items-center justify-content-center text-white mr-2" style="width: 36px; height: 36px; border-radius: 50%; background: #28a745; font-size: 16px;">
                                    <i class="fas fa-bus"></i>
                                </span>
                                <h3 class="font-weight-bold mb-0" style="font-size: 16px; color: #070c39;">Budget Hotels with Shuttles</h3>
                            </div>
                            <p class="text-muted small mb-2" style="line-height: 1.6;">
                                For budget-conscious pilgrims and large families, economy properties located 600m to 1500m away in areas such as Ibrahim Khalil Road, Kudai, and Mahbas Al-Jinn provide continuous free 24/7 air-conditioned shuttle transfers directly to the Haram courtyards.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 pt-2 border-top">
                    <div class="col-md-6 mb-3">
                        <h4 class="font-weight-bold mb-2" style="font-size: 16px; color: #070c39;"><i class="fas fa-bed text-warning mr-2"></i> Room Occupancy Types Explained</h4>
                        <ul class="text-muted small pl-3 mb-0" style="line-height: 1.8;">
                            <li><strong>Double Room (2 Beds):</strong> Ideal for couples or 2 pilgrims seeking privacy with private attached bathroom.</li>
                            <li><strong>Triple Room (3 Beds):</strong> Features 3 standard single beds, ideal for small families and relatives.</li>
                            <li><strong>Quad Room (4 Beds):</strong> 4 single beds in one room—the most popular and cost-effective option for families.</li>
                            <li><strong>Quint / Sharing (5 Beds):</strong> High-capacity sharing configuration offering the lowest per-bed rate for budget pilgrims.</li>
                        </ul>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h4 class="font-weight-bold mb-2" style="font-size: 16px; color: #070c39;"><i class="fas fa-utensils text-warning mr-2"></i> Meal Inclusions &amp; Dining Plans</h4>
                        <ul class="text-muted small pl-3 mb-0" style="line-height: 1.8;">
                            <li><strong>Room Only (RO):</strong> Basic accommodation without meals, offering full flexibility to explore local dining.</li>
                            <li><strong>Bed &amp; Breakfast (BB):</strong> Daily international or Pakistani/Asian morning buffet breakfast included in your room tariff.</li>
                            <li><strong>Half Board (HB):</strong> Includes daily breakfast along with dinner buffet.</li>
                            <li><strong>Full Board (FB):</strong> Complete culinary coverage with breakfast, lunch, and dinner provided inside the hotel restaurant.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ ACCORDION SECTION --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="faq-section p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <div class="text-center mb-4">
                    <span class="badge badge-warning px-3 py-2 text-white" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; background: #f58220;">Frequently Asked Questions</span>
                    <h2 class="mt-2" style="color: #070c39; font-weight: 700; font-size: 24px;">Umrah Hotels in Makkah &amp; Madinah FAQ</h2>
                    <p class="text-muted" style="font-size: 14px;">Find quick answers regarding room booking, walking distances to Haram, check-in policies, and verified travel agents.</p>
                </div>

                <div class="accordion" id="umrahHotelsFaqAccordion">
                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="hFaqHeadingOne" style="cursor: pointer;" data-toggle="collapse" data-target="#hFaqCollapseOne" aria-expanded="true" aria-controls="hFaqCollapseOne">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How do I book an Umrah hotel in Makkah or Madinah through Agents.com.pk?
                            </h3>
                        </div>
                        <div id="hFaqCollapseOne" class="collapse show" aria-labelledby="hFaqHeadingOne" data-parent="#umrahHotelsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                You can filter hotel listings by City (Makkah or Madinah), Hotel Star Category (3-Star, 4-Star, 5-Star), Room Occupancy (Double, Triple, Quad), and Meal Type. Each hotel listing displays the verified travel agency providing the rate. Click the listing or agent name to view their direct WhatsApp number and phone number, confirm room availability for your dates, and receive an authentic booking voucher without hidden broker fees.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="hFaqHeadingTwo" style="cursor: pointer;" data-toggle="collapse" data-target="#hFaqCollapseTwo" aria-expanded="false" aria-controls="hFaqCollapseTwo">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What is the difference between Haram View, Kaaba View, and City View rooms?
                            </h3>
                        </div>
                        <div id="hFaqCollapseTwo" class="collapse" aria-labelledby="hFaqHeadingTwo" data-parent="#umrahHotelsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Hotels located in the Abraj Al Bait (Clock Tower) and Jabal Omar complexes offer distinct room categories: <strong>Kaaba View</strong> rooms provide direct panoramic window views of the Holy Kaaba and Mataf courtyard; <strong>Haram View</strong> rooms overlook the wider Masjid Al-Haram complex and courtyards; while <strong>City View</strong> rooms face the surrounding city of Makkah at a more economical price point while still keeping you within steps of the Haram gates.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="hFaqHeadingThree" style="cursor: pointer;" data-toggle="collapse" data-target="#hFaqCollapseThree" aria-expanded="false" aria-controls="hFaqCollapseThree">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How far are budget/economy hotels from Masjid Al-Haram, and is shuttle service available?
                            </h3>
                        </div>
                        <div id="hFaqCollapseThree" class="collapse" aria-labelledby="hFaqHeadingThree" data-parent="#umrahHotelsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Budget and economy hotels in Makkah are typically located between 600 meters and 1500 meters from the Haram in popular neighborhoods such as Ibrahim Khalil, Kudai, Aziziyah, and Mahbas Al-Jinn. Most 3-star and economy hotels provide free 24/7 air-conditioned shuttle buses that drop pilgrims directly at the Haram bus terminals (e.g., Kudai or Ajyad tunnels) within a 3 to 5-minute ride.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="hFaqHeadingFour" style="cursor: pointer;" data-toggle="collapse" data-target="#hFaqCollapseFour" aria-expanded="false" aria-controls="hFaqCollapseFour">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What room types (Double, Triple, Quad, Sharing) are best for families and groups?
                            </h3>
                        </div>
                        <div id="hFaqCollapseFour" class="collapse" aria-labelledby="hFaqHeadingFour" data-parent="#umrahHotelsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                In Saudi hospitality, hotels generally feature individual single beds rather than queen or king beds (except specific executive suites). A <strong>Double Room</strong> contains 2 separate single beds, a <strong>Triple Room</strong> contains 3 single beds, and a <strong>Quad Room</strong> contains 4 single beds. Families traveling together frequently book Triple or Quad rooms to keep the family in one spacious unit while substantially lowering the per-person cost.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="hFaqHeadingFive" style="cursor: pointer;" data-toggle="collapse" data-target="#hFaqCollapseFive" aria-expanded="false" aria-controls="hFaqCollapseFive">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What are the standard check-in and check-out times for hotels in Makkah and Madinah?
                            </h3>
                        </div>
                        <div id="hFaqCollapseFive" class="collapse" aria-labelledby="hFaqHeadingFive" data-parent="#umrahHotelsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Standard check-in time across most Saudi hotels is 4:00 PM (16:00), and standard check-out time is 12:00 PM (noon). During peak seasons such as Ramadan or Rabi-ul-Awwal, check-in may strictly adhere to 4:00 PM due to high turnover. If you arrive early in the morning, hotels provide secure complimentary luggage storage so you can proceed to the Haram for Umrah or prayer until your room is ready.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="hFaqHeadingSix" style="cursor: pointer;" data-toggle="collapse" data-target="#hFaqCollapseSix" aria-expanded="false" aria-controls="hFaqCollapseSix">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Can I book Umrah hotels separately without purchasing a full Umrah package?
                            </h3>
                        </div>
                        <div id="hFaqCollapseSix" class="collapse" aria-labelledby="hFaqHeadingSix" data-parent="#umrahHotelsFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Yes! With the advent of the Saudi Tourist Visa, Umrah e-Visa, and Nusuk platform, pilgrims now have total autonomy to arrange their own flights and visas, and book hotel accommodation independently. The verified travel agents on Agents.com.pk offer customized, hotel-only vouchers at wholesale B2B rates for both Makkah and Madinah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('schema')
@if(!request()->has('page'))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "How do I book an Umrah hotel in Makkah or Madinah through Agents.com.pk?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "You can filter hotel listings by City (Makkah or Madinah), Hotel Star Category (3-Star, 4-Star, 5-Star), Room Occupancy (Double, Triple, Quad), and Meal Type. Each hotel listing displays the verified travel agency providing the rate with direct phone/WhatsApp contact for immediate booking voucher confirmation."
            }
        },
        {
            "@type": "Question",
            "name": "What is the difference between Haram View, Kaaba View, and City View rooms?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Kaaba View rooms provide direct window views of the Holy Kaaba and Mataf courtyard; Haram View rooms overlook the wider Masjid Al-Haram complex; while City View rooms face the surrounding city of Makkah at a more economical price point."
            }
        },
        {
            "@type": "Question",
            "name": "How far are budget/economy hotels from Masjid Al-Haram, and is shuttle service available?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Budget hotels in Makkah are typically located 600m to 1500m away in areas like Ibrahim Khalil, Kudai, and Mahbas Al-Jinn, providing free 24/7 air-conditioned shuttle transport directly to the Haram courtyards."
            }
        },
        {
            "@type": "Question",
            "name": "What room types (Double, Triple, Quad, Sharing) are best for families and groups?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "In Saudi hotels, rooms contain individual single beds: Double Room has 2 beds, Triple Room has 3 beds, and Quad Room has 4 beds. Families frequently book Triple or Quad rooms to stay together while lowering per-person costs."
            }
        },
        {
            "@type": "Question",
            "name": "What are the standard check-in and check-out times for hotels in Makkah and Madinah?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Standard check-in time across Saudi hotels is 4:00 PM (16:00), and check-out is 12:00 PM (noon). Hotels offer secure complimentary luggage storage for early arrivals."
            }
        },
        {
            "@type": "Question",
            "name": "Can I book Umrah hotels separately without purchasing a full Umrah package?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Yes, with Saudi tourist and Umrah e-visas, pilgrims can book hotel accommodation separately from verified travel agents on Agents.com.pk at wholesale B2B rates."
            }
        }
    ]
}
</script>
@endif
@endpush
@endsection
@push('script')
<script type="text/javascript">
   function filters(){
      var formData = $("#filter").serialize();

      $.ajax({
        url: "{{request()->url()}}",
        type: "GET",
        data: formData,
        beforeSend: function()
        {
              $('#loadmore').hide();
          $('#agentPackgesData').html('<tr><td colspan="6"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
      }

  }).done(function(data)
  {
    if(data.html == ""){
       $('#agentPackgesData').html('<tr><td colspan="6"><b>No Record found</b></td></tr>');
       return;
   }
     $('.endless-pagination').attr('data-next-page', data.next_page);
   $("#agentPackgesData").html(data.html);
      if(data.next_page !== null) {
        $('#loadmore').show();
    }else{
        $('#loadmore').hide();
    }
});
}
$(document).ready(function () {
  $(document).on('click','.showDetail',function(){
     var d = $(this).parent().find('.show-dropdown');
     d.toggle();
 });
  $(document).on('click','#expandmobileSearch',function() {

     $('#mobileSearch').toggle();
 });
    $(document).on('click','.search',function() {
      $.each($(".filtersclass select option:selected"), function () {
      
        $(this).prop('selected', false); // <-- HERE
    });
      filters();
    });
})

function fetchPosts() {

     var page = $('.endless-pagination').attr('data-next-page');

    if(page !== null) {



        $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Hotels');
        $('#loadmore').prop('disabled',true);
        $.get(page, function(data){

            $('.append-data').append(data.html);
            $('#loadmore').html('Load More Hotels');
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
</script>
@endpush