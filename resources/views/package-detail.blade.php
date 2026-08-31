@extends('layouts.master')
@section('content')
<section id="content" class="container pt-5">

    <h1 style="" class="agentDetailTitle">{{ $detail->name }} </span>
    </h1>
    <hr />

    <div class="row mt-4">
        <div class="col-md-4">
            @if (!is_null($detail->agents_id))
            <img src="{{ url('storage/uploads/packages/' . $detail->image) }}" width="100%"
                alt="{{ !empty($detail->image_alt) ? $detail->image_alt : $detail->name }}"
                fetchpriority="high"
                style="border-radius: 7px;object-fit: cover;margin-bottom: 10px; background:#f0f0f0 ">
            @endif
        </div>
        <div class="col-md-8">
            <h5 class="mb-3" style="background: #090d3a; padding: 15px;color: white; border-radius: 12px;">Umrah
                Packages Includes</h5>
            <div class="row">
                <div class="col-6">
                    <div style="background: #f2f2f2;padding: 15px;color: black;">
                        <p class="text-center mb-1">Makkah</p>
                        <h3 class="text-center">12</h3>
                        <h5 class="text-center">Nights</h5>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background: #f2f2f2;padding: 15px;color: black;">
                        <p class="text-center mb-1">Madina</p>
                        <h3 class="text-center">8</h3>
                        <h5 class="text-center">Nights</h5>
                    </div>
                </div>
            </div>
            <div class="row mt-3 mb-3 align-items-center">
                <div class="col-md-6 ">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><i class="fas fa-plane"></i> Flight Included</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><i class="fa fa-car"></i> {{$detail->transport}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><i class="fa fa-globe"></i> Visa {{$detail->umrah_visa == 1?'Included':'Not
                                Included'}}</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><i class="fa fa-bus"></i> Shuttle {{$detail->shuttle_service ==
                                1?'Included':'Not Included'}}</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div style="background: #090d3a; padding: 15px;color: white; border-radius: 12px;">

                        <h2 class="text-center mb-0"><small style="font-size:12px">from</small> PKR
                            {{$detail->shairing}}</h2>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                @if(!is_null($detail->makkah_hotel))
                <div class="col-md-6">
                    <h6>Hotel in Makkah</h6>
                    <div style="background: #f2f2f2; padding: 8px;color: black; border-radius: 8px;" >
                        <div class="row">
                            <div class="col-3 pr-1">
                                @if(!empty($detail->makkah_hotel->img))
                                 <img src="{{url('storage/uploads/hotels/'.$detail->makkah_hotel->img)}}" class="w-100">
                                @endif
                            </div>
                            <div class="col-8 pl-1">
                                <h6 class="mb-0">{{!is_null($detail->makkah_hotel)?$detail->makkah_hotel->name:''}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(!is_null($detail->madinah_hotel))
                <div class="col-md-6">
                    <h6>Hotel in Madina</h6>
                    <div style="background: #f2f2f2; padding: 8px;color: black; border-radius: 8px;" >
                        <div class="row">
                            <div class="col-3 pr-1">
                                @if(!empty($detail->madinah_hotel->img))
                                 <img src="{{url('storage/uploads/hotels/'.$detail->madinah_hotel->img)}}" class="w-100">
                                @endif
                            </div>
                            <div class="col-8 pl-1">
                                <p class="mb-0">{{!is_null($detail->madinah_hotel)?$detail->madinah_hotel->name:''}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-9">
            <div class="row align-items-center">
                <div class="col-md-3 mb-2 col-6">
                    <div style="background: #090d3a; padding: 15px;color: white; border-radius: 12px;">
                        <h6 class="mb-1 text-center">Shairing Room</h6>
                        <h5 class="text-center mb-0"> PKR {{$detail->shairing}}</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-2 col-6">
                    <div style="background: #090d3a; padding: 15px;color: white; border-radius: 12px;">
                        <h6 class="mb-1 text-center">Quad Room</h6>
                        <h5 class="text-center mb-0"> PKR {{$detail->quad_room}}</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-2 col-6">
                    <div style="background: #090d3a; padding: 15px;color: white; border-radius: 12px;">
                        <h6 class="mb-1 text-center">Triple Room</h6>
                        <h5 class="text-center mb-0"> PKR {{$detail->triple_room}}</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3 col-6">
                    <div style="background: #090d3a; padding: 15px;color: white; border-radius: 12px;">
                        <h6 class="mb-1 text-center">Double Room</h6>
                        <h5 class="text-center mb-0"> PKR {{$detail->double_room}}</h5>
                    </div>
                </div>
            </div>
                </div>
                <div class="col-md-3">
                    <p class="text-center mb-0">Speak to the Agent</p>
                    <h5 class="text-center mb-1 text-capitalize" style="color:#f58220">  <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"  style="color:#f58220">{{ strtolower($detail->agent->business_name) }}</a></h5>
                    <h4 class="text-center">@if(!empty($detail->agent->phone)) @php $phone = explode(',', $detail->agent->phone);
                        $count = 0; @endphp @foreach($phone as $p) @php $count++; @endphp @if($count == 1)<a href="tel:{{$p}}"
                          style="color: unset;"> <i class="fa fa-phone-volume"></i> {{$p}} </a> @endif @endforeach @endif</h4>
                </div>
                
            </div>
    @if(!empty($detail->sector) && !empty($detail->departure_date))
    <div class="clearfix"></div>
    <h4>Flight Details:</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Sector</th>
                <th>Airline</th>
                <th>Flight No</th>
                <th>Departure Date</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
            </tr>
        </thead>
        <tr>
            <td>{{$detail->sector}}</td>
            <td>
                @if(!is_null($detail->airline) && !empty($detail->airline->img))
                <img src="{{url('storage/uploads/airline/'.$detail->airline->img)}}" class="img-responsive"
                    style="width: 100px;height: 48px;">
                @endif
            </td>
            <td>{{$detail->flight}}</td>
            <td>{{date('d M Y',strtotime($detail->departure_date))}}</td>
            <td>{{$detail->departure_time}}</td>
            <td>{{$detail->arrival_time}}</td>
        </tr>
    </table>
    @endif
    @if(!empty($detail->return_sector) && !empty($detail->return_departure_date))
    <h4>Return Flight Details:</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Sector</th>
                <th>Airline</th>
                <th>Flight No</th>
                <th>Return Date</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
            </tr>
        </thead>
        <tr>
            <td>{{$detail->return_sector}}</td>
            <td>
                @if(!is_null($detail->return_airline) && !empty($detail->return_airline->img))
                <img src="{{url('storage/uploads/airline/'.$detail->return_airline->img)}}" class="img-responsive"
                    style="width: 100px;height: 48px;">
                @endif
            </td>
            <td>{{$detail->return_flight}}</td>
            <td>{{date('d M Y',strtotime($detail->return_departure_date))}}</td>
            <td>{{$detail->return_departure_time}}</td>
            <td>{{$detail->return_arrival_time}}</td>
        </tr>
    </table>
    @endif

    <br>

    {{-- @if (!is_null($detail->agent))
    <div class="box-hang-title">
        <h3 class="">Agent Contact Details</h3>
    </div>
    @if (!$detect->isMobile())
    <div class="visas-agent-box" style="">
        <div class="row">

            <div class="col-3" style="position: relative;">
                <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"
                    class="blog-link">
                    @if (!empty($detail->agent->logo))
                    <img src="{{ url('storage/uploads/agents/' . $detail->agent->logo) }}"
                        style="width: 100%;height: 150px;object-fit: contain;">
                    @else
                    <img src="{{ url('images/placeholder.jpg') }}" style="width: 100%;height: 150px">
                    @endif
                </a>
                @if (CheckPermission($detail->agent->id, 'verified_agent'))
                <div class="ribbon-agent ribbon-green">
                    Verified Agent


                </div>
                @else
                <div class="ribbon-agent">
                    Basic Agent
                </div>
                @endif

            </div>
            <div class="col-6 pr-0">
                <div class="blog-detail">

                    <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"
                        class="blog-link">
                        <h3 class="mb-2 agent-title text-capitalize">
                            {{ strtolower($detail->agent->business_name) }}</h3>
                    </a>

                    <ul class="agent-listing-link">
                        @if (CheckPermission($detail->agent->id, 'full_contact') && !empty($detail->agent->website))
                        <li><a href="http://{{ str_replace('http://', '', str_replace('www.', '', str_replace('https://', '', $detail->agent->website))) }}"
                                class="btn btn-block btn-primary  btn-sm " target="_blank">Website</a></li>
                        @endif



                        <li><a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug . '#deals' : '') }}"
                                class="btn  btn-block btn-sm btn-warning">Hot Deals</a></li>
                        @if (empty($detail->agent->users_id))
                        <li><a href="{{ url('claim-business/' . $detail->agent->slug) }}"
                                class="btn  btn-block btn-sm btn-danger">Claim Business</a></li>
                        @endif
                        <div class="clearfix"></div>
                    </ul>

                    <p><i class="fa fa-map-marker-alt"></i> {{ $detail->agent->address }}
                        {{ $detail->agent->address }} @if (!empty($detail->agent->address) &&
                        !empty($detail->agent->city->name))
                        ,
                        @endif{{ $detail->agent->city->name }}</p>


                    @if (!empty($d->agent->phone))
                    @php
                    $phone = explode(',', $d->agent->phone);
                    @endphp
                    <div class="row">


                        @foreach ($phone as $p)
                        <div class="col-md-6">

                            <p class="mb-1"><a href="tel:{{ $p }}" style="color: unset;"><i class="fa fa-phone"></i>
                                    {{ $p }}</a></p>
                        </div>
                        @endforeach
                    </div>
                    @endif


                </div>
            </div>
            <div class="col-3 text-center {{ !is_null($detail->agent->agentType) && !empty($detail->agent->agentType->image) ? 'pt-2' : 'pt-4' }}"
                style="    border-left: 2px dashed;">
                @if (!is_null($detail->agent->agentType) && !empty($detail->agent->agentType->image))
                <img src="{{ url('storage/uploads/agents/' . $detail->agent->agentType->image) }}"
                    style="width:50px;height:40px;margin-bottom: 10px;" alt="{{ $detail->agent->agentType->name }}">
                @endif
                <div class="clearfix"></div>
                {!! showRatingStars($detail->agent->agentReviews()->where('active', 1)->avg('rating')) !!}
                <p class="text-center mt-2 mb-2"><a
                        href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug . '#reviews' : '') }}"
                        style="color: #070c39">Write Review</a></p>
                <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"
                    class="btn btn-primary btn-block btn-sm">More Info</a>
            </div>

        </div>
    </div>
    @else
    <div class="visas-agent-box" style="">
        <div class="row">

            <div class="col-md-9 col-8 pr-0">
                <div class="blog-detail">

                    <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"
                        class="blog-link">
                        <h3 class="mt-0 mb-0 agent-title text-capitalize">
                            {{ strtolower($detail->agent->business_name) }}</h3>
                    </a>

                    @if (CheckPermission($detail->agent->id, 'verified_agent'))
                    <p style="color:green" class="m-0">
                        @if (!is_null($detail->agent->agentType) && !empty($detail->agent->agentType->image))
                        <img src="{{ url('storage/uploads/agents/' . $detail->agent->agentType->image) }}"
                            style="width:50px;height:40px;" alt="{{ $detail->agent->agentType->name }}">
                        @endif <i class="fa fa-check" style="color:green"></i>
                        Verified Agent
                    </p>
                    @else
                    <p class="m-0">
                        @if (!is_null($detail->agent->agentType) && !empty($detail->agent->agentType->image))
                        <img src="{{ url('storage/uploads/agents/' . $detail->agent->agentType->image) }}"
                            style="width:50px;height:40px;" alt="{{ $detail->agent->agentType->name }}">
                        @endif Basic Agent
                    </p>
                    @endif
                    <ul class="agent-listing-link">
                        @if (CheckPermission($detail->agent->id, 'full_contact') && !empty($detail->agent->website))
                        <li><a href="http://{{ str_replace('http://', '', str_replace('www.', '', str_replace('https://', '', $detail->agent->website))) }}"
                                class="btn btn-block btn-primary  btn-sm " target="_blank">Website</a></li>
                        @endif


                        <li><a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug . '#deals' : '') }}"
                                style="font-size: 12px;padding: 2px 0;" class="btn  btn-block btn-sm btn-warning">Hot
                                Deals</a></li>
                        @if (empty($detail->agent->users_id))
                        <li><a href="{{ url('claim-business/' . $detail->agent->slug) }}"
                                style="font-size: 12px;padding: 2px 0;" class="btn  btn-block btn-sm btn-danger">Claim
                            </a></li>
                        @endif
                        <div class="clearfix"></div>
                    </ul>

                    <p><i class="fa fa-map-marker-alt"></i> {{ $detail->agent->address }} @if(!empty($detail->agent->address) && !empty($detail->agent->city->name)),  @endif {{ $detail->agent->city->name }}</p>
                    @if (!empty($d->agent->phone))
                    @php
                    $phone = explode(',', $d->agent->phone);
                    @endphp

                    <div class="row">


                        @foreach ($phone as $p)
                        <div class="col-md-6">

                            <p class="mb-1"><a href="tel:{{ $p }}" style="color: unset;"><i class="fa fa-phone"></i>
                                    {{ $p }}</a></p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-4">
                <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"
                    class="blog-link">
                    @if (!empty($detail->agent->logo))
                    <img src="{{ url('storage/uploads/agents/' . $detail->agent->logo) }}" style="width: 100%;">
                    @else
                    <img src="{{ url('images/placeholder.jpg') }}" style="width: 100%;">
                    @endif
                </a>
                <div style="font-size: 12px;" class="mt-1">


                    {!! showRatingStars($detail->agent->agentReviews()->where('active', 1)->avg('rating')) !!}
                    <p class="text-center m-1"><a
                            href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug . '#reviews' : '') }}"
                            style="color: #070c39">Write Review</a></p>
                    <a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug : '') }}"
                        class="btn btn-primary btn-block btn-sm">More Info</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif --}}
    @if ($detect->isMobile())
    <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
        data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    @endif


</section>
@endsection
@push('script')
<script type="text/javascript">
    function filters() {
        var formData = $("#filter").serialize();

        $.ajax({
            url: "{{ request()->url() }}",
            type: "GET",
            data: formData,
            beforeSend: function () {
                $('#agentPackgesData').html(
                    '<p class="text-center" style="width:100%"><b><i class="fa fa-spinner fa-spin"></i> Loading...</b></p>'
                );
            }

        }).done(function (data) {
            if (data.html == "") {
                $('#agentPackgesData').html(
                    '<p class="text-center" style="width:100%"><b>No Record found</b></p>');
                return;
            }
            $("#agentPackgesData").html(data.html);
        });
    }
    $(document).ready(function () {
        $('#expandmobileSearch').click(function () {
            $('#mobileSearch').toggle();
        });
    });
</script>
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Product",
            "@id": "{{ request()->url() }}#package",
            "name": "{{ addslashes($detail->name) }}",
            "description": "{{ addslashes(str_limit(strip_tags($detail->content1 ?? $detail->name), 160)) }}",
            "url": "{{ request()->url() }}",
            @if(!empty($detail->image))
            "image": "{{ url('storage/uploads/packages/' . $detail->image) }}",
            @endif
            "offers": {
                "@type": "Offer",
                "priceCurrency": "PKR",
                "price": "{{ !empty($detail->price) ? $detail->price : '0' }}",
                "availability": "https://schema.org/InStock",
                "url": "{{ request()->url() }}"
            }
        },
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://agents.com.pk/"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Umrah Packages",
                    "item": "https://agents.com.pk/cheap-umrah-packages"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($detail->name) }}",
                    "item": "{{ request()->url() }}"
                }
            ]
        }
    ]
}
</script>
@endpush