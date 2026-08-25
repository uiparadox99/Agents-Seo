@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">
    @if(request()->has('to') || $filters->count() == 0)
    <div class="row">
        <div class="col-md-12">
            @if(isset($agentDetail) && !is_null($agentDetail))
                <h2 class="text-capitalize  mb-1 mt-3 pb-0 "><b>{{strtolower($agentDetail->business_name)}} Sasti Tickets</b>
                </h2>
                <hr>
            @else
              
                @if(!$detect->isMobile())
                  @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to'))) 
                    <h4 class="mt-3 text-center"><b>{{request()->get('from')}} to {{request()->get('to')}}</b> <a href="{{url('sasti-tickets')}}" class="btn btn-primary float-right">Back to Search</a></h4>
                    <hr>
                @endif
                    <form action="{{url('sasti-tickets')}}" method="get" id="filter" onsubmit="return false;">
                        <div style="display:none" class="embassy-search mt-2 {{!$detect->isMobile()?'pb-3 pt-3':'pb-3 pt-3'}} mt-4"
                            style="border: 2px solid #070c39;background: #070c39;color: #fff">
                            <h4 class="text-center mb-3">Search Sasti Ticket </h4>
                            <div class="row">
                                
                        
                            <div class=" form-group col-md-4">

                                <!--<input type="text" name="from" class="form-control" value="{{request()->has('from')??request()->get('from')}}" placeholder="From">-->
                                <select name="from" class="form-control">
                                    <option value="">From</option>
                                    @foreach($from as $c)
                                    <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') ==
                                        $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" form-group col-md-4">
                                <!--                      <label for=""><b>To</b></label> -->
                                <!--<input type="text" name="to" class="form-control" value="{{request()->has('to')??request()->get('to')}}" placeholder="To">-->

                                <select name="to" class="form-control">
                                    <option value="">To</option>
                                    @foreach($to as $c)
                                    <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') ==
                                        $c->name)?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn mb-3 btn-primary search {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif -->
                                Search Tickets </button>
                            </div>
                        
                            <div class="col-md-2">
                            <a type="button"  href="javascript:;" class="text-light text-underline text-center btn-block showAll {{!$detect->isMobile()?'btn-block':''}}" style="text-decoration:underline"><h5>Show
                                All Flights</h5></a>
                            </div>
                            
                            
            </div>
                        </div>
                        <div class="embassy-search mt-2 filtersclass" style="border: 2px solid #070c39;">
                                <div class="row">
                        <div class=" col-md-3">
                                <select name="sort" id="sort" class="form-control" onchange="filters()">
                                    <!--              <option value="">All</option> -->
                                    <option value="">Nearest Date</option>
                                    <option value="low">Low to high prices</option>
                                    <option value="high" {{ request()->has("sort") && request()->get("sort") == "high" ?
                                        "selected":"" }} >High to low prices</option>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="airline" class="form-control" id="airline" onchange="filters()">
                                    <option value="">Select Airline</option>
                                    @foreach($airlines as $a)
                                    <option value="{{$a->id}}" {{request()->has('airline') && request()->get('airline') ==
                                        $a->id?"selected":""}}>{{$a->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <!--    <label><b>By Month</b></label> -->
                                <select name="month" class="form-control" onchange="filters()">
                                    <option value="">By Month</option>
                                    <option value="01" {{request()->has('month') && request()->get('month') ==
                                        '01'?'selected':''}}>January</option>
                                    <option value="02" {{request()->has('month') && request()->get('month') ==
                                        '02'?'selected':''}}>February</option>
                                    <option value="03" {{request()->has('month') && request()->get('month') ==
                                        '03'?'selected':''}}>March</option>
                                    <option value="04" {{request()->has('month') && request()->get('month') ==
                                        '04'?'selected':''}}>April</option>
                                    <option value="05" {{request()->has('month') && request()->get('month') ==
                                        '05'?'selected':''}}>May</option>
                                    <option value="06" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>June</option>
                                    <option value="07" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>July</option>
                                    <option value="08" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>August</option>
                                    <option value="09" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>September</option>
                                    <option value="10" {{request()->has('month') && request()->get('month') ==
                                        '10'?'selected':''}}>October</option>
                                    <option value="11" {{request()->has('month') && request()->get('month') ==
                                        '11'?'selected':''}}>November</option>
                                    <option value="12" {{request()->has('month') && request()->get('month') ==
                                        '12'?'selected':''}}>December</option>
                                </select>
                            </div>
                        
                        
                            <div class=" col-md-3">
                                <select name="agent" class="form-control select2" onchange="filters()">
                                    <option value="">Agents</option>
                                    @foreach($agents as $c)
                                    <option value="{{$c->id}}" class="text-capitalize">{{ strtolower($c->business_name)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                @else
                <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()">
                    @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) && !empty(request()->has('to')))
                        {{request()->get('from')}} To {{request()->get('to')}}
                    @else 
                        Search Ticket 
                    @endif 
                    <span style="float: right;"><i class="fas fa-arrow-down"></i> Filters </span>
                </div>
                    <div id="mobileSearch" class=" embassy-search mb-2 filtersclass"
                        style="    border: 2px solid #070c39; display: none;">
                        <form action="{{url('sasti-tickets')}}" method="get" id="filter" onsubmit="return false;">
                            <div class=" form-group col-md-4 d-none">

                                <!--<input type="text" name="from" class="form-control" value="{{request()->has('from')??request()->get('from')}}" placeholder="From">-->
                                <select name="from" class="form-control">
                                    <option value="">From</option>
                                    @foreach($from as $c)
                                    <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') ==
                                        $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" form-group col-md-4 d-none">
                                <!--                      <label for=""><b>To</b></label> -->
                                <!--<input type="text" name="to" class="form-control" value="{{request()->has('to')??request()->get('to')}}" placeholder="To">-->

                                <select name="to" class="form-control">
                                    <option value="">To</option>
                                    @foreach($to as $c)
                                    <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') ==
                                        $c->name)?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="sort" id="sort" class="form-control" onchange="filters()">
                                    <option value="">Nearest Date</option>
                                    <option value="low">Low to high prices</option>
                                    <option value="high" {{ request()->has("sort") && request()->get("sort") == "high" ?
                                        "selected":"" }} >High to low prices</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="airline" class="form-control" id="airline" onchange="filters()">
                                    <option value="">Airline</option>
                                    @foreach($airlines as $a)
                                    <option value="{{$a->id}}" {{request()->has('airline') && request()->get('airline') ==
                                        $a->id?"selected":""}}>{{$a->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <!--    <label><b>By Month</b></label> -->
                                <select name="month" class="form-control" onchange="filters()">
                                    <option value="">By Month</option>
                                    <option value="10" {{request()->has('month') && request()->get('month') ==
                                        '10'?'selected':''}}>October</option>
                                    <option value="11" {{request()->has('month') && request()->get('month') ==
                                        '11'?'selected':''}}>November</option>
                                    <option value="12" {{request()->has('month') && request()->get('month') ==
                                        '12'?'selected':''}}>December</option>
                                    <option value="01" {{request()->has('month') && request()->get('month') ==
                                        '01'?'selected':''}}>January</option>
                                    <option value="02" {{request()->has('month') && request()->get('month') ==
                                        '02'?'selected':''}}>February</option>
                                    <option value="03" {{request()->has('month') && request()->get('month') ==
                                        '03'?'selected':''}}>March</option>
                                    <option value="04" {{request()->has('month') && request()->get('month') ==
                                        '04'?'selected':''}}>April</option>
                                    <option value="05" {{request()->has('month') && request()->get('month') ==
                                        '05'?'selected':''}}>May</option>
                                    <option value="06" {{request()->has('month') && request()->get('month') ==
                                        '06'?'selected':''}}>June</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="agent" class="form-control" onchange="filters()">
                                    <option value="">Agents</option>
                                    @foreach($agents as $c)
                                    <option value="{{$c->id}}" class="text-capitalize">{{strtolower($c->business_name)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            
                        </form>
                    </div>
                @endif
            @endif
            
        </div>
        <div class="col-md-12">
            @if($flights->count() > 0)
            <div data-next-page="{{ $flights->nextPageUrl() }}" class=" endless-pagination">
                @if(!$detect->isMobile())
                <table class="table  table-bordered mt-4 text-center">
                    <thead>
                        <tr>
                            <th width="10%">Airline</th>
                            <th>Flight No.</th>
                            <th>From</th>
                            <!--  <th>One Stop</th> -->
                            <th>To</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Conditions</th>
                            <th>Luggage</th>
                            <th width="15%">Travel Agent</th>
                        </tr>
                    </thead>
                    <tbody class="append-data" id="agentPackgesData">
                        @include('partials.load-flight')
                    </tbody>
                </table>
                @else
                <div class="append-data" id="agentPackgesData">
                    @include('partials.load-flight')
                </div>
                @endif

            </div>
            @if(!empty($flights->nextPageUrl()))
            <div class="text-center">
                <button id="loadmore" class="btn btn-default" onclick="fetchPosts()">Load More Tickets</button>
                <div class="clearfix"></div>
                <br>
            </div>
            @endif

            @else
            <br>
            <p class="text-center"><strong>No Ticket added by agents</strong></p>
            @endif
        </div>
    </div>
    @else
         @if(isset($agentDetail) && !is_null($agentDetail))
            <h2 class="text-capitalize mb-1 mt-3 pb-0 "><b>{{strtolower($agentDetail->business_name)}} Sasti Tickets</b>
            </h2>
            <hr>
            @else
            @if(request()->has('from') && request()->has('to') && !empty(request()->get('from')) &&
            !empty(request()->has('to'))) <h4 class="text-center mt-3"><b>{{request()->get('from')}} to
                    {{request()->get('to')}}</b></h4>
            <hr> @endif
            <form action="{{url('sasti-tickets')}}" method="get" id="filter">
                <div class="embassy-search mt-2 {{!$detect->isMobile()?'pb-3 pt-3':'pb-3 pt-3'}} mt-4"
                    style="border: 2px solid #070c39;background: #070c39;color: #fff">
                    <h4 class="text-center mb-3">Search Sasti Ticket </h4>
                    <div class="row">
                        
                 
                    <div class=" form-group col-md-4">

                        <!--<input type="text" name="from" class="form-control" value="{{request()->has('from')??request()->get('from')}}" placeholder="From">-->
                        <select name="from" class="form-control">
                            <option value="">From</option>
                            @foreach($from as $c)
                            <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') ==
                                $c->name?'selected':''}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" form-group col-md-4">
                        <!--                      <label for=""><b>To</b></label> -->
                        <!--<input type="text" name="to" class="form-control" value="{{request()->has('to')??request()->get('to')}}" placeholder="To">-->

                        <select name="to" class="form-control">
                            <option value="">To</option>
                            @foreach($to as $c)
                            <option value="{{$c->name}}" {{(request()->has('to') && request()->get('to') ==
                                $c->name)?'selected':''}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <button type="submit" class="btn mb-3 btn-primary search {{!$detect->isMobile()?'btn-block':''}}" style="background-color: #f58220;border-color: #f58220;"><!-- @if(!$detect->isMobile()) <i class="fas fa-arrow-right"></i>@endif -->
                        Search Tickets </button>
                    </div>
                  
                     <div class="col-md-2 col-6">
                    <a   href="{{url('sasti-tickets?from=&to=')}}" class="text-light text-underline text-center btn-block showAll {{!$detect->isMobile()?'btn-block':''}}" style="text-decoration:underline"><h5>Show
                        All Flights</h5></a>
                       </div>
                       
                       
      </div>
                </div>
             
            </form>
         
            @endif
     <div class="row mt-4">
        @foreach($filters as $f)
        <div class="col-md-3 mb-3 col-6">
           <a href="{{url('sasti-tickets?from='.$f->from_city.'&to='.$f->to_city.'&month='.$f->month.'&airline='.$f->airline.'&sort='.$f->sortby)}}" class="btn-block">
               <span class="ticketsCount">{{$f->sasti_tickets_count}} Flights</span>
                 <img src="{{url('storage/uploads/jobs/'.$f->image)}}" style="width: 100%;object-fit:cover;" class="filter-img">
           </a>
        </div>
        @endforeach
     </div>
    @endif
</section>
@endsection
@push('script')
<script type="text/javascript">
    function filters() {
        // $("#filter").submit();
        var formData = $("#filter").serialize();

        $.ajax({
            url: "{{request()->url()}}",
            type: "GET",
            data: formData,
            beforeSend: function () {
                $('#loadmore').hide();
                $('#agentPackgesData').html('<tr><td colspan="9"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
            }

        }).done(function (data) {
            if (data.html == "") {
                $('#agentPackgesData').html('<tr><td colspan="9"><b>No Record found</b></td></tr>');
                return;
            }
            $('.endless-pagination').attr('data-next-page', data.next_page);
            $("#agentPackgesData").html(data.html);
            if (data.next_page !== null) {
                $('#loadmore').show();
            } else {
                $('#loadmore').hide();
            }
        });
    }
    $(document).ready(function () {
        $(document).on('click', '.showDetail', function () {
            var d = $(this).parent().find('.show-dropdown');
            d.toggle();
        });
        $(document).on('click', '#expandmobileSearch', function () {

            $('#mobileSearch').toggle();
        });
        $(document).on('click', '.search', function () {
            $.each($(".filtersclass select option:selected"), function () {

                $(this).prop('selected', false); // <-- HERE
            });
            filters();
        });
        $(document).on('click', '.showAll', function () {
            $("#filter").trigger("reset");
            filters();
        });
    })

    function fetchPosts() {

        var page = $('.endless-pagination').attr('data-next-page');

        if (page !== null) {



            $('#loadmore').html('<i class="fa fa-spinner fa-spin"></i> Loading Tickets');
            $('#loadmore').prop('disabled', true);
            $.get(page, function (data) {

                $('.append-data').append(data.html);
                $('#loadmore').html('Load More Tickets');
                $('#loadmore').prop('disabled', false);
                if (data.next_page !== null) {
                    $('#loadmore').show();
                } else {
                    $('#loadmore').hide();
                }
                $('.endless-pagination').attr('data-next-page', data.next_page);
            });


        }
    }
</script>
@if(request()->has('to'))
<script>
    $(document).ready(function () {
        filters();
    })
</script>
@endif
@endpush