@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
            <h3>BEOE Jobs <a href="{{url('agent-add-foreign-job')}}" class="btn btn-primary" style="float:right">Add Job</a> </h3>
            @if($jobs->count() > 0)
            <div class="table-responsive content-box-agent"  >
                <table class="table table-borderd table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Country</th>
                            <th>Salary</th>
                  <!--           <th>Requirement</th> -->
                            <th>Place of Duty</th>
                               <th>Permission</th>
                            <th>Action</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $r)
                        <tr data-id="{{ $r->id }}">
                            
                            <td>{{$r->title}}</td>
                            <td style="font-family:arial"> {{$r->relation_country->country}}</td>
                             <td style="font-family:arial"> {{$r->salary}}</td>
                             <td style="font-family:arial"> {{$r->place_of_duty}}</td>
                             <td style="font-family:arial"> {{$r->permission}}</td>
                            <td><a href="{{route('edit-foreign-job',$r->id)}}" class="btn btn-success btn-sm">Edit</a> 
                            </td>
                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $jobs->links() !!}
            </div>
            @else
              <div class="content-box-agent">
                             <p class="no-record">No Job Added</p>
                       </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
function addToHome(pointer) {
var SITE_PATH = "{{ url('/') }}";
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
        url: SITE_PATH + '/job-active',
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