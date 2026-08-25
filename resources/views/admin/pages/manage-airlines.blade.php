@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Airlines
            <a href="{{ route('admin.add-airline') }}" class="btn btn-primary pull-right">Add Airline</a>
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
                                    <th>Image</th>
                                    <th>Image Alt</th>
                                    <th>Country</th>
                                    <th>Name</th>
                                    <th>Content</th>
                                    <th>User</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airlines as $s)
                                <tr>
                                    <td>@if(!empty($s->img))
                                        <img src="{{ url('storage/uploads/airline/'.$s->img) }}" width="100px">
                                        @else
                                        <img src="//placehold.it/150x150">
                                        @endif
                                    </td>
                                    <td>{{ $s->image_alt }}</td>
                                    <td>{{ $s->countries->country }}</td>
                                    <td>
                                        {{ $s->name }}
                                    </td>
                                    <td>
                                        {{ strip_tags(str_limit($s->content,100)) }}
                                    </td>
                                    <td>
                                        {{ !is_null($s->user)?$s->user->name:'' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-airline', $s->id) }}" title="Edit">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil"></i></button></a> <a
                                            href="{{ route('admin.add-fares', $s->id) }}" title="Fares">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="fa fa-money"></i></button></a>
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