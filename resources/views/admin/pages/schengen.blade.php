@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Schengen Page
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-schengen') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="row form-group">
                                    <div class="col-md-1 col-md-offset-2">
                                        <label for="">Heading</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="title" name="heading"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->heading:'' }}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-1 col-md-offset-2">
                                        <label for="">Image</label>
                                    </div>
                                    @if(empty($detail->image))
                                    <div class="col-sm-6">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    @else
                                    <div class="col-sm-3">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <img src="{{ url('storage/uploads/schengen/'.$detail->image) }}"
                                            style="width: 200px; height: 200px;">
                                    </div>
                                    @endif
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-md-offset-2">
                                        <label for="">Image Alt</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="image_alt" name="image_alt"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->image_alt:'' }}"
                                            class="form-control" >
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Content Before List</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea class="form-control editor" id="content" placeholder="Content"
                                                name="content1">{{ isset($detail)&&!is_null($detail)?$detail->content1:'' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($detail->countries))
                                @php
                                $country = explode(',', $detail->countries);
                                @endphp
                                @foreach($country as $f)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Country</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="country[]">
                                                <option value="">Select</option>
                                                @foreach($countries as $c)
                                                <option value="{{ $c->country }}"
                                                    {{ isset($f)&& $f == $c->country ?'selected':'' }}>{{ $c->country }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                @else
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Country</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="country[]">
                                                <option value="">Select</option>
                                                @foreach($countries as $c)
                                                <option value="{{ $c->country }}">{{ $c->country }}</option>
                                                @endforeach
                                            </select>
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

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Content After List</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea class="form-control editor" id="content" placeholder="Content"
                                                name="content2">{{ isset($detail)&&!is_null($detail)?$detail->content2:'' }}</textarea>
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
$('.date-picker').datepicker({
    setDate: new Date(),
    format: 'dd/mm/yyyy',
});
$('.select2').select2();
var count = 1;
$("#addmore").click(function() {

    var number_html =
        '<div class="expended_html">  <div class="form-group"><div class="row"><div class="col-md-1 col-md-offset-2"><label for="">Country</label></div> <div class="col-sm-6"><select class="form-control select2" name="country[]"><option value="">Select</option>  @foreach($countries as $c) <option value="{{ $c->country }}" >{{ $c->country }}</option> @endforeach</select></div><div class="col-sm-1"><a href="javascript:;" class="removeNo  btn-danger btn-sm " style="margin-bottom:5px" > &times;</a> </div></div>  </div></div>';

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