<header>

    <nav class="navbar navbar-expand-sm ">
        <div class="container">
            <!-- Brand -->
            @if (is_null($app))
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    <img src="{{ url('images/agents-logo.png') }}" class="customlogo"></a>
                <div style="    display: inline-flex;
    gap: 10px;
    align-items:center;">
                    
                <div class="dropdown">
                    <button type="button" class="btn btn-warning text-white" data-toggle="dropdown">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="dropdown-menu">
                        @stack('top-mobile-link')
                        @if (auth()->check())
                            <a href="{{ url('/home') }}" class="dropdown-item  "
                                style="    border-bottom: 1px solid;">{{ !is_null(auth()->user()->agents()->first()) ? auth()->user()->agents()->first()->business_name : auth()->user()->name }}</a>
                        @endif
                        @if (!auth()->check())
                            <a href="{{ url('login') }}" class="dropdown-item  ">Login/Register</a>
                        @endif
                        @stack('mobile-link')



                        <a href="{{ route('flight') }}" class="dropdown-item button"
                            style="margin: 0 10px;width: 90%;border-radius: 5px;"> Umrah
                            Tickets</a>

                        <a href="{{ route('umrah-packages') }}"
                            class="dropdown-item button mt-2 {{ request()->is('cheap-umrah-packages-2019') ? 'nav-active' : '' }}"
                            style="margin: 0 10px;width: 90%;border-radius: 5px;"> Umrah
                            Packages</a>

                        <a href="{{ route('sasti-tickets') }}" class="dropdown-item button mt-2"
                            style="margin: 0 10px;width: 90%;border-radius: 5px;">Sasti Tickets</a>
                               <a href="{{ route('umrah-hotels') }}" class="dropdown-item button mt-2"
                            style="margin: 0 10px;width: 90%;border-radius: 5px;">Umrah Hotels</a>
                        <a href="{{ url('travel-airline-jobs') }}" class="dropdown-item  ">Airline Jobs</a>
                            <a href="{{ url('foreign-jobs') }}" class="dropdown-item  ">Foreign Jobs</a>
                        <!--<a href="{{ url('airline-circulars') }}" class="dropdown-item  ">Airline Circulars</a>-->
                        <a href="{{ url('travel-agent-jobs') }}" class="dropdown-item  ">Travel Agency Jobs</a>
                        <!--<div class="dropdown">-->
                        <!--    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"-->
                        <!--        aria-expanded="false">-->
                        <!--        Dropdown button-->
                        <!--    </button>-->
                        <!--    <div class="dropdown-menu">-->
                        <!--        <a class="dropdown-item" href="#">Action</a>-->
                        <!--        <a class="dropdown-item" href="#">Another action</a>-->
                        <!--        <a class="dropdown-item" href="#">Something else here</a>-->
                        <!--    </div>-->
                        <!--</div>-->


                    </div>
                </div>
                  @if($detect->isMobile())
                        <a class="ml-2" href="https://wa.me/+447344321378" style="color:#8cff71">
                          <i class="fab fa-whatsapp" style="font-size:40px"></i>  
                        </a>
                        @endif
                </div>

                <!-- Links -->
                <ul class="navbar-nav">
                    <li class="no-hover">
                        <a href="{{ route('umrah-hotels') }}" class="nav-link  button" style="border-radius: 5px;">Umrah
                            Hotels</a>
                    </li>
                    <li class="no-hover">
                        <a href="{{ route('flight') }}" class="nav-link  button  ml-2" style="border-radius: 5px;">Umrah
                            Tickets</a>
                    </li>
                    <li class="no-hover {{ request()->is('cheap-umrah-packages') ? 'active' : '' }}">

                        <a href="{{ route('umrah-packages') }}" class="nav-link button ml-2"
                            style="border-radius: 5px;"> Umrah Packages</a>
                    </li>

                    <li class="no-hover">
                        <a href="{{ route('sasti-tickets') }}" class="nav-link  button ml-2"
                            style="border-radius: 5px;">Sasti Tickets</a>
                    </li>
                    <li class="no-hover">
                        <a href="{{ route('tour-packages') }}" class="nav-link  button ml-2"
                            style="border-radius: 5px;">Tour Packages</a>
                    </li>
                    <li>
                        <a class="ml-3" target="_blank" href="https://wa.me/+447344321378" style="color:#8cff71">
                          <i class="fab fa-whatsapp" style="font-size:40px"></i>  
                        </a>
                    </li>



                </ul>
                
            @else
                <a class="navbar-brand" href="{{ url('/') }}" style="margin: 0 auto;"><img
                        src="{{ url('images/logo.png') }}"></a>
            @endif
        </div>
    </nav>

</header>
@if (!$detect->isMobile())
    @include('includes/agent-header')
@endif
@yield('taskHeader')
<!-- @if (request()->url() != 'https://www.Agents.com.pk/travel-agents-in-pakistan')
<marquee DIRECTION="right" onmouseover="this.stop();" onmouseout="this.start();" style="">یہاں آپ پاکستان میں سفارت خانے
    کے بارے میں تمام ضروری معلومات حاصل کرسکتے ہیں .ہم ویزا کی اقسام، فیس، توثیق، ٹریول انشورنس، ایئر ٹکٹ کے بارے میں
    رہنمائی بھی فراہم کرتے ہیں.</marquee>
@endif -->
