@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Custom Content
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-content') }}">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Page</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="page" class="form-control">
                                                <option value="">Select</option>

                                                @foreach($section as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ isset($detail)&& $detail->section_id == $sec->id ?'selected':'' }}>
                                                    {{ $sec->title }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Content</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea class="form-control editor" placeholder="Content"
                                                name="content">{{ isset($detail)&&!is_null($detail)?$detail->content:'' }}</textarea>
                                            Use these Tags : [country]
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