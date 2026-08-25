@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Allow Agent Packages
            <a href="{{ route('admin.add-show-package') }}" class="btn btn-primary pull-right">Add</a>
        </h1>

    </section>
@php    $beforetoday =  date("d-M-Y", strtotime("today - 1 week") ); $today =  date("d-M-Y", strtotime("today") ); @endphp
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover datatables">
                            <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>Expiry</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach($shows as $s)
                                @if(strtotime($beforetoday) == strtotime($s->expire))
                                <tr class="btn-warning" style="background: #f39c12">
                                @elseif(strtotime($s->expire) <= strtotime($today))
                                <tr class="btn-danger"  style="background: #dd4b39" >
                                    @else
                                <tr>
                                    @endif
                                    <td>{{ $s->bis}}</td>
                                    <td>
                                        {{ date('d M Y',strtotime($s->expire)) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-show-package', $s->id) }}">
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