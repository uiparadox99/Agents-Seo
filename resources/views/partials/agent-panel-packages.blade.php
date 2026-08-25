<div class="row">
@foreach($packages as $s)
<div class="col-md-4 mb-2">
<div class="agent-detail-box content-box-agent m-0" style="border-color: #070c39">

  
    @if(!empty($s->image))
      <img src="{{url('storage/uploads/packages/'.$s->image)}}" width="100%" style="height:150px;object-fit:cover">
      @else
      <img src="{{url('images/placeholder.jpg')}}" width="100%" style="height:150px;object-fit:cover">
      @endif
      <h6 class="mt-3">{{ ucfirst($s->name) }} 
       <span style="float: right;">
      <a href="{{ route('user.edit-packages', $s->umrahId) }}" title="Edit" >
        <button class="btn btn-primary btn-xs btn-sm">Edit</button></a>&nbsp;
        <a href="{{ route('user.edit-packages',['id' => $s->umrahId, 'copy' => 'yes']) }}" title="Edit">
        <button class="btn btn-success btn-xs btn-sm">Copy</button></a></span>
        <div class="clearfix"></div>
      </h6>
      <table class="table table-striped w-100">
        <tr data-id="{{$s->umrahId}}">
          
          <th>Active / Inactive </th>
          <td>     @if(is_null($packages->where('active',1)->first()) || $s->active == 1)
            <label> <input type="checkbox" onchange="addToHome(this)" {{ $s->active == 1?'checked':'' }}> </label><span class="top<?php echo $s->umrahId; ?>"></span>

            @else
            <label> <input type="checkbox" onchange="addToHome(this)"  {{ $s->active == 1?'checked':'' }}></label><span class="top<?php echo $s->umrahId; ?>"></span>

            @endif
          </td>
          </tr>
        <tr>
          <th>Added On </th>
          <td>{{date('d M Y',strtotime($s->created_at))}}</td>
        </tr>
        <tr>
          <th>Airline</th>
          <td>{{$s->airline}}</td>
          </tr>
        <tr>
          <th>Departure City</th>
          <td>{{$s->from}}</td>
        </tr>
             
      </table>


    </div>
    </div>
    
    @endforeach
  </div>