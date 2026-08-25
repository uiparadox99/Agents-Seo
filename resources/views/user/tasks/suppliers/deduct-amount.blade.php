@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   <section class="content-header">
      <h1>
         Deduct Amount
      </h1>
      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Deduct Amount</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Deduct Amount</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
                  <form action="{{ route('save-deduct-supplier-amount') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ $id }}" name="sup_id">
                        <div class="row">
                        	<div class="col-sm-6 form-group">
                        		<label class="control-label require">Amount</label>
                        		<input placeholder="Amount" class="form-control" name="amount" type="text" data-validation="number" data-validation-error-msg="Only Digit">
                        	</div>
                           <div class="col-sm-6 form-group">
                              <label class="control-label require">Date</label>
                              <input placeholder="Date" class="form-control today-date" name="trans_date" type="text" data-validation="required" >
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-sm-6 form-group">
                              <label class="control-label require">Remarks</label>
                              <textarea class="form-control" name="remarks" data-validation="required"></textarea>
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
