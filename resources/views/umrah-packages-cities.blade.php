@extends('layouts.master')
@section('content')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-3 col-pd">
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
        </div>

        <div class="col-md-9 ">
            @if($cities->count() > 0)
            <section id="packages" class="container">
                <div class="title text-center p-3">
                    <h1>Umrah Packages</h1>
                    <div class="bar"><span></span><span></span><span></span></div>
                </div>
                <div class="packages pt-3 pr-4 pl-4">
                    <div class="row">
                        @foreach($cities as $p)
                        <div class="col-md-6 pr-3 pl-2">
                            <div class="box ">
                                <a href="{{url('cheap-umrah-packages-from-'.str_slug($p->name))}}">
                                 <!--    <div class="top-cut"></div>
                                    <div class="ribbon ribbon-top-left"><span>Popular</span></div>
                                    <div class="bottom-cut"></div> -->
                                    @if(!empty($p->img))
                                    <img src="{{url('storage/uploads/cities/'.$p->img)}}"  alt="{{!empty($p->image_alt)?$p->image_alt:$p->name}}" class="box-img">
                                    @else
                                     <img src="{{url('images/placeholder.jpg')}}"  alt="{{!empty($p->image_alt)?$p->image_alt:$p->name}}" class="box-img">
                                    @endif
                                    <div class="layer " style="    width: 94%;">
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
                                          From <span style="color:orange">{{$p->name}}</span></h3>
                                        <p class="m-0">Umrah Packages</p>
                                    </div>
                            </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div> <ins class="adsbygoogle" style="display:inline-block;width:100%;height:82px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </section>
            @endif
             <div class="col-md-12" style="text-align: justify;">
                <hr>
                <p>Every Muslims wish to perform Umrah. It’s not easy to find a suitable umrah package in budget. Here
                    you will get information about umrah packages from all major cities of pakistan with hotel
                    accomodation, Airline return tickets and other necessary information about umrah. We will give you a
                    detailed information of all the Ziyarats in Makkah and Madina to plan you umrah package accordingly.
                    For Ziyarats, you have to tell our umrah agents so they can arrange you umrah package accordingly
                    and also inform the embassy. Our Umrah packages are made according to every individual's preferences
                    keeping in view the number of days of their stay. We include these Ziyarats in the packages so that
                    pilgrims also know the history of Islam and the important places associated with our Prophet (SAWW).
                </p>
                <h4>What is Umrah?</h4>
                <p>Umrah is also called as mini hajj. It is derived from an Arabic word “I’timaar” which means visit and
                    the word Umrah means paying a visit to holy Kaaba. Although it is not made obligatory for Muslims
                    doing Umrah can reward you in akhirah. Umrah is different from Hajj in its performance. Umrah can be
                    performed at any time throughout the year while hajj can be performed only in the month of Zul Hajj.
                    And during Umrah pilgrims don’t go to Mina, Arafat, Muzdalifah and also do not have to sacrifice
                    animals. </p>

                <h4>Faraiz of Umrah</h4>
                <ul>
                    <li>Ihram</li>
                    <li>Tawaaf</li>
                    <li>Saai</li>
                    <li>Tahal-lul</li>
                </ul>
                <h4>Things You Need To Know About Umrah Packages</h4>
                <p>Every Muslim wants to go to holy cities of Makkah and Madinah to perform Umrah at least once in their
                    lifetime. We keep on making it easy for people to perform Umrah by offering those Umrah packages.
                    You don’t need to worry about anything like visa processing, hotel booking, ticket booking. We are
                    providing Umrah tickets to everyone who wishes to perform Umrah. You just have to give us a call and
                    tell your requirements and budget, and we will do the rest for you. We can arrange your whole Umrah
                    package as soon as you require.</p>
            </div>

          
        </div>
    </div>

    </div>
</section>
@endsection