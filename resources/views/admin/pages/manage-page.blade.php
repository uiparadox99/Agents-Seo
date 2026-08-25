@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Pages Content
            <a href="{{ route('admin.add-page') }}" class="pull-right btn btn-success ">Add Page</a>
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
                                @foreach($pages as $s)
                                <tr>
                                    <td>{{ $s->page }}</td>
                                    <td>
                                        {{ str_limit(strip_tags($s->content), 100) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-page', $s->id) }}">
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