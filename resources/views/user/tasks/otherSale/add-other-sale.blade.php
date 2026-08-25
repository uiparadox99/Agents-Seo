@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')

<div class="container">
 
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
         
            <h2 style="text-align: center;">Add Other Sale</h2>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-sm-12">
              @include('user.tasks.partials.other-sales-form')
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
