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

    <h2>Frequently Asked Questions (FAQs)</h2>

    <h3>Q1: How much does an Umrah package from Pakistan cost?</h3>
    <p>Prices vary based on duration, hotel category, and group size — basic economy packages typically start around PKR 150,000 per person. See our full <a href="{{url('umrah-cost-from-pakistan')}}">Umrah cost guide</a> for details.</p>

    <h3>Q2: Does the Umrah package include flights and hotel?</h3>
    <p>Yes, most of our packages include return flights, hotel accommodation, and visa processing all together.</p>

    <h3>Q3: Can I get an Umrah package from any city in Pakistan?</h3>
    <p>Yes, we offer Umrah packages from major cities including Karachi, Lahore, Islamabad, Faisalabad, Multan, Peshawar, Quetta, and Sialkot.</p>

    <h3>Q4: What is the difference between Umrah and Hajj packages?</h3>
    <p>Umrah can be performed any time of the year and has fewer rituals, while Hajj takes place only during Zul Hajj and includes additional obligations. Compare our <a href="{{url('hajj-packages-pakistan')}}">Hajj packages</a> if you're planning for Hajj instead.</p>

    <h3>Q5: How do I book an Umrah package?</h3>
    <p>Simply contact us with your preferred city, travel dates, and budget — our verified agents will arrange the complete package for you.</p>
</div>


</section>
@endsection