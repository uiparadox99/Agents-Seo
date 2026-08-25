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
            <h1>Search For Agent</h1>
            <form id="searchForm" method="get" action="{{request()->getRequestUri()}}">
               <div class="input-group input-group-lg  mb-3">
                  <input type="text" class="form-control"  value="{{!empty(request()->get('q'))?request()->get('q'):''}}"  autocomplete="off" name="q" placeholder="Search By Name">
                  <div class="input-group-append" id="submitSearch" style="cursor: pointer;">
                     <span class="input-group-text"><i class="fa fa-search" style="margin-right: 10px"></i> Search</span>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section> -->

<section id="content" class="container" style="padding-top: 20px;">
   <div class="agents-city-section" style="">
        <div class="text-center">
            <h3 style="font-weight: 700; margin-bottom: 18px;">Search Travel Agents by City</h3>
        </div>
        <ul class="aplhabatic-list">
            <li><a href="{{url('travel-agents-in-pakistan/a')}}">A</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/b')}}">B</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/c')}}">C</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/d')}}">D</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/e')}}">E</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/f')}}">F</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/g')}}">G</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/h')}}">H</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/i')}}">I</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/j')}}">J</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/k')}}">K</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/l')}}">L</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/m')}}">M</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/n')}}">N</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/o')}}">O</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/p')}}">P</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/q')}}">Q</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/r')}}">R</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/s')}}">S</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/t')}}">T</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/u')}}">U</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/v')}}">V</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/w')}}">W</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/x')}}">X</a></li>
            <li class="y-style-on-mobile"><a href="{{url('travel-agents-in-pakistan/y')}}">Y</a></li>
            <li><a href="{{url('travel-agents-in-pakistan/z')}}">Z</a></li>
        </ul>
        <div class="clearfix"></div>
      
    </div>
    <br>
<!-- <div class="text-center"><h3>Search Agent By City</h3></div> -->
   <div class="row" style="margin-right: -5px;margin-left: -5px;">
    @if($cities->count() > 0)
    @foreach($cities as $c)
    <div class="col-md-2 col-6" style="padding-left:5px;padding-right:5px;">
     <a href="{{url('travel-agents-in-'.str_slug($c->name))}}" class="city-link text-capitalize" style="color:#070c39  !important;background:unset">{{strtolower($c->name)}}</a>
   </div>
   @endforeach
   @else
   <div class="col-md-12">
     <p class="text-center">No City Found</p>
   </div>
   @endif
</div>
</section>
@endsection