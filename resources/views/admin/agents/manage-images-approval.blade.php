@extends('admin.layout.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Approve Gallery
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
                             <option {{request()->has('agent') && request()->get('agent') == $r->id?'selected':''}} value="{{$r->id}}">{{$r->business_name}}</option>>
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
                                    <th>Agent</th>
                                    <th width="30%">Cover</th>
                                    <th with="20%">Logo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($images as $key => $r)
                                <tr data-id="{{ $r->id }}">
                                <td><a href="{{url('agent/'.$r->slug)}}" target="_blank">{{$r->business_name}}</a></td>
                                    <td>
                                    <a href="{{url('storage/uploads/agents/'.$r->cover)}}" data-lightbox="cover-{{$key+1}}" data-title="cover">
                                        <img src="{{url('storage/uploads/agents/'.$r->cover)}}" alt=""
                                        style="height:100px;object-fit:contain">
                                    </a>
                                    <br>
                                    @if($r->cover_changed == 1)
                                        <form method="get" action="">
                                            <input type="hidden" name="agent_id" value="{{$r->id}}">
                                            <button type="submit" value="approve" name="cover_change" class="btn btn-sm btn-primary">Approve</button>
                                            <button type="submit" value="reject" name="cover_change" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                        @endif
                                    </td>
                                    <td>
                                    <a href="{{url('storage/uploads/agents/'.$r->logo)}}" data-lightbox="logo-{{$key+1}}" data-title="logo">
                                        <img src="{{url('storage/uploads/agents/'.$r->logo)}}" alt=""
                                        style="height:100px;object-fit:contain">
                                    </a>
                                        @if($r->logo_changed == 1)
                                        <form method="get" action="">
                                            <input type="hidden" name="agent_id" value="{{$r->id}}">
                                            <button type="submit" value="approve" name="logo_change" class="btn btn-sm btn-primary">Approve</button>
                                            <button type="submit" value="reject" name="logo_change" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $images->links() !!}
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
        url: MAIN_PATH + '/admin/approve-gallery',
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