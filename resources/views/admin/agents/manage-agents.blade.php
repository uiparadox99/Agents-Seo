@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage {{request()->path() == 'admin/agents'?'':'Foreign'}} Agents
                @if(request()->path() == 'admin/agents')
                <a href="{{ url('admin/add-agent') }}" class="btn btn-primary pull-right">Add Agent</a>
                @else
                <a href="{{ url('admin/add-foreign-agent') }}" class="btn btn-primary pull-right">Add Foreign Agent</a>
                @endif
        </h1>

    </section>
    <style type="text/css">
        .dataTables_paginate{
            display: none;
        }
        .dataTables_info{
            display: none;
        }
    </style>
     
 <section class="content">
         <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                   
                        <form method="get" action="{{request()->path() == 'admin/agents'?url('admin/agents'):url('admin/foreign-agents')}}">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label>ID</label>
                                <input type="text" name="agent_id"  id="agentID" autocomplete="off" class="form-control" value="{{request()->has('agent_id')?request()->get('agent_id'):''}}" placeholder="ID">
                            </div>
                            <div class="col-md-2 form-group">
                                <label>Business Name</label>
                                  @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                                <input type="text" name="business_name"  id="agentbar" autocomplete="off" class="form-control" value="{{request()->has('business_name')?request()->get('business_name'):''}}" placeholder="Business Name">
                                @else
                                <input type="text" name="business_name"  autocomplete="off" class="form-control" value="{{request()->has('business_name')?request()->get('business_name'):''}}" placeholder="Business Name">
                                @endif
                            </div>
                              @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                             <div class="col-md-2 form-group">
                                <label>Email</label>
                                <input type="text" name="email" placeholder="Email" class="form-control" value="{{request()->has('email')?request()->get('email'):''}}">
                            </div>
                             <div class="col-md-2 form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" placeholder="Phone Number" class="form-control" value="{{request()->has('phone')?request()->get('phone'):''}}"> 
                            </div>
                            <div class="col-md-2 form-group">
                                <label>Mobile</label>
                                <input type="text" name="mobile" placeholder="Mobile Number" class="form-control" value="{{request()->has('mobile')?request()->get('mobile'):''}}"> 
                            </div>
                             @endif
                             <div class="col-md-2 form-group">
                                <label>City</label>
                                <select name="city" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->id}}" {{request()->has('city') && request()->get('city') == $c->id?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                   @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                              <div class="col-md-2 form-group">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($types as $t)
                                    <option value="{{$t->id}}" {{request()->has('type') && request()->get('type') == $t->id?'selected':''}}>{{$t->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                              <div class="col-md-2 form-group">
                                <label>By Date</label>
                                <input type="text" name="date" class="form-control datepicker" autocomplete="off" value="{{request()->has('date')?request()->get('date'):''}}" placeholder="By Date"> 
                            </div>
                            <div class="col-md-2 form-group">
                                <label>Order By</label>
                                <select name="orderby" class="form-control" >
                                    <option value="" >Latest</option>
                                    <option value='name' {{request()->has('orderby') && request()->get('orderby') == 'name'?'selected' :''}}>Name</option>
                                    <option value='todayVisitsAsc' {{request()->has('orderby') && request()->get('orderby') == 'todayVisitsAsc'?'selected' :''}}>Today Visits ASC</option>
                                     <option value='todayVisitsDesc' {{request()->has('orderby') && request()->get('orderby') == 'todayVisitsDesc'?'selected' :''}}>Today Visits DESC</option>
                                       <option value='totalVisitsAsc' {{request()->has('orderby') && request()->get('orderby') == 'totalVisitsAsc'?'selected' :''}}>Total Visits ASC</option>
                                      <option value='totalVisitsDesc' {{request()->has('orderby') && request()->get('orderby') == 'totalVisitsDesc'?'selected' :''}}>Total Visits DESC</option>
                                           <option value='oepJobsAsc' {{request()->has('orderby') && request()->get('orderby') == 'oepJobsAsc'?'selected' :''}}>OEP Jobs ASC</option>
                                                <option value='oepJobsDesc' {{request()->has('orderby') && request()->get('orderby') == 'oepJobsDesc'?'selected' :''}}>OEP Jobs DESC</option>
                                </select>
                   
                            </div>
                              <div class="col-md-1 form-group">
                                <label>DTS Verified ?</label>
                                <select name="verified" class="form-control">
                                    <option value=""> Select</option>
                                    <option value="1" {{request()->has('verified') && request()->get('verified') == '1'?'selected':''}}>Yes</option>
                                    <option value="0" {{request()->has('verified') && request()->get('verified') == '0'?'selected':''}}>No</option>
                                </select>
                            </div>
                             <div class="col-md-1 form-group">
                                <label>Claimed ?</label>
                                <select name="claimed" class="form-control" >
                                    <option value=''>Select</option>
                                    <option value='yes' {{request()->has('claimed') && request()->get('claimed') == 'yes'?'selected' :''}}>Claimed</option>
                                    <option value='no'{{request()->has('claimed') && request()->get('claimed') == 'no'?'selected' :''}}>Not Claimed</option>
                             
                                </select>
                   
                            </div>
                            
                            <div class="col-md-1 form-group">
                                <label>Verified ?</label>
                                <select name="agent_verified" class="form-control" >
                                    <option value=''>Select</option>
                                    <option value='1' {{request()->has('agent_verified') && request()->get('agent_verified') == '1'?'selected' :''}}>Yes</option>
                                    <option value='0' {{request()->has('agent_verified') && request()->get('agent_verified') == '0'?'selected' :''}}>No</option>
                             
                                </select>
                   
                            </div>
                            @endif
                            <div class="col-md-2 form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search" style="margin-right: 10px;"></i> Search</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <h3 style="text-align: center;">Total Agents : {{$agents->total()}}</h3>
                        <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Business Name</th>
                       
                                    <th>Phone</th>
                                    <th>Email/Mobile</th>
                                    <th>Type</th>
                                    <th>City</th>
                                    @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                                    <th>DTS Attachment</th>
                                    <th>DTS Varified?</th>
                                    @endif
                                    <th>Since</th>
                                    @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                                    <th>Claimed ?</th>
                                    <th>Verified?</th>
                                    <th>OEP Jobs</th>
                                    <th>Today Visits</th>
                                    <th>Total Visits</th>
                                   @endif
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agents as $s)
                                <tr data-id="{{$s->id}}">
                                    <td>{{$s->id}}</td>
                                    <td class="text-capitalize">

                                                      <a href="{{ url('agent/'.$s->slug) }}" target="_blank">    {{ strtolower($s->business_name) }} {{$s->active == 0?'(Non Active)':''}}</a> 
                                            
                                              <!-- {{ strtolower($s->business_name) }} {{$s->active == 0?'(Non Active)':''}} -->
                                         
                               
                                    </td>
                                     <!-- <td>
                                        {{ $s->password }}
                                    </td> -->
                                    <td>
                                        {{ $s->phone }} 
                                    </td>
                                    <td >
                                        {!! str_replace(',','<br>',$s->email) !!} <br> {{ $s->mobile }} {{$s->secondary_mobile}}
                                    </td>
                                    <td>
                                        {{ !is_null($s->agentType)?$s->agentType->name:'' }}
                                    </td>
                                    <td>
                                        {{ !is_null($s->city)?$s->city->name:'' }}
                                    </td>
                                    @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                                    <td>
                                        @if(!is_null($s->dtsAttachments))
                                        <!-- <img src="{{url('storage/uploads/agents/'.$s->dts_attachment)}}" alt=""
                                            style="width:150px;height:100px;"> -->
                                            @foreach($s->dtsAttachments as $d)
                                            <a href="{{url('storage/uploads/agents/'.$d->file)}}" target="_blank" class="btn btn-primary btn-xs btn-sm" download><i class="fa fa-download"></i></a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $s->dts_verified == 1?'checked':'' }}><span
                                            class="top<?php echo $s->id; ?>"></span>
                                    </td>
                                    @endif
                                     <td>
                                        @if(!empty($s->created_at))
                                        {{ date('d M Y',strtotime($s->created_at)) }}
                                        @else
                                        {{ date('d M Y',strtotime($s->updated_at)) }}
                                        @endif
                                    </td>
                                    @if(auth()->guard('admin')->user()->email != 'imran@agents.com.pk')
                                    <td>
                                        @if(!is_null($s->users_id))
                                         Claimed
                                        @else
                                        Not Claimed
                                        @endif
                                    </td>
                                    <td>
                                        <form action="" method="get" id="form{{$s->id}}">
                                                     <input type="hidden" name="verify_agent" value="{{$s->id}}">
                                               <label><input type="checkbox" name="verified" onchange="$('#form{{$s->id}}').submit()" value="1" {{$s->verified == 1?'checked':''}}> Verified</label>
                                        </form>
                                        

                                    </td>
                                    <td>{{$s->foreign_jobs_Count}}</td>
                                    <td>{{$s->today_visitors}}</td>
                                     <td>{{$s->total_visitors}}</td>
                                     @endif
                                    <td>
                                     @if(request()->path() == 'admin/agents')
                                        <a href="{{ route('admin.edit-agent', $s->id) }}">
                                            <button class="btn btn-success btn-sm btn-xs"><i
                                                    class="fa fa-pencil"></i></button></a>
                                       @else
                                         <a href="{{ route('admin.edit-foreign-agent', $s->id) }}">
                                            <button class="btn btn-success btn-sm btn-xs"><i
                                                    class="fa fa-pencil"></i></button></a>
                                       @endif
                                        <!--|-->
                                        <!-- <a href="{{ url('agent/'.$s->slug) }}" target="_blank">-->
                                        <!--    <button class="btn btn-primary btn-sm btn-xs"><i-->
                                        <!--            class="fa fa-globe"></i></button></a>-->
                                             
                                                    @if(!empty($s->password))
                                                         | <button class="btn btn-danger btn-sm- btn-xs btn-sm  jsRecord" data-email='{{ $s->user_email }}'  data-business='{{ $s->business_name }}' data-password='{{ $s->password }}' data-toggle="modal" data-target="#updatefacility"  type="button" ><i class="fa fa-key"></i></button>
                                                <!--     <div class="dropdown" style="    display: inline-block;">
                                                      <ul class="dropdown-menu">
                                                        <li>{{$s->user_email}}</li>
                                                        <li>{{$s->password}}</li>
                                                    </ul>
                                                </div> -->
                                                    @endif 

                                                    | <a
                                            href="{{ route('admin.delete-agent', $s->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this Agent?');"
                                            class="btn btn-danger btn-sm btn-xs"><i class="fa fa-trash"></i></a> 
                                           
                                    </td>
                             
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   
                    </div>
                         <div class="pagination">
                            
                        {!! $agents->links() !!}
                        </div>
                </div>
            </div>
        </div>
    </section>
</div>
    <div id="updatefacility" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" id="addManagementLabel"><span id="business"></span> Login Credentials</h4>
                        </div>
                        <div class="modal-body">
                           
                            <p><strong>Email :</strong> <span id="email"></span></p>
                            <p><strong>Password :</strong> <span id="password"></span></p>
                              
                        </div>
                     
                </div><!-- /.modal-content-->
            </div><!-- /.modal-dialog -->
        </div>
      
@endsection
@push('script')
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    });
    $("table.agentdatatables").DataTable({
        "pageLength": 50,
    });
    $('.out_bound_date').datepicker( {
               format: "d-M-yyyy", 
               autoclose: true,
               startDate: new Date(),
           });
    function verifiedConfirm(e) {
            $('#form').submit();
       /* if (confirm('Are you sure you want to proceed.')) {
        }else{
          e.preventDefault;
          location.reload();
        }*/
    }
function addToHome(pointer) {

    var $this = $(pointer);
    var tr = $this.closest('tr');
    var id = tr.data('id');

    if ($this.is(':checked')) {
        var is_home = 1;
    } else {
        var is_home = 0;
    }

    $this.prop("disabled", true);
    $this.val("Processing..");

    $.ajax({
        url: SITE_PATH + '/dts-verified',
        type: 'GET',
        data: {
            is_home: is_home,
            id: id
        },
        dataType: "JSON",
        success: function(data) {
            if (data.notify) {
                $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
            } else {
                $(".top" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
            }
        },
        error: function() {

        },
        complete: function() {
            $this.prop("disabled", false);
        }
    });
}
   $(function(){
         $(".jsRecord").click(function(){
                var $this = $(this);
                    var email = $this.data("email");
                    var password = $this.data("password");
                    var business = $this.data("business");
                    $("#email").text(email);
                    $("#password").text(password);
                    $("#business").html("<b class='text-capitalize'>"+business+"</b>");
                 
                
                
                
            });
      });
</script>
@endpush