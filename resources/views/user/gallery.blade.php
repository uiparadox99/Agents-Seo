@extends('layouts.master')

@section('content')

<div class="container">
  <div class="row ">
    <div class="col-md-3">
      @include('includes.user-sidebar')
    </div>

    <div class="col-md-9 agent-main-box" >
      <h3>Business Gallery
                <!--     @if($gallery->count() == 0 || $gallery->count() <= 15)
                     @if(!is_null(auth()->user()->agents()->first()) && !CheckPermission(auth()->user()->agents()->first()->id,'5_gallery_pictures') && $gallery->count() < 1)
                        <a href="{{url('/add-gallery')}}" class="btn btn-primary" style="float: right;">Add Gallery</a>
                        @endif
                        @if(!is_null(auth()->user()->agents()->first()) && CheckPermission(auth()->user()->agents()->first()->id,'5_gallery_pictures') && $gallery->count() < 5)
                        <a href="{{url('/add-gallery')}}" class="btn btn-primary" style="float: right;">Add Gallery</a>
                        @endif
                        @endif -->
                        <a href="{{url('agent-add-gallery')}}" class="btn btn-primary" style="float: right;">Add Image</a>
                      </h3>

                      <div class="row">
                        @if($gallery->count() > 0)
                        @foreach($gallery as $r)
                        <div class="col-md-4 image-box-col">
                          <div  class="image-box" data-id="{{ $r->id }}"> 
                            <div>


                             @if($r->active == 1 || !is_null(auth()->user()->agents()->first()) && !CheckPermission(auth()->user()->agents()->first()->id,'5_gallery_pictures') && $count < 1 )

                             <form id="submitactive" method="post" action="{{url('active-gallery')}}">
                               {{csrf_field()}}
                               <input type="hidden" name="id" value="{{$r->id}}">
                               <label  style="width: 100%;font-weight: 700;"><span style="{{$r->active == 1?'color: green;':''}}">Active</span> / Inactive <input type="checkbox" name="active" value="1" style="float: right;transform: scale(1.5);"  onclick="submit()" {{$r->active == 1?'checked':''}}> </label>
                             </form>

                             @elseif( $r->active == 1 || !is_null(auth()->user()->agents()->first()) && CheckPermission(auth()->user()->agents()->first()->id,'5_gallery_pictures') && $count < 5)

                             <form id="submitactive" method="post" action="{{url('active-gallery')}}">
                              {{csrf_field()}}
                              <input type="hidden" name="id" value="{{$r->id}}">
                              <label style="width: 100%;color: #f58220; font-weight: 700;">  Active / Inactive <input type="checkbox" style="float: right;transform: scale(1.5);" name="active" value="1" onclick="submit() "  {{$r->active == 1?'checked':''}}> </label>
                            </form>

                            @else


                            <span style="font-size: 13px;">Upgrade to <a href="{{url('subscriptions')}}" style="    color: #f58220; font-weight: 700;">Verified Agent</a>  to add more <input type="checkbox" name="active" value="1"  disabled="" style="    transform: scale(1.5); float: right;"></span>

                            @endif
                          </div>
                          @if($r->admin_approved != 1)
                          <p class="text-danger">Not Approved</p>
                          @endif
                          <img src="{{url('storage/uploads/agents/'.$r->image)}}"
                          style="width: 100%;height:200px;object-fit:contain">
                        </div>
                      </div>
                      @endforeach
                       @else
                       <div class="content-box-agent">
                             <p class="no-record">No Gallery Images Added</p>
                       </div>
                
                    @endif
                    </div>
                    {!! $gallery->links() !!}
                   
                  </div>
                </div>
              </div>
              @endsection
              @push('script')
              <script type="text/javascript">
                function submit() {
                  $('#submitactive').submit();
                }
                function addToHome(pointer) {

                  var $this = $(pointer);
                  var tr = $this.closest('tr');
                  var id = tr.data('id');

                  if ($this.is(':checked')) {
                    var is_home = 1;
                  } else {
                    var is_home = 0;
                  }

                  $this.prop("disabled", true);
                  $this.val("Processing..");

                  $.ajax({
                    url: SITE_PATH + '/active-review',
                    type: 'GET',
                    data: {
                      is_home: is_home,
                      id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                      if (data.notify) {
                        $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
                      } else {
                        $(".top" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
                      }
                    },
                    error: function() {

                    },
                    complete: function() {
                      $this.prop("disabled", false);
                    }
                  });
                }
              </script>
              @endpush