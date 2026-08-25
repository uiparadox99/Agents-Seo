@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
            <h3>Hajj Packages <a href="{{url('agent-add-hajj-package')}}" class="btn btn-danger" style="float:right">Add Package</a> </h3>
            @if($detect->isMobile())
            <div class="mobile-search-bar" id="expandmobileSearch" onclick="expand()"> Search Hajj Packages <i class="fa fa-filter" style="float: right;"></i></div>
            <div class="content-box-agent" id="mobileSearch" style=" display: none;">
                @else
                <div class="content-box-agent">
                    @endif
                    <form method="get" action="{{url('agent-hajj-packages')}}"  id="filter" onsubmit="return false;">
                        <div class="row">
                         
                         
                          <div class="col-md-4 form-group">
                            <label>Title</label>
                            <input type="text" name="name" placeholder="Package Title" class="form-control" value="{{request()->has('name')?request()->get('name'):''  }}">
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <label>From</label>
                            <select name="from" class="form-control">
                                <option value=""> Select</option>
                                @foreach($from as $c)
                                <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') == $c->name?'selected':''}}>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Airlines</label>
                            <select name="airline" class="form-control">
                                <option value=""> Select</option>
                                @foreach($airlines as $c)
                                <option value="{{$c->id}}" {{request()->has('airline') && request()->get('airline') == $c->id?'selected':''}}>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 form-group text-center">
                         
                            <button type="button"  onclick="filters()" class="btn btn-primary btn-block "><i class="fa fa-search" style="margin-right: 10px;"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div  id="agentPackgesData">
               @include('partials.agent-panel-packages')
           </div>
           
           {!! $packages->links() !!}
       </div>
   </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
  $( document ).ready(function() {
    $('#expandmobileSearch').click(function() {

       $('#mobileSearch').toggle();
   });
});
  function filters(){
    var formData = $("#filter").serialize();

    $.ajax({
        url: "{{request()->url()}}",
        type: "GET",
        data: formData,
        beforeSend: function()
        {
            $('#agentPackgesData').html('<tr><td colspan="4"class="text-center"><b><i class="fa fa-spinner fa-spin"></i> Loading...</b></td></tr>');
        }

    }).done(function(data)
    {
        if(data.html == ""){
         $('#agentPackgesData').html('<tr><td colspan="4" class="text-center"><b>No Record found</b></td></tr>');
         return;
     }
     $("#agentPackgesData").html(data.html);
 });
}
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
        url: SITE_PATH + '/agent-package-active',
        type: 'GET',
        data: {
            is_home: is_home,
            id: id
        },
        dataType: "JSON",
        success: function(data) {
            if (data.notify) {
                $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
                location.reload();
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