@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Related Sites
            <a href="{{ route('admin.add-related') }}" class="btn btn-primary pull-right">Add Related Site</a>
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
                                    <th>Flag</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <!--  <th>Description</th> -->
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedSites as $s)
                                <tr data-id="{{$s->id}}">
                                    <td>
                                        @if(!empty($s->logo))
                                        <img src="{{ url('storage/uploads/related/'.$s->logo) }}" width="100px">
                                        @else
                                        <img src="//placehold.it/150x150">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $s->title }}
                                    </td>
                                    <td>
                                        {{ $s->link }}
                                    </td>
                                    <!--  <td>
                                 {{ strip_tags(str_limit($s->description,100)) }}
                                                                </td> -->
                                    <td>
                                        <a href="{{ url('admin/edit-related/'.$s->id) }}">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil"></i></button></a>
                                        |
                                        <a href="{{ url('admin/delete-related/'.$s->id) }}"
                                            onclick="return confirm('Are you sure you want to delete it.')">
                                            <button class="btn btn-danger btn-sm"><i
                                                    class="fa fa-trash"></i></button></a>

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