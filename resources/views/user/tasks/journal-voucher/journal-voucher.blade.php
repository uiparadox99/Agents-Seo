@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    @php

        $id             = isset($trans)?$trans->id:'';
        $trans_date     = isset($trans)?$trans->trans_date:'';
        $from           = isset($trans)?$trans->from:'';
        $to             = isset($trans)?$trans->to:'';
        $from_remarks   = isset($trans)?$trans->from_remarks:'';
        $to_remarks     = isset($trans)?$trans->to_remarks:'';
        $amount         = isset($trans)?$trans->amount:'';
        $mode           = isset($trans)?$trans->payment_mode:'';

    @endphp

    <div class="container">
        <section class="content-header">
            <h1>
                Journal Voucher
            </h1>
            <ol class="breadcrumb">
                <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Journal Voucher</li>
            </ol>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Journal Voucher</h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <div class="row ">
                        <div class="col-md-6 col-md-offset-3">
                            <form action="{{ route('save-journal-voucher') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="control-label require">From</label>
                                        <select name="from"  class="form-control" data-validation="required">
                                            <option value="">Select From</option>
                                            @foreach($vendees as $v)
                                                <option value="{{ $v->id }}" {{ $from == $v->id?'selected':'' }}>
                                                    {{ $v->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-8 form-group">
                                        <label class="control-label require">Info</label>
                                        <input type="text" class="form-control from-info" name="from_remarks" value="{{ $from_remarks }}">
                                    </div>
                                </div>

                                <div class="row to">
                                    <div class="col-md-4 form-group">
                                        <label class="control-label require">To</label>
                                        <select name="to" class="form-control" data-validation="required">
                                            <option value="">Select To</option>
                                            @foreach($vendees as $v)
                                                <option value="{{ $v->id }}" {{ $to == $v->id?'selected':'' }}>
                                                    {{ $v->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-8 form-group">
                                        <label class="control-label require">Info</label>
                                        <input type="text" class="form-control to-info" name="to_remarks" value="{{ $to_remarks }}">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label require">Amount</label>
                                        <input placeholder="Amount" class="form-control" name="amount" type="text" data-validation="number" data-validation-error-msg="Only Digit" value="{{ $amount }}">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label require">Payment Mode</label>
                                        <select class="form-control" name="payment_mode">
                                            <option value="Cash" {{ $mode == 'Cash'?'selected':'' }}>Cash</option>
                                            <option value="Check" {{ $mode == 'Check'?'selected':'' }}>Check</option>
                                            <option value="Bank Transfer" {{ $mode == 'Bank Transfer'?'selected':'' }}>Bank Transfer</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label require">Date</label>
                                        <input placeholder="Date" class="form-control today-date" name="trans_date" type="text" data-validation="required" value="{{ $trans_date  }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                 
                                            <button type="reset" class="btn btn-info btn-flat">Reset</button>
                                            <button class="btn btn-primary btn-flat pull-right" type="submit">Submit</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script type="text/javascript">

        $('.from-info').on('keyup', function () {
            $('.to-info').val($(this).val())
        });




        $("select[name=from]").on('change', function () {
            var $this = $(this);
            $("select[name=to] option").each(function(i,v) {
                if (  $this.find(":selected").val() == $(v).val() && $(v).val() != '') {
                    $(v).hide();
                }else{
                    $(v).show();
                }
            });

        })


    </script>
@endpush
