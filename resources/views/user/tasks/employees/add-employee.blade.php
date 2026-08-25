@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
      <h1>
         Add Employee
      </h1>
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Employee</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-12">
                  <form method="POST" action="{{ route('save-employee') }}">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ isset($admin)?$admin->id:'' }}" name="id">
                     <div class="col-md-6 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($admin)?$admin->name:'' }}" autofocus>
                        @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ isset($admin)?$admin->email:'' }}">
                        @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Password</label>
                        <div class="input-group">
                        <input id="password" type="password" class="form-control" name="password" value="{{ isset($admin)?$admin->visible_password:'' }}">
                        <span class="input-group-addon" onclick="showPassword('password')"><i class="fa fa-eye"></i></span>
                     </div>
                        @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="control-label">Confirm Password</label>
                          <div class="input-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ isset($admin)?$admin->visible_password:'' }}">
                          <span class="input-group-addon" onclick="showPassword('password-confirm')"><i class="fa fa-eye"></i></span>
                     </div>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="form-group col-md-12">
                        <h3>Permissions</h3>
                        <hr>
                        <div class="row">
                           <div class="col-md-4">
                              <label><input type="checkbox" name="all" id="allP" onclick="checkAll(this)"> &nbsp; All</label>
                           </div>

                           @foreach($permissions as $p)
                           <div class="col-md-4">
                              <label><input type="checkbox" name="permissions[]" value="{{$p->id}}" {{isset($addedpermissions) && in_array($p->id,$addedpermissions)?'checked':''}}> &nbsp; {{$p->permission}} </label>
                           </div>
                           @endforeach
                        </div>
                        <br>
                       
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
   function checkAll(event) {
     if($(event).is(":checked")){
       $('input[type="checkbox"]').prop('checked', true);
     }else{
      $('input[type="checkbox"]').prop('checked', false);
     }
   }
   function showPassword(id) {
      var val = $('#'+id).attr('type');
      if (val == 'password') {
          $('#'+id).attr('type','text');
       }else{
          $('#'+id).attr('type','password');
       }
     
   }
</script>
@endpush
