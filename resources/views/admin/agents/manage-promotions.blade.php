@extends('admin.layout.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<div class="content-wrapper">
    <section class="content-header">
        <h1>
           Approve Promotions
        </h1>

    </section>
 <section class="content">
        <div class="box">
            <div class="box-body">
                <form method="get" action="" class="row">
                    <div class="form-group col-md-4">
                        <label>Agent</label>
                        <select name="agent" class="form-control select2">
                            <option>Select</option>
                             @foreach($agents as $key => $r)
                             <option {{request()->has('agent') && request()->get('agent') == $r->agents_id?'selected':''}} value="{{!is_null($r->agent)?$r->agent->id:''}}">{{!is_null($r->agent)?$r->agent->business_name:''}}</option>>
                             @endforeach
                        </select>
                    </div>
                      <div class="form-group col-md-2">
                          <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block" >Search</button>
                    </div>
                </form>
            </div>
         </div>
     </section>
    <section class="content">
        <div class="row">   
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Uplodaed BY</th>
                                    <th>Agent</th>
                                    <th>Airline</th>
                                    <th>Promotion</th>
                                    <th>Approve it</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotions as $key => $r)
                                <tr data-id="{{ $r->id }}">
                                    <td>{{!is_null($r->airline_id)?'Airline':'Agent'}}</td>
                                    <td><a href="{{url(!is_null($r->agent)?'agent/'.$r->agent->slug:'')}}" target="_blank">{{!is_null($r->agent)?$r->agent->business_name:''}}</a></td>
                                 
                                    <td>{{!is_null($r->airline_id)?$r->airline->name:''}}</td>
                                    <td>
                                    <a href="{{url('storage/uploads/agents/'.$r->image)}}" data-lightbox="image-{{$key+1}}" data-title="Image">
                                        <img src="{{url('storage/uploads/agents/'.$r->image)}}" alt=""
                                        style="height:100px;object-fit:contain">
                                    </a>
                                     </td>
                                    <td>
                                        <label><input type="checkbox" onchange="addToHome(this)"
                                            {{ $r->admin_approved == 1?'checked':'' }}><span
                                            class="top<?php echo $r->id; ?>"></span> Approve it</label>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $promotions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
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
        url: MAIN_PATH + '/admin/approve-promotion',
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