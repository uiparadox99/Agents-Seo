@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add / Edit Fares For {{ $airline->name }}
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations"
                                action="{{ route('admin.save-fares') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="airline_id"
                                    value="{{ isset($airline)&&!is_null($airline)?$airline->id:'' }}">
                                @if($fares->count() > 0)
                                @foreach($fares as $f)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">From</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="from[]">
                                                <option value="">Select</option>
                                                @foreach($cities as $c)
                                                <option value="{{ $c->name }}"
                                                    {{ isset($f)&& $f->from == $c->name ?'selected':'' }}>{{ $c->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">To</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="to[]">
                                                <option value="">Select</option>
                                                @foreach($cities as $c)
                                                <option value="{{ $c->name }}"
                                                    {{ isset($f)&& $f->to == $c->name ?'selected':'' }}>{{ $c->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="price[]" class="form-control" r
                                                value="{{ isset($f)&&!is_null($f)?$f->price:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Return Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="return[]" class="form-control" r
                                                value="{{ isset($f)&&!is_null($f)?$f->return:'' }}">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">From</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="from[]">
                                                <option value="">Select</option>
                                                @foreach($cities as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">To</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="to[]">
                                                <option value="">Select</option>
                                                @foreach($cities as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="price[]" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Return Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="return[]" class="form-control" r value="">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="new_image"></div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <a href="javascript:void(0);" class="addmore  btn-primary btn pull-right"
                                                id="addmore">Add More</a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-5">
                                        <input type="submit" name="save" value="Save" class="btn btn-primary">
                                        <input type="reset" value="Reset" class="btn btn-default">
                                    </div>
                                </div>
                            </form>
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
$('.select2').select2();

var count = 2;
$("#addmore").click(function() {

    var number_html =
        '<div class="expended_html"><div class="form-group"> <div class="row"> <div class="col-md-1 col-md-offset-2"><label for="">From</label> </div> <div class="col-sm-6">  <select class="form-control select2" name="from[]"><option value="">Select</option> @foreach($cities as $c) <option value="{{ $c->name }}" >{{ $c->name }}</option> @endforeach</select> </div><div class="col-sm-2"><a href="javascript:;" class="removeNo  btn-danger btn-sm " style="margin-bottom:5px" > &times;</a></div>   </div>  </div><div class="form-group"><div class="row"><div class="col-md-1 col-md-offset-2"><label for="">To</label></div><div class="col-sm-6"><select class="form-control select2" name="to[]"><option value="">Select</option> @foreach($cities as $c)<option value="{{ $c->name }}" >{{ $c->name }}</option> @endforeach</select>  </div> </div> </div>   <div class="form-group"> <div class="row">  <div class="col-md-1 col-md-offset-2"> <label for="">Price</label>  </div> <div class="col-sm-6"><input type="number" name="price[]" class="form-control"   >  </div> </div> </div><div class="form-group">   <div class="row"><div class="col-md-1 col-md-offset-2"> <label for="">Return Price</label></div> <div class="col-sm-6"> <input type="number" name="return[]" class="form-control"  >   </div> </div></div></div>';

    $(".new_image").append(number_html);

    count++;

    $(".removeNo").click(function() {
        $(this).closest('.expended_html').remove();
        count--;

        $("#addmore").show();
    });
});
</script>
@endpush