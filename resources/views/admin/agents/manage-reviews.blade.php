@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Agents Reviews
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
                                    <th>Attachment</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Rating</th>
                                    <th>Message</th>
                                    <th>Active / Inactive</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $r)
                                <tr data-id="{{ $r->id }}">
                                    <td>
                                        @if(empty($r->attachement))
                                        <img src="{{url('images/placeholder.jpg')}}" alt=""
                                            style="width:200px;height:100px;">
                                        @else
                                        <img src="{{url('storage/uploads/agents/'.$r->attachement)}}" alt=""
                                            style="width:200px;height:100px;">
                                            @endif
                                        </td>
                                    <td>{{$r->user->name}}</td>
                                    <td>{{$r->agent->business_name}}</td>
                                    <td>{{$r->rating}}</td>
                                    <td>{{$r->message}}</td>
                                    <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $r->active == 1?'checked':'' }}><span
                                            class="top<?php echo $r->id; ?>"></span>
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
        url: MAIN_PATH + '/active-review',
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