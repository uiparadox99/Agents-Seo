@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Visas
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
                                    <th>Visa Country</th>
                                    <th>Is home</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($countries as $v)
                                @php
                                $check = Auth::guard('admin')->user()->type !=
                                'admin'?in_array($v->country_id,$assigned): !in_array($v->country_id,$assigned);
                                @endphp
                                @if($check)
                                <tr data-id="{{ $v->countries_id }}">
                                    <td>{{ unslug($v->country_name) }}</td>

                                    <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $v->country_home == 1?'checked':'' }}><span
                                            class="top<?php echo $v->id; ?>"></span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-visa', $v->countries_id) }}"
                                            class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                        <?php if (auth()->guard('admin')->user()->type == 'admin'): ?> <a
                                            href="{{ route('admin.delete-visa', $v->countries_id) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> <?php endif ?>
                                    </td>
                                </tr>
                                @endif
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
        url: SITE_PATH + '/save-home-countries',
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