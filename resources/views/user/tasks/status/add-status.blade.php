@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   <section class="content-header">
      <h1>
         Add Status
      </h1>
      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Status</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Status</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
                  <form action="{{ route('save-status') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ isset($status)?$status->id:'' }}" name="id">
                     <div class="row">
                       <div class="col-sm-6 form-group">
                         <label class="control-label require">Status Name</label>
                         <input placeholder="Name" class="form-control" name="name" type="text" value="{{ old('name', isset($status)?$status->name:'') }}" data-validation="required" >
                      </div>
                       <div class="col-sm-6 form-group">
                         <label class="control-label require">status Code</label>
                         <select class="form-control" name="type" id="type"  data-validation="required" >
                          <option value="task" {{isset($status) && $status->type == 'task'?'selected':''}}>Task</option>
                          <option value="tickets" {{isset($status) && $status->type == 'tickets'?'selected':''}}>Tickets</option>
                          <!-- <option value="visas" {{isset($status) && $status->type == 'visas'?'selected':''}}>Visas</option>
                          <option value="hotels" {{isset($status) && $status->type == 'hotels'?'selected':''}}>Hotels</option>
                          <option value="packages" {{isset($status) && $status->type == 'packages'?'selected':''}}>Packages</option>
                          <option value="umrah" {{isset($status) && $status->type == 'umrah'?'selected':''}}>Umrah</option>
                          <option value="travel-insurance" {{isset($status) && $status->type == 'travel-insurance'?'selected':''}}>Travel Insurance</option>
                          <option value="others" {{isset($status) && $status->type == 'others'?'selected':''}}>Others (Re-issue / Seat Allocation)</option> -->
                        </select>
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
  $(function(){
   /* $("input[name=code]").mask("99");*/
});
</script>
@endpush
