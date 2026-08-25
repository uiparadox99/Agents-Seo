@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            General Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">General Settings</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">General Settings</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="{{ route('save.general-settings') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Website Name</label>
                                    <input type="text" class="form-control" placeholder="Website Name"
                                        name="website_name" value="{{ $setting->website_name }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Website Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Website Short Description</label>
                                    <textarea rows="4" class="form-control" name="website_desc"
                                        placeholder="Website Short Description">{{ $setting->website_desc }}</textarea>
                                </div>

                                @if(!is_null($setting->phone))
                                @foreach(explode(',' ,$setting->phone) as $p)
                                <div class="col-sm-10 form-group">
                                    <label class="control-label require">Phone</label>
                                    <input type="text" class="form-control" name="phone[]" placeholder="Phone"
                                        value="{{ $p }}">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <a href="javascript:;" class="btn btn-sm btn-success btn-block add-phone"><i
                                            class="fa fa-plus"></i></a>
                                </div>
                                @endforeach
                                @endif

                                <div class="phone">

                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email"
                                        value="{{ $setting->email }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" placeholder="Facebook"
                                        value="{{ $setting->facebook }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Twitter</label>
                                    <input type="text" class="form-control" name="twitter" placeholder="Twitter"
                                        value="{{ $setting->twitter }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">LinkedIn</label>
                                    <input type="text" class="form-control" name="linkedin" placeholder="LinkedIn"
                                        value="{{ $setting->linkedin }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" placeholder="Instagram"
                                        value="{{ $setting->instagram }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">YouTube</label>
                                    <input type="text" class="form-control" name="youtube" placeholder="YouTube"
                                        value="{{ $setting->youtube }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address"
                                        value="{{ $setting->address }}">
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label class="control-label require">Google Embedded Map</label>
                                    <textarea rows="4" name="google_map" placeholder="Google Embedded Map"
                                        class="form-control">{{ $setting->google_map }}</textarea>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div>
                                            <button type="reset" class="btn btn-info btn-flat">Reset</button>
                                            <button class="btn btn-primary btn-flat pull-right"
                                                type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
$('.add-phone').click(function() {
    var $html =
        `<div class="appended-phone"> <div class="col-sm-10 form-group"> <label class="control-label require">Phone</label> <input type="text" class="form-control" name="phone[]" placeholder="Phone"> </div><div class="col-sm-2 form-group"> <a href="javascript:;" class="btn btn-sm btn-danger btn-block remove-phone"><i class="fa fa-minus"></i></a> </div></div>`;
    $('.phone').append($html);
});

$(document).on('click', '.remove-phone', function() {
    $(this).closest('.appended-phone').remove();
})
</script>
@endpush