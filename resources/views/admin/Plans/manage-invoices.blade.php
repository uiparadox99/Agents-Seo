@extends('admin.layout.master')
@section('title', 'Agent Profile Updates')
@section('content')

<?php $a = 1; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Invoices Details
            <small>Manage</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Invoices Details</li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header with-border">
                        <a href="{{url('admin/manage-subscription')}}" class="btn btn-primary pull-right"><i
                                class="fa fa-arrow-left">&nbsp;</i>Go Back</a>
                        <h3 class="box-title">List of Invoices</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-condensed table-striped" width="100%" id="agent-management-approvals">
                            <thead>
                                <tr>
                                    <th>Agent Name</th>
                                    <th>Plan Price</th>
                                    <th>Payment</th>
                                    <th>Discount</th>
                                    <th>Account Title</th>
                                    <th>Account #</th>
                                    <th>Receiver</th>
                                    <th>Expire</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $n)
                                <tr>
                                    <td>
                                        {{$n->business_name}}

                                    </td>
                                    <td>
                                        {{$n->plan_price}}
                                    </td>
                                    <td>{{$n->payment}}</td>
                                    <td>{{$n->discount_percentage}} %</td>
                                    <td>{{ $n->account_title}}</td>
                                    <td>{{ $n->account_number }}</td>
                                    <td>{{ $n->receiver_account_title}}</td>
                                    <td>{{ $n->expire_date }}</td>
                                    <td><button
                                            class="btn btn-xs btn-{{$n->status == 'paid'?'success':'warning'}} text-uppercase">{{ $n->status }}</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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