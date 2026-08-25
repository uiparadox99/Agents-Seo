@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Quick Links
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
                                    <th>Section</th>
                                    <th>Visas Country</th>
                                    <th>Visas Linked</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quick_links as $s)
                                <tr>
                                    <td>{{ $s->section->title }}</td>
                                    <td>
                                        {{ $s->country->country }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.delete-quick-links', $s->id) }}">
                                            <button class="btn btn-danger btn-sm"><i
                                                    class="fa fa-times"></i></button></a>
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