@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Cities
            <a href="{{ route('admin.add-cities') }}" class="btn btn-primary pull-right">Add City</a>
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
                                    <th>Jobs</th>
                                    <th>Sasti Tickets</th>
                                    <th>Umrah Tickets</th>
                                    <th>For Embassy?</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $s)
                                <tr>
                                    <td>{{ $s->countries->country }}</td>
                                    <td>
                                        {{ $s->name }}
                                    </td>
                                    <td>
                                        <form method="get" action="" id="form1{{$s->id}}">
                                            <input type="hidden" name="edit_id" value="{{$s->id}}">
                                            <input type="hidden" name="type" value="jobs">
                                            <label><input type="checkbox" name="jobs" value="1" onchange="$('#form1{{$s->id}}').submit()" {{$s->jobs == 1?'checked':''}}> Jobs?</label>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="get" action="" id="form2{{$s->id}}">
                                            <input type="hidden" name="edit_id" value="{{$s->id}}">
                                               <input type="hidden" name="type" value="sasti_ticket">
                                            <label><input type="checkbox" name="sasti_ticket" value="1" onchange="$('#form2{{$s->id}}').submit()" {{$s->sasti_ticket == 1?'checked':''}}> Sasti Tickets?</label>
                                        </form>
                                    </td>
                                        <td>
                                        <form method="get" action="" id="form3{{$s->id}}">
                                            <input type="hidden" name="edit_id" value="{{$s->id}}">
                                               <input type="hidden" name="type" value="airport">
                                            <label><input type="checkbox" name="airport" value="1" onchange="$('#form3{{$s->id}}').submit()" {{$s->airport == 1?'checked':''}}> Umrah Tickets?</label>
                                        </form>
                                    </td>
                                       <td>
                                        <form method="get" action="" id="form4{{$s->id}}">
                                            <input type="hidden" name="edit_id" value="{{$s->id}}">
                                               <input type="hidden" name="type" value="embassy">
                                            <label><input type="checkbox" name="for_embassy" value="1" onchange="$('#form4{{$s->id}}').submit()" {{$s->type == 'embassy'?'checked':''}}> Embassy?</label>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-city', $s->id) }}">
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