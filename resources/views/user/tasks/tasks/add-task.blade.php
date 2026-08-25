@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Task</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('save-task') }}" method="POST"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" value="{{isset($detail)?$detail->id:''}}">
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label class="control-label">Task Category</label>

                                    <select class="form-control" name="task_types_id" id="type" data-validation="required">
                                        <option value="">Select Task Category</option>
                                        <!-- <option value="tickets" {{isset($status) && $status->type == 'tickets'?'selected':''}}>Tickets</option>
                                        <option value="visas" {{isset($status) && $status->type == 'visas'?'selected':''}}>Visas</option>
                                        <option value="hotels" {{isset($status) && $status->type == 'hotels'?'selected':''}}>Hotels</option>
                                        <option value="packages" {{isset($status) && $status->type == 'packages'?'selected':''}}>Packages</option>
                                        <option value="umrah" {{isset($status) && $status->type == 'umrah'?'selected':''}}>Umrah</option>
                                        <option value="travel-insurance" {{isset($status) && $status->type == 'travel-insurance'?'selected':''}}>Travel Insurance</option>
                                        <option value="others" {{isset($status) && $status->type == 'others'?'selected':''}}>Others (Re-issue / Seat Allocation)</option> -->
                                       @foreach($taskTypes as $t)
                                       <option value="{{ $t->id }}" {{isset($detail) && $detail->task_types_id == $t->id?'selected':''}}>{{ $t->name }}</option>
                                       @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label class="control-label">Party</label>
                                    <select name="parties_id" id="parties_id" class='form-control select2' data-validation="required">
                                        <option value="">Select Party</option>
                                        @foreach($parties as $p)
                                        <option value="{{ $p->id }}" {{isset($detail) && $detail->vendees_id == $p->id?'selected':''}} data-phone="{{ $p->phone }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label">Phone #</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{isset($detail)?$detail->phone:''}}"/>
                                </div>
</div>
<div class="row">
                                <div class="col-md-4 form-group" id="status_div">
                                    <label class="control-label">Type</label>
                                    <select class="form-control" name="type" id="type" data-validation="required">
                                     <option value="1" {{isset($detail) && $detail->task_type == 1?'selected':''}}>Urgent</option>
                                     <option value="2" {{isset($detail) && $detail->task_type == 2?'selected':''}}>Important</option>
                                     <option value="3" {{isset($detail) && $detail->task_type == 3?'selected':''}}>Normal</option>
                              <!--        <option value="3" {{isset($detail) && $detail->task_type == 4?'selected':''}}>Followup</option> -->
                                    </select>
                                </div>
                                  <div class="col-md-4 form-group" id="status_div">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" name="statuses_id" id="statuses_id" data-validation="required">
                                        <option value="">Select Status</option>
                                        @foreach($statuses as $s)
                                        <option value="{{ $s->id }}" {{isset($detail) && $detail->last_status == $s->id?'selected':(!isset($detail) && empty($detail->last_status) && $s->id == '3'?'selected':'')}}>{{ $s->name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="history_id" value="{{isset($detail) && !is_null($detail->history) && $detail->history->count() > 0?$detail->history()->first()->id:''}}">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">Passenger Name</label>
                                    <input type="text" class="form-control text-uppercase" name="pax_name" value="{{isset($detail)?$detail->pax_name:''}}" id="pax_name" />
                                </div>
                                @if(auth()->guard('admin')->user()->type == 'admin')
                                <div class="col-md-4 form-group">
                                 <label>Staff</label>
                                 <select class="form-control" name="admins_id" data-validation="required">
                                  <option value="">Select</option>
                                  @foreach($admins as $a)
                                  <option value="{{ $a->id }}" {{isset($detail) && $detail->admins_id == $a->id?'selected':'' }}>
                                      {{ $a->name }}
                                  </option>
                                  @endforeach
                              </select>
                          </div>
                                @endif

                                <div class="col-md-12 form-group">
                                    <label class="control-label">Remarks</label>
                                    <textarea type="text" class="form-control" name="remarks" id="remarks">{!! isset($detail) && !is_null($detail->history) && $detail->history->count() > 0?str_replace('<br />','',$detail->history()->first()->remarks):'' !!}</textarea>
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
    </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
    $('#parties_id').change( function () {
        $('#phone').val($(this).find(":selected").data('phone'))
    });
</script>
@endpush
