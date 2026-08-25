@extends('layouts.master') @section('content')
<section id="slider">
    <div class="">
        <div class="container">
            <div class="search text-center">
                <!-- <h1><b>Agents.com.pk is a fast growing source of embassy</b></h1>
                <p style="">you will find a team of dedicated professionals, each contributing their optimum expertise to deliver and ensure complete satisfaction of our clients</p>
 -->              <!--   <form id="searchForm" method="get" action="{{url('search')}}">
                    <div class="input-group input-group-lg  mb-3">
                        <input type="text" class="form-control" required="" id="country" autocomplete="off" name="q"
                            placeholder="Enter Country Name">
                        <div class="input-group-append" id="submitSearch" style="cursor: pointer;">
                            <span class="input-group-text">@if(!$detect->isMobile()) <i class="fa fa-search" style="margin-right: 10px"></i>
                                 Search @else <i class="fa fa-search" ></i>  @endif</span>
                        </div>
                    </div>
                </form> -->
                <!-- @if(!$detect->isMobile())
                <div style="height: 87px;">
                        @if($detect->isMobile())
          <a href="fb://facewebmodal/f?href=https://web.facebook.com/Agents.com.pk?_rdc=1&_rdr" target="_blank"><img src="{{url('images/Facebook-Banner-mob.png')}}" height="100%"></a>
          @else
           <a href="https://www.facebook.com/Agents.com.pk" target="_blank"><img src="{{url('images/Facebook-Banner-mob.png')}}" height="100%"></a>
           @endif 
                    <ins class="adsbygoogle" style="display:inline-block;width:680px;height:82px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <div class="clearfix"></div>
                </div>
                @endif -->
            </div>
        </div>
        <!-- @if($related->count() > 0 && !$detect->isMobile())
        <div class="bg-orange">
            <div class="container">
                <section class="customer-logos slider countries pt-3 pb-3">
                    @foreach($related as $v)
                    <div class="slide text-center">
                        <a href="{{ url($v->country_name.'/'.$v->slug) }}">
                            <img src="{{url('images/flag.svg')}}" class="rounded-circle">
                            <span
                                class="rounded-circle flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}">

                            </span>
                            <?php if (!$detect->isMobile()): ?>
                            <p class="">{{str_limit(str_replace('Embassy in Islamabad','',$v->title),10)}}</p>
                            <?php else: ?>
                            @php $name = str_replace('Embassy in Islamabad','',$v->title); @endphp @if(strlen($name) >
                            10)
                            <p class="">{{shortname($name)}}</p>
                            @else
                            <p class="">{{$name}}</p>
                            @endif
                            <?php endif ?>
                        </a>
                    </div>

                    @endforeach
                </section>
            </div>
        </div>
        @endif -->
    </div>
</section>

<section id="home-search-embassy-section">
    <div class="container">
         <div class="agents-city-section" style="">
        <div class="text-center">
            <h3 style="font-weight: 700; margin-bottom: 18px;color: #070c39;">Select Embassy in Islamabad</h3>
        </div>
        <div class="form-group">
            <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="" style="font-weight: 700">Select Embassy</option>
                @foreach($embassies as $e)
                <option value="{{url(str_slug($e->country).'/'.$e->slug)}}">{{$e->country}}</option>
                @endforeach
            </select>
        </div>
        <ul class="aplhabatic-list">
            <li><a href="{{url('search-embassy-in-islamabad/a')}}">A</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/b')}}">B</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/c')}}">C</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/d')}}">D</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/e')}}">E</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/f')}}">F</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/g')}}">G</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/h')}}">H</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/i')}}">I</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/j')}}">J</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/k')}}">K</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/l')}}">L</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/m')}}">M</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/n')}}">N</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/o')}}">O</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/p')}}">P</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/q')}}">Q</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/r')}}">R</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/s')}}">S</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/t')}}">T</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/u')}}">U</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/v')}}">V</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/w')}}">W</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/x')}}">X</a></li>
            <li class="y-style-on-mobile"><a href="{{url('search-embassy-in-islamabad/y')}}">Y</a></li>
            <li><a href="{{url('search-embassy-in-islamabad/z')}}">Z</a></li>
        </ul>
        <div class="clearfix"></div>
      
    </div>
    </div>
</section>
@if($visas->count() > 0)
<section id="popular" class="container">
    <div class="title text-center p-3">
        <h2><b>Popular Embassies</b></h2>
        <div class="bar"><span></span><span></span><span></span></div>
        <p class="text-justify d-none"><a href="http://Agents.com.pk"
                data-saferedirecturl="http://Agents.com.pk">Agents.com.pk</a> is a fast growing source of embassy, visas
            information provider, Tour Operator and Travel Agent in Pakistan. At <a
                href="http://Agents.com.pk">Agents.com.pk</a>, you will find a team of dedicated professionals, each
            contributing their optimum expertise to deliver and ensure complete satisfaction of our clients. Our highly
            experienced staff members are ready to serve you from the time you think to travel. We ensure you hassle
            free and comfortable travel at an affordable price.&nbsp; Through years of experience and goodwill generated
            between us and our partner suppliers in the Tourism and Travel sector, we can offer you the best available
            rates ever offered</p>
    </div>
    <div class="popular-content pr-2">
        <div class="row">
            @php $count = 0; @endphp @foreach($visas as $key => $v) @php $count++; @endphp @if(!$detect->isMobile())
            @if($count == 3 || $count == 6) 
            @if($detect->isMobile())
            <div class="col-md-12 pr-2 col-12">
                @else
                <div class="col-md-4 pr-2 col-6">
                    @endif
                    <div>
                        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:247px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                @endif
                <div class="col-md-4 pr-2 col-6">
                    <a href="{{ url($v->country_name.'/'.$v->slug) }}">
                        <div class="popular-box  mb-4">
                            <div style="padding: 10px 0">
                                <img src="{{asset('flags/4x3/'.strtolower(getCountryCode($v->country)).'.svg')}}"
                                    style="object-fit: contain;    padding: 15px 0;" alt="{{$v->country}} visa">
                            </div>

                            <!-- <img src="{{url('images/'.$v->country.'.jpg')}}"> -->

                            <!-- <div class="flag"><span class=" rounded-circle flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></span></div> -->
                            <div class="p-3 pl-4 pr-4 text-center bg-lightgrey" style="padding: 10px 0 !important">
                                <h4> {{ $v->country }} Visa </h4>

                            </div>
                        </div>
                    </a>
                </div>
                @if($count == 12)
                @if($detect->isMobile())
                <div class="col-md-12 pr-2 col-12">
                    @else
                    <div class="col-md-4 pr-2 col-6">
                        @endif
                        <div>
                            <ins class="adsbygoogle" style="display:inline-block;width:100%;height:247px"
                                data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                    </div>
                    @endif
                    @else

                    <div class="col-md-4 pr-2 col-6">
                        <a href="{{ url($v->country_name.'/'.$v->slug) }}">
                            <div class="popular-box  mb-4">

                                <img src="{{asset('flags/4x3/'.strtolower(getCountryCode($v->country)).'.svg')}}"
                                    style="object-fit: contain;    padding: 6px 0;">

                                <!-- <img src="{{url('images/'.$v->country.'.jpg')}}"> -->

                                <!-- <div class="flag"><span class=" rounded-circle flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></span></div> -->
                                <div class="p-3 pl-4 pr-4 text-center bg-lightgrey">
                                    <h4> {{ $v->country }} Visa </h4>

                                </div>
                            </div>
                        </a>
                    </div>
                    @if($count == 4 || $count == 8 || $count == 12)
                    @if($detect->isMobile())
                    <div class="col-md-12 pr-2 col-12">
                        @else
                        <div class="col-md-4 pr-2 col-6">
                            @endif
                            <div>
                                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
                                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                                <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
</section>
@endif
<!-- <div class="container">
   <ins class="adsbygoogle" style="display:inline-block;width:100%;height:80px" data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
   <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
   </script>
 </div> -->
<!-- <div class="row">
   <div class="col-md-6 home-about-content">
       <h3>About visas</h3>
       <p><b>Embassy</b> is normally a term for the main representative office of another country in the capital city of Pakistan and primarily headed by the Ambassador.</p>
       <p><b>Foreign Consulate General</b> or Consulate is a lower level diplomatic representative office, often stationed in a city outside of Islamabad and is typically headed by the Consul-General official.</p>
       <p><b>Honorary Consulate</b> – This lower level office is normally run by a local business person who agrees to carry out limited consular duties in a city where the foreign country does not have a representative.</p>
       <p>Diplomats of foreign countries deals in making agreements, attend state dinners, or organize or represent the policies and interests of foreign country. The duties and tasks of diplomats are significantly varied.</p> <a href="{{ url('about') }}" class="btn">More</a></div>
   <div class="col-md-6"> <img src="{{ url('images/visa-application.jpg') }}" style="width: 100%;" alt="About Viasa" title="About Visas"></div>
 </div> -->
@if($quick_links_req->count() > 0)
<div class="row d-none">
    <div class="col-md-12 ">
        <div class="famous_visa">
            <div class="text-center">
                <h1 class="visasheading">Visa Requirements</h1>
            </div>
            <div class="numberlist">
                <p class="text-justify">Get details information about visa requirements of your required country. You
                    just need to select the country from the below list or type name of the country in the search box at
                    the top of the page. You will get the list of documents required to visa application.</p>
                <ul>
                    @if(!$detect->isMobile()) @foreach($quick_links_req as $v)
                    <li><span class="flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></span> <a
                            href="{{ url($v->country_name.'/'.$v->slug.'-for-pakistani-nationals') }}">
                            {{ $v->country }} {{$v->title}} </a></li>
                    @endforeach @else @foreach($quick_links_req as $v) @if($v->country !='Antigua and Barbuda')
                    <?php
       $countries = array_flip(config("countries"));
       if(strlen($v->country) > 11){
         $country = isset($countries[$v->country])?shortName($v->country):$v->country;
       }else{
         $country = $v->country;
       }
       ?>
                    <li>
                        <a href="{{ url($v->country_name.'/'.$v->slug.'-for-pakistani-nationals') }}">
                            <i class="flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></i>
                            <p class="flagName">{{ $country }}</p>
                        </a>
                    </li>
                    @endif @endforeach @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endif @if($quick_links_fee->count() > 0)
<div class="row d-none">
    <div class="col-md-12 ">
        <div class="famous_visa">
            <div class="text-center">
                <h1 class="visasheading">Visa Fees</h1>
            </div>
            <div class="numberlist">
                <p class="text-justify">We also collect and provide information about visa fees for Pakistanis for
                    different countries. These visa fees are estimated. Fees can be changed at any time. Select your
                    required country and get information about visa fees according to visa type.</p>
                <ul>
                    @if(!$detect->isMobile()) @foreach($quick_links_fee as $v)
                    <li><span class="flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></span> <a
                            href="{{ url($v->country_name.'/'.$v->slug.'-for-pakistani-nationals') }}">
                            {{ $v->country }} {{$v->title}} </a></li>
                    @endforeach @else @foreach($quick_links_fee as $v) @if($v->country !='Antigua and Barbuda')
                    <?php
     $countries = array_flip(config("countries"));
     if(strlen($v->country) > 11){
       $country = isset($countries[$v->country])?shortName($v->country):$v->country;
     }else{
       $country = $v->country;
     }
     ?>
                    <li>
                        <a href="{{ url($v->country_name.'/'.$v->slug.'-for-pakistani-nationals') }}">
                            <i class="flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></i>
                            <p class="flagName">{{ $country }}</p>
                        </a>
                    </li>
                    @endif @endforeach @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endif @if($quick_links_pro->count() > 0)
<div class="row d-none">
    <div class="col-md-12 ">
        <div class="famous_visa">
            <div class="text-center">
                <h1 class="visasheading">Visa Processing Time</h1>
            </div>
            <div class="numberlist">
                <p class="text-justify">If you are looking for visa processing time for any country you want to visit,
                    we are here to provide you the information about visa processing time for your required countries.
                    We team tried their level best to collect information about visa processing time from different
                    embassies around the world. If you want any more details about visas fees, visa status or processing
                    you can contact us.</p>
                <ul>
                    @if(!$detect->isMobile()) @foreach($quick_links_pro as $v)
                    <li><span class="flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></span> <a
                            href="{{ url($v->country_name.'/'.$v->slug.'-for-pakistani-nationals') }}">
                            {{ $v->country }} {{$v->title}} </a></li>
                    @endforeach @else @foreach($quick_links_pro as $v) @if($v->country !='Antigua and Barbuda')
                    <?php
     $countries = array_flip(config("countries"));
     if(strlen($v->country) > 11){
       $country = isset($countries[$v->country])?shortName($v->country):$v->country;
     }else{
       $country = $v->country;
     }
     ?>
                    <li>
                        <a href="{{ url($v->country_name.'/'.$v->slug.'-for-pakistani-nationals') }}">
                            <i class="flag-icon fa-2x flag-icon-{{ strtolower(getCountryCode($v->country)) }}"></i>
                            <p class="flagName">{{ $country }}</p>
                        </a>
                    </li>
                    @endif @endforeach @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endif @if($packages->count() > 0)
<section id="packages" class="container">
    <div class="title text-center p-3">
        <h2><b>Umrah Packages</b></h2>
        <div class="bar"><span></span><span></span><span></span></div>
    </div>

    <div class="packages pt-3 pr-3 pl-3">

        <div class="row">
            @foreach($packages as $key => $p) @if($key == 2) @if(!$detect->isMobile())
            <div class="col-md-4 pr-3 pl-2">
                <div>
                    <ins class="adsbygoogle" style="display:inline-block;width:100%;height:250px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            @else
            <div class="col-md-4 pr-3 pl-2">
                <div>
                    <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>

            @endif @endif
            <div class="col-md-4 pr-3 pl-2">

                <div class="box ">
                    <a href="{{ url($p->slug) }}">
                        <div class="top-cut"></div>
                        <div class="ribbon ribbon-top-left"><span>Popular</span></div>
                        <div class="bottom-cut"></div>
                        <img src="{{url('storage/uploads/packages/mobile/'.$p->image)}}" class="box-img" alt="{{$p->image_alt}}">
                        <div class="layer " style="    ">
                        </div>
                        <!--    <div class="calendar">
                     <i class="fa fa-calendar"></i> 7-Days
                                                     </div>
                                                     <div class=" price">
                     <div class="row m-0 p-0">
                        <div class="col-3 pl-0 pt-3 pr-2">
                            <img src="{{url('images/errow.png')}}" width="100%">
                        </div>
                        <div class="col-9 p-0">

                            <strong class="text-white ">PKR</strong>
                            <h4 class="text-white mb-0" style="margin-top: -5px;"><b>20,000</b></h4>

                        </div>
                     </div>
                   </div> -->
                        <div class="p-2 text-center detail">
                            <h3 class="m-0 p-0"><small><i class="fa fa-map-marker-alt"></i></small>
                                {{str_replace('Umrah Packages','',$p->name)}}</h3>
                            <p class="m-0">Umrah Packages</p>
                        </div>
                </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @if($detect->isMobile())
    <div>
        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    @else
    <div>
        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:82px"
            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    @endif
</section>
@endif @if($airlines->count() > 0)
<p class="text-justify  d-none"> Do you want to get information about sir fares of top airlines in Pakistan? Don’t worry
    about this, we are here to provide you required information. Here you can find information and estimated prices air
    tickets for top airlines operating from Pakistan to around the world.</p>
<section id="flayer" class="container">
    <section class="flayer-logos slider">
        @foreach($airlines as $a)
        <div class="slide">
            <div class="box">
                <a href="{{ url('airline/'.$a->slug) }}">
                    <img src="{{ url('storage/uploads/airline/'.$a->img) }}" alt="{{$a->image_alt}}" style="width:100%;">
                </a>
            </div>
        </div>
        @endforeach
    </section>
</section>
@endif @if(!empty($big))
<section id="blog" class="container pt-3 pb-3">
    <div class="row">
        <div class="col-md-8 pr-0">
            @if(!empty($big))
            <a href="{{url('blog/'.$big->slug)}}">
                @if(!empty($big->image))
                <div class="big"
                    style="background: url({{url('storage/uploads/blogs/'.$big->image)}});background-size: cover; background-repeat: no-repeat;">
                    @else
                    <div class="big">
                        @endif
                        <div class="big-overlay">
                            <div class="content">
                                <h3 class="text-uppercase"><b> {{$big->title}}</b></h3>
                                <p>{{date('d M Y',strtotime($big->created_at))}}</p>
                                <div class="hr">
                                </div>
                            </div>
                        </div>
                    </div>
            </a> @endif
            <div class="row">

                <div class="col-md-7 pr-0">
                    @if(!empty($midum))
                    <a href="{{url('blog/'.$midum->slug)}}">
                        @if(!empty($midum->image))
                        <div class="midum"
                            style="background: url({{url('storage/uploads/blogs/'.$midum->image)}});background-size: cover; background-repeat: no-repeat;">
                            @else
                            <div class="midum">
                                @endif
                                <div class="midum-overlay">
                                    <div class="content">
                                        <h4 class="text-uppercase" style="    font-size: 17px;"><b>{{$midum->title}}</b>
                                        </h4>
                                        <p>{{date('d M Y',strtotime($midum->created_at))}}</p>
                                        <div class="hr">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </a> @endif
                </div>
                <div class="col-md-5 pl-0">
                    @if(!empty($small))
                    <a href="{{url('blog/'.$small->slug)}}">
                        @if(!empty($small->image))
                        <div class="small"
                            style="background: url({{url('storage/uploads/blogs/'.$small->image)}});background-size: cover; background-repeat: no-repeat;">
                            @else
                            <div class="small">
                                @endif
                                <div class="small-overlay">
                                    <div class="content">
                                        <h4 style="    font-size: 17px;"><b>{{$small->title}}</b></h4>
                                        <p>{{date('d M Y',strtotime($small->created_at))}}</p>
                                        <div class="hr">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </a> @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 pl-0">
            <div class="title pt-4 p-3 pl-4">
                <h1>Blog Posts</h1>
                <div class="bar"><span></span><span></span><span></span></div>
            </div>
            <p class="pt-2 pl-4 pr-4 pb-4 ">
                Want to get information about foreign embassies in Islamabad, Pakistan? it’s very easy to get your
                required information here are Agents.com.pk.
            </p>
            @if(!empty($left))
            <a href="{{url('blog/'.$left->slug)}}">
                @if(!empty($left->image))
                <div class="left"
                    style="background: url({{url('storage/uploads/blogs/'.$left->image)}});background-size: cover; background-repeat: no-repeat;">
                    @else
                    <div class="left">
                        @endif
                        <div class="left-overlay">
                            <div class="content">
                                <h4><b>{{$left->title}}</b></h4>
                                <p>{{date('d M Y',strtotime($left->created_at))}}</p>
                                <div class="hr">
                                </div>
                            </div>
                        </div>
                    </div>
            </a> @endif
        </div>
        <div class="col-md-12 pt-3 text-center">
            <a href="{{url('blogs')}}" class="button text-white" style="text-decoration: none;color: unset;"><b>Read All
                    Posts <i class="fa fa-angle-double-right"></i></b></a>
        </div>
    </div>
</section>
@endif
<!-- @if($detect->isMobile() && is_null($app))
<section id="MobileApp">
    <div class="container">
        <p>Download our APP for latest Visa updates</p>
        <a href="https://play.google.com/store/apps/details?id=www.Agents.com.pk" class="btn btn-primary">
            <div class="row">
                <div class="col-md-3 col-3">
                    <img src="{{url('images/play.png')}}" width="40px">
                </div>
                <div class="col-md-9 col-9" style="padding-left: 0;">
                    Available on the
                    <br> <strong>Play Store</strong>
                </div>
            </div>
        </a>
    </div>
</section>
@else @if(is_null($app))
<section id="app">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-5 text-center">
                <img src="{{url('images/app.png')}}" style="">
            </div>
            <div class="col-md-7 col-7">
                @if(!$detect->isMobile())
                <h3>Get latest Visa Info</h3>
                <p>Stay connected to get latest news and information about visas polices, airline tickets, umrah
                    packages and much more.</p>
                @endif
                <a href="https://play.google.com/store/apps/details?id=www.Agents.com.pk" class="btn btn-primary">
                    <div class="row">
                        <div class="col-md-3 col-3">
                            <img src="{{url('images/play.png')}}" width="50px">
                        </div>
                        <div class="col-md-9 col-9" style="padding-left: 0;">
                            Available on the
                            <br> <strong>Play Store</strong>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endif @endif  -->
 @endsection
 @push('script')
<script>
$(document).ready(function() {
    $('#country').typeahead({
        minLength: 0,
        showHintOnFocus: true,
        autoSelect: false,
        source: function(query, result) {
            $.ajax({
                url: "{{url('get-country')}}",
                data: 'query=' + query,
                dataType: "json",
                type: "GET",
                success: function(data) {
                    return result(data);
                }
            });
        },

        afterSelect: function(args) {
            window.location.href = args.slug;
        }
    });
});
</script> @endpush
