@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
@php
$permissionsData = auth()->guard('admin')->user()->permissions;
$permissions = array();
foreach($permissionsData as $p){
    $permissions[] = $p->code;
}

@endphp
<div class="container">
  <section class="content-header">
    <h1>
      Party Detail
    </h1>
    <ol class="breadcrumb">
      <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Party Detail</li>
    </ol>
  </section>
  <form action="{{ route('save-party') }}" method="POST" enctype="multipart/form-data">
   {{ csrf_field() }}
   <section class="content">

    <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <h3 class="box-title">{{$party->name}}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                  </div> -->
                  <div class="box-body">
                  
                   
                    <div class="row">

                     <div class="col-md-6">
                      <a href="{{url('admin/manage-tasks?parties_id='.$party->id)}}" class="btn btn-warning">Tasks</a>
                      <div class="form-group  pull-right">
                        @if(auth()->guard('admin')->user()->type == 'admin' || in_array('edit_party',$permissions))
                        <a href="{{url('admin/detail-party/'.$party->id.'?edit=yes')}}" class="btn btn-warning">Edit</a> &nbsp;&nbsp;
                        <a href="{{url('admin/detail-party/'.$party->id)}}" class="btn btn-primary">Detail</a>
                        @endif
                      <!--   <button type="reset" class="btn btn-info btn-flat">Reset</button> -->
                        &nbsp;<button class="btn btn-primary btn-flat pull-right hide-button" type="submit">Save</button>                     
  
                      </div>
                      <div class="clearfix"></div>
                      <input type="hidden" name="passengers" value="yes">
                      <input type="hidden" value="{{ isset($party)?$party->id:'' }}" name="id">
                      <div class="row">
                        <div class="col-sm-4 form-group">
                          <label class="control-label require">Category</label>
                          <select name="category" id="category" class="form-control hide-it" data-validation="required">
                            <option value="">Select Category</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{isset($party) && $party->account_categories_id == $c->id?'selected':''}}>{{ $c->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <input type="hidden" name="type" value="party">

                        <div class="col-sm-4 form-group">
                          <label class="control-label require">Name</label>
                          <input placeholder="Name" class="form-control hide-it" name="name" type="text" value="{{ old('name', isset($party)?$party->name:'') }}" data-validation="required" >
                        </div>
                         <div class="col-sm-4 form-group">
                              <label class="control-label require">Email</label>
                              <input placeholder="Email" class="form-control hide-it" name="email" type="text" value="{{ old('email', isset($party)?$party->email:'') }}"  >
                           </div>
                           <div class="col-sm-4 form-group ">
                           <label class="control-label require">Staff</label>
                           <select class="form-control select2 hide-it" name="admins_id" data-validation="required">
                             <option value="">Select Staff</option>
                             @foreach($admins_id as $a)
                             <option value="{{ $a->id }}" {{ isset($party) && $party->admins_id == $a->id?'selected':'' }}>
                               {{ $a->name }}
                             </option>
                             @endforeach
                           </select>
                         </div>

                        <div class="col-sm-4 form-group">
                          <label class="control-label require">Phone</label>
                          <input placeholder="Phone" class="form-control hide-it" maxlength="14" name="phone" pattern="\d*" type="text" value="{{ old('phone', isset($party)?$party->phone:'') }}" data-validation="required" oninvalid="this.setCustomValidity('Invalid Phone Number')" oninput="setCustomValidity('')">
                        </div>
                          <div class="col-sm-4 form-group">
                          <label class="control-label require">Phone 2</label>
                          <input placeholder="Phone" class="form-control hide-it" maxlength="14" name="phone_2" pattern="\d*" type="text" value="{{ old('phone_2', isset($party)?$party->phone_2:'') }}"  oninvalid="this.setCustomValidity('Invalid Phone Number')" oninput="setCustomValidity('')">
                        </div>
                          </div>
                       <div class="row">
                          <div class="col-sm-4 form-group">
                          <label class="control-label require">Phone 3</label>
                          <input placeholder="Phone" class="form-control hide-it" maxlength="14" name="phone_3" pattern="\d*" type="text" value="{{ old('phone_3', isset($party)?$party->phone_3:'') }}"  oninvalid="this.setCustomValidity('Invalid Phone Number')" oninput="setCustomValidity('')">
                        </div>

                        <div class="col-sm-4 form-group">
                          <label>Sector</label>
                          <select name="party_sector" class="form-control hide-it">
                            <option value="">Select</option>
                            @foreach ($sectors as $s)
                               <option value="{{$s->name}}" {{isset($party) && $party->sector == $s->name?'selected':''}}>{{$s->name}}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" name="party_sector" class="form-control hide-it" value="{{ old('sector', isset($party)?$party->sector:'') }}" placeholder="Sector"> --}}
                        </div>
                        <div class="col-sm-4 form-group">
                          <label>Second Sector</label>
                          <select name="sector_two" class="form-control hide-it">
                            <option value="">Select</option>
                            @foreach ($sectors as $s)
                               <option value="{{$s->name}}" {{isset($party) && $party->sector_two == $s->name?'selected':''}}>{{$s->name}}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" name="sector_two" class="form-control hide-it" value="{{ old('sector', isset($party)?$party->sector_two:'') }}" placeholder="Second Sector"> --}}
                        </div>

                    <!--     <div class="col-sm-12 form-group">
                     <label>Remarks</label>
                     <textarea name="remarks" class="form-control hide-it" rows="2">{{ old('remarks', isset($party)?$party->remarks:'') }}</textarea>
                                           </div> -->
                       <div class="col-sm-12 form-group">
                         <label>Important Information</label>
                         <textarea name="information" class="form-control hide-it" placeholder="Information" rows="3">{{ old('information', isset($party)?$party->information:'') }}</textarea>
                       </div>
                       <div class="col-sm-6 form-group">
                        <label class="control-label require">
                          <input name="is_show_in_accounts" {{ old('is_show_in_accounts', isset($party)?$party->is_show_in_accounts:'') == 1?'checked':'' }} type="checkbox" value="1"> &nbsp;&nbsp; Show in Accounts</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <button class="btn btn-primary btn-flat pull-right" type="submit">Save</button> 
                      <div class="clearfix"></div>
                    @if($passengers->count() > 0)
                    @foreach($passengers as $p)
                    <input type="hidden" name="passenger_id[]" value="{{$p->id}}">
                    <div class="row">
                      <div class="col-sm-1 form-group" style="padding-right: 0">
                       <label class="control-label">Title</label>
                       <select name="title[]" class="form-control hide-it">
                         <option value="MR" {{$p->title == 'MR'?'selected':''}}>MR</option>
                         <option value="MRS" {{$p->title == 'MRS'?'selected':''}}>MRS</option>
                         <option value="MS" {{$p->title == 'MS'?'selected':''}}>MS</option>
                         <option value="MISS" {{$p->title == 'MISS'?'selected':''}}>MISS</option>
                         <option value="MSTR" {{$p->title == 'MSTR'?'selected':''}}>MSTR</option>
                         <option value="INFANT" {{$p->title == 'INFANT'?'selected':''}}>INFANT</option>
                       </select>
                     </div>
                     <div class="col-sm-2 form-group">
                      <label class="control-label require">Surname</label>
                      <input placeholder="Surname" class="form-control hide-it onlyLetters" name="surname[]" type="text" value="{{ $p->surname??'' }}" >
                    </div>
                    <div class="col-sm-3 form-group">
                      <label class="control-label require">Given name</label>
                      <input placeholder="Given Name" class="form-control hide-it onlyLetters" name="given_name[]" type="text" value="{{ $p->given_name??'' }}" >
                    </div>
                    <div class="col-sm-2 form-group" style="padding-left: 8px;">
                     <label class="control-label require">Passport</label>
                     <input type="text" name="passport[]" class="form-control hide-it " placeholder="Passport" value="{{$p->passport}}" maxlength="15"  data-validation-error-msg="Required">
                   </div> 
                   <div class="col-sm-2 form-group">
                     <label class="control-label require">Date of Birth</label>
                     <input type="text" name="dob[]" class="form-control hide-it dob"  value="{{isset($p->dob)?$p->dob:''}}" placeholder="Date">
                   </div>
                   <div class="col-sm-2 form-group">
                     <label class="control-label require">Passport Expiry</label>
                     <input type="text" name="passport_expiry[]" class="form-control hide-it dob"  value="{{isset($p->passport_expiry)?$p->passport_expiry:''}}" placeholder="Date">
                   </div>
                 </div>
                 @endforeach
                 @else
                 <input type="hidden" name="passenger_id" value="">
                 <div class="row">
                  <div class="col-sm-2 form-group" >
                   <label class="control-label">Title</label>
                   <select name="title[]" class="form-control">
                     <option value="MR" >MR</option>
                     <option value="MRS" >MRS</option>
                     <option value="MS" >MS</option>
                     <option value="MISS" >MISS</option>
                     <option value="MSTR" >MSTR</option>
                     <option value="INFANT">INFANT</option>
                   </select>
                 </div>
                 <div class="col-sm-5 form-group">
                  <label class="control-label require">Surname</label>
                  <input placeholder="Surname" class="form-control onlyLetters" name="surname[]" type="text" value="" >
                </div>
                <div class="col-sm-5 form-group">
                  <label class="control-label require">Given name</label>
                  <input placeholder="Given Name" class="form-control onlyLetters" name="given_name[]" type="text" value="" >
                </div>
                <div class="col-sm-4 form-group" >
                 <label class="control-label require">Passport</label>
                 <input type="text" name="passport[]" class="form-control " placeholder="Passport" value="" maxlength="15"  data-validation-error-msg="Required">
               </div> 
               <div class="col-sm-4 form-group">
                 <label class="control-label require">Date of Birth</label>
                 <input type="text" name="dob[]" class="form-control dob"  value="" placeholder="Date">
               </div>
               <div class="col-sm-4 form-group">
                 <label class="control-label require">Passport Expiry</label>
                 <input type="text" name="passport_expiry[]" class="form-control dob"  value="" placeholder="Date">
               </div>
             </div>
             @endif
             <div class="new_image"></div>
             <div class="form-group text-center">
               <a href="javascript:void(0);" class="addmore  btn-primary btn "
               id="addmore">Add More</a>
               <div class="clearfix"></div>
             </div>
                    </div>
                  </div>
                </div>
              </div>

              {{-- <div class="box box-default">
                <div class="box-body">
                
        </div>
      </div> --}}

      @if($inquiry->count() > 0)
      <div class="row">
        @foreach($inquiry as $i)
        <div class="col-sm-3">
          <div class="box box-default">
            <div class="box-body">
             <a href="{{url('admin/manage-tasks?statuses_id=all&parties_id='.$party->id.'&expand='.$i->id)}}" style="color:unset">
              <div class="row">
                <div class="col-sm-5">
                  <strong>Inquiry No</strong> <br>
                  {{$i->id}}
                </div>
                <div class="col-sm-7">
                  <strong>Date</strong> <br>
                  {{ date('d-M-Y (H:s)',strtotime($i->created_at)) }}
                </div>
              </div></a> 
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif
      <div class="box box-default">

    

          <div class="box-body hide-new">
<button class="btn btn-primary btn-flat pull-right" type="submit">Save</button> 
                   <div class="clearfix"></div>
            <div class="row ">
             <div class="col-sm-2 form-group">
               <label>Image</label>
               <input type="file" name="image[]" class="form-control">
             </div>
             <div class="col-sm-2 form-group">
               <label>Title</label>
               <input type="text" name="image_title[]" class="form-control">
             </div>
             <div class="col-sm-2 form-group">
               <label>Image</label>
               <input type="file" name="image[]" class="form-control">
             </div>
             <div class="col-sm-2 form-group">
               <label>Title</label>
               <input type="text" name="image_title[]" class="form-control">
             </div>
             <div class="col-sm-2 form-group">
               <label>Image</label>
               <input type="file" name="image[]" class="form-control">
             </div>
             <div class="col-sm-2 form-group">
               <label>Title</label>
               <input type="text" name="image_title[]" class="form-control">
             </div>
           
           </div>
         <div class="new_attachment"></div>
           <div class="form-group text-center">
            <a href="javascript:void(0);" class="addmoreAttach  btn-primary btn "
            id="addmoreAttach">Add More</a>
            <div class="clearfix"></div>
          </div>
        </div>
 
      @if($attachments->count() > 0)
      <br>
      <div style="padding: 0 10px;">


        <div class="row">
         @foreach($attachments as $t)
         <div class="col-sm-2 form-group">

          <a href="{{url('storage/uploads/attachments/'.$t->image)}}" title="{{$t->title}}" target="_blank"> <img src="{{url('storage/uploads/attachments/'.$t->image)}}" style="width: 100%;height: 150px;" title="{{$t->title}}"></a>
          <p class="btn-block" style="margin: 5px 0; padding: 6px;">{{$t->title}}  <a href="{{url('admin/delete-attachement/'.$t->id)}}" class="btn btn-danger btn-sm btn-xs pull-right btn-remove" onclick="return confirm('Are you sure you want to delete it?');"><i class="fa fa-trash"></i> </a> <div class="clearfix"></div></p>
         </div>
         @endforeach
       </div>
     </div>
     @endif
   </div>
 </section> 
</form>
</div>

@endsection

@push('script')
@if(!request()->has('edit'))
<script type="text/javascript">
  $( ".hide-it" ).addClass( "disabled" );
  $( ".disabled" ).prop("readonly", true);
  $( ".hide-button" ).hide();
  $('.hide-it option:not(:selected)').attr('disabled', true);
  $( ".btn-remove" ).hide();

</script>
@endif
<script type="text/javascript">
  var count = 2;
  $("#addmore").click(function() {

    var number_html =
    '<div class="expended_html">\
    <div class="row">\
    <div class="col-sm-2 form-group">\
    <label class="control-label">Title</label>\
    <select name="title[]" class="form-control">\
    <option value="MR" >MR</option>\
    <option value="MRS" >MRS</option>\
    <option value="MS" >MS</option>\
    <option value="MISS" >MISS</option>\
    <option value="MSTR" >MSTR</option>\
    <option value="INFANT">INFANT</option>\
    </select>\
    </div>\
    <div class="col-sm-5 form-group">\
    <label class="control-label require">Surname</label>\
    <input placeholder="Surname" class="form-control onlyLetters" name="surname[]" type="text" value="" >\
    </div>\
    \
    <div class="col-sm-5 form-group">\
    <label class="btn-block">Given name  <a href="javascript:;" class="removeNo  btn-danger btn-sm btn-xs pull-right" style="margin-bottom:5px;" > &times;</a></label>\
    <input placeholder="Given Name" class="form-control onlyLetters" name="given_name[]" type="text" value="" >\
    </div>\
    <div class="col-sm-4 form-group" >\
    <label class="control-label require">Passport</label>\
    <input type="text" name="passport[]" class="form-control " placeholder="Passport" value="" maxlength="15"  data-validation-error-msg="Required">\
    </div> \
    <div class="col-sm-4 form-group">\
    <label class="control-label require">Date of Birth</label>\
    <input type="text" name="dob[]" class="form-control dob"  value="" placeholder="Date">\
    </div>\
    <div class="col-sm-4 form-group">\
    <label class="btn-block">Passport Expiry</label>\
    <input type="text" name="passport_expiry[]" class="form-control dob"  value="" placeholder="Date">\
    </div>\
    </div>\
    </div>';

    $(".new_image").append(number_html);
 $(".dob").mask("99/99/9999");
    count++;

    $(".removeNo").click(function() {
      $(this).closest('.expended_html').remove();
      count--;

      $("#addmore").show();
    });
  });
  $("#addmoreAttach").click(function() {

    var number_html =
    '<div class="expended_html"><div class="row">\
             <div class="col-sm-2 form-group">\
               <label>Image</label>\
               <input type="file" name="image[]" class="form-control">\
             </div>\
             <div class="col-sm-2 form-group">\
               <label>Title</label>\
               <input type="text" name="image_title[]" class="form-control">\
             </div>\
             <div class="col-sm-2 form-group">\
               <label>Image</label>\
               <input type="file" name="image[]" class="form-control">\
             </div>\
             <div class="col-sm-2 form-group">\
               <label>Title</label>\
               <input type="text" name="image_title[]" class="form-control">\
             </div>\
             <div class="col-sm-2 form-group">\
               <label>Image</label>\
               <input type="file" name="image[]" class="form-control">\
             </div>\
             <div class="col-sm-2 form-group">\
               <label class="btn-block">Title <a href="javascript:;" class="removeNo  btn-danger btn-sm btn-xs pull-right" style="margin-bottom:5px;" > &times;</a></label>\
               <input type="text" name="image_title[]" class="form-control">\
             </div>\
           </div>\
    </div>';

    $(".new_attachment").append(number_html);

    count++;

    $(".removeNo").click(function() {
      $(this).closest('.expended_html').remove();
      count--;

      $("#addmoreAttach").show();
    });
  });
</script>
@endpush
