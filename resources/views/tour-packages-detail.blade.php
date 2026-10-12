@extends('layouts.master')
@section('content')
    <section id="content" class="container pt-5">

                <h1 style="    background: #090d3a;
    padding: 15px;
    color: white;
    border-radius: 12px;">{{ $detail->title }} <span style="float:right;color:#f58220"><small style="font-size: 22px">Starting
                        From:</small> Rs{{ $detail->price }}</span>
                </h1>

                <div class="row mt-4">
                    <div class="col-md-6">
                        @if (!is_null($detail->agents_id))
                        <img src="{{ url('storage/uploads/packages/' . $detail->image) }}" width="100%"
                            style="border-radius: 7px;object-fit: cover;margin-bottom: 10px; background:#f0f0f0;height:300px ">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Country</th>
                                <td>{{$detail->country}}</td>
                              
                            </tr>
                            <tr>
                                <th>Nights</th>
                                <td>{{$detail->nights}}</td>
                                <th>Days</th>
                                <td>{{$detail->days}}</td>
                            </tr>
                            @if(!empty($detail->departure_date))
                            <tr>
                                <th>Departure Date</th>
                                <td>{{$detail->departure_date}}</td>
                                
                                <th>Return Date</th>
                                <td>{{$detail->return_date}}</td>
                            </tr>
                            @endif
                        </table>
                        <h4>Package Included:</h4>
                        <table class="table table-bordered table-striped">
                            @if(!empty($detail->return_ticket) && $detail->return_ticket == 1)
                            <tr>
                                <th>Return Ticket</th>
                                <td>Yes</td>
                                <th>Return Airline</th>
                                <td>{{$detail->return_airline}}</td>
                            </tr>
                            @endif
                            @if(!empty($detail->visit_visa) && $detail->visit_visa == 1)
                            <tr>
                                <th>Visit</th>
                                <td>Yes</td>
                                <th>Remarks</th>
                                <td>{{$detail->visit_visa_remarks}}</td>
                            </tr>
                            @endif
                            <tr>
                                @if(!empty($detail->airpor_pickdrop) && $detail->airpor_pickdrop == 1)
                                <th>Airport Pickup & Drop</th>
                                <td>Yes</td>
                                @endif
                             
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h4>Package Pricing:</h4>
                    <div class="row mt-4">
                        @foreach ($detail->pricings as $p)
                            
                
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                            <tr>
                                <th>Departure City</th>
                                <td>{{$p->city}}</td>
                                @if(!empty($p->single_room))
                                <th>Single Room</th>
                                <td>Rs{{$p->single_room}}</td>
                                @endif
                            </tr>
                            @if(!empty($p->triple_room) || !empty($p->double_room))
                            <tr>
                                @if(!empty($p->double_room))
                                <th>Double Room</th>
                                <td>Rs{{$p->double_room}}</td>
                                @endif
                                @if(!empty($p->triple_room))
                                <th>Triple Room</th>
                                <td>Rs{{$p->triple_room}}</td>
                                @endif
                            </tr>
                            @endif
                            @if(!empty($p->infant) || !empty($p->quad_room))
                            <tr>
                               
                                @if(!empty($p->quad_room))
                                <th>Quad Room</th>
                                <td>Rs{{$p->quad_room}}</td>
                                @endif
                                @if(!empty($p->infant))
                                <th>Infant</th>
                                <td>Rs{{$p->infant}}</td>
                                @endif
                            </tr>
                            @endif
                           
                        </table>
                        </div>
                        @endforeach
                        
                </div>
            

                <br>
                @if ($detect->isMobile())
                    <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                @endif

                    <h2 class="mb-3">Tour Internity</h2>
                    <div class="package-detail-agent-description" style="border:1px solid #070c39">
                        {!! renderHTML($detail->tour_itinery) !!}
                </div>
                <br>
                @if (!is_null($detail->agent))
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
                                            <img src="{{ url('images/placeholder.jpg') }}"
                                                style="width: 100%;height: 150px">
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
                                                        class="btn btn-block btn-primary  btn-sm "
                                                        target="_blank">Website</a></li>
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
                                            {{ $detail->agent->address }} @if (!empty($detail->agent->address) && !empty($detail->agent->city->name))
                                                ,
                                            @endif{{ $detail->agent->city->name }}</p>


                                        @if (!empty($d->agent->phone))
                                            @php
                                                $phone = explode(',', $d->agent->phone);
                                            @endphp
                                            <div class="row">


                                                @foreach ($phone as $p)
                                                    <div class="col-md-6">

                                                        <p class="mb-1"><a href="tel:{{ $p }}"
                                                                style="color: unset;"><i class="fa fa-phone"></i>
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
                                            style="width:50px;height:40px;margin-bottom: 10px;"
                                            alt="{{ $detail->agent->agentType->name }}">
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
                                                        style="width:50px;height:40px;"
                                                        alt="{{ $detail->agent->agentType->name }}">
                                                @endif <i class="fa fa-check" style="color:green"></i>
                                                Verified Agent
                                            </p>
                                        @else
                                            <p class="m-0">
                                                @if (!is_null($detail->agent->agentType) && !empty($detail->agent->agentType->image))
                                                    <img src="{{ url('storage/uploads/agents/' . $detail->agent->agentType->image) }}"
                                                        style="width:50px;height:40px;"
                                                        alt="{{ $detail->agent->agentType->name }}">
                                                @endif Basic Agent
                                            </p>
                                        @endif
                                        <ul class="agent-listing-link">
                                            @if (CheckPermission($detail->agent->id, 'full_contact') && !empty($detail->agent->website))
                                                <li><a href="http://{{ str_replace('http://', '', str_replace('www.', '', str_replace('https://', '', $detail->agent->website))) }}"
                                                        class="btn btn-block btn-primary  btn-sm "
                                                        target="_blank">Website</a></li>
                                            @endif


                                            <li><a href="{{ url(!is_null($detail->agent->slug) ? 'agent/' . $detail->agent->slug . '#deals' : '') }}"
                                                    style="font-size: 12px;padding: 2px 0;"
                                                    class="btn  btn-block btn-sm btn-warning">Hot Deals</a></li>
                                            @if (empty($detail->agent->users_id))
                                                <li><a href="{{ url('claim-business/' . $detail->agent->slug) }}"
                                                        style="font-size: 12px;padding: 2px 0;"
                                                        class="btn  btn-block btn-sm btn-danger">Claim </a></li>
                                            @endif
                                            <div class="clearfix"></div>
                                        </ul>

                                        <p><i class="fa fa-map-marker-alt"></i> {{ $detail->agent->address }} @if (!empty($detail->agent->address) && !empty($detail->agent->city->name))
                                                ,
                                            @endif {{ $detail->agent->city->name }}</p>
                                        @if (!empty($d->agent->phone))
                                            @php
                                                $phone = explode(',', $d->agent->phone);
                                            @endphp

                                            <div class="row">


                                                @foreach ($phone as $p)
                                                    <div class="col-md-6">

                                                        <p class="mb-1"><a href="tel:{{ $p }}"
                                                                style="color: unset;"><i class="fa fa-phone"></i>
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
                                            <img src="{{ url('storage/uploads/agents/' . $detail->agent->logo) }}"
                                                style="width: 100%;">
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
                @endif
                @if ($detect->isMobile())
                    <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                @endif


    @include('partials.product-reviews', ['product' => $detail, 'type' => 'tour'])

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
                beforeSend: function() {
                    $('#agentPackgesData').html(
                        '<p class="text-center" style="width:100%"><b><i class="fa fa-spinner fa-spin"></i> Loading...</b></p>'
                    );
                }

            }).done(function(data) {
                if (data.html == "") {
                    $('#agentPackgesData').html(
                        '<p class="text-center" style="width:100%"><b>No Record found</b></p>');
                    return;
                }
                $("#agentPackgesData").html(data.html);
            });
        }
        $(document).ready(function() {
            $('#expandmobileSearch').click(function() {

                $('#mobileSearch').toggle();
            });
        });
    </script>
@endpush

@push('schema')
    @include('partials.product-schema', ['product' => $detail, 'type' => 'tour'])
@endpush
