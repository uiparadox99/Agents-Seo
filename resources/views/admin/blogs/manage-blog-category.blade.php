@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Blogs Categories
            <a href="{{ route('admin.add-blog-category') }}" class="btn btn-primary pull-right">Add category</a>
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
                                    <th>Name</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $s)
                                <tr>
                                    <td>
                                        {{ $s->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-blog-category', $s->id) }}">
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

@endpush