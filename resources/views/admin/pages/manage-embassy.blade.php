@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Embassy Pages
            <a href="{{ route('admin.add-embassy') }}" class="pull-right btn btn-success ">Add Emabassy Page</a>
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
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Title</th>
                                    <th>Address</th>
                                    <th>phone</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($embassy as $s)
                                <tr>

                                    <td>{{ isset($s->country)?$s->country->country:'' }}</td>
                                    <td>{{ isset($s->city)?$s->city->name:'' }}</td>
                                    <td><a href="{{url($s->slug)}}" target="_blank">{{ $s->title }}</a></td>
                                    <td>
                                        {{$s->address}}
                                    </td>
                                    <td>
                                        {{$s->phone}}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-embassy', $s->id) }}">
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