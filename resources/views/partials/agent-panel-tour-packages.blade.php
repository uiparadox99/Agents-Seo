<div class="row">
@foreach($packages as $s)
<div class="col-md-6">
<div class="agent-detail-box content-box-agent mb-4" style="border-color: #070c39">

      @if(!empty($s->image))
      <img src="{{url('storage/uploads/packages/'.$s->image)}}" width="100%;" style="height: 230px;object-fit:cover">
      @else
      <img src="{{url('images/placeholder.jpg')}}" width="100%" style="height: 230px;object-fit:cover" >
      @endif

      <h3 class="mt-2"><a href="{{ url('tour-packages/'.$s->slug) }}" title="preview"  target="_blank" class="btn btn-secondary btn-xs btn-sm">Preview</a>  <a href="{{ route('user.edit-tour-packages', $s->id) }}" title="Edit" style="float: right;">
        <button class="btn btn-primary btn-xs btn-sm">Edit</button></a>
        <div class="clearfix"></div>
      </h3>
      <table class="table table-striped">
        <tr data-id="{{$s->id}}">
          <th>Active / Inactive </th>
          <td>     @if(is_null($packages->where('active',1)->first()) || $s->active == 1)
            <label> <input type="checkbox" onchange="addToHome(this)" {{ $s->active == 1?'checked':'' }}> </label><span class="top<?php echo $s->id; ?>"></span>

            @else
            <label> <input type="checkbox" onchange="addToHome(this)" disabled="" {{ $s->active == 1?'checked':'' }}></label><span class="top<?php echo $s->id; ?>"></span>

            @endif
          </td>
        </tr>
        <tr>
          <th width="40%">Title</th>
          <td>{{$s->title}}</td>
        </tr>
        <tr>
          <th>Departure Date</th>
          <td>{{$s->departure_date}}</td>
        </tr>
        <tr>
            <th>Return Date</th>
            <td>{{$s->return_date}}</td>
          </tr>
        <tr>
          <th>Price</th>
          <td><small>Rs.</small>{{$s->price}}</td>
        </tr>
        <tr>
          <th>Nights</th>
          <td>{{$s->nights}}</td>
        </tr>
        <tr>
            <th>Days</th>
            <td>{{$s->days}}</td>
          </tr>
      </table>


    </div>
  </div>
  
  
  @endforeach
</div>