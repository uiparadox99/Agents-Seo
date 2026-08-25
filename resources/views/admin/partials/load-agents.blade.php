 <option value="">Select</option>
 @foreach($agents as $a)
 <option value="{{$a->id}}" {{isset($detail)&&!is_null($detail) && $detail->agents_id == $a->id?'selected':''}}>{{$a->business_name}} ({{$a->city}})</option>
 @endforeach