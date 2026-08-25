@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">

   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Supplier</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
   
               <div class="col-md-12">
                  <form action="{{ route('save-supplier') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ isset($supplier)?$supplier->id:'' }}" name="id">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="control-label require">Category</label>
                                <select name="category" id="category" class="form-control" data-validation="required">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}"{{isset($supplier) && $supplier->account_categories_id == $c->id?'selected':''}}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="type" value="supplier">

                        	<div class="col-sm-6 form-group">
                        		<label class="control-label require">Name</label>
                        		<input placeholder="Name" class="form-control" name="name" type="text" value="{{ old('name', isset($supplier)?$supplier->name:'') }}" data-validation="required" >
                        	</div>
                        	<div class="col-sm-6 form-group">
                        		<label class="control-label require">Show in Accounts</label><br>
                        		<input name="is_show_in_accounts" {{ old('is_show_in_accounts', isset($supplier)?$supplier->is_show_in_accounts:'') == 1?'checked':'' }} type="checkbox" value="1">
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
