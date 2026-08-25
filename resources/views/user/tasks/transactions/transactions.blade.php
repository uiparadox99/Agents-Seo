@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    <div class="container">
        <section class="content-header">
     {{--        <h1>
                Ledger
            </h1> --}}
           {{--  <ol class="breadcrumb">
                <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Ledger</li>
            </ol> --}}
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="text-center m-0">Ledger</h1>
                    <div class="box-tools pull-right">

                    </div>
                </div>
                <div class="box-body">

                    <form class="form-validation" method="GET">
                        <div class="filters">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <div class="row tasks-dates">
                                        
                                        <div class="col-md-2 form-group">
                                            <label>Party / Supplier</label>
                                            <select style="text-align: center;" class="form-control" onchange="ShowSupplier(this)">
                                                <option value="party"> Party</option>
                                                <option value="supplier"{{request()->has('suppliers_id')  && !empty(request()->get('suppliers_id'))?'selected':''}}>Supplier</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group " id="suppliermain"  style="{{request()->has('suppliers_id') && !empty(request()->get('suppliers_id'))?'':'display: none;'}}">
                                            <label>Supplier</label>
                                            <select name="suppliers_id" id="supplier" class="form-control"
                                                    onchange="disableSelect(this)">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $s)
                                                    <option
                                                        value="{{ $s->id }}" {{ app('request')->input('suppliers_id') ==  $s->id?'selected':'' }}>
                                                        {{ $s->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group" id="partymain" style="{{request()->has('suppliers_id') && !empty(request()->get('suppliers_id'))?'display: none;':''}}">
                                            <label>Party</label>
                                            <select name="parties_id" id="party" class="form-control select2"
                                                    onchange="disableSelect(this)">
                                                <option value="">Select Party</option>
                                                @foreach($parties as $p)
                                                    <option
                                                        value="{{ $p->id }}" {{ app('request')->input('parties_id') ==  $p->id?'selected':'' }}>
                                                        {{ $p->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Dates Between</label>
                                            <input type="text" name="date_start" placeholder="From" data-validation="required" autocomplete="off"
                                                   class="form-control " id="start_date" value="{{ app('request')->input('date_start') }}">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>&nbsp;</label>
                                            <input type="text" name="date_end" data-validation="required" autocomplete="off" placeholder="To"
                                                   class="form-control " id="end_date" value="{{ app('request')->input('date_end') }}">
                                        </div>
                                        <div class="col-md-1 form-group">
                                            <label class="btn-block">&nbsp;</label>
                                            <input type="submit" class="btn btn-primary btn-block"
                                            value="Search">

                                        </div>
                                        <div class="col-md-1 form-group" style="text-align: right;">
                                            <label class="btn-block">&nbsp;</label>
                                            <a href="{{ route('transactions') }}"
                                               class="" style="text-decoration: underline;"><h4>Clear</h4></a>
                                        </div>

                                       
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>

                    @if(!is_null($transactions) && $transactions->count() > 0)
                        <table class="table table-bordered ">
                            <thead>
                            <tr>
                                <th width="7%">Trans. #</th>
                                <th width="7%">Date</th>
                                <th >Passenger Name</th>
                                <th>Ticket No.</th>
                                <th>Sector</th>
                                <th>Airline PNR</th>
                               <!--  <th>Party</th> -->
                                <th>Staff</th>
                           <!--      <th>Supplier</th> -->
                                <th width="7%">Paid</th>
                                <th width="7%">Received</th>
                                <th width="7%">Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                 $balance = '';
                                 $paid = '';
                                 $received = '';
                                @endphp

                            @foreach($transactions as $t)
                                @php
                                 $remarks = '';
                                    if($t->trans_type == 'ticket'){
                                        if ($t->to == $id) {
                                            $received   = $t->cost;
                                            $paid       = 0;
                                            $balance    = $t->from_current_balance + $t->cost;
                                        }
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
                                        <td>{{ $t->trans_date }}</td>
                                        <td class="text-uppercase">{{ $t->ticket->given_name.' '.$t->ticket->surname }}</td>
                                        <td>{{ $t->ticket->ticket_no }}</td>
                                        <td>{{ $t->ticket->sector }}</td>
                                        <td>{{ $t->ticket->airline_pnr }}</td>
                                      <!--   <td>{{ $t->party->name }}</td> -->
                                        <td>{{ $t->ticket->admin->name }}</td>
                         <!--                <td>{{ $t->supplier->name }}</td> -->
                                        <td>{{ $paid }}</td>
                                        <td>{{ $received }}</td>
                                        <td class="{{ $red_td }}">{{ $balance }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $t->id }}</td>
                                        <td>{{ $t->trans_date }}</td>
                                        <td colspan="5">{{ $remarks }}</td>
                                        <td>{{ $paid }}</td>
                                        <td>{{ $received }}</td>
                                        <td class="{{ $red_td }}">{{ $balance }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        {!! $transactions->links() !!}
                        @else
                        @if(request()->has('date_start'))
                        <p style="text-align: center;font-size: 20px">No Record Found</p>
                        @endif
                    @endif
                </div>
            </div>
        </section>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
        $('#party').trigger("change");
        $('#supplier').trigger("change");

        function disableSelect(e) {

            var type = $(e).attr('id');

            /*if (type == 'supplier') {
                if ($(e).val() != '') {
                    $('#party').prop('selectedIndex', 0);
                    $('#party').attr('disabled', 'disabled');
                } else {
                    $('#party').removeAttr('disabled', 'disabled');
                }
                 $('#party').val('');
            } else if (type == 'party') {
                if ($(e).val() != '') {
                    $('#supplier').prop('selectedIndex', 0);
                    $('#supplier').attr('disabled', 'disabled');
                } else {
                    $('#supplier').removeAttr('disabled', 'disabled');
                }
                 $('#supplier').val('');
            }*/
        }
        function ShowSupplier(event) {
             if (event.value == 'supplier') {
                $('#partymain').hide();
                $('#suppliermain').show();
                $('#party').select2("val",'');
                 /*$('#party option:selected').removeAttr('selected');*/
             }else{
                $('#partymain').show();
                $('#suppliermain').hide();
                    $('#supplier').val('');
                   /*  $('#supplier option:selected').removeAttr('selected');*/
             }
        }
        $(document).ready(function(){
            $("#start_date").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                  endDate: new Date(),
                orientation: "bottom"
            }).on('changeDate', function(selected) {
               startDate = new Date(selected.date.valueOf());
               endDate = new Date($("#end_date").datepicker("getDate"));

               if (endDate < startDate) {
                $("#end_date").datepicker("setDate", "");
            }
            $('#end_date').datepicker('setStartDate', startDate);
        });

            $("#end_date").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                  endDate: new Date(),
                orientation: "bottom"
            }).on('changeDate', function(selected) {
            });
        });
    </script>
@endpush
