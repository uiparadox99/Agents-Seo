@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        @if(auth()->user()->verified != 1)
        <div class="col-md-12">
            <div class="btn-danger btn-block mt-3 mb-0 p-2">
                <p class="mb-0 text-center">Your email is not verified please check your inbox</p>
            </div>
        </div>
        @endif
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box pt-0">

            <div class="agent-detail-box content-box-agent">
                <div class="row">
                    <div class="col-md-12">

                        <table class="table table-striped table-bordered">

                            @if($detail->type == 'airline' && !is_null($detail->airline))
                            {{-- @if($detail->type == 'airline' && !empty($detail->airline->img))
                            <tr>
                                <th>Logo</th>
                                <td> <img src="{{url('storage/uploads/airline/'.$detail->airline->img)}}" height="80"></td>
                            </tr>
                            @endif --}}
                            <tr>
                                <th>Airline</th>
                                <td>{{$detail->airline->name}}</td>
                            </tr>
                            @endif
                            @if(!empty($detail->name))
                            <tr>
                                <th>Name</th>
                                <td>{{$detail->name}}</td>
                            </tr>
                            @endif
                            @if(!empty($detail->email))
                            <tr>
                                <th>Email</th>
                                <td>{{$detail->email}}</td>
                            </tr>
                            @endif

                        </table>

                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection