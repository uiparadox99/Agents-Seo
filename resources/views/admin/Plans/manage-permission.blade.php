@extends('admin.layout.master')
@section('title', 'Plans')
@section('pageTitle', 'Manage Plans')
@section('pageTitleSub', 'Manage')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Permissions
            <small>Manage</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manage Permissions</li>
        </ol>
    </section>

    <section class="content">

        @if(!empty(Session::get("msg")))
        @include("admin.includes.notification")
        @endif

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Permission</h3>
                        <a href="{!! URL::to('admin/permission') !!}"
                            class="pull-right btn btn-facebook actionBtn">Add</a>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach($plans as $d)
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $d->name ; ?></td>
                                    <td><?php echo $d->code ; ?></td>
                                    <td class="actionBtn">
                                        <a href="{!! URL::to('admin/permission/'.$d->id) !!}" class="actionBtn"
                                            title="Edit"><i class="fa fa-edit"></i></a>
                                        <!--<a href="{!! URL::to('admin/designation-delete/'.$d->id) !!}" class="actionBtn" title="Delete"><i class="fa fa-trash-o"></i></a>-->
                                    </td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.box -->
                </div>

            </div>
            <!-- /.col -->
        </div>
    </section>
</div>
@endsection