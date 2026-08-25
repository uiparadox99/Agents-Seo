@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Visas Policy Page
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-visa-policy') }}"
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
                                        <label for="">Issue Date</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="date"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->policy_date:'' }}"
                                            class="form-control date-picker" required>
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
                                        <img src="{{ url('storage/uploads/policy/'.$detail->image) }}"
                                            style="width: 200px; height: 200px;">
                                    </div>
                                    @endif
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-md-offset-2">
                                        <label for="">Image Alt</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text"  name="image_alt"
                                            value="{{ isset($detail)&&!is_null($detail)?$detail->image_alt:'' }}"
                                            class="form-control" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Content</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea class="form-control editor" id="content" placeholder="Content"
                                                name="content">{{ isset($detail)&&!is_null($detail)?$detail->content:'' }}</textarea>
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
</script>

@endpush