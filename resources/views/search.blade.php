@extends('layouts.master')
@section('content')
<!-- <section id="slider">
    <div class="bg-overlay" style="height: 100%">
        <div class="container">
            <?php if (!$detect->isMobile()): ?>
            <div class="search text-center" style="padding: 50px;">
                <?php else: ?>
                <div class="search text-center" style="padding: 10px;">
                    <?php endif ?>
                    <h1>Select Embassy in Islamabad</h1>
                    <form id="searchForm" method="get" action="{{url('search')}}">
                        <div class="input-group input-group-lg  mb-3">
                            <input type="text" class="form-control"
                                value="{{!empty(request()->get('q'))?request()->get('q'):''}}" id="country"
                                autocomplete="off" name="q" placeholder="Enter Country Name">
                            <div class="input-group-append" id="submitSearch" style="cursor: pointer;">
                                <span class="input-group-text"><i class="fa fa-search" style="margin-right: 10px"></i>
                                    Search</span>
                            </div>
                        </div>
                    </form>
                    <?php if (!$detect->isMobile()): ?>
                    <div style="height: 87px;">
                        <ins class="adsbygoogle" style="display:inline-block;width:680px;height:82px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        <div class="clearfix"></div>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
</section> -->
<section id="home-search-embassy-section">
    <div class="container">
         <div class="agents-city-section" style="">
        <div class="text-center">
            <h3 style="font-weight: 700; margin-bottom: 18px;color: #070c39;">Select Embassy in Islamabad</h3>
        </div>
        <div class="form-group">
            <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="" style="font-weight: 700">Select Embassy</option>
                @if(isset($embassies))
                    @foreach($embassies as $e)
                    <option value="{{url(str_slug($e->country).'/'.$e->slug)}}">{{$e->country}}</option>
                    @endforeach
                @endif
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
<section id="content" class="container">
    <div class="row">
       <!--  <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
            <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

             <br>
       <div class="sticky">
         <div style="width: 100% !important;margin: 10px 0;" class="converter ">
           <div style=""><h4>Currency Converter</h4><script type="text/javascript" src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1"></script></div>
         </div>
         <ins class="adsbygoogle"
         style="display:inline-block;width:280px;height:250px"
         data-ad-client="ca-pub-9682339330195266"
         data-ad-slot="3145814347"></ins>
         <script>
           (adsbygoogle = window.adsbygoogle || []).push({});
         </script>
       </div>
            <?php endif ?>
        </div> -->
        <div class="col-md-12 search-main-section">
            @if($visas->count() > 0)
            <div class="row">
                    
              
            @foreach ($visas as $d)
                <div class="col-md-4">
            <div class="visas-listing-box">
                <a href="{{url($d->country_name.'/'.$d->slug)}}">
                    <h3 style="font-size: 19px;
    font-weight: 700;">{{$d->title}}</h3>
                </a>
              <!--   <a href="{{url($d->country_name.'/'.$d->slug)}}">
                    <p><strong>{{url($d->country_name.'/'.$d->slug)}}</strong></p>
                </a>
                <p>{{$d->meta_desc}}</p> -->
            </div>
              </div>
            @endforeach
            </div>
   
            @else
            <p class="text-center" style="    margin: 59px 0;
    background: #070c39;  color: white;"><strong>No Record Found</strong></p>
            @endif
        </div>


      <!--   <div class="col-md-2 col-pd">
            <div>
                <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

        </div> -->
    </div>
</section>
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