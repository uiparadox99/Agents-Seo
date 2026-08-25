@if($hotels->count() > 0)
@foreach($hotels as $h)
<option value="{{$h->id}}" {{isset($detail) && !is_null($detail) && $detail->hotels_id == $h->id?'selected':''}}>{{$h->name}}</option>
@endforeach
@else
<option value="">No Hotel Found</option>
@endif