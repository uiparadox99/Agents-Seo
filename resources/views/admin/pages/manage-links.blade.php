@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Useful Links
            <a href="{{ route('admin.add-link') }}" class="pull-right btn btn-success ">Add Link</a>
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
                                    <th>Img</th>
                                    <th>Name</th>
                                    <th>Link</th>
                                    <th width="7%">Active</th>
                                    <th width="7%">Show on Home?</th>
                                    <th width="7%">Airport?</th>
                                    <th width="7%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($links as $s)
                                <tr>
                                    <td>@if(!is_null($s->img))
                                        <img src="{{ url('storage/uploads/links/'.$s->img) }}" width="100px">
                                        @else
                                        @endif
                                    </td>
                                    <td>{{ $s->name }}</td>
                                    <td>
                                        {{ $s->link }}
                                    </td>
                                     <td>
                                        <form class="" method="get" action="" id="form{{$s->id}}">
                                            <input type="hidden" value="{{$s->id}}" name="active_id">
                                            <label><input onchange="$('#form{{$s->id}}').submit()" type="checkbox" name="active" value="1" {{$s->active == 1?'checked':''}}> Active</label>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="" method="get" action="" id="form2{{$s->id}}">
                                            <input type="hidden" value="{{$s->id}}" name="sidebar_id">
                                            <label><input onchange="$('#form2{{$s->id}}').submit()" type="checkbox" name="show_in_sidebar" value="1" {{$s->show_in_sidebar == 1?'checked':''}}> home?</label>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="" method="get" action="" id="form3{{$s->id}}">
                                            <input type="hidden" value="{{$s->id}}" name="airport_id">
                                            <label><input onchange="$('#form3{{$s->id}}').submit()" type="checkbox" name="airport" value="1" {{$s->airport == 1?'checked':''}}> Airport?</label>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-link', $s->id) }}">
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