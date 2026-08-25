@extends('admin.layout.master')
@section('title', 'Plan')
@section('pageTitle', 'Manage Plan')
@section('pageTitleSub', 'Manage')
@section('content')
<?php $GeneralClasses = 'form-control'; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Status
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Status</li>
        </ol>
    </section>

    <section class="content">
        <?php $d = !empty($modal)? $modal : ""; ?>
        {!! Form::model($modal, array('route' => array('admin.plan', !empty($modal)?$d->id:""),
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
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-3">
                                {!! Form::text("name", null, ['class'=>'validate[required] '.$GeneralClasses,
                                'placeholder'=>'Name']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-3">
                                {!! Form::textarea("description", null, ['class'=>$GeneralClasses]) !!}
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div> <!-- /.row -->

        {!! Form::close() !!}
    </section>
</div>.
@endsection