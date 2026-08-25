@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   <section class="content-header">
      <h1>
         Add Type
      </h1>
      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Type</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Type</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
                  <form action="{{ route('save-room-type') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ isset($detail)?$detail->id:'' }}" name="id">
                     <div class="row">
                       <div class="col-sm-12 form-group">
                         <label class="control-label require">Name</label>
                         <input placeholder="Name" class="form-control" name="name" type="text" value="{{ old('name', isset($detail)?$detail->name:'') }}" data-validation="required" >
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
