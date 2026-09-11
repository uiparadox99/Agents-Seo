@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">

    <!--     <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
            <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

            <br>
            <div class="sticky">
                <div style="width: 100% !important;margin: 10px 0;" class="converter ">
                    <div style="">
                        <h4>Currency Converter</h4>
                        <script type="text/javascript"
                            src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1">
                        </script>
                    </div>
                </div>
                <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <?php endif ?>
        </div> -->


    <section id="packages">
        <div class="title text-center p-md-3 p-1">
            <h1 class="mb-md-3 mb-0">Umrah Packages From Pakistan</h1>

            <div class=" short-cities-links">
                <ul class="mb-0">
                    <li>
                        <a href="{{url('umrah-packages-from-faisalabad')}}"
                            class="btn btn-primary btn-block">Faisalabad</a>
                    </li>
                    <li>
                        <a href="{{url('umrah-packages-from-islamabad')}}"
                            class="btn btn-primary btn-block">Islamabad</a>
                    </li>

                    <li>
                        <a href="{{url('umrah-packages-from-karachi')}}" class="btn btn-primary btn-block ">Karachi</a>
                    </li>
                    <li>
                        <a href="{{url('umrah-packages-from-lahore')}}" class="btn btn-primary btn-block">Lahore</a>
                    </li>
                    <li>
                        <a href="{{url('umrah-packages-from-multan')}}" class="btn btn-primary btn-block">Multan</a>
                    </li>
                    <li>
                        <a href="{{url('umrah-packages-from-peshawar ')}}" class="btn btn-primary btn-block">Peshawar
                        </a>
                    </li>

                    <li>
                        <a href="{{url('umrah-packages-from-quetta')}}" class="btn btn-primary btn-block">Quetta</a>
                    </li>

                    <li>
                        <a href="{{url('umrah-packages-from-sialkot')}}" class="btn btn-primary btn-block">Sialkot </a>
                    </li>



                    <div class="clearfix"></div>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        @if($packages->count() > 0)
        @if(!$detect->isMobile())
        <div class="row">
            @foreach($packages as $pr)
            <div class="col-md-3 pr-2 pl-2">
                <div class="dropdown-detail listings p-0 mb-2" style="      border: 2px solid #f58220;">

                    <div class="mobile-flight-box-header" style="padding:0">

                            <a href="{{ url($pr->slug) }}" style="color:black;border-bottom:2px solid grey" class="btn-block p-2 ">
                                <div class="row">
                                    <div class="col-9 pr-1">
                                        <h6 class="mb-0 text-capitalize" style="height: 58px;"> {{ucfirst(strtolower($pr->name))}}</h6>
                                    </div>
                                    <div class="col-3 pl-1 pr-2">
                                         @if(!empty($pr->extra_via))
                                        <p class="text-success mb-0"><b>One Stop</b></p>
                                        @else
                                        <p class="text-success mb-0"><b>Direct</b></p>
                                        @endif
                                        <p class="mb-0 text-capitalize">{{$pr->stars}}</p>
                                    </div>
                                </div>
                            </a>

                        <div class="p-2">
                           <h6 class="">
                                @if(!is_null($pr->airline) && !empty($pr->airline_img))
                                <img src="{{url('storage/uploads/airline/'.$pr->airline_img)}}" class="img-responsive"
                                style="width: 40px;height: 20px;object-fit:contain">
                                @else
                                <img src="//placehold.it/150x150" style="weight: 40px;height: 20px;object-fit:contain">
                                @endif
                                {{$pr->from}} <span class="text-danger">to</span> {{ $pr->to}} <span style="color:#424dad">{{ date_format(date_create($pr->departure_date), 'd M Y')
                                }}</span>
                           </h6>
                           <h6 class=" mb-3">
                                @if(!is_null($pr->airline) && !empty($pr->airline_img))
                                <img src="{{url('storage/uploads/airline/'.$pr->airline_img)}}" class="img-responsive"
                                style="width: 40px;height: 20px;object-fit:contain">
                                @else
                                <img src="//placehold.it/150x150" style="weight: 40px;height: 20px;object-fit:contain">
                                @endif
                                {{$pr->return_from}} <span class="text-danger">to</span> {{ $pr->return_to}} <span style="color:#424dad">{{ date_format(date_create($pr->return_departure_date), 'd M Y')
                                }}</span>
                           </h6>
                           <div class="row">
                                <div class="col-8 pr-1">
                                    <p class="mb-0"><b>Package Includes:</b> Flight - Hotel {{$pr->umrah_visa == 1?'- Visa':''}}
                                    {{$pr->transport?'- '.$pr->transport:''}} {{$pr->shuttle_service?'-
                                    '.$pr->shuttle_service:''}}</p>
                                </div>
                                <div class="col-4 pl-0">
                                    <h6 class="text-success mb-0"><b> Rs: {{$pr->shairing}}</b></h6>
                                     <small>From</small>
                                </div>
                           </div>
                        </div>
                      
                    </div>
                    <div class="pt-1 pb-1 pl-2 pr-2">
                    <div class=" row">
                        <div class="col-7 pr-1">
                                <a href="{{url('agent/'.$pr->agent->slug)}}" style="color:unset" target="_blank">
                                    <p class="mb-0">{{!is_null($pr->agent)?strtolower($pr->agent->business_name):''}}, {{$pr->agent->city->name}}</p>
                                </a>
                            </div>
                            <div class="col-5 pl-1">
                                <p class="mb-0">
                                    @if(!empty($pr->agent->phone)) 
                                        @php $phone = explode(',',
                                        $pr->agent->phone);
                                        $count = 0; @endphp
                                        @foreach($phone as $p) @php $count++; @endphp
                                            @if($count == 1)
                                            <a href="tel:{{$p}}" style="color: unset;">{{$p}}
                                            </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                            </div>
                        </div>
                        </div>
                   
                </div>
            </div>
            @endforeach
        </div>
        @else
        @foreach($packages as $pr)

        <!--<div class="box-hang-title">-->
        <!--  <h3 class="" style="padding: 7px 25px 5px 25px;">}</h3>-->
        <!--</div>-->



        <div class="dropdown-detail listings p-0 mb-2" style="      border: 2px solid #f58220;padding:0 !important">

                    <div class="mobile-flight-box-header" style="padding:0">

                            <a href="{{ url($pr->slug) }}" style="color:black;border-bottom:2px solid grey" class="btn-block p-2 ">
                                <div class="row">
                                    <div class="col-9 pr-1">
                                        <h6 class="mb-0 text-capitalize"> {{$pr->name}}</h6>
                                    </div>
                                    <div class="col-3 pl-1">
                                         @if(!empty($pr->extra_via))
                                        <h6 class="text-success mb-0">One Stop</h6>
                                        @else
                                        <h6 class="text-success mb-0">Direct</h6>
                                        @endif
                                        <p class="mb-0 text-capitalize">{{$pr->stars}}</p>
                                    </div>
                                </div>
                            </a>

                        <div class="p-2">
                           <h6 class="">
                                @if(!is_null($pr->airline) && !empty($pr->airline_img))
                                <img src="{{url('storage/uploads/airline/'.$pr->airline_img)}}" class="img-responsive"
                                style="width: 60px;">
                                @else
                                <img src="//placehold.it/150x150" style="weight: 60px;">
                                @endif
                                {{$pr->from}} <span class="text-danger">to</span> {{ $pr->to}} <span style="color:#424dad">{{ date_format(date_create($pr->departure_date), 'd M Y')
                                }}</span>
                           </h6>
                           <h6 class=" mb-3">
                                @if(!is_null($pr->airline) && !empty($pr->airline_img))
                                <img src="{{url('storage/uploads/airline/'.$pr->airline_img)}}" class="img-responsive"
                                style="width: 60px;">
                                @else
                                <img src="//placehold.it/150x150" style="weight: 60px;">
                                @endif
                                {{$pr->return_from}} <span class="text-danger">to</span> {{ $pr->return_to}} <span style="color:#424dad">{{ date_format(date_create($pr->return_departure_date), 'd M Y')
                                }}</span>
                           </h6>
                           <div class="row">
                                <div class="col-9 pr-1">
                                    <p class="mb-0"><b>Package Includes:</b> Flight - Hotel {{$pr->umrah_visa == 1?'- Visa':''}}
                                    {{$pr->transport?'- '.$pr->transport:''}} {{$pr->shuttle_service?'-
                                    '.$pr->shuttle_service:''}}</p>
                                </div>
                                <div class="col-3 pl-0 pr-2">
                                    <h6 class="text-success mb-0"><b> Rs: {{$pr->shairing}}</b></h6>
                                    <small>From</small>
                                </div>
                           </div>
                        </div>
                      
                    </div>
                    <div class="pt-1 pb-1 pl-2 pr-2">
                    <div class=" row">
                        <div class="col-8 pr-1">
                                <a href="{{url('agent/'.$pr->agent->slug)}}" style="color:unset" target="_blank">
                                    <h6 class="mb-0">{{!is_null($pr->agent)?strtolower($pr->agent->business_name):''}}, {{$pr->agent->city->name}}</h6>
                                </a>
                            </div>
                            <div class="col-4 pl-1">
                                <h6 class="mb-0">
                                    @if(!empty($pr->agent->phone)) 
                                        @php $phone = explode(',',
                                        $pr->agent->phone);
                                        $count = 0; @endphp
                                        @foreach($phone as $p) @php $count++; @endphp
                                            @if($count == 1)
                                            <a href="tel:{{$p}}" style="color: unset;">{{$p}}
                                            </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </h6>
                            </div>
                        </div>
                        </div>
                   
                </div>


        @endforeach
        @endif

        @endif
    </section>

 <!-- ============================================= -->
<!-- SUGGESTED META (add to this page's controller / meta section) -->
<!-- ============================================= -->

<!--
Meta Title: Umrah Packages from Pakistan 2026 | All Cities - Agents.com.pk
Meta Description: Compare Umrah packages from Pakistan — Karachi, Lahore, Islamabad & more. Flights, hotels, and visa included. Find affordable Umrah deals today.
-->

<!-- ============================================= -->
<!-- REPLACE ONLY THIS BOTTOM CONTENT DIV -->
<!-- (Keep everything above it — the dynamic package cards and city links — exactly as is) -->
<!-- ============================================= -->

<div style="text-align: justify;">
    <hr>
    <p>Every Muslim wishes to perform Umrah, but it's not always easy to find a suitable <strong>Umrah package</strong> within budget. Here you'll find Umrah packages from all major cities of Pakistan — including Karachi, Lahore, Islamabad, Faisalabad, Multan, Peshawar, Quetta, and Sialkot — with hotel accommodation, return airline tickets, and all the information you need to plan your journey. If you're looking for a <a href="{{url('cheap-umrah-packages')}}">cheap Umrah package</a>, we also offer budget-friendly options without compromising on service.</p>

    <p>Not sure how much to budget? Check our detailed <a href="{{url('umrah-cost-from-pakistan')}}">Umrah cost from Pakistan guide</a> for a complete price breakdown, including flights, hotels, and visa fees.</p>

    <h2>What is Umrah?</h2>
    <p>Umrah is also known as the "mini Hajj." The word is derived from the Arabic term "I'timaar," meaning to visit, and Umrah refers to paying a visit to the Holy Kaaba. Although it is not obligatory for Muslims, performing Umrah carries great reward in the Akhirah. Umrah differs from Hajj in how it is performed — Umrah can be carried out at any time throughout the year, while Hajj can only be performed during the month of Zul Hajj. During Umrah, pilgrims do not visit Mina, Arafat, or Muzdalifah, and there is no requirement to sacrifice an animal. Planning to go for Hajj instead? See our <a href="{{url('hajj-packages-pakistan')}}">Hajj packages from Pakistan</a>.</p>

    <h2>Faraiz of Umrah</h2>
    <ul>
        <li>Ihram</li>
        <li>Tawaaf</li>
        <li>Sa'ai</li>
        <li>Tahal-lul</li>
    </ul>

    <h2>What's Included in Our Umrah Packages?</h2>
    <p>Every Muslim dreams of visiting the holy cities of Makkah and Madinah at least once in their lifetime to perform Umrah. We make this journey easier by offering complete Umrah packages so you don't have to worry about visa processing, hotel booking, or ticket booking separately. Our packages typically include:</p>
    <ul>
        <li>Return flight tickets — see our <a href="{{url('cheap-umrah-flights-from-pakistan')}}">cheap Umrah flights from Pakistan</a></li>
        <li>Umrah visa processing</li>
        <li>Comfortable accommodation — browse our <a href="{{url('umrah-hotels')}}">Umrah hotels</a> near Haram</li>
        <li>Ground transport and Ziyarat arrangements</li>
    </ul>
    <p>Simply give us a call, share your requirements and budget, and we'll arrange your complete Umrah package as soon as you need it — through our network of verified <a href="{{url('agents')}}">travel agents</a> across Pakistan.</p>

    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="faq-section p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <div class="text-center mb-4">
                    <span class="badge badge-warning px-3 py-2 text-white" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; background: #f58220;">Frequently Asked Questions</span>
                    <h2 class="mt-2" style="color: #070c39; font-weight: 700; font-size: 24px;">Umrah Packages FAQ</h2>
                    <p class="text-muted" style="font-size: 14px;">Common queries regarding Umrah package pricing, inclusions, verified agents, and booking procedures.</p>
                </div>

                <div class="accordion" id="umrahFaqAccordion">
                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="uHeadingOne" style="cursor: pointer;" data-toggle="collapse" data-target="#uCollapseOne" aria-expanded="true" aria-controls="uCollapseOne">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How much does an Umrah package from Pakistan cost?
                            </h3>
                        </div>
                        <div id="uCollapseOne" class="collapse show" aria-labelledby="uHeadingOne" data-parent="#umrahFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Prices vary based on duration (10, 15, 21, or 28 days), hotel category (economy sharing vs. 4-star or 5-star near Haram), and travel season (Ramadan and school holidays are higher). Economy packages generally start from PKR 180,000 to PKR 250,000 per person including visa and flights, while 4-star and 5-star executive packages range from PKR 350,000 to PKR 650,000+ per person. See our comprehensive <a href="{{url('umrah-cost-from-pakistan')}}">Umrah cost from Pakistan guide</a> for updated estimates.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="uHeadingTwo" style="cursor: pointer;" data-toggle="collapse" data-target="#uCollapseTwo" aria-expanded="false" aria-controls="uCollapseTwo">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What is typically included in an Umrah package?
                            </h3>
                        </div>
                        <div id="uCollapseTwo" class="collapse" aria-labelledby="uHeadingTwo" data-parent="#umrahFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Complete Umrah packages listed by our certified travel agents typically bundle return airline tickets, an official Saudi Umrah e-visa with mandatory health insurance, hotel accommodation in Makkah and Madinah, and intercity ground transportation (Jeddah airport to Makkah, Makkah to Madinah, and Madinah to airport). Many packages also include guided Ziyarat tours to historical and religious landmarks.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="uHeadingThree" style="cursor: pointer;" data-toggle="collapse" data-target="#uCollapseThree" aria-expanded="false" aria-controls="uCollapseThree">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Can I get an Umrah package from any city in Pakistan?
                            </h3>
                        </div>
                        <div id="uCollapseThree" class="collapse" aria-labelledby="uHeadingThree" data-parent="#umrahFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Yes! Our platform features verified travel agencies operating in all major hubs across Pakistan, including Karachi, Lahore, Islamabad, Faisalabad, Multan, Peshawar, Sialkot, and Quetta. Flights depart directly or via convenient connections from your local airport (KHI, LHE, ISB, MUX, PEW, SKT).
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="uHeadingFour" style="cursor: pointer;" data-toggle="collapse" data-target="#uCollapseFour" aria-expanded="false" aria-controls="uCollapseFour">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> What is the difference between economy and 5-star Umrah packages?
                            </h3>
                        </div>
                        <div id="uCollapseFour" class="collapse" aria-labelledby="uHeadingFour" data-parent="#umrahFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                The primary differences are hotel proximity to the Haram, room occupancy, and ground transport. Economy packages usually place pilgrims in 3-star hotels 600m–1200m away (often with free 24/7 shuttle service) with quad or quint sharing rooms. 5-star packages feature luxury properties right in the Clock Tower complex or adjacent to the Haram courtyard (0–150 meters away), private double rooms, daily buffet breakfast, and private VIP GMC or coaster transfers.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="uHeadingFive" style="cursor: pointer;" data-toggle="collapse" data-target="#uCollapseFive" aria-expanded="false" aria-controls="uCollapseFive">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> How do I compare and choose packages from different verified agents?
                            </h3>
                        </div>
                        <div id="uCollapseFive" class="collapse" aria-labelledby="uHeadingFive" data-parent="#umrahFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                On Agents.com.pk, each listing clearly details the total price, airline, hotel names with exact walking distances to Masjid al-Haram and Masjid an-Nabawi, package duration, and agency credentials. You can contact agents directly via WhatsApp or phone to clarify inclusions and ask for photos or past pilgrim testimonials before paying.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                        <div class="card-header bg-white py-3" id="uHeadingSix" style="cursor: pointer;" data-toggle="collapse" data-target="#uCollapseSix" aria-expanded="false" aria-controls="uCollapseSix">
                            <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                <i class="fas fa-question-circle text-warning mr-2"></i> Can packages be customized for families or senior citizens?
                            </h3>
                        </div>
                        <div id="uCollapseSix" class="collapse" aria-labelledby="uHeadingSix" data-parent="#umrahFaqAccordion">
                            <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                Absolutely. Most registered agents offer tailor-made customized Umrah packages where you can choose private room arrangements, request wheelchair-accessible hotels with elevators close to the Haram gates, specify private transport between cities, or add extra days in either Makkah or Madinah.
                            </div>
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
            "name": "How much does an Umrah package from Pakistan cost?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Prices vary based on duration (10, 15, 21, or 28 days), hotel category (economy sharing vs. 4-star or 5-star near Haram), and travel season. Economy packages generally start from PKR 180,000 to PKR 250,000 per person including visa and flights, while 4-star and 5-star executive packages range from PKR 350,000 to PKR 650,000+ per person."
            }
        },
        {
            "@type": "Question",
            "name": "What is typically included in an Umrah package?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Complete Umrah packages listed by our certified travel agents typically bundle return airline tickets, an official Saudi Umrah e-visa with mandatory health insurance, hotel accommodation in Makkah and Madinah, and intercity ground transportation between airports and hotels."
            }
        },
        {
            "@type": "Question",
            "name": "Can I get an Umrah package from any city in Pakistan?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Yes! Our platform features verified travel agencies operating in all major hubs across Pakistan, including Karachi, Lahore, Islamabad, Faisalabad, Multan, Peshawar, Sialkot, and Quetta."
            }
        },
        {
            "@type": "Question",
            "name": "What is the difference between economy and 5-star Umrah packages?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "The primary differences are hotel proximity to the Haram, room occupancy, and ground transport. Economy packages usually place pilgrims in 3-star hotels 600m–1200m away with quad or quint sharing rooms. 5-star packages feature luxury properties right near Haram courtyard (0–150 meters away), private double rooms, daily buffet breakfast, and private VIP transport."
            }
        },
        {
            "@type": "Question",
            "name": "How do I compare and choose packages from different verified agents?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "On Agents.com.pk, each listing clearly details the total price, airline, hotel names with exact walking distances to Masjid al-Haram and Masjid an-Nabawi, package duration, and agency credentials. You can contact agents directly via WhatsApp or phone to clarify inclusions before paying."
            }
        },
        {
            "@type": "Question",
            "name": "Can packages be customized for families or senior citizens?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Absolutely. Most registered agents offer tailor-made customized Umrah packages where you can choose private room arrangements, request wheelchair-accessible hotels close to the Haram gates, specify private transport between cities, or adjust duration."
            }
        }
    ]
}
</script>
@endif
@endpush

@endsection