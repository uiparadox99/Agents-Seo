@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Job Designations
            <a href="{{ url('admin/add-job-designation') }}" class="btn btn-primary pull-right">Add Job Designation</a>
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
                                    <!--<th>Image</th>-->
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $s)
                                <tr data-id="{{$s->id}}">
                                    <!--@if(empty($s->image))-->
                                    <!--<td>-->
                                    <!--    <img src="//placehold.it/200x200px" style="width: 100px;height: 100px">-->
                                    <!--</td>-->
                                    <!--@else-->
                                    <!--<td>-->
                                    <!--    <img src="{{url('storage/uploads/jobs/'.$s->image)}}"-->
                                    <!--        style="width: 100px;height: 100px">-->
                                    <!--</td>-->
                                    <!--@endif-->
                                    <td>
                                        {{ $s->name }}
                                    </td>
                                       <td>
                                        {{ $s->category->name }}
                                    </td>

                                    <td>
                                        <a href="{{url('admin/edit-job-designation/'.$s->id) }}">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil"></i></button></a>

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
        url: SITE_PATH + '/save-featured-blog',
        type: 'GET',
        data: {
            is_featured: is_home,
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