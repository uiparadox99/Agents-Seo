@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Sector</h3>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
                  <form action="{{ route('save-flight') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ isset($flight)?$flight->id:'' }}" name="id">
                     <div class="row">
                       <div class="col-sm-6 form-group">
                         <label class="control-label require">Flight Sector</label>
                         <input placeholder="Flight Sector" class="form-control" name="name" type="text" value="{{ old('name', isset($flight)?$flight->name:'') }}" data-validation="required" style="text-transform: uppercase;">
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
   $("input[name=name]").mask("?aaa-aaa");
});
</script>
@endpush
