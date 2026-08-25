@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Custom Content
            <a href="{{ route('admin.add-content') }}" class="pull-right btn btn-success ">Add content</a>
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
                                    <th>Page</th>
                                    <th>Content</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($content as $s)
                                <tr>
                                    <td>{{ $s->title }}</td>
                                    <td>
                                        {{ str_limit($s->content,100) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-content', $s->id) }}">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil"></i></button></a> | <a
                                            href="{{ route('admin.delete-content', $s->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?');">
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

@endpush