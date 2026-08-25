@if(!$detect->isMobile())
    @if(!empty(auth()->user()->agents()->first()->logo))
        <div class="agent-detail-box content-box-agent">
            <h5>Profile <a href="{{url('user/edit-business/'.auth()->user()->agents()->first()->id)}}" class="btn btn-sm btn-primary" style="float:right">Edit</a></h5>
            <img src="{{url('storage/uploads/agents/'.auth()->user()->agents()->first()->logo)}}" width="100%" height="200px" style="object-fit: contain;">
        </div>
    @endif
    @if(auth()->user()->type == 'airline' && !is_null(auth()->user()->airline) && !empty(auth()->user()->airline->img))
    <div class="agent-detail-box content-box-agent">
        <img src="{{url('storage/uploads/airline/'.auth()->user()->airline->img)}}" width="100%" height="200px" style="object-fit: contain;">
    </div>
    @endif
    
    <div class="sidebar">
        <ul>
            @if(auth()->user()->type == 'agent')
            <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="{{ url('/home') }}">My Business Profile</a></li>
            @else
            <li class="{{ Request::is('profile') ? 'active' : '' }}"><a href="{{ url('/profile') }}">My Profile</a></li>
            @endif
            @if(!is_null(auth()->user()->agents) && count(auth()->user()->agents) > 0 )
            <li class="{{ Request::is('manage-sales') ? 'active' : '' }}"><a href="{{ url('manage-sales') }}">Accounts</a></li>
                <li class="{{ Request::is('agent-gallery') ? 'active' : '' }}"><a href="{{ url('agent-gallery') }}">Gallery</a></li>
                <li class="{{ Request::is('agent-promotions') ? 'active' : '' }}"><a href="{{ url('agent-promotions?type=agent') }}">Special Offers Leaflets</a></li>
                <li class="{{ Request::is('manage-agent-jobs') ? 'active' : '' }}"><a href="{{ url('manage-agent-jobs?type=agent') }}">Manage Staff Jobs</a></li>
                @if(auth()->user()->agents()->first()->agent_type_id == 3)
                 <li class="active"><a href="{{ url('manage-agent-foreign-jobs') }}">BEOE Jobs</a></li>
                 @endif
                @if(!is_null(auth()->user()->agents()->first()))
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_sasti_tickets'))
                        <li class="{{ Request::is('agent-sasti-tickets') ? 'active' : '' }}"><a href="{{ url('agent-sasti-tickets') }}">Sasti Tickets</a></li>
                    @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_packages'))
                    <li class="{{ Request::is('agent-tour-packages') ? 'active' : '' }}"><a href="{{ url('agent-tour-packages') }}">Tour Packages</a></li>
                @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_flight_tickets'))
                        <li class="{{ Request::is('agent-flights') ? 'active' : '' }}"><a href="{{ url('agent-flights') }}">Umrah Tickets</a></li>
                    @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_packages'))
                        <li class="{{ Request::is('agent-packages') ? 'active' : '' }}"><a href="{{ url('agent-packages') }}">Umrah Packages</a></li>
                    @endif
                      @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_packages') && auth()->user()->agents()->first()->agent_type_id == 4)
                        <li class="{{ Request::is('agent-hajj-packages') ? 'active' : '' }}"><a href="{{ url('agent-hajj-packages') }}">Hajj Packages</a></li>
                    @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_hotels'))
                        <li class="{{ Request::is('agent-umrah-hotels') ? 'active' : '' }}"><a href="{{ url('agent-umrah-hotels') }}">Umrah Hotels</a></li>
                    @endif
                @endif
                <li class="{{ Request::is('agent-reviews') ? 'active' : '' }}"><a href="{{ url('agent-reviews') }}">Manage Reviews</a></li>
                <!-- https://agents.com.pk/studio/poster-templates/posters/travel -->
                <li class=""><a href="javascript:;" data-toggle="modal" data-target="#imageModal">Design Poster</a></li>
            @endif
            @if(auth()->user()->type == 'airline')
            <li class="{{ Request::is('manage-agent-jobs') ? 'active' : '' }}"><a href="{{ url('manage-agent-jobs?type=airline') }}">Manage Staff Jobs</a></li>
            <li class="{{ Request::is('agent-promotions') ? 'active' : '' }}"><a href="{{ url('agent-promotions?type=airline') }}">Special Offers</a></li>
            @endif
            <li class="{{ Request::is('change-password') ? 'active' : '' }}"><a href="{{ url('/change-password') }}">Change Password</a></li>
            <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
@else
    <div class="mobile-search-bar" id="expanduserSidebar" onclick="expand()" style="float: left;display: inline-block;padding: 8px 12px;">
        <i class="fa fa-bars"></i>
    </div>
    <div class="clearfix"></div>
    <div class="sidebar" style="display: none;">
        <ul>
        @if(auth()->user()->type == 'agent')
            <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="{{ url('/home') }}">My Business Profile</a></li>
            @else
            <li class="{{ Request::is('profile') ? 'active' : '' }}"><a href="{{ url('/profile') }}">My Profile</a></li>
            @endif

           
            @if(!is_null(auth()->user()->agents) && count(auth()->user()->agents) > 0 )
                <li class="{{ Request::is('agent-gallery') ? 'active' : '' }}"><a href="{{ url('agent-gallery') }}">Gallery</a></li>
                <li class="{{ Request::is('agent-promotions') ? 'active' : '' }}"><a href="{{ url('agent-promotions?type=agent') }}">Special Offers Leaflets</a></li>
                <li class="{{ Request::is('manage-agent-jobs') ? 'active' : '' }}"><a href="{{ url('manage-agent-jobs?type=agent') }}">Manage Staff Jobs</a></li>
                @if(auth()->user()->agents()->first()->agent_type_id == 3)
                 <li class="{{ Request::is('manage-agent-foreign-jobs') ? 'active' : '' }}"><a href="{{ url('manage-agent-foreign-jobs') }}">BEOE Jobs</a></li>
                 @endif
                @if(!is_null(auth()->user()->agents()->first()))
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_sasti_tickets'))
                        <li class="{{ Request::is('agent-sasti-tickets') ? 'active' : '' }}"><a href="{{ url('agent-sasti-tickets') }}">Sasti Tickets</a></li>
                    @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_packages'))
                    <li class="{{ Request::is('agent-tour-packages') ? 'active' : '' }}"><a href="{{ url('agent-tour-packages') }}">Tour Packages</a></li>
                @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_flight_tickets'))
                        <li class="{{ Request::is('agent-flights') ? 'active' : '' }}"><a href="{{ url('agent-flights') }}">Umrah Tickets</a></li>
                    @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_packages'))
                        <li class="{{ Request::is('agent-packages') ? 'active' : '' }}"><a href="{{ url('agent-packages') }}">Umrah Packages</a></li>
                    @endif
                    @if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_packages')  && auth()->user()->agents()->first()->agent_type_id == 4)
                        <li class="{{ Request::is('agent-hajj-packages') ? 'active' : '' }}"><a href="{{ url('agent-hajj-packages') }}">Hajj Packages</a></li>
                    @endif
                    <!--@if(CheckPermission(auth()->user()->agents()->first()->id, 'manage_umrah_hotels'))-->
                    <!--    <li class="{{ Request::is('agent-umrah-hotels') ? 'active' : '' }}"><a href="{{ url('agent-umrah-hotels') }}">Umrah Hotels</a></li>-->
                    <!--@endif-->
                @endif
                <li class="{{ Request::is('agent-reviews') ? 'active' : '' }}"><a href="{{ url('agent-reviews') }}">Manage Reviews</a></li>
            @endif
            @if(auth()->user()->type == 'airline')
            <li class="{{ Request::is('agent-jobs') ? 'active' : '' }}"><a href="{{ url('agent-jobs?type=airline') }}">Manage Staff Jobs</a></li>
            <li class="{{ Request::is('agent-promotions') ? 'active' : '' }}"><a href="{{ url('agent-promotions?type=airline') }}">Special Offers </a></li>
            @endif
            <li class="{{ Request::is('change-password') ? 'active' : '' }}"><a href="{{ url('/change-password') }}">Change Password</a></li>
            <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
@endif

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <!-- Close Button -->
      <div class="modal-header p-2">
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <!-- Image -->
      <div class="modal-body text-center">
        <img src="{{asset('studio-comingsoon.jpeg')}}" class="img-fluid popup-img">
      </div>

    </div>
  </div>
</div>