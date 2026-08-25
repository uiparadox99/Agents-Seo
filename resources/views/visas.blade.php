@extends('layouts.master')
@section('content')
@include('includes.slider')
<!-- <section id="slider">
    <div class="bg-overlay" style="height: 100%">
        <div class="container">
     
            <div class="search text-center" style="padding: 124px 0;">
            
                <h2><b>Select Embassy in Islamabad</b></h2>
                    <form id="searchForm" method="get" action="{{url('search')}}">
                        <div class="input-group input-group-lg  mb-3">
                            <input type="text" class="form-control" required=""
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
<section id="content" class="container ">
    <div class="row">
        <?php if (!$detect->isMobile()): ?>
        <div class="col-md-3 pr-0">
            <?php else: ?>
            <div class="col-md-3 p-0  mt-2">
                <?php endif ?>

                @include ('includes/left-sidebar')

                <?php if (!$detect->isMobile()): ?>
                <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="2281973599"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <?php endif ?>
            </div>

            <?php if (!$detect->isMobile()): ?>
            <div class="col-md-6 ">


                <div class="left-contetnt mt-2">
                    <div class="agents-city-section" style="">
                        <div class="text-center">
                            <h4 style="font-weight: 700; margin-bottom: 8px;color: #070c39;">Select Embassy in Islamabad</h4>
                        </div>
                        
                        <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="" style="font-weight: 700">Select Embassy</option>
                            @foreach($embassies as $e)
                            <option value="{{url(str_slug($e->country).'/'.$e->slug)}}">{{$e->country}}</option>
                            @endforeach
                        </select>
                        
                        
                        
                    </div>
                    <br>
                    <h1 class="main-tile">{!! $content->title !!}</h1>

                    <div class="cntn">
                        @if(!empty($extra_content))
                        {!! renderHTML($extra_content) !!}
                        @endif

                        <?php
                            // $content1 = $content->content;
                            // $content1 = str_replace("&lt;h1", "&lt;h2", $content1);
                            // $content1 = str_replace("&lt;/h1&gt;", "&lt;/h2&gt;", $content1);
                        ?>
                        {!! renderHTML(renderFlags($content->content)) !!}

                        @if(!empty($extra_content))
                        {!! renderHTML($extra_content) !!}
                        @endif
                    </div>

                    <div style="display:none">
                        {!! stripslashes($content->tags) !!}
                    </div>

                    <div class="links">
                        <ul style="padding: 0;">
                            <?php foreach ($visa as $d => $v) { ?>
                            <?php if ($v->is_right == 0 && $d!=0 && $d <= 8): ?>
                            <a
                                href="{{ url($v->country_name.'/'.$v->slug.(strpos($v->slug , 'visa-requirements') === true?'-for-pakistani-nationals':'')) }}">
                                <li class="links-li">
                                    <?= $v->title; ?>
                                </li
                            </a>
                            <?php endif; ?>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 pl-0 pr-0">
                @if(isset($embassy_page) && !empty($embassy_page))
                <ul style="padding: 0;">
                    <li class="links-li bounce " style="width: 100%;float: none;">
                        <a href="{{url($embassy_page->slug)}}">{{$embassy_page->title}}</a>
                    </li>
                </ul>
                <hr>
                @endif
                <div id="googleMap" style="width:100%;height:178px;margin-top: 10px;"></div>
                <div style="width: 100%;">
                    <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <a href="javascript:;">Download Visa Form</a>
                @include ('includes/right-sidebar')
                <div style="width: 100%;">
                    <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="3586590058"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>

                <div style="width: 100% !important;margin: 10px 0;" class="converter">
                    <div style="">
                        <h4><b>Currency Converter</b></h4>
                        <script type="text/javascript"
                            src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1">
                        </script>
                    </div>
                </div>
                <div style="width: 100%;">
                    <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="2281973599"></ins>
                    <script>
                    setTimeout(function() {
                        (adsbygoogle = window.adsbygoogle || []).push({})
                    }, 1000);
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            <?php endif ?>
        </div>

</section>

@endsection
@push('script')
<script type="text/javascript">
$(document).ready(function() {
    $('#country').typeahead({
        minLength: 0,
        autoSelect: false,
        showHintOnFocus: true,
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
    }).focus(function() {
        $(this).trigger('keydown.autocomplete');
    })
});

if ($('.collapse').length) {
    $('.collapse').on('shown.bs.collapse', function(e) {
        var $card = $(this).closest('.card');
        $('html,body').animate({
            scrollTop: $card.offset().top
        }, 500);
    });
}
</script>
<script>
     var address = $(".highlight-content p:nth-child(2)").text();
     if(address != ''){
        adzdress = address;
     }else{
        address = 'Islamabad,Pakistan'
     }
        var geocoder; //To use later
        var map; //Your map
        
        function myMap() {
             geocoder = new google.maps.Geocoder();
                    codeAddress();
                    //Default setup
                    var myOptions = {
                       zoom: 14,
                     }
          
          
          map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
        }

     
        //Call this wherever needed to actually handle the display
        function codeAddress() {
           
          
            geocoder.geocode( { 'address': address}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                //Got result, center the map and put it out there
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
              } else {
                // alert("Geocode was not successful for the following reason: " + status);
              }
            });
          }

        
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC25ud3-p1XvE0YEWHmCKla49qXs5ZW0BI&callback=myMap"></script>
@endpush