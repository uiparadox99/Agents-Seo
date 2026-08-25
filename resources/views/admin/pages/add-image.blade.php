@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Image
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations"
                                action="{{ route('admin.save-image') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Image</label>
                                        </div>
                                        @if(isset($detail) && !is_null($detail->image))
                                     
                                        <div class="col-sm-6 form-group">
                                            <input type="file" name="image" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <img src="{{ url('storage/uploads/images/'.$detail->image) }}" width="30%">
                                        </div>

                                        @else
                                        <div class="col-sm-6">
                                            <input type="file" name="image" class="form-control" required="" value="">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-md-offset-2">
                                        <label for="">Image Alt</label>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="text" name="image_alt" class="form-control" value="">
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
</script>
@endpush