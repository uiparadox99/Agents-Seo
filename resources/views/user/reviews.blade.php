@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9 agent-main-box">
        	<h3>Business Reviews</h3>
        	<div class="content-box-agent">
                @if($reviews->count() < 0)
        		<table class="table table-borderd table-striped">
        			<thead>
        				<tr>
        				<th>Name</th>
        				<th>Rating</th>
        				<th>Message</th>
        				<th>Active?</th>
        			</tr>
        			</thead>
        			<tbody>
        				@foreach($reviews as $r)
        				<tr data-id="{{ $r->id }}">
        					<td>{{$r->user->name}}</td>
        					<td>{{$r->rating}}</td>
        					<td>{{$r->message}}</td>
        					   <td><input type="checkbox" onchange="addToHome(this)" {{ $r->active == 1?'checked':'' }}><span class="top<?php echo $r->id; ?>"></span>
                                </td>
        				</tr>
        				@endforeach
        			</tbody>
        		</table>
        		{!! $reviews->links() !!}
                @else
      
                             <p class="no-record">No Reviewed Yet </p>
                     
                @endif
			</div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    function addToHome(pointer){

        var $this   = $(pointer); 
        var tr      = $this.closest('tr');
        var id      = tr.data('id');
      
        if ($this.is(':checked')) {
            var is_home = 1;
        }else{
            var is_home = 0;
        }

        $this.prop("disabled", true);
        $this.val("Processing..");

        $.ajax({
            url: SITE_PATH+'/active-review',
            type: 'GET',
            data: {is_home: is_home, id: id},
            dataType: "JSON",
            success: function(data){
                if(data.notify){
                    $(".top"+id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
                }else{
                    $(".top"+id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
                }
            },
            error: function(){

            },
            complete:function(){
              $this.prop("disabled", false);
          }
      });
    }

</script>
@endpush