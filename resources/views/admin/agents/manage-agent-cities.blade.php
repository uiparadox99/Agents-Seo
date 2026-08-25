@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Agent Cities
            <a href="{{ url('admin/add-agent-city') }}" class="btn btn-primary pull-right">Add Agent City</a>
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">PK Agent Cities</a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Foreign Agent Cities</a></li>
                          </ul>
                        
                          <!-- Tab panes -->
                          <div class="tab-content" style="padding-top:20px">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <table class="table table-hover datatables" >
                                    <thead>
                                        <tr>
                                            <!--<th width="10%">Picture</th>-->
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Show Home</th>
                                            <th width="10%">Order</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cities as $s)
                                        <tr data-id="{{$s->id}}">
                                            <!--@if(empty($s->image))-->
                                            <!--<td>-->
                                            <!--    <img src="//placehold.it/200x200px" style="width: 100px;height: 100px">-->
                                            <!--</td>-->
                                            <!--@else-->
                                            <!--<td>-->
                                            <!--    <img src="{{url('storage/uploads/agents/'.$s->image)}}"-->
                                            <!--        style="width: 100px;height: 100px">-->
                                            <!--</td>-->
                                            <!--@endif-->
                                            <td>
                                                {{ $s->name }}
                                            </td>
                                            <td>{{!is_null($s->country)?$s->country->country:''}}</td>
                                            <td><input type="checkbox" style="position: unset;left: unset;opacity: unset;" onchange="addToHome(this)" {{ $s->top_trending == 1?'checked':'' }} ><span class="top<?php echo $s->id; ?>"></span>
        									</td>
        
        									<td>
        										@if(!empty($s->top_number) && !is_null($s->top_number))
        														{{$s->top_number}} 
        														<a href="{{url('admin/unset-business-number/'.$s->id)}}" class="btn btn-danger btn-sm btn-xs
        															" style="margin-left: 15px;height: 20px">Unset</a>
        
        															@else
        										<select class="form-control" name="top_number" onchange="addNumber(this)">
        											<option value="">Select</option>
        											@for ($i=1; $i <= 22 ; $i++)
        											   @if(!in_array($i, $numbers)) 
        											<option value="{{$i}}" {{$s->top_number == $i?'selected':''}}>{{$i}}</option>
        											@endif
        											@endfor
        										</select>
        										<span class="trending<?php echo $s->id; ?>"></span>
        										@endif
        									</td>
                                            <td>
                                                <a href="{{ url('admin/edit-agent-city/'.$s->id) }}">
                                                    <button class="btn btn-success btn-sm"><i
                                                            class="fa fa-pencil"></i></button></a>
        
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile">
                                <table class="table table-hover datatables" >
                                    <thead>
                                        <tr>
                                            <!--<th width="10%">Picture</th>-->
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Show Home</th>
                                            <th width="10%">Order</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($foreign_cities as $s)
                                        <tr data-id="{{$s->id}}">
                                            <!--@if(empty($s->image))-->
                                            <!--<td>-->
                                            <!--    <img src="//placehold.it/200x200px" style="width: 100px;height: 100px">-->
                                            <!--</td>-->
                                            <!--@else-->
                                            <!--<td>-->
                                            <!--    <img src="{{url('storage/uploads/agents/'.$s->image)}}"-->
                                            <!--        style="width: 100px;height: 100px">-->
                                            <!--</td>-->
                                            <!--@endif-->
                                            <td>
                                                {{ $s->name }}
                                            </td>
                                            <td>{{!is_null($s->country)?$s->country->country:''}}</td>
                                            <td><input type="checkbox" style="position: unset;left: unset;opacity: unset;" onchange="addToHome(this)" {{ $s->top_trending == 1?'checked':'' }} ><span class="top<?php echo $s->id; ?>"></span>
        									</td>
        
        									<td>
        										@if(!empty($s->top_number) && !is_null($s->top_number))
        														{{$s->top_number}} 
        														<a href="{{url('admin/unset-business-number/'.$s->id)}}" class="btn btn-danger btn-sm btn-xs
        															" style="margin-left: 15px;height: 20px">Unset</a>
        
        															@else
        										<select class="form-control" name="top_number" onchange="addNumber(this)">
        											<option value="">Select</option>
        											@for ($i=1; $i <= 22 ; $i++)
        											   @if(!in_array($i, $numbers)) 
        											<option value="{{$i}}" {{$s->top_number == $i?'selected':''}}>{{$i}}</option>
        											@endif
        											@endfor
        										</select>
        										<span class="trending<?php echo $s->id; ?>"></span>
        										@endif
        									</td>
                                            <td>
                                                <a href="{{ url('admin/edit-agent-city/'.$s->id) }}">
                                                    <button class="btn btn-success btn-sm"><i
                                                            class="fa fa-pencil"></i></button></a>
        
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                          </div>
                        
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
var basePath = '{{url('/')}}';
		var agentTable = $('#example1').dataTable( {
			"iDisplayLength": 20,
			"processing": true,
			"serverSide": true,
			"bFilter": false,
			"ajax":{
                      url :"manage-agent-cities-pagination", // json datasource
                      type: "POST",  // type of method  , by default would be get
                      data: function(d) {
                      	var frm_data = $('#searchFrom').serializeArray();
                      	$.each(frm_data, function(key, val) {
                      		d[val.name] = val.value;
                      	});
                      },
                      error: function(){  // error handling code
                      }
                  },
                  'createdRow': function( row, data, dataIndex ) {
                  	$(row).attr('data-id', data.id);
                  },
                  "columns": [
                    { "data": "image", render: function(data, type, row, meta){
                  	if (row.image == '') {
                  		var $html = '<img src="//placehold.it/200x200px" style="width: 100px;height: 100px">';
                  	}else{
                  		var $html = ' <img src="'+basePath+'storage/uploads/agents/'+row.image+'"  style="width: 100px;height: 100px">';
                  	}
                  	return $html;  
                  } },
                  { "data": "name"},
                  { "data": "top_trending", render: function(data, type, row, meta){
                  	if (row.top_trending == 1) {
                  		var $html = '<input type="checkbox" style="position: unset;left: unset;opacity: unset;" onchange="addToHome(this)" checked ><span class="top'+row.id+'"></span>';
                  	}else{
                  		var $html = ' <input type="checkbox" style="position: unset;left: unset;opacity: unset;" onchange="addToHome(this)"  ><span class="top'+row.id+'"></span>';
                  	}
                  	return $html;  
                  } },
                  { "data": "business_name" },
                  { "data": "item_type"},
                  { "data": "email" },
                  { "data": "tin_number"},
                  { "data": "restaurant_address"},
                  { "data": "city"},

                  { "data": "isfeatured", render: function(data, type, row, meta){
                  	if (row.isfeatured == 1) {
                  		var $html = '		<div class="switch-field"><input type="radio" class="featured" id="switch_left'+row.id+'" name="switch_2'+row.id+'" value="1" checked/>\
                  		<label for="switch_left'+row.id+'">Yes</label>\
                  		<input type="radio" class="featured" id="switch_right'+row.id+'" name="switch_2'+row.id+'" value="0" />\
                  		<label for="switch_right'+row.id+'" >No</label></div>';
                  	}else{
                  		var $html = '	<div class="switch-field">	<input type="radio" class="featured" id="switch_left'+row.id+'" name="switch_2'+row.id+'" value="1" />\
                  		<label for="switch_left'+row.id+'">Yes</label>\
                  		<input type="radio" class="featured" id="switch_right'+row.id+'" name="switch_2'+row.id+'" value="0" checked />\
                  		<label for="switch_right'+row.id+'" >No</label></div>';
                  	}
                  	return $html;  
                  } },

                  { "data": "city"},
                  { "data": "action", render: function(data, type, row, meta){
                  	if (row.deleted_at != '') {
                  		var $html = '<div class="btn-group">\
                  		<button type="button" class="btn btn-info">Action</button>\
                  		<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">\
                  		<span class="caret"></span>\
                  		<span class="sr-only">Toggle Dropdown</span>\
                  		</button>\
                  		<ul class="dropdown-menu" role="menu">\
                  		<li>\
                  		<a href="'+basePath+'/admin/edit-restuarant/'+row.id+'" ><i class="fa fa-pencil"></i> Edit</a>\
                  		</li>\
                  		<li style="background-color: white;">\
                  		<a href="'+basePath+'/admin/delete-restaurant/'+row.id+'"><i class="fa fa-trash"></i> Delete</a>\
                  		</li>\
                  		<li style="background-color: white;">\
                  		<a href="'+basePath+'/admin/manage-item?restaurant=/'+row.id+'" class=""><i class="fa fa-bars"></i> Items</a>\
                  		</li>\
                  		<li style="background-color: white;">\
                  		<a href="'+basePath+'/admin/invoice-history'+row.id+'" class=""><i class="fa fa-money"></i> Invoice </a>\
                  		</li>\
                  		</ul>\
                  		</div>';
                  	}else{
                  		var $html = '<div class="btn-group">\
                  		<button type="button" class="btn btn-info">Action</button>\
                  		<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">\
                  		<span class="caret"></span>\
                  		<span class="sr-only">Toggle Dropdown</span>\
                  		</button>\
                  		<ul class="dropdown-menu" role="menu">\
                  		<li>\
                  		<a href="'+basePath+'/admin/edit-restuarant/'+row.id+'" ><i class="fa fa-pencil"></i> Edit</a>\
                  		</li>\
                  		<li style="background-color: white;">\
                  		<a href="'+basePath+'/admin/restore-restaurant/'+row.id+'" ><i class="fa fa-refresh"> </i> Restore</a>\
                  		</li>\
                  		<li style="background-color: white;">\
                  		<a href="'+basePath+'/admin/manage-item?restaurant=/'+row.id+'" class=""><i class="fa fa-bars"></i> Items</a>\
                  		</li>\
                  		<li style="background-color: white;">\
                  		<a href="'+basePath+'/admin/invoice-history'+row.id+'" class=""><i class="fa fa-money"></i> Invoice </a>\
                  		</li>\
                  		</ul>\
                  		</div>';
                  	}
                  	

                  	return $html;
                  }},
                  ]
              });
$("#search").click(function(){
	$('#example1').DataTable().draw(true);
});
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
        url: SITE_PATH + '/save-home-listing',
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

function addNumber(pointer) {

    var $this = $(pointer);
    var tr = $this.closest('tr');
    var id = tr.data('id');
    var top = $this.find(' option:selected').val();


    $this.prop("disabled", true);
    $this.val("Processing..");

    $.ajax({
        url: SITE_PATH + '/save-home-listing-number',
        type: 'GET',
        data: {
            top: top,
            id: id
        },
        dataType: "JSON",
        success: function(data) {
            location.reload();
            if (data.notify) {
                $(".trending" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
            } else {
                $(".trending" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
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