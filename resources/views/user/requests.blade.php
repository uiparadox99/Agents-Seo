@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
            <h3>Applicant Requests</h3>
            <div  class="table-responsive content-box-agent">
                @if($requests->count() > 0)
                <table class="table table-borderd table-striped">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Applicant Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>CV</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $r)
                        <tr data-id="{{ $r->id }}">
                            <td>{{$r->category}}</td>
                            <td>{{$r->name}}</td>
                            <td class="number-style">{{$r->email}}</td>
                            <td class="number-style">{{$r->number}}</td>
                            <td> @if(!is_null($r->jobAttachements) && $r->jobAttachements->count() > 0)
                                @php
                                $count = '0';
                                @endphp
                                @foreach($r->jobAttachements as $j)
                                @php
                                $count++;
                                @endphp
                                <a href="{{url('storage/uploads/jobs/'.$j->attachment)}}" download>Download
                                    {{$count}}</a>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $requests->links() !!}
                @else
                <p class="no-record">No Applicant Requests</p>
                @endif
            </div>
        </div>
    </div>
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
        url: SITE_PATH + '/active-review',
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