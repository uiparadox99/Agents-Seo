<style>
    marquee {
        display: none !important;
    }
    </style>
    <section id="subscribe" class="agentHeader">
        <div class="container pt-2 pb-3">
    
            <div class="row text-center">
    
                <!-- <div class="col-md-6 col-12 pt-2">
                    <h3 class="text-white add-bussiness-title">Add Your Own Business and Get Listed</h3>
                </div> -->
                <!-- <div class="col-md-4   pt-2">
    
              <input type="text" name="email" data-validation="email" data-message="You haven not prpoovide"  class="form-control p-2" placeholder="Enter your Email" name="">
            </div> -->
    
                <div class="col-md-5    text-left pr-0">
    
    
    
                    <!-- <a href="{{url('travel-news')}}" class="agent-link  p-1 text-uppercase"
                        style="border-radius:7px;">Travel News</a> -->
                    <!--<a href="{{url('airline-special-offers')}}" class="agent-link  p-1 text-uppercase"-->
                    <!--    style="border-radius:7px;">Airline Special Offers</a>-->
                        <a href="{{url('travel-airline-jobs')}}" class="agent-link  p-1 text-uppercase"
                        style="border-radius:7px;">Airline Jobs</a>
                            <a href="{{url('travel-agent-jobs')}}" class="agent-link  p-1 text-uppercase"
                        style="border-radius:7px;">Travel Agency Jobs</a>
                        <a href="{{url('foreign-jobs')}}" class="agent-link  p-1 text-uppercase"
                        style="border-radius:7px;">Foreign Jobs</a>
                    <!--<a href="{{url('travel-agent-jobs')}}" class="agent-link  p-1 text-uppercase" style="border-radius:7px;">Travel-->
                    <!--    Agency Jobs</a>-->
                        
                        <!--<label class="dropdown-dd">-->
                        <!--  <div class="dd-button">Search Jobs</div>-->
                        <!--  <input type="checkbox" class="dd-input" id="test">-->
                        <!--  <ul class="dd-menu">-->
                        <!--    <li><a href="{{url('travel-agent-jobs')}}">Travel Agency Jobs</a></li>-->
                        <!--    <li><a href="{{url('travel-airline-jobs')}}">Airline Jobs</a></li>-->
                        <!--  </ul>-->
                        <!--</label>-->
                        
                       <!--  <a href="{{route('flight')}}" class="agent-link  p-1 text-uppercase" style="border-radius:7px;">Flights</a> -->
    
    
                </div>
                <div class="col-md-5" style="padding-left: 0">
                      <form id="AgentSearchForm" method="get" action="{{url('travel-agents-in-pakistan')}}" class="agent-search-bar-main">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control"
                                    value="{{!empty(request()->get('q'))?request()->get('q'):''}}" id="agentbar"
                                    autocomplete="off" name="q" placeholder="Search Travel Agent by Name" style="height: 25px;    font-size: 15px;">
                                <div class="input-group-append" id="submitAgentSearch" style="cursor: pointer;height: 25px;">
                                    <span class="input-group-text" style="background: #070c39; color: #fff;font-size: 12px;border-color: #070c39;"> <i class="fa fa-search" style="margin-right: 10px"></i> Search</span>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="col-md-2    text-right" style="text-align:right; ">
                    @if(auth()->check())
                    <a href="{{url(auth()->user()->type == 'agent'?'/home':'profile')}}" class="agent-link  p-2 text-uppercase"
                        style="border-radius:7px;">{{!is_null(auth()->user()->agents()->first())?substr(auth()->user()->agents()->first()->business_name,0,15):auth()->user()->name}}</a>
                    @else
                    <a href="{{url('login')}}" class="agent-link  p-2 text-uppercase" style="border-radius:7px;">                    Login / Register</a>
    
                    <!-- <a href="{{url('register')}}" class="agent-link  p-2 text-uppercase" style="border-radius:7px;">Register
                        your
                        Agency</a> -->
                    @endif
                </div>
            </div>
        </div>
    </section>
    