@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container pt-4" >
     <h1 class="mb-4 text-center">Visa Verification & other useful links</h1>
    <div class="row align-items-center" style="margin-right: -5px;margin-left: -5px;">
        @foreach($links as $j)
        @if($j->airport != 1)
        <div class="col-md-3 col-6" style="padding-left:5px;padding-right:5px;margin-bottom:5px;">
            <a href="{{$j->link}}" target="_blank" class="city-link" title="{{$j->name}}" style="    min-height: 90px;">
               @if(!is_null($j->img))
                <div class="row align-items-center">
                    <div class="col-4 pr-1">
                      <img src="{{ url('storage/uploads/links/'.$j->img) }}" style="width:100%;object-fit:contain;height:70px">
                    </div>
                    <div class="col-8 pl-1">
                           <h6 class="mb-0">{{$j->name}}</h6>
                    </div>
                </div>            
                @else
                     <div class="row align-items-center">
                    <div class="col-4 pr-1" style="height:70px">
                    </div>
                    <div class="col-8 pl-1">
                           <h6 class="mb-0">{{$j->name}}</h6>
                    </div>
                </div>
                @endif
            </a>
        </div>
        @endif
        @endforeach
    </div>
    <h1 class="mb-4 text-center">Flight Schedules</h1>
    <div class="row align-items-center" style="margin-right: -5px;margin-left: -5px;">
        @foreach($links as $j)
        @if($j->airport == 1)
        <div class="col-md-3 col-6" style="padding-left:5px;padding-right:5px;margin-bottom:5px;">
            <a href="{{$j->link}}" target="_blank" class="city-link" title="{{$j->name}}" style="    min-height: 90px;">
               @if(!is_null($j->img))
                <div class="row align-items-center">
                    <div class="col-4 pr-1">
                      <img src="{{ url('storage/uploads/links/'.$j->img) }}" style="width:100%;object-fit:cover;height:70px">
                    </div>
                    <div class="col-8 pl-1">
                           <h6 class="mb-0">{!! str_replace('Flight','<br> Flight',$j->name) !!}</h6>
                    </div>
                </div>            
                @else
                     <div class="row align-items-center">
                    <div class="col-4 pr-1" style="height:70px">
                    </div>
                    <div class="col-8 pl-1">
                           <h6 class="mb-0">{!! str_replace('Flight','<br> Flight',$j->name) !!}</h6>
                    </div>
                </div>
                @endif
            </a>
        </div>
        @endif
        @endforeach
    </div>
</section>


@endsection