@extends('admin.layout.master')
@section('title', 'Agent Profile Updates')
@section('content')

<?php $a = 1; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Subscriptions
            <small>Manage</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Subscriptions</li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{url('admin/subscriber/0/add')}}" class="btn btn-primary pull-right"><i
                                class="fa fa-plus">&nbsp;</i>Add Subscriber</a>
                        <h3 class="box-title">List of Subscriptions</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-condensed table-striped" width="100%" id="agent-management-approvals">
                            <thead>
                                <tr>
                                    <th>ID #</th>
                                    <th>Agent Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Plan</th>
                                    <th>Price</th>
                                    <th>Payment Status</th>
                                    <th>Duration</th>
                                    <th>Expire</th>
                                    <th>Subscribed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscriptions as $subscribe)
                            
                                <tr class="" style="{{$subscribe->active != 1?'background: red;color: #fff':''}}">
                                    <td>{{ $a++ }}</td>
                                    <td>
                                        {{$subscribe->agent->business_name}}

                                    </td>
                                    <td>{{$subscribe->agent->email}}</td>
                                    <td>{{$subscribe->agent->phone}}</td>
                                    <td>{{ $subscribe->plan->name }}</td>
                                    <td>
                                        Rs {{$subscribe->payment}}
                                       <!--  @foreach($subscribe->plan->plansPriceDiscounts as $plan)
                                        @if($plan->isDiscountActive == 1)
                                        {!! ($plan->price * $plan->discount_percentage)/100 !!} ({!!
                                        $plan->discount_percentage !!}%)
                                        @else
                                        {{$plan->price}}
                                        @endif
                                        @endforeach -->
                                    </td>
                                    <td>{{$subscribe->status}}</td>
                                    <td>{{ $subscribe->period }} Year</td>
                                    <td
                                        class="@if($subscribe->expairy_date >= firstDayOfMonth() && $subscribe->expairy_date <= lastDayOfMonth()) {{'bg-warning'}}@elseif($subscribe->expairy_date < CurrentDate()){{'bg-red'}}@endif">
                                        {{ $subscribe->expairy_date }}</td>
                                    <td>{{ xTimeAgo($subscribe->created_at) }}</td>
                                    <td>
                                        <a href="{{url('admin/subscriber/'.$subscribe->agents_id.'/edit')}}"
                                            class="btn btn-success btn-sm">
                                            <i class="fa fa-gear">&nbsp;</i> Edit
                                        </a>
                                        <a href="{{url('admin/subscriber/'.$subscribe->agents_id.'/renewal')}}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-gear">&nbsp;</i> Renewal
                                        </a><br>
                                        <a href="{{url('admin/invoices/'.$subscribe->id)}}"
                                            class="btn btn-success btn-sm" style="margin-top: 5px">
                                            <i class="fa fa-money">&nbsp;</i> Invoices
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $subscriptions->links() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
</div>
@endsection