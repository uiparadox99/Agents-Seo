@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Jobs
             <a href="{{ url('admin/add-job') }}" class="btn btn-primary pull-right">Add Job</a> 
        </h1>

    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form method="get" action="">
                              <div class="row">
                                 <div class="form-group col-md-2">
                                    <label for="">Airlines</label>
                                    <select name="airline" id="" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($airlines as $c)
                                        <option value="{{$c->users_id}}"
                                            {{request()->has('airline') && request()->get('airline') == $c->users_id ?'selected':'' }}>
                                            {{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                 <div class="form-group col-md-2">
                                    <label for="">Countries</label>
                                    <select name="countries_id" id="countries" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($countries as $c)
                                        <option value="{{$c->id}}"
                                            {{request()->has('countries_id') && request()->get('countries_id') == $c->id ?'selected':'' }}>
                                            {{$c->country}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Job City</label>
                                    <select name="city" id="cities" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($cities as $c)
                                        <option value="{{$c->id}}" data-country="{{$c->countries_id}}"
                                            {{request()->has('city') && request()->get('city') == $c->id ?'selected':'' }}>
                                            {{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Job Designation</label>
                                    <select name="designation" id="" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($designations as $c)
                                        <option value="{{$c->id}}"
                                            {{request()->has('designation') && request()->get('designation') == $c->id ?'selected':'' }}>
                                            {{$c->name}} ({{!is_null($c->category)?$c->category->name:''}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover datatables">
                            <thead>
                                <tr>
                                     <th>Date</th>
                                <th>By</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Title</th>
                                   <th>Designation</th>
                                   <th>Airline</th>
                            <th>Offer</th>
                            <!--<th width="30%">Requirement</th>-->
                            <th>Apply Date</th>
                            <th>Active</th>
                            <th>Applicants</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $r)
                        <tr data-id="{{ $r->id }}">
                             <td>{{date('d M Y',strtotime($r->created_at))}}</td>
                             <td>
                                @if(!is_null($r->agent))
                                Agent
                                @else
                                Airline
                                @endif
                             </td>
                             <td>{{!empty($r->country)?$r->country->country:''}}</td>
                               <td>{{!empty($r->airlineCity)?$r->airlineCity->name:''}}</td>
                            <td>{{explode('at',$r->title)[0]}}</td>
                            <td>{{!is_null($r->jobDesignation)?$r->jobDesignation->name:''}}</td>
                             <!--<td>{{!is_null($r->agent)?$r->agent->business_name:''}}</td>-->
                             
                             <td>{{!is_null($r->user) && !is_null($r->user->airline)?$r->user->airline->name:''}}</td>
                            <td style="font-family:arial">{{$r->offer}}</td>
                            <!--<td>{!! $r->requirement!!}</td>-->
                            <td style="font-family:arial">{{$r->apply_date}}</td>
                            <td>
                                <form class="" method="get" action="" id="form{{$r->id}}">
                                    <input type="hidden" value="{{$r->id}}" name="active_id">
                                    <label><input onchange="$('#form{{$r->id}}').submit()" type="checkbox" name="active" value="1" {{$r->active == 1?'checked':''}}> Active</label>
                                </form>
                            </td>
                            <td><a
                                    href="{{url('admin/jobs-applicants?id='.$r->id)}}" class="btn btn-primary btn-sm"> {{$r->jobApplicants->count()}} Applications</a>
                                    <a
                                    href="{{url('admin/edit-job/'.$r->id)}}" class="btn btn-primary btn-sm"> Edit</a>
                            </td>
                            <!-- <td>@if($r->status == 'unpaid')
                                <p>Not Paid yet</p>
                                @else
                                <a href="{{url('/renew-subscription?id='.$r->id)}}"  class="btn btn-success btn-sm">Renew</a>
                                @endif
                            </td> -->
                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
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
        url: SITE_PATH + '/save-featured-blog',
        type: 'GET',
        data: {
            is_featured: is_home,
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