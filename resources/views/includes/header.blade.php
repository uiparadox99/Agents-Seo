<header>
    <nav class="navbar navbar-expand-sm">
        <div class="container">
            <!-- Brand -->
            @if (is_null($app))
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    <img src="{{ asset('images/agents-logo.png') }}" class="customlogo" alt="Agents.com.pk - Travel and Embassy Portal" width="180" height="45">
                </a>
                <div style="display: inline-flex; gap: 10px; align-items: center;">
                    <div class="dropdown">
                        <button type="button" class="btn btn-warning text-white" data-toggle="dropdown" aria-label="Toggle Navigation Menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="dropdown-menu">
                            @stack('top-mobile-link')
                            @if (auth()->check())
                                <a href="{{ url('/home') }}" class="dropdown-item" style="border-bottom: 1px solid #e9ecef;">
                                    {{ !is_null(auth()->user()->agents()->first()) ? auth()->user()->agents()->first()->business_name : auth()->user()->name }}
                                </a>
                            @else
                                <a href="{{ url('login') }}" class="dropdown-item">Login / Register</a>
                            @endif
                            @stack('mobile-link')

                            <a href="{{ route('flight') }}" class="dropdown-item button" style="margin: 0 10px; width: 90%; border-radius: 5px;">Umrah Tickets</a>
                            <a href="{{ route('umrah-packages') }}" class="dropdown-item button mt-2" style="margin: 0 10px; width: 90%; border-radius: 5px;">Umrah Packages</a>
                            <a href="{{ route('sasti-tickets') }}" class="dropdown-item button mt-2" style="margin: 0 10px; width: 90%; border-radius: 5px;">Sasti Tickets</a>
                            <a href="{{ route('umrah-hotels') }}" class="dropdown-item button mt-2" style="margin: 0 10px; width: 90%; border-radius: 5px;">Umrah Hotels</a>
                            <a href="{{ url('travel-airline-jobs') }}" class="dropdown-item">Airline Jobs</a>
                            <a href="{{ url('foreign-jobs') }}" class="dropdown-item">Foreign Jobs</a>
                            <a href="{{ url('travel-agent-jobs') }}" class="dropdown-item">Travel Agency Jobs</a>
                        </div>
                    </div>
                    @if($detect->isMobile())
                    <a class="ml-2" href="https://wa.me/+447344321378" target="_blank" rel="noopener noreferrer" style="color:#8cff71" aria-label="Contact on WhatsApp">
                        <i class="fab fa-whatsapp" style="font-size:36px"></i>  
                    </a>
                    @endif
                </div>

                <!-- Desktop Links -->
                <ul class="navbar-nav">
                    <li class="no-hover">
                        <a href="{{ route('umrah-hotels') }}" class="nav-link button" style="border-radius: 5px;">Umrah Hotels</a>
                    </li>
                    <li class="no-hover">
                        <a href="{{ route('flight') }}" class="nav-link button ml-2" style="border-radius: 5px;">Umrah Tickets</a>
                    </li>
                    <li class="no-hover {{ request()->is('cheap-umrah-packages*') || request()->is('umrah-packages*') ? 'active' : '' }}">
                        <a href="{{ route('umrah-packages') }}" class="nav-link button ml-2" style="border-radius: 5px;">Umrah Packages</a>
                    </li>
                    <li class="no-hover {{ request()->is('sasti-tickets*') ? 'active' : '' }}">
                        <a href="{{ route('sasti-tickets') }}" class="nav-link button ml-2" style="border-radius: 5px;">Sasti Tickets</a>
                    </li>
                    <li class="no-hover {{ request()->is('tour-packages*') ? 'active' : '' }}">
                        <a href="{{ route('tour-packages') }}" class="nav-link button ml-2" style="border-radius: 5px;">Tour Packages</a>
                    </li>
                    <li>
                        <a class="ml-3" target="_blank" rel="noopener noreferrer" href="https://wa.me/+447344321378" style="color:#8cff71" aria-label="WhatsApp Support">
                            <i class="fab fa-whatsapp" style="font-size:36px"></i>  
                        </a>
                    </li>
                </ul>
            @else
                <a class="navbar-brand" href="{{ url('/') }}" style="margin: 0 auto;">
                    <img src="{{ asset('images/logo.png') }}" alt="Agents.com.pk Logo">
                </a>
            @endif
        </div>
    </nav>
</header>
@if (!$detect->isMobile())
    @include('includes.agent-header')
@endif
@yield('taskHeader')
