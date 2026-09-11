@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Blogs
            <a href="{{ route('admin.add-blog') }}" class="btn btn-primary pull-right">Add Blog</a>
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border" style="padding-bottom: 10px;">
                        <div class="btn-group">
                            <a href="{{ route('admin.blogs') }}" class="btn btn-{{ empty($featuredFilter) ? 'primary' : 'default' }}">All Blogs ({{ \App\Blogs::count() }})</a>
                            <a href="{{ route('admin.blogs') }}?featured=1" class="btn btn-{{ $featuredFilter == '1' ? 'warning' : 'default' }}">⭐ Featured Only ({{ \App\Blogs::where('is_featured', 1)->count() }})</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover datatables">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Is Featured ?</th>
                                    <th>content</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $s)
                                <tr data-id="{{$s->id}}">
                                    <td>
                                        <img src="{{ $s->image_url }}" onerror="this.onerror=null;this.src='{{ asset('images/blog-default.jpg') }}';" width="100px" style="height: 65px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td>
                                        {{ $s->title }}
                                    </td>
                                    <td>
                                        {{ !empty($s->blogsCategory)?$s->blogsCategory->name:'' }}
                                    </td>
                                    <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $s->is_featured == 1?'checked':'' }}><span
                                            class="top<?php echo $s->id; ?>"></span>
                                    </td>
                                    <td>
                                        {{ strip_tags(str_limit($s->content,100)) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-blog', $s->id) }}">
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