@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
@php
$permissionsData = auth()->guard('admin')->user()->permissions;
$permissions = array();
foreach($permissionsData as $p){
$permissions[] = $p->code;
}
@endphp
<div class="container">
   <section class="content-header">
      @if(isset($searched))
      <h1>
         Manage Tasks
         <ul class="top-search-btns">
            <li><a href="{{url('admin/manage-tasks?searched=yes')}}">All</a></li>
           @foreach($admins as $a)
              <li><a href="{{url('admin/manage-tasks?admins_id='.$a->id)}}">{{ $a->name }}</a></li>
           @endforeach
         </ul>
         <div class="pull-right show-on-dekstop">
            <a href="javascript:;" data-toggle="collapse" data-target="#search" class="btn btn-success btn-sm"><i class="fa fa-filter"></i> filters</a>
            <a href="{{ route('add-task') }}" class="btn btn-danger btn-sm">Add Task</a>
         </div>
        
      </h1>
      @endif
     
      {{-- <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Manage Tasks</li>
      </ol> --}}
   </section>
   <section class="content">
      <div class="box">
         @if(isset($searched))
         @if(request()->has('date_start'))
         <div class="box-header with-border">
          
            <h3 class="box-title">
               <!-- Manage Tasks &nbsp; --> 
               @if(request()->has('date_start') && !empty(request()->get('date_start'))) <strong>Results For </strong> {{request()->get('date_start')}} @endif @if(request()->has('date_end') && !empty(request()->get('date_end'))) To {{request()->get('date_end')}} @endif &nbsp;
               @if(request()->has('inquiry_num') && !empty(request()->get('inquiry_num'))) <strong>Inquiry No: </strong> {{request()->get('inquiry_num')}} @endif &nbsp; @if(request()->has('admins_id') && !empty(request()->get('admins_id'))) <strong>Staff: </strong> {{isset($adminAdded) && !is_null($adminAdded)?$adminAdded->name:''}} @endif &nbsp; @if(request()->has('statuses_id') && !empty(request()->get('statuses_id')) && request()->get('statuses_id') != 'all') <strong>Status: </strong> {{isset($statusAdded) && !is_null($statusAdded)?$statusAdded->name:''}} @endif &nbsp; @if(request()->has('task_types_id') && !empty(request()->get('task_types_id'))) <strong>Type: </strong> {{isset($typeAdded) && !is_null($typeAdded)?$typeAdded->name:''}} @endif &nbsp;  @if(request()->has('parties_id') && !empty(request()->get('parties_id'))) <strong>Party: </strong> {{isset($partyAdded) && !is_null($partyAdded)?$partyAdded->name:''}} @endif &nbsp;  @if(request()->has('pax_name') && !empty(request()->get('pax_name'))) <strong>Name: </strong> {{request()->get('pax_name')}} @endif &nbsp;  @if(request()->has('phone') && !empty(request()->get('phone'))) <strong>Phone: </strong> {{request()->get('phone')}} @endif
            </h3>
           
            <!--   <div class="box-tools pull-right">
               <a href="{{ route('add-task') }}" class="btn btn-danger btn-sm btn-block">Add Task</a>
               </div> -->
         </div>
         @endif
      
         <div class="box-body">
          <div class="row show-on-mobile">
            <div class="col-xs-6">
                 <a href="{{ route('add-task') }}" class="btn btn-danger btn-sm">Add Task</a>
            </div>
            <div class="col-xs-6 text-right">
          <button data-toggle="collapse" data-target="#search" class="btn btn-sm btn-primary " >Filters</button>
              
            </div>
          </div>
            <div id="search" class="collapse ">
               <form class="form-validation" method="GET">

                  <div class="filters" style="margin-top: 10px">
                     <div class="row">
                        <div class="col-md-2 form-group" >
                           <div class="row tasks-dates">
                              <div class="col-xs-6">
                                 <label>Dates Between</label>
                                 <input type="text" name="date_start" placeholder="From" autocomplete="off" class="form-control datepicker" value="{{ app('request')->input('date_start') }}">
                              </div>
                              <div class="col-xs-6">
                                 <label>&nbsp;</label>
                                 <input type="text" name="date_end" autocomplete="off" placeholder="To" class="form-control datepicker" value="{{ app('request')->input('date_end') }}">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-2 form-group">
                           <label>Party Name</label>
                           <select name="parties_id" class="form-control select2">
                              <option value="">All</option>
                              @foreach($parties as $p)
                              <option value="{{ $p->id }}" {{ app('request')->input('parties_id') == $p->id?'selected':'' }}>
                              {{ $p->name }}
                              </option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-md-1 form-group">
                           <label>Inquiry No.</label>
                           <input type="text" name="inquiry_num" class="form-control" value="{{ app('request')->input('inquiry_num') }}">
                        </div>
                        <div class="col-md-1 form-group col-xs-6">
                           <label>Staff</label>
                           <select class="form-control" name="admins_id">
                              <option value="all">All</option>
                              @foreach($admins as $a)
                              <option value="{{ $a->id }}" {{ app('request')->input('admins_id') == $a->id?'selected':(app('request')->input('admins_id') != 'all' && auth()->guard('admin')->user()->type == 'employee' && auth()->guard('admin')->user()->id == $a->id?'selected':'') }}>
                              {{ $a->name }}
                              </option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-md-1 form-group col-xs-6">
                           <label>Task Status</label>
                           <select class="form-control" name="statuses_id">
                              <option value="all">All</option>
                              @foreach($statuses as $s)
                              <option value="{{ $s->id }}" {{ app('request')->input('statuses_id') == $s->id?'selected':'' }}>
                              {{ $s->name }}
                              </option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-md-1 col-xs-6">
                           <label> Category</label>
                           <select class="form-control" name="task_types_id">
                              <option value="">All</option>
                              @foreach($taskTypes as $t)
                              <option value="{{ $t->id }}" {{ app('request')->input('task_types_id') == $t->id?'selected':'' }}>
                              {{ $t->name }}
                              </option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-md-1 col-xs-6">
                           <label> Type</label>
                           <select class="form-control" name="position_type">
                              <option value="">All</option>
                              <option value="1" {{request()->has('position_type') && request()->get('position_type') == 1?'selected':''}}>Urgent</option>
                              <option value="2" {{request()->has('position_type') && request()->get('position_type') == 2?'selected':''}}>Important</option>
                              <option value="3" {{request()->has('position_type') && request()->get('position_type') == 3?'selected':''}}>Normal</option>
                           </select>
                        </div>
                        <div class="col-md-1 col-xs-6">
                           <label  >&nbsp;</label><br>
                           <input type="submit" class="btn btn-success btn-block" value="Search">
                        </div>
                        <div class="col-md-1 col-xs-6">
                           <label  >&nbsp;</label><br>
                           <a href="{{ route('manage-tasks') }}" class="btn btn-primary btn-block">All</a>
                        </div>
                       
                     </div>
                  </div>
               </form>
            </div>
            <hr>
            <div class="show-on-dekstop">
              
        
            <table class="table task-table" style="">
               <thead>
                  <tr>
                     <th width="6%">Inquiry No.</th>
                     <th  width="9%">Date</th>
                     <th  width="5%">Category</th>
                     <th width="15%">Passenger Name</th>
                     <th  width="5%">Type</th>
                     <th width="8%">Phone</th>
                     <th  width="22%">Party</th>
                     <th  width="8%">Staff</th>
                     <th>Action</th>
                     {{--
                     <th>Action</th>
                     --}}
                  </tr>
               </thead>
               <tbody id="myGroup">
                  @foreach($tasks as $t)   
                  <tr class="entries">
                     <td style="padding: 0"><a href="javascript:;" class="btn-block" style="padding: 8px;font-size: 17px;"  aria-expanded="false" aria-controls="detail{{ $t->id }}" onclick=" $('#detail{{ $t->id }}').show();$('.entries').hide()"><strong>{{ $t->id }}</strong></a></td>
                     <td>{{ date('d-M-Y (H:s)',strtotime($t->created_at)) }}</td>
                     <td>{{ !is_null($t->type) && !empty($t->type->name)?$t->type->name:'' }}</td>
                     <td class="text-uppercase">{{ $t->pax_name }}</td>
                     <td style="{{$t->task_type == 1?'color:red':($t->task_type == 2?'color:blue':($t->task_type == 3?'color:green':''))}};text-transform:capitalize;">{{$t->task_type == 1?'Urgent':($t->task_type == 2?'Important':($t->task_type == 3?'Normal':($t->task_type == 4?'Followup':'')))}}</td>
                     <td>{{ $t->phone }}</td>
                     <td>
                        @if(!is_null($t->party))
                        <a href="{{url('admin/manage-tasks?admins_id=all&parties_id='.$t->party->id)}}">{{ !is_null($t->party)?$t->party->name:'N/A' }}</a>
                        @endif
                     </td>
                     <td>{{ !is_null($t->admin)?$t->admin->name:'' }}</td>
                     <td>
                        @if(!is_null($t->attachment))
                        @php $i = 1 @endphp
                        @foreach($t->attachment as $a)
                        @if($a->is_private != 1 )
                        @if(strpos($a->img,".pdf"))
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @else
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @endif
                        @else
                        @if($t->admins_id == auth()->guard('admin')->user()->id)
                        @if(strpos($a->img,".pdf"))
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe>" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @else
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @endif
                        @endif
                        @endif
                        @endforeach
                        @endif
                        <a href="{{ url('admin/add-attachment').'/'.$t->id }}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i></a>
                        @if(auth()->guard('admin')->user()->type == 'admin' || in_array('edit_task',$permissions))
                        <a href="{{ url('admin/edit-task/'.$t->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        @endif
                     </td>
                     {{--
                     <td>--}}
                        {{--<button class="btn btn-sm btn-info" data-record='{{ json_encode($t) }}' onclick="updateInfo(this)">Edit</button>--}}
                        {{--
                     </td>
                     --}}
                  </tr>
                  <tr id="detail{{$t->id}}" class="collapse" data-parent="#myGroup">
                     <td colspan="9">
                        <section class="content" style="background: #f0f0f0">
                           <!--  <h2>
                              Task Detail
                              </h2> -->
                           <div class="box box-default">
                              <div class="box-header with-border">
                                 <h3 class="box-title">Change Status</h3>
                              </div>
                              <div class="box-body">
                                 <div class="row">
                                    <div class="col-md-6 ">
                                       <table class="table table-bordered">
                                          <tr>
                                             <th width="20%">Enquiry No</th>
                                             <td width="30%"><a href="javascript:;" onclick="$('#detail{{$t->id}}').hide(); $('.entries').show()">{{$t->id}}</a></td>
                                             <th width="20%">Passenger Name</th>
                                             <td width="30%" class="text-uppercase">{{$t->pax_name}}</td>
                                          </tr>
                                          <tr>
                                             <th width="20%">Date</th>
                                             <td width="30%">{{ date('d-M-Y (H:s)',strtotime($t->created_at)) }}</td>
                                             <th width="20%">Party</th>
                                             <td width="30%">{{ !is_null($t->party)?$t->party->name:'N/A' }}</td>
                                          </tr>
                                          </tr>
                                          <tr>
                                             <th width="20%">Category</th>
                                             <td width="30%">{{ !is_null($t->type) && !empty($t->type->name)?$t->type->name:'' }}</td>
                                             <th width="20%">Phone</th>
                                             <td width="30%">{{$t->phone}}</td>
                                          </tr>
                                          <tr>
                                             <th width="20%">Staff</th>
                                             <td width="30%">{{ !is_null($t->admin)?$t->admin->name:'' }}</td>
                                             <th width="20%">Attachments</th>
                                             <td width="30%">@if(!is_null($t->attachment))
                                                @php $i = 1 @endphp
                                                @foreach($t->attachment as $a)
                                                @if($a->is_private != 1 )
                                                @if(strpos($a->img,".pdf"))
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @else
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @endif
                                                @else
                                                @if($t->admins_id == auth()->guard('admin')->user()->id)
                                                @if(strpos($a->img,".pdf"))
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe>" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @else
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @endif
                                                @endif
                                                @endif
                                                @endforeach
                                                @endif
                                                <a href="{{ url('admin/add-attachment').'/'.$t->id }}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i></a>
                                             </td>
                                          </tr>
                                       </table>
                                       <form action="{{ route('task-status') }}" method="POST" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="tasks_id" value="{{ $t->id }}">
                                          <div class="form-group" style="    margin-top: 30px;">
                                             <label class="control-label require">Remarks</label>
                                             <textarea type="text" class="form-control " name="remarks" id="remarks"></textarea>
                                          </div>
                                          <div class="row">
                                             <div class="col-sm-2 ">
                                                <button type="reset" class="btn btn-block btn-info btn-flat">Reset</button>
                                             </div>
                                             <div class="col-sm-6 ">
                                                <!--           <label class="control-label require">Status</label> -->
                                                <select class="form-control" name="statuses_id" id="statuses_id" data-validation="required">
                                                   <option value="">Select Status</option>
                                                   @foreach($statuses as $s)
                                                   <option value="{{ $s->id }}" {{$s->id == '3'?'selected':''}}>{{ $s->name }}</option>
                                                   @endforeach
                                                </select>
                                             </div>
                                             <div class="col-sm-2 ">
                                                <!--  <label style="display: block;">&nbsp;</label> -->
                                                <label class="control-label require">Only Me &nbsp;
                                                <input type="checkbox" name="is_private" value="1"></label>
                                             </div>
                                             <div class="col-sm-2 ">
                                                <button class="btn btn-primary btn-block btn-flat pull-right" type="submit">Submit</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                    <div class="col-md-6 ">
                                       @if(count($t->history))
                                       <h3>History</h3>
                                       <table class="table table-bordered table-striped datatable task-remarks-table" style="    border-collapse: separate;
                                       border-spacing: 0px 9px;">
                                          <thead>
                                             <tr>
                                                <th width="69%">Remarks</th>
                                                <th width="4%">Status</th>
                                                <th width="12%">Added By</th>
                                                <th width="15%">Time</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @foreach($t->history()->orderBy('id','DESC')->get() as $h)
                                             @if($h->is_private != 1)
                                             <tr>
                                                <td  width="69%">{!! $h->remarks !!}</td>
                                                <td class="{{$h->status->id == 5?'text-success':($h->status->id == 3?'text-warning':'text-danger')}}">{{ $h->status->name }}</td>
                                                <td>{{ !is_null($h->admins_id)?$h->admin->name:'' }}</td>
                                                <td>{{ date('d-M-Y (H:s)',strtotime($h->created_at)) }}</td>
                                             </tr>
                                             @else
                                             @if(!is_null($h->admins_id ) && $h->admins_id == auth()->guard('admin')->user()->id)
                                             <tr>
                                                <td  width="69%">{!! $h->remarks !!}</td>
                                                <td>{{ $h->status->name }}</td>
                                                <td>{{ !is_null($h->admins_id)?$h->admin->name:'' }}</td>
                                                <td>{{ date('d-M-Y (H:s)',strtotime($h->created_at)) }}</td>
                                             </tr>
                                             @endif
                                             @endif
                                             @endforeach
                                          </tbody>
                                       </table>
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                           {{-- <div class="box">
                              <div class="box-body">
                                 
                              </div>
                           </div> --}}
                        </section>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
                </div>
                <div class="show-on-mobile">
                  @foreach($tasks as $t)   
                  <table class="table task-table" style="">
                    <tr class="mobileentries">
                      {{--  onclick=" $('.collapse.in')
                        .collapse('hide');"data-toggle="collapse" data-target="#mobiledetail{{ $t->id }}" --}}
                     <th width="">Inquiry No.</th>
                       <td style="padding: 0"><a href="javascript:;" class="btn-block" style="padding: 8px;font-size: 17px;"  aria-expanded="false"  onclick=" $('#mobiledetail{{ $t->id }}').show();$('.mobileentries').hide()"><strong>{{ $t->id }}</strong></a></td>
                   </tr>
                    <tr id="mobiledetail{{$t->id}}" class="collapse" data-parent="#myGroup">
                     <td colspan="9">
                        <section class="content" style="background: #f0f0f0;padding: 0;">
                           <!--  <h2>
                              Task Detail
                              </h2> -->
                           <div class="box box-default" style="margin-bottom: 0;">
                              <div class="box-header with-border">
                                 <h3 class="box-title">Change Status</h3>
                              </div>
                              <div class="box-body" style="padding: 0;">
                                 <div class="row">
                                    <div class="col-md-6 ">
                                       <table class="table table-bordered">
                                          <tr>
                                             <th>Enquiry No</th>
                                             <td><a href="javascript:;" onclick="$('#mobiledetail{{$t->id}}').hide(); $('.mobileentries').show()">{{$t->id}}</a></td>
                                                </tr>
                                          <tr>
                                             <th>Passenger Name</th>
                                             <td class="text-uppercase">{{$t->pax_name}}</td>
                                          </tr>
                                          <tr>
                                             <th>Date</th>
                                             <td>{{ date('d-M-Y (H:s)',strtotime($t->created_at)) }}</td>
                                                </tr>
                                          <tr>
                                             <th>Party</th>
                                             <td>{{ !is_null($t->party)?$t->party->name:'N/A' }}</td>
                                          </tr>
                                          </tr>
                                          <tr>
                                             <th>Category</th>
                                             <td>{{ !is_null($t->type) && !empty($t->type->name)?$t->type->name:'' }}</td>
                                                </tr>
                                          <tr>
                                             <th>Phone</th>
                                             <td>{{$t->phone}}</td>
                                          </tr>
                                          <tr>
                                             <th>Staff</th>
                                             <td>{{ !is_null($t->admin)?$t->admin->name:'' }}</td>
                                                </tr>
                                          <tr>
                                             <th>Attachments</th>
                                             <td>@if(!is_null($t->attachment))
                                                @php $i = 1 @endphp
                                                @foreach($t->attachment as $a)
                                                @if($a->is_private != 1 )
                                                @if(strpos($a->img,".pdf"))
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @else
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @endif
                                                @else
                                                @if($t->admins_id == auth()->guard('admin')->user()->id)
                                                @if(strpos($a->img,".pdf"))
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe>" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @else
                                                <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                                                {{ $i++ }}
                                                </a>
                                                @endif
                                                @endif
                                                @endif
                                                @endforeach
                                                @endif
                                                <a href="{{ url('admin/add-attachment').'/'.$t->id }}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i></a>
                                             </td>
                                          </tr>
                                       </table>
                                    </div>
                                    <div class="col-md-6 ">
                                       <form action="{{ route('task-status') }}" method="POST" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="tasks_id" value="{{ $t->id }}">
                                          <div class="form-group" style="    margin-top: 30px;">
                                             <label class="control-label require">Remarks</label>
                                             <textarea type="text" class="form-control " name="remarks" id="remarks"></textarea>
                                          </div>
                                          <div class="row form-group">
                                            
                                             <div class="col-sm-6 col-xs-8">
                                                <!--           <label class="control-label require">Status</label> -->
                                                <select class="form-control" name="statuses_id" id="statuses_id" data-validation="required">
                                                   <option value="">Select Status</option>
                                                   @foreach($statuses as $s)
                                                   <option value="{{ $s->id }}" {{$s->id == '3'?'selected':''}}>{{ $s->name }}</option>
                                                   @endforeach
                                                </select>
                                             </div>
                                             <div class="col-sm-2 col-xs-4 form-group">
                                                <!--  <label style="display: block;">&nbsp;</label> -->
                                                <label class="control-label require">Only Me &nbsp;
                                                <input type="checkbox" name="is_private" value="1"></label>
                                             </div>
                                              <div class="col-sm-2 col-xs-6">
                                                <button type="reset" class="btn btn-block btn-info btn-flat">Reset</button>
                                             </div>
                                             <div class="col-sm-2 col-xs-6">
                                                <button class="btn btn-primary btn-block btn-flat pull-right" type="submit">Submit</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="box">
                              <div class="box-body" style="padding: 0">
                                 @if(count($t->history))
                                 <h3>History</h3>
                                          @foreach($t->history()->orderBy('id','DESC')->get() as $h)
                                 <table class="table table-bordered table-striped datatable" >
                                       @if($h->is_private != 1)
                                       <tr>
                                           <th >Remarks</th>
                                        <td>{!! $h->remarks !!}</td>
                                      </tr>
                                      <tr>
                                           <th >Status</th>
                                        <td>{{ $h->status->name }}</td>
                                      </tr>
                                      <tr>
                                            <th>Added By</th>
                                        <td>{{ !is_null($h->admins_id )?$h->admin->name:'' }}</td>
                                      </tr>
                                      <tr>

                                          <th>Time</th>
                                        <td>{{ date('d-M-Y (H:s)',strtotime($h->created_at)) }}</td>
                                      </tr>
                                       @else
                                       @if(!is_null($h->admins_id ) && $h->admins_id == auth()->guard('admin')->user()->id)
                                       <tr>
                                           <th >Remarks</th>s
                                          <td>{!! $h->remarks !!}</td>
                                            </tr>
                                        <tr>
                                            <th >Status</th>

                                          <td>{{ $h->status->name }}</td>
                                            </tr>
                                        <tr>
                                              <th>Added By</th>
                                          <td>{{ !is_null($h->admins_id )?$h->admin->name:'' }}</td>
                                            </tr>
                                        <tr>

                                          <th>Time</th>
                                          <td>{{ date('d-M-Y (H:s)',strtotime($h->created_at)) }}</td>
                                       </tr>
                                       @endif
                                       @endif
                                      
                                 </table>
                                  @endforeach
                                 @endif
                              </div>
                           </div>
                        </section>
                     </td>
                  </tr>
                   <tr class="mobileentries">
                     <th  width="">Date</th>
                            <td>{{ date('d-M-Y (H:s)',strtotime($t->created_at)) }}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th  width="">Category</th>
                        <td>{{ !is_null($t->type) && !empty($t->type->name)?$t->type->name:'' }}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th width="">Passenger Name</th>
                         <td class="text-uppercase">{{ $t->pax_name }}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th  width="">Type</th>

                     <td style="{{$t->task_type == 1?'color:red':($t->task_type == 2?'color:blue':($t->task_type == 3?'color:green':''))}};text-transform:capitalize;">{{$t->task_type == 1?'Urgent':($t->task_type == 2?'Important':($t->task_type == 3?'Normal':($t->task_type == 4?'Followup':'')))}}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th width="">Phone</th>
                        <td>{{ $t->phone }}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th  width="">Party</th>
                              <td>{{ !is_null($t->party)?$t->party->name:'N/A' }}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th  width="">Staff</th>

                     <td>{{ !is_null($t->admin)?$t->admin->name:'' }}</td>
                   </tr>
                   <tr class="mobileentries">
                     <th>Action</th>
                      <td>
                        @if(!is_null($t->attachment))
                        @php $i = 1 @endphp
                        @foreach($t->attachment as $a)
                        @if($a->is_private != 1 )
                        @if(strpos($a->img,".pdf"))
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @else
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @endif
                        @else
                        @if($t->admins_id == auth()->guard('admin')->user()->id)
                        @if(strpos($a->img,".pdf"))
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<iframe src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' /></iframe>" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @else
                        <a href="{{ url('storage/uploads/attachments').'/'.$a->img }}" data-toggle="tooltip" title="<img src='{{ url('storage/uploads/attachments').'/'.$a->img }}' class='tooltip-img' />" target="blank" class="btn btn-sm btn-success attach-btn">
                        {{ $i++ }}
                        </a>
                        @endif
                        @endif
                        @endif
                        @endforeach
                        @endif
                        <a href="{{ url('admin/add-attachment').'/'.$t->id }}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i></a>
                        @if(auth()->guard('admin')->user()->type == 'admin' || in_array('edit_task',$permissions))
                        <a href="{{ url('admin/edit-task/'.$t->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        @endif
                     </td>
                   </tr>
                 
            </table>
            <hr style="border-color: black;">
                    @endforeach
                </div>
            {!! $tasks->links() !!}
         </div>
         @else
         <div class="box-body">
            <ul class="search-btns">
                <li><a href="{{url('admin/manage-tasks?searched=yes')}}">All <br> <small class="text-danger">{{$all_count}}</small></a></li>
               @foreach($admins as $a)
                  <li><a href="{{url('admin/manage-tasks?admins_id='.$a->id)}}">{{ $a->name }} <br> <small class="text-danger">{{$a->tasks()->where('tasks.last_status','!=',5)->count()}}</small></a></li>
               @endforeach
               @foreach($taskTypes as $t)
               <li><a href="{{url('admin/manage-tasks?task_types_id='.$t->id)}}">{{ $t->name }} <br> <small class="text-danger">{{$t->tasks()->where('tasks.last_status','!=',5)->count()}}</small></a></li>
               @endforeach
               <li><a href="{{url('admin/manage-tasks?position_type=1')}}">Urgent <br> <small class="text-danger">{{$type_1_count}}</small></a></li>
                  <li><a href="{{url('admin/manage-tasks?position_type=2')}}">Important <br> <small class="text-danger">{{$type_2_count}}</small></a></li>
                     <li><a href="{{url('admin/manage-tasks?position_type=3')}}">Normal <br> <small class="text-danger">{{$type_3_count}}</small></a></li>
                     <li><a href="{{url('admin/manage-tasks?statuses_id=9')}}">Website <br> <small class="text-danger">{{$website_count}}</small></a></li>
            </ul>
         </div>
         @endif
      </div>
   </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
   $(function(){
      $(".select2").select2();
     $('a[data-toggle="tooltip"]').tooltip({
       animated: 'fade',
       placement: 'bottom',
       html: true
     });
   })
   
</script>
@if(request()->has('expand') && !empty(request()->get('expand')))
<script type="text/javascript">
   $(function(){
     var id = "{{request()->get('expand')}}";
     $('#detail'+id).toggle();
   });
   
</script>
@endif
@endpush