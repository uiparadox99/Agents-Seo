@extends('layouts.master') @section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">

            <h3>Manage subscription @if(!empty($subscriptions->first()) && $subscriptions->first()->plan->id == '5')<a href="{{url('/add-subscription')}}" class="btn btn-primary" style="float:right">Upgrade Now</a>@endif  @if($subscriptions->count() == 0 ) <a href="{{url('/add-subscription')}}" class="btn btn-primary" style="float:right">Add Subscription</a> @endif </h3>
            <div class="text-center">
             <!--    @if(!is_null(auth()->user()->agents()->first()) && !CheckPermission(auth()->user()->agents()->first()->id,'jobs'))<a href="{{url('preview-business/'.auth()->user()->agents()->first()->slug)}}"
                 class="btn btn-sm btn-primary" >Your profile as Varified Agent</a>@endif  -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive beinfits-on-subscription content-box-agent" >

                            <h6 style="color:red"><b>Benefits of Agent :</b></h6>
                            <p>Advertise your packages and special deals.</p>
                            <p>Advertise your business free of cost.</p>
                            <p>Get clients from around the world. </p>
                            <p>Publish your pictures gallery.</p>
                            <p>Publish your contact details.</p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive subscription-table content-box-agent" >
                        <!--  <table class="table table-borderd table-striped">
                    <thead>
                       <tr>
                           <th>Plan</th>
                           <th>Period</th>
                           <th>Price</th>
                           <th>Expairy</th>
                           <th>Payment Status</th>

                       </tr>
                   </thead>
                   <tbody>
                       @foreach($subscriptions as $r)
                       <tr data-id="{{ $r->id }}">
                          <td>{{!is_null($r->plan)?$r->plan->name:''}}</td>

                          @if($r->plan->id != 5)
                          <td  style="font-family:arial">{{$r->period}} Year</td>
                          <td  style="font-family:arial">Rs {{$r->payment}}</td>
                          <td style="font-family:arial">{{date('d M Y',strtotime($r->expairy_date))}}  @php
                           $check = date('Y-m-d h:i:s', strtotime("-7 day",strtotime($r->expairy_date)));

                           @endphp
                           @if($r->expairy_date == $check)
                           <a href="{{url('/renew-subscription?id='.$r->id)}}"  class="btn btn-success btn-sm">Renew Now</a>
                       @endif  </td>
                       <td class="text-capitalize">{{$r->status}}</td>
                       @else
                       <td  style="font-family:arial">-</td>
                       <td  style="font-family:arial">-</td>
                       <td  style="font-family:arial">-</td>
                       <td  style="font-family:arial">-</td>
                       @endif

                   </tr>
                   @endforeach
                                 </tbody>
                             </table> -->
                             @foreach($subscriptions as $r)
                             <table class="table table-borderd table-striped">

                                <tr data-id="{{ $r->id }}">
                                    <th>Plan</th>
                                    <td>{{!is_null($r->plan)?$r->plan->name:''}}</td>
                                </tr>

                                @if($r->plan->id != 5)
                                <tr>
                                    <th>Period</th>
                                    <td style="font-family:arial">{{$r->period}} Year</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td style="font-family:arial">Rs {{$r->payment}}</td>
                                </tr>
                                <tr>
                                    <th>Expiry</th>
                                    <td style="font-family:arial">{{date('d M Y',strtotime($r->expairy_date))}} @php $check = date('Y-m-d h:i:s', strtotime("-7 day",strtotime($r->expairy_date))); @endphp @if($r->expairy_date == $check)
                                        <a href="{{url('/renew-subscription?id='.$r->id)}}" class="btn btn-success btn-sm">Renew Now</a> @endif </td>
                                    </tr>

                                    <tr>
                                        <th>Payment Status</th>
                                        <td class="text-capitalize">{{$r->status}}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th>Period</th>
                                        <td style="font-family:arial">-</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td style="font-family:arial">-</td>
                                    </tr>
                                    <tr>
                                        <th>Expiry</th>
                                        <td style="font-family:arial">-</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <td style="font-family:arial">-</td>
                                    </tr>
                                    @endif @endforeach
                                </table>
                                {!! $subscriptions->links() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <style type="text/css">
                
            </style>
            <div class="row plans-row" style="margin-left:0;margin-right:0;position: relative;">

                <div class=" col-md-4 text-left color777 wow fadeInLeft" data-wow-delay="0.7s" data-wow-duration="1.5s" style=" color: #fff;padding: 0">
                    <!--<div class="per-month uppercase semibold">per month</div>-->
                    <div class="plan-name featured-title" style="  ">
                    <div class="title"><b>Features</b></div>
                </div>
                <div class=" text-right">
                    @foreach($permissions as $perm) @if($perm->id == 5 || $perm->id == 6 || $perm->id == 11 || $perm->id == 12) @else
                    <label class="heading-label" style="">{{$perm->name}}</label>
                    @endif @endforeach
                    <label class="heading-label" style="">Gallery Pictures</label>
                    <label class="heading-label" style="">Promotions</label>
                </div>
                <div style="margin-top: 40px;"></div>
            </div>

            @foreach($plans as $p)
            <div class=" col-md-4 text-center color777 wow fadeInLeft pl-0 pr-0" style="padding-top:30px;" data-wow-delay="0.7s" data-wow-duration="1.5s">
                <div class="plan-name">


                    <div class="title"><b>{{$p->name}}</b></div>
                    @if($p->id == 5)
                    <div class="price-tbl b-radius5">
                        -
                    </div>
                    <small>-</small> @else
                    <div class="price-tbl b-radius5" style="font-weight: 500">Rs @if(!is_null($p->plansPriceDiscounts)) @foreach($p->plansPriceDiscounts->where("active", '1') as $pp) {!! $pp->isDiscountActive == 1 ? '<i style="text-decoration: line-through;">'.number_format($pp->price)."</i> / " : ""!!}{!! $pp->isDiscountActive == 1 ? number_format($pp->price - ($pp->price * $pp->discount_percentage)/100) : number_format($pp->price)!!} @endforeach @endif
                    </div>
                    <small>Per Year</small> @endif
                </div>
                <!--<div class="per-month uppercase semibold">per month</div>-->
                <!--   <div style="margin-top:13px;"></div> -->

                <div class="lh36 font13 top40 text-center prices-agents">
                    @foreach($permissions as $perm) @php $count = 1 @endphp @foreach($permAssoc as $assoc) @if($assoc->plan_id == $p->id && $assoc->plans_permissions_id == $perm->id) @php $count = 0 @endphp @if($perm->id == 5 || $perm->id == 6 || $perm->id == 11 || $perm->id == 12) @else
                    <span class="yes-no">
                        <i class="fa fa-check"></i>
                    </span> @endif @endif @endforeach @if($perm->id == 5 || $perm->id == 6 || $perm->id == 11 || $perm->id == 12) @else @if($count == 1)
                    <span class="yes-no">
                        <i class="fa fa-times"></i>
                    </span> @endif @endif @endforeach
                </div>
                <div style="margin-top: 40px;"></div>
            </div>
            @endforeach
            <span class="hover-1 ">1</span>
            <span class="hover-2">1</span>
            <span class="hover-5">5</span>
            <span class="hover-3">3</span>
        </div>
    </div>
    @endsection @push('script')
    <script type="text/javascript">
        function addToHome(pointer) {

            var $this = $(pointer);
            var tr = $this.closest('tr');
            var id = tr.data('id');

            if ($this.is(':checked')) {
                var is_home = 1;
            } else {
                var is_home = 0;
            }

            $this.prop("disabled", true);
            $this.val("Processing..");

            $.ajax({
                url: SITE_PATH + '/active-review',
                type: 'GET',
                data: {
                    is_home: is_home,
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.notify) {
                        $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
                    } else {
                        $(".top" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
                    }
                },
                error: function() {

                },
                complete: function() {
                    $this.prop("disabled", false);
                }
            });
        }
    </script>
    @endpush