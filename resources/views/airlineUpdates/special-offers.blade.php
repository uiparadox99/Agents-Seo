@extends('layouts.master')
@section('content')
    @include('includes.slider')
    <!-- <section id="slider">
    <div class="bg-overlay" style="height: 100%">
            <div class="container">
                <?php if (!$detect->isMobile()): ?>
                <div class="search text-center" style="padding: 50px;">
                    <?php else: ?>
                    <div class="search text-center" style="padding: 10px;">
                        <?php endif ?>
                        <h1>Search For Latest Airline Circulars</h1>
                        <form id="searchForm" method="get" action="{{ url('airline-updates') }}">
                            <div class="input-group input-group-lg  mb-3">
                                <input type="text" class="form-control"
                                    value="{{ !empty(request()->get('q')) ? request()->get('q') : '' }}" autocomplete="off"
                                    name="q" placeholder="Search">
                                <div class="input-group-append" id="submitSearch" style="cursor: pointer;">
                                    <span class="input-group-text">
    @if (!$detect->isMobile())
    <i class="fa fa-search" style="margin-right: 10px"></i>
                                     Search
@else
    <i class="fa fa-search" ></i>
    @endif
    </span>
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
    <section id="content" class="container">
        <div class="row">

            <div class="col-md-12 ">
                <div class="embassy-search mt-4">
                    <form method="get" action="{{ url('airline-special-offers') }}">


                        <div class="row">
                            <div class="col-md-4" style="vertical-align: middle;padding-top: 5px;">
                                <h5>Search Special Offers By Airline </h5>
                            </div>
                            @if (!$detect->isMobile())
                                <div class="col-md-1">
                                    <i class="fa fa-plane" style="font-size:30px;margin-top:5px;color:#f58220"></i>
                                </div>
                            @endif

                            <div class="col-md-7">
                                <select class="form-control select2" name="airline"
                                    onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    <option value="{{ url('airline-special-offers') }}">Select </option>
                                    @foreach ($airlines as $d)
                                        <option value="{{ url('airline-special-offers?airline=' . $d->id) }}"
                                            {{ request()->has('airline') && request()->get('airline') == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </form>
                </div>

                @if ($updates->count() > 0)
                    <div class="row mt-4">
                        @foreach ($updates as $d)
                            <div class="col-md-4">
                                <div class=" p-3" style="border-radius: 10px;background:#f0f0f0">

                                    <a href="{{ url('airline-special-offer/' . $d->id) }}" style="color:unset">
                                        <img src="{{ url('storage/uploads/agents/' . $d->image) }}" alt="Special Offer"
                                            class="promotionImage w-100">
                                        <h5 class="mt-3"><b>{{ $d->name }}</b></h5>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        {!! $updates->appends(request()->except('page'))->links() !!}
                    </div>
                @else
                    <p class="text-center" style="    margin: 59px 0;
    background: #070c39;  color: white;"><strong>No
                            Record Found</strong></p>
                @endif
            </div>


            <!--    <div class="col-md-2 col-pd">
       <div>
         <ins class="adsbygoogle"
         style="display:inline-block;width:280px;height:600px"
         data-ad-client="ca-pub-9682339330195266"
         data-ad-slot="3145814347"></ins>
         <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
         </script>
       </div>
     
     </div> -->
        </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#country').typeahead({
                minLength: 0,
                showHintOnFocus: true,
                autoSelect: false,
                source: function(query, result) {
                    $.ajax({
                        url: "{{ url('get-country') }}",
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
            });
        });
    </script>
@endpush
