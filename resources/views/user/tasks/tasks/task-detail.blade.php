@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
    <div class="container">
        <section class="content-header">
            <h1>
                Task Detail
            </h1>
        </section>
        <section class="content">

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Status</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form action="{{ route('task-status') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="tasks_id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label class="control-label require">Status</label>
                                        <select class="form-control" name="statuses_id" id="statuses_id">
                                            <option value="">Select Status</option>
                                            @foreach($statuses as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label style="display: block;">&nbsp;</label>
                                        <label class="control-label require">Only Me &nbsp;
                                          <input type="checkbox" name="is_private" value="1"></label>
                                      </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label require">Remarks</label>
                                        <textarea type="text" class="form-control " name="remarks" id="remarks"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                   
                                            <button type="reset" class="btn btn-info btn-flat">Reset</button>
                                            <button class="btn btn-primary btn-flat pull-right" type="submit">Submit</button>
                                      
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered" id="taskDataTable">
                        <thead>
                        <tr>
                            <th width="8%">Inquiry No.</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Passenger Name</th>
                            <th>Phone</th>
                            <th>Party</th>
                            <th>Staff</th>
                            <th>Attachment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $t->id }}</td>
                            <td>{{ $t->created_at }}</td>
                            <td>{{ $t->type->name }}</td>
                            <td>{{ $t->pax_name }}</td>
                            <td>{{ $t->phone }}</td>
                            <td>{{ is_null($t->party)?'N/A':$t->party->name }}</td>
                            <td>{{ $t->admin->name }}</td>
                            <td>
                                @if(!is_null($t->attachment))
                                    @php $i = 1 @endphp
                                    @foreach($t->attachment as $a)
                                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" target="blank" class="btn btn-sm btn-success attach-btn">
                                            {{ $i++ }}
                                        </a>
                                    @endforeach
                                @endif
                                <a href="{{ url('admin/add-attachment').'/'.$t->id }}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    @if(count($history))
                        <h3>History</h3>
                    <table class="table table-bordered table-striped datatable" >
                        <thead>
                        <tr>
                            <th width="72%">Remarks</th>
                            <th width="8%">Status</th>
                            <th width="8%">Added By</th>
                            <th width="12%">Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($history as $h)
                        @if($h->is_private != 1)
                            <tr>
                                <td>{!! $h->remarks !!}</td>
                                <td>{{ $h->status->name }}</td>
                                <td>{{ $h->admin->name }}</td>
                                <td>{{ $h->created_at }}</td>
                            </tr>
                            @else
                            @if($h->admins_id == auth()->guard('admin')->user()->id)
                            <tr>
                                <td>{!! $h->remarks !!}</td>
                                <td>{{ $h->status->name }}</td>
                                <td>{{ $h->admin->name }}</td>
                                <td>{{ $h->created_at }}</td>
                            </tr>
                            @endif
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </section>
    </div>

@endsection

@push('script')

@endpush
