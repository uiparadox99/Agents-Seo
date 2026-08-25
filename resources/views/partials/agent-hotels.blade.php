@foreach($hotels as $h)
<tr data-id="{{$h->id}}" >
    <td class="text-capitalize">
        {{$h->hotel}}
        <br>
        {{$h->hotelcity}}
    </td>
    <td >SAR {{$h->double}}</td>
    <td >SAR {{$h->tripple}}</td>
    <td >SAR {{$h->quad}}</td>
    <td  class="text-capitalize">@if($h->meal_type == 'room only')
        {{$h->meal_type}}
        @else
        <span class="text-success">{{$h->meal_type}}</span>
        @endif</td>
    <!--    <td class="text-capitalize">{{$h->agent_name}} <br> <i class="fa fa-phone-volume"></i> {{$h->agent_contact}}
    </td>
    -->
    <td class="text-center">   <span  class="top<?php echo $h->id; ?> btn-block">   </span><label>
    <input type="checkbox" onchange="addToHome(this)" {{ $h->active == 1?'checked':'' }}>
Active</label><br>

<a href="{{url('agent-edit-umrah-hotel-'.$h->id)}}" title="Edit" class="  btn btn-primary btn-xs btn-sm">Edit</a></td>
</tr>

@endforeach