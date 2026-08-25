@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   <section class="content-header">
      <h1>
         Add Attachment
      </h1>
      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Attachment</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Attachment</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
                  <form action="{{ route('save-attachment') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" name="tasks_id" value="{{ $id }}">
                     <input type="hidden" name="vendees_id" value="{{ $vendees_id }}">
                        <div class="row">
                        	<div class="col-sm-6 form-group">
                        		<label class="control-label require">Name</label>
                        		<input class="form-control" name="img" type="file" data-validation="required" >
                        	</div>
                        	<div class="col-sm-6 form-group">
                        		<label class="control-label require">Title</label>
                        		<input placeholder="Title" class="form-control" name="title" type="text" data-validation="required" >
                        	</div>
                        </div>

                        <div class="row">
                           <div class="col-sm-6 form-group">
                              <label class="control-label require">Only Me
                              <input type="checkbox" name="is_private" value="1"></label>
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

</script>
@endpush
