@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Link
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-link') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Image</label>
                                        </div>
                                        @if(isset($detail)&&!is_null($detail->img))
                                        <div class="col-sm-3">
                                            <input type="file" name="img" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <img src="{{ url('storage/uploads/links/'.$detail->img) }}" width="30%">
                                        </div>

                                        @else
                                        <div class="col-sm-6">
                                            <input type="file" name="img" class="form-control" value="">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" placeholder="Name"
                                                name="name" value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Link</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" placeholder="Link"
                                                name="link" value="{{ isset($detail)&&!is_null($detail)?$detail->link:'' }}">
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

@endpush