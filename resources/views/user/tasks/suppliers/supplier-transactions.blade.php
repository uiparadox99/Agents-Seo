@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    <div class="container">
        <section class="content-header">
            <h1>
                Supplier Transactions
            </h1>
            <ol class="breadcrumb">
                <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Supplier Transactions</li>
            </ol>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Supplier Transactions</h3>
                    <div class="box-tools pull-right">

                    </div>
                </div>
                <div class="box-body">
                    <div class="row transactions-detail">
                        <div class="col-md-7">
                            <h2>
                                {{ $supplier->name }}
                            </h2>
                        </div>
                        <div class="col-md-5 text-right pricing">
                            <p>Current Amount</p>
                            <h2>{{ abs($supplier->current_balance) }}</h2>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="7%">Trans. #</th>
                            <th>Ticket No.</th>
                            <th>Sector</th>
                            <th>Passenger Name</th>
                            <th>Party</th>
                            <th>Staff</th>
                            <th width="10%">Date</th>
                            <th width="10%">Paid</th>
                            <th width="10%">Received</th>
                            <th width="10%">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($transactions as $t)
                            @php
                                if($t->trans_type == 'ticket'){
                                    if ($t->to == $id) {
                                       $received   = $t->cost;
                                       $paid       = 0;
                                       $balance    = $t->from_current_balance + $t->cost;
                                    }
                                }else{
                                    if ($t->to == $id) {
                                       $received   = $t->amount;
                                       $paid       = 0;
                                       $balance    = $t->amount + $t->to_current_balance;
                                       $remarks    = $t->to_remarks;
                                    }elseif ($t->from == $id) {
                                       $received   = 0;
                                       $paid       = $t->amount;
                                       $balance    = $t->from_current_balance - $t->amount;
                                       $remarks    = $t->from_remarks;
                                    }
                                }
                            $red_td = $balance < 0 ?'bg-red':'';
                            @endphp

                            @if($t->trans_type == 'ticket')
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ $t->ticket->ticket_no }}</td>
                                    <td>{{ $t->ticket->sector }}</td>
                                    <td>{{ $t->ticket->pax_name }}</td>
                                    <td>{{ $t->party->name }}</td>
                                    <td>{{ $t->ticket->admin->name }}</td>
                                    <td>{{ $t->trans_date }}</td>
                                    <td>{{ $paid }}</td>
                                    <td>{{ $received }}</td>
                                    <td class="{{ $red_td }}">{{ $balance }} </td>
                                </tr>
                            @else
                                <tr>
                                    <td><a href="{{ route('edit-journal-voucher', $t->id) }}">{{ $t->id }}</a></td>
                                    <td colspan="5">{{ $remarks }}</td>
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

    </script>
@endpush
