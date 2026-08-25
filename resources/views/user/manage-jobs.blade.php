@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
            <h3>Staff Jobs <a href="{{url('agent-add-job?type='.request()->get('type'))}}" class="btn btn-primary" style="float:right">Add Job</a> </h3>
            @if($jobs->count() > 0)
            <div class="table-responsive content-box-agent"  >
                <table class="table table-borderd table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Offer</th>
                            <th>Experience</th>
                  <!--           <th>Requirement</th> -->
                            <th>Apply Date</th>
                            <th>Active?</th>
                            <th>Action</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $r)
                        <tr data-id="{{ $r->id }}">
                            <td style="font-family:arial">{{date('d M Y',strtotime($r->created_at))}}</td>
                            @if(request()->get('type') == 'agent')
                            <td>{{str_replace('required at '.$r->agent->business_name,'',$r->title)}}</td>
                            @else
                                <td>{{$r->title}}</td>
                            @endif
                            
                            <td style="font-family:arial">Rs {{$r->offer}}</td>
                            <td style="font-family:arial">{{!is_null($r->jobExperience)?$r->jobExperience->name:''}}</td>
             <!--                <td>{{$r->requirement}}</td> -->
                            <td style="font-family:arial">{{date('d M Y',strtotime($r->apply_date))}}</td>
                              <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $r->active == 1?'checked':'' }}><span
                                            class="top<?php echo $r->id; ?>"></span>
                                    </td>
                            <td><a href="{{url('edit-job/'.$r->id.'?type='.request()->get('type'))}}" class="btn btn-success btn-sm">Edit</a> <a
                                    href="{{url('agent-requests?id='.$r->id)}}" class="btn btn-primary btn-sm">Applications {{$r->jobApplicants()->where('approved',1)->count()}}</a>
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