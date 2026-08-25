@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')

<div class="container">
   <section class="content-header">
      <h1>
         Add Travel Insurance
      </h1>
      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Travel Insurance</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
         
            <h2 style="text-align: center;">Add Travel Insurance</h2>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-sm-8 col-md-offset-2">
              @include('user.tasks.partials.travel-insurance-form')
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
