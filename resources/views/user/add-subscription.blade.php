@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>

        <div class="col-md-9" style="padding: 0 5px;">
            <form method="post" class="has-callback-validations" action="{{ route('user.save-subscription') }}"
                enctype="multipart/form-data" id="myModal"
                style="box-shadow: 0 4px 15px 0 #dfdfdf;padding: 15px;margin: 10px 0">
                @csrf



                <h3 class="text-center">Subscription</h3>
                <hr>
                <input type="hidden" name="price" id="subs_price">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Plan</label>
                        <select name="plan" id="plan_id" class="form-control" data-validation="required">
                            <!-- <option value="">Select</option> -->
                            @foreach($plans as $p)
                            @if($p->id != 5 )
                            <option value="{{$p->id}}"
                                data-price="{{!is_null($p->plansPriceDiscounts()->where('active',1)->first()) && !empty($p->plansPriceDiscounts()->where('active',1)->first())?$p->plansPriceDiscounts()->where('active',1)->first()->price:''}}" data-2year="{{!is_null($p->plansPriceDiscounts()->where('active',1)->first()) && !empty($p->plansPriceDiscounts()->where('active',1)->first())?$p->plansPriceDiscounts()->where('active',1)->first()->price_2year:''}}">
                                {{$p->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Period</label>
                        <select name="period" id="period" class="form-control" data-validation="required">
                            <option value="">Select</option>
                            <!-- <option value="1">1 Year</option>
                            <option value="2">2 Year</option> -->
                            @for($i = 1; $i<=2; $i++) <option value="{{$i}}" id="{{$i}}"
                                {{!empty($modal)?$d->period == $i?"selected":"":""}}> {{$i}} Year</option>
                                @endfor
                        </select>
                    </div>
                </div>
                <h3 id="price" class="text-center number-style"></h3>


                <div class="row">
                    <div class="col-sm-6 col-sm-offset-5">
                        <input type="submit" name="save" value="Upgrade Now" class="btn btn-primary">
                        <input type="reset" value="Reset" class="btn btn-default">
                    </div>
                </div>
            </form>
          
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
$("#plan_id").change(function() {
    var plan = $('#plan_id option:selected').data('price');
    var year = $('#plan_id option:selected').data('2year');

    var period = $('#period option:selected').val();
    if (period == 1) {
  var price = plan;
    }else{
  var price = year;
    }
    // var price = plan * period;
    $('#price').html('Total Price : <strong>' + price + '</strong>');
    $('#subs_price').val(price);
});
$("#period").change(function() {
    var plan = $('#plan_id option:selected').data('price');
  var year = $('#plan_id option:selected').data('2year');
    var period = $('#period option:selected').val();
      if (period == 1) {
  var price = plan;
    }else{
  var price = year;
    }
    // var price = plan * period;
    $('#subs_price').val(price);
    $('#price').html('Total Price : <strong>' + price + '</strong>');
});
</script>
@endpush