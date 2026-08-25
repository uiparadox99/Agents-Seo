@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Job Applications
            <!-- <a href="{{ url('admin/add-job-category') }}" class="btn btn-primary pull-right">Add Job Category</a> -->
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover datatables">
                            <thead>
                                <tr>
                            <th>Date</th>
                            <th>Job Title</th>
                            <th>Applicant Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>Approved ?</th>
                            <th>CV</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $r)
                        <tr data-id="{{ $r->id }}">
                             <td>{{date('d M Y',strtotime($r->created_at))}}</td>
                            <td>{{$r->category}}</td>
                            <td>{{$r->name}}</td>
                            <td>{{$r->email}}</td>
                            <td>{{$r->number}}</td>
                                <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $r->approved == 1?'checked':'' }}><span
                                            class="top<?php echo $r->id; ?>"></span>
                                    </td>
                            <td> @if(!is_null($r->jobAttachements) && $r->jobAttachements->count() > 0)
                                @php
                                $count = '0';
                                @endphp
                                @foreach($r->jobAttachements as $j)
                                @php
                                $count++;
                                @endphp
                                 <a href="{{url('storage/uploads/jobs/'.$j->attachment)}}" target="_blank" class="btn btn-warning btn-sm" >Open
                                    {{$count}}</a>
                                <a href="{{url('storage/uploads/jobs/'.$j->attachment)}}" class="btn btn-primary btn-sm" download>Download
                                    {{$count}}</a>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
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
        url: SITE_PATH + '/applicant-approved',
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