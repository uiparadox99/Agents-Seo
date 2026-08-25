@extends('layouts.master') @section('content')
<!--<section id="slider" style="background: url({{url('images/slider-new.jpg')}}) !important;background-position: center !important;">-->
<!--    <div class="">-->
<!--        <div class="container">-->
<!--            <div class="search text-center">-->
             
<!--            </div>-->
<!--        </div>-->
      
<!--    </div>-->
<!--</section>-->
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
 @if($packages->count() > 0)
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
