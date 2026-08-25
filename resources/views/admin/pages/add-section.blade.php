@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Section
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-section') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ isset($sec)&&!is_null($sec)?$sec->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Title</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="title" class="form-control" required
                                                value="{{ isset($sec)&&!is_null($sec)?$sec->title:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="open">Open</label>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="checkbox" id="open" name="open" value="1"
                                                {{ isset($sec)&&!is_null($sec) && $sec->open == 1?'checked':'' }}>
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