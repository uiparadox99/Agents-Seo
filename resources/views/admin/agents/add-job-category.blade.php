@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Job Category
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form enctype="multipart/form-data" method="post" class="has-callback-validations"
                                action="{{ url('admin/save-job-category') }}">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="name" class="form-control" required=""
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">
                                        </div>
                                    </div>
                                </div>

                                <!--@if(isset($detail)&&!is_null($detail) && !empty($detail->image))-->
                                <!--<div class="form-group">-->
                                <!--    <div class="row">-->
                                <!--        <div class="col-md-1 col-md-offset-2">-->
                                <!--            <label for="">Image</label>-->
                                <!--        </div>-->
                                <!--        <div class="col-sm-3">-->
                                <!--            <input type="file" name="image" class="form-control" value="">-->
                                <!--        </div>-->
                                <!--        <div class="col-sm-3">-->
                                <!--            <img src="{{url('storage/uploads/jobs/'.$detail->image)}}"-->
                                <!--                style="width: 100%;height: 100px;">-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--@else-->

                                <!--<div class="form-group">-->
                                <!--    <div class="row">-->
                                <!--        <div class="col-md-1 col-md-offset-2">-->
                                <!--            <label for="">Image</label>-->
                                <!--        </div>-->
                                <!--        <div class="col-sm-6">-->
                                <!--            <input type="file" name="image" class="form-control"  value="">-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--@endif-->

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