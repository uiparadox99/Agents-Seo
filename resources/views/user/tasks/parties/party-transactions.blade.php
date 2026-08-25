@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    <div class="container">
        <section class="content-header">
            <h1>
                Party Transactions
            </h1>
            <ol class="breadcrumb">
                <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Party Transactions</li>
            </ol>
        </section>
        <section class="content">
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Party Transactions</h3>
                    <div class="box-tools pull-right">

                    </div>
                </div>
                <div class="box-body">
                    <div class="row transactions-detail">
                        <div class="col-md-7">
                            <h2>
                                {{ $party->name }}
                            </h2>
                        </div>
                        <div class="col-md-5 text-right pricing">
                            <p>Current Balance</p>
                            <h2>{{ $party->current_balance }}</h2>
                        </div>
                    </div>
                    <table class="table table-bordered datatables">
                        <thead>
                        <tr>
                            <th width="7%">Trans. #</th>
                            <th>Ticket No.</th>
                            <th>Sector</th>
                            <th>Passenger Name</th>
                            <th>Supplier</th>
                            <th>Staff</th>
                            <th width="7%">Date</th>
                            <th width="7%">Paid</th>
                            <th width="7%">Received</th>
                            <th width="7%">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($transactions as $t)
                            @php
                                if($t->trans_type == 'ticket'){
                                    if ($t->from == $id) {
                                       $paid       = $t->sale;
                                       $received   = 0;
                                       $balance    = $t->to_current_balance - $t->sale;
                                    }
                                }else{
                                if ($t->to == $id) {
                                       $received   = $t->amount;
                                       $paid       = 0;
                                       $balance    = $t->amount + $t->to_current_balance;
                                       $remarks    = $t->to_remarks;

                                    }
                                    if ($t->from == $id) {
                                       $received   = 0;
                                       $paid       = $t->amount;
                                       $balance    = $t->from_current_balance - $t->amount;
                                       $remarks    = $t->from_remarks;
                                    }
                                }
                            $red_td = $balance < 0 ?'bg-red':'';
                            @endphp

                            @if(!is_null($t->ticket))
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ $t->ticket->ticket_no }}</td>
                                    <td>{{ $t->ticket->sector }}</td>
                                    <td>{{ $t->ticket->pax_name }}</td>
                                    <td>{{ $t->ticket->admin->name }}</td>
                                    <td>{{ $t->supplier->name }}</td>
                                    <td>{{ $t->trans_date }}</td>
                                    <td>{{ $paid }}</td>
                                    <td>{{ $received }}</td>
                                    <td class="{{ $red_td }}">{{ $balance }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td colspan="4">{{ $remarks }}</td>
                                    <td>{{ $t->admin->name }}</td>
                                    <td>{{ $t->trans_date }}</td>
                                    <td>{{ $paid }}</td>
                                    <td>{{ $received }}</td>
                                    <td class="{{ $red_td }}">{{ $balance }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
        $(function(){

        })
    </script>
@endpush
