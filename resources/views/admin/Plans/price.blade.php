@extends('admin.layout.master')
@section('title', 'Plan')
@section('pageTitle', 'Manage Plan')
@section('pageTitleSub', 'Manage')
@section('content')
<?php $GeneralClasses = 'form-control'; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Plan
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Plan</li>
        </ol>
    </section>

    <section class="content">
        <?php $d = !empty($modal)? $modal : ""; ?>
        {!! Form::model($modal, array('route' => array('admin.price', !empty($modal)?$d->id:""),
        'class'=>'form-horizontal form-validation', 'enctype'=>'multipart/form-data')) !!}
        <div class="row">

            <!-- right column -->
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Basic Information</h3>
                        <button type="submit" class="btn btn-info pull-right">Save</button>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                        <div class="form-group">
                            <label for="plan" class="col-sm-2 control-label">Plan</label>
                            <div class="col-sm-4">
                                <select class="validate[required]  <?php echo $GeneralClasses; ?>" name="plan">
                                <!--     <option value="">Select</option> -->
                                    @foreach($plans as $p)
                                    @if($p->id != 5)
                                    <option value="{{ $p->id }}"
                                        {{ !empty($d) && $p->id == $d->plan_id?"selected":"" }}>{{ $p->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">Price for 1 year</label>
                            <div class="col-sm-4">
                                {!! Form::text("price", null, ['class'=>'validate[required] '.$GeneralClasses,
                                'placeholder'=>'Price']) !!}
                            </div>
                            <label for="price" class="col-sm-2 control-label">Price for 2 year</label>
                            <div class="col-sm-4">
                                {!! Form::text("price_2year", null, ['class'=>'validate[required] '.$GeneralClasses,
                                'placeholder'=>'Price']) !!}
                            </div>
                            <!-- <label for="price_per_year" class="col-sm-2 control-label">Price Per Year</label>
                    <div class="col-sm-4">
                        {!! Form::text("price_per_year", null, ['class'=>$GeneralClasses, 'placeholder'=>'Name']) !!}
                    </div> -->
                        </div>
                  <!--       <div class="form-group">
                            <label for="discount_price" class="col-sm-2 control-label">Discount by price</label>
                    <div class="col-sm-4">
                        {!! Form::text("discount_price", null, ['class'=>$GeneralClasses, 'placeholder'=>'Discount by price']) !!}
                    </div>
                            <label for="discount_percentage" class="col-sm-2 control-label">Discount percentage</label>
                            <div class="col-sm-4">
                                {!! Form::text("discount_percentage", null, ['class'=>$GeneralClasses,
                                'placeholder'=>'Discount by percentage']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount_start_date" class="col-sm-2 control-label">Discount start date</label>
                            <div class="col-sm-4">
                                {!! Form::text("discount_start_date", null, ['class'=>$GeneralClasses,
                                'placeholder'=>'Discount start date']) !!}
                            </div>
                            <label for="discount_end_date" class="col-sm-2 control-label">Discount end date</label>
                            <div class="col-sm-4">
                                {!! Form::text("discount_end_date", null, ['class'=>$GeneralClasses,
                                'placeholder'=>'Discount end date']) !!}
                            </div>
                        </div> -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div> <!-- /.row -->

        {!! Form::close() !!}
    </section>
</div>

@endsection