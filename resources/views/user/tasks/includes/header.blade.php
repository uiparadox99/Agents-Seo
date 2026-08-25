@php
$permissionsData = auth()->guard('admin')->user()->permissions;
$permissions = array();
foreach($permissionsData as $p){
    $permissions[] = $p->code;
}

@endphp
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="{{ url('admin/home') }}" class="navbar-brand"><b>Management  </b>System</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_tasks',$permissions))
                    <li class="{{request()->path() == 'admin/manage-tasks'?'active':''}}">
                        <a href="{{ route('manage-tasks') }}">Tasks</a>
                    </li>
                    @endif

                    <li class="{{request()->path() == 'admin/income-report'?'active':''}}"><a href="{{ route('income-report') }}">Income</a></li>
                    <li class="{{request()->path() == 'admin/manage-invoices'?'active':''}}"><a href="{{ route('manage-invoices') }}">Invoices</a></li>
                    <li class="{{request()->path() == 'admin/manage-quotation'?'active':''}}"><a href="{{ route('manage-quotation') }}">Quotation</a></li>
                    <li class="{{request()->path() == 'admin/manage-currency-invoices'?'active':''}}"><a href="{{ route('manage-currency-invoices') }}">Star Currency Invoice</a></li>
                    <li class="{{request()->path() == 'admin/manage-travel-invoices'?'active':''}}"><a href="{{ route('manage-travel-invoices') }}">Travel Voucher</a></li>
                    <li class="{{request()->path() == 'admin/manage-reservations'?'active':''}}"><a href="{{ route('manage-reservations') }}">Reservations</a></li>
                 
                    <li class="{{request()->path() == 'admin/transactions'?'active':''}}"><a href="{{ route('transactions') }}">Ledger</a></li>
                    <li class="{{request()->path() == 'admin/search'?'active':''}}"><a href="{{ route('search') }}">Search</a></li>

<!--   @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_call_logs',$permissions))
                  <li class="">
                      <a href="{{ route('manage-call-logs') }}">Call Logs</a>
                  </li>
                  @endif -->
                      @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_airline_blocks',$permissions))
                    <li class="{{request()->path() == 'admin/manage-airline-block'?'active':''}}">
                        <a href="{{ route('manage-airline-block') }}">Airline Blocks</a>
                    </li>
                    @endif
                      @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_daily_sales',$permissions))
                    <li class="{{request()->path() == 'admin/manage-sales'?'active':''}}">
                        <a href="{{ route('manage-sales') }}">Reports</a>
                    </li>
                    @endif

                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Entries <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="{{request()->path() == 'admin/daily-logs'?'active':''}}">
                                <a href="{{ route('manage-tickets') }}">Tickets</a>
                            </li>
                              <li class="">
                                <a href="{{ route('manage-visa-sale') }}">Visa Sales</a>
                            </li>
                            <li class="">
                                <a href="{{ route('manage-hotel-sale') }}">Hotel Sales</a>
                            </li>
                         
                            <li class="">
                                <a href="{{ route('manage-tour-package') }}">Tour Package</a>
                            </li>
                              <li class="">
                                <a href="{{ route('manage-umrah-sale') }}">Umrah Sales</a>
                            </li>
                             <li class="">
                                <a href="{{ route('manage-travel-insurance') }}">Travel Insurance</a>
                            </li>
                          
                          
                               <li class="">
                                <a href="{{ route('manage-other-sale') }}">Other Sales</a>
                            </li>
                    
                        </ul>
                    </li> -->
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          @if(auth()->guard('admin')->user()->type == 'admin' || in_array('journal_voucher',$permissions))
                          <li class="{{request()->path() == 'admin/journal-voucher'?'active':''}}"><a href="{{ route('journal-voucher') }}">Journal Voucher</a></li>
                          @endif
                          @if(auth()->guard('admin')->user()->type == 'admin' || in_array('MANAGE_SUPPLIERS',$permissions))
                          <li class="{{request()->path() == 'admin/manage-suppliers'?'active':''}}"><a href="{{ route('manage-suppliers') }}">Manage Suppliers</a></li>
                          @endif
                          @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_account_categories',$permissions))
                          <li class="{{request()->path() == 'admin/manage-accounts-categories'?'active':''}}"><a href="{{ route('manage-accounts-categories') }}">Manage Accounts Categories</a></li>
                          @endif
                          @if(auth()->guard('admin')->user()->type == 'admin' || in_array('MANAGE_PARTIES',$permissions))
                          <li class="{{request()->path() == 'admin/manage-parties'?'active':''}}"><a href="{{ route('manage-parties') }}">Manage Parties</a></li>
                          @endif
                            @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_cities',$permissions))
                            <li class="{{request()->path() == 'admin/manage-cities'?'active':''}}"><a href="{{ route('manage-cities') }}">Manage Cities</a></li>
                            @endif
                            @if(auth()->guard('admin')->user()->type == 'admin')
                            <li class="{{request()->path() == 'admin/manage-employees'?'active':''}}"><a href="{{ route('manage-employees') }}">Manage Employees</a></li>
                            @endif
                              @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_flights',$permissions))
                            <li class="{{request()->path() == 'admin/manage-flights'?'active':''}}"><a href="{{ route('manage-flights') }}">Manage Sectors</a></li>
                            @endif
                            <!-- <li class="{{request()->path() == 'admin/daily-logs'?'active':''}}"><a href="{{ route('manage-flights') }}">Manage Titles</a></li>
                            <li class="{{request()->path() == 'admin/daily-logs'?'active':''}}"><a href="{{ route('manage-flights') }}">Manage Taxes</a></li> -->
                              @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_airlines',$permissions))
                            <li class="{{request()->path() == 'admin/manage-airlines'?'active':''}}"><a href="{{ route('manage-airlines') }}">Manage Airlines</a></li>
                            @endif
                            <!-- <li class="{{request()->path() == 'admin/daily-logs'?'active':''}}"><a href="{{ route('manage-status') }}">Manage Status</a></li> -->
                              @if(auth()->guard('admin')->user()->type == 'admin' || in_array('MANAGE_ROOM_TYPES',$permissions))
                            <li class="{{request()->path() == 'admin/manage-room-type'?'active':''}}"><a href="{{ route('manage-room-type') }}">Manage Room Types</a></li>
                            @endif
                              @if(auth()->guard('admin')->user()->type == 'admin' || in_array('MANAGE_VISA_TYPES',$permissions))
                            <li class="{{request()->path() == 'admin/manage-visa-type'?'active':''}}"><a href="{{ route('manage-visa-type') }}">Manage Visa Types</a></li>
                            @endif
                               <li class="{{request()->path() == 'admin/daily-logs'?'active':''}}"><a href="{{ route('daily-logs') }}">Daily Logs</a></li>
                            <!-- <li class="divider"></li> -->
                        </ul>
                    </li>
                    @if(auth()->guard('admin')->user()->type == 'admin' || in_array('MANAGE_PARTIES',$permissions))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Party <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                    <li class="{{request()->path() == 'admin/add-party'?'active':''}}"><a href="{{ route('add-party') }}">Add Party</a></li>
                    <li class="{{request()->path() == 'admin/manage-parties'?'active':''}}"><a href="{{ route('manage-parties') }}">Manage Parties</a></li>
                        </ul>
                    @endif
                      @if(auth()->guard('admin')->user()->type == 'admin' || in_array('manage_daily_sales',$permissions))
                     <li class="{{request()->path() == 'admin/add-entry'?'active':''}}">
                        <a href="{{ route('add-entry') }}" class="">Add Sale</a>
                    </li>
                    @endif

                </ul>
            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ auth()->guard('admin')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-header">
                                <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ auth()->guard('admin')->user()->name }}
                                </p>
                            </li>

                            <li class="user-footer">
                                @if(auth()->guard('admin')->user()->type == 'admin')
                                <div  class="pull-left">
                                    <a href="{{ url('take-backup.php') }}" class="btn btn-default btn-flat">Take Backup</a>
                                </div>
                                @endif
                                <div class="pull-right">
                                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

