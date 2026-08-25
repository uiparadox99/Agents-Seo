@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Section
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
                                    <th>Title</th>
                                    <th>Open</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($section as $s)
                                <tr>
                                    <td>{{ $s->title }}</td>
                                    <td>
                                        @if($s->open == 1)
                                        <b class="text-success">Yes</b>
                                        @else
                                        <b class="text-danger">No</b>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-section', $s->id) }}">
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