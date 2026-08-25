@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Embassy Page
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-embassy') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <input type="hidden" name="section[]" value="1">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Title</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="text" name="title" class="form-control" id="title" required=""
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->title:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>Country</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="country" class="form-control select2" required="">
                                                <option value="">Select</option>
                                                @foreach($countries as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ isset($detail)&& $detail->countries_id == $sec->id ?'selected':($sec->id == 3?'selected':'') }}>
                                                    {{ $sec->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>Cities</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="cities_id" class="form-control select2" required="">
                                                <option value="">Select</option>
                                                @foreach($cities as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ isset($detail)&& $detail->cities_id == $sec->id ?'selected':($sec->id == 7?'selected':'')}}>
                                                    {{ $sec->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Address</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="address" class="form-control" id="Address"
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->address:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">phone</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="phone" class="form-control" id="phone"
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->phone:'' }}">
                                                <p>Use Comma to add multiple like this: 999-999, 999-999</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">fax</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="fax" class="form-control" id="fax"
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->fax:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">email</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="email" class="form-control" id="email"
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->email:'' }}">
                                                <p>Use Comma to add multiple like this: example@gmail.com, example2@gmail.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">website</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="website" class="form-control" id="website"
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->website:'' }}">
                                        </div>
                                    </div>
                                </div>



                                <div class="col-sm-8 col-sm-offset-2">
                                    <h4 class="m-t-0 header-title m-b-10"><b>Seo Detail</b></h4>
                                    <hr>

                                    <div class="seo-preview">
                                        <h3 id="preview_title">{{isset($detail)?$detail->meta_title:''}}</h3>
                                        <h5 id="preview_url">{{isset($detail)?url('/').'/'.$detail->slug:''}}</h5>
                                        <p id="preview_description">{{isset($detail)?$detail->meta_description:''}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Meta Title<span class="star">*</span></label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{isset($detail)?$detail->meta_title:''}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Slug<span class="star">*</span></label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                            value="{{isset($detail)?$detail->slug:''}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Meta Description<span class="star">*</span></label>
                                        <textarea name="meta_description" id="meta_description" cols="30" rows="5"
                                            class="form-control ">{{isset($detail)?$detail->meta_description:''}}</textarea>
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
<script type="text/javascript">
$(document).on('keyup', '#title', function() {
    var title = $('#title').val();
    var title = title.charAt(0).toUpperCase() + title.slice(1);
    $('#meta_title').val(title);
    var html = '<span>' + title.substr(0, 55) + '</span><span style="color:red">' + title.substr(55, 1000) +
        '</span>'
    $('#preview_title').html(html);
    var slug = title;
    slug = slug.toLowerCase();
    slug = slug.replace(/ /g, '-');
    slug = slug.replace(/[^\w-]+/g, '');
    $('#slug').val(MAIN_PATH + '/' + slug);
    $('#preview_url').html(MAIN_PATH + '/' + slug);

});
$(document).on('keyup', '#meta_title', function() {
    var title = $('#meta_title').val();
    var html = '<span>' + title.substr(0, 55) + '</span><span style="color:red">' + title.substr(55, 1000) +
        '</span>'
    $('#preview_title').html(html);
    var slug = title;
    slug = slug.toLowerCase();
    slug = slug.replace(/ /g, '-');
    slug = slug.replace(/[^\w-]+/g, '');


});
$(document).on('keyup', '#slug', function() {
    var title = $('#slug').val();
    var slug = title;
    slug = slug.replace(MAIN_PATH, '');
    slug = slug.toLowerCase();
    slug = slug.replace(/ /g, '-');
    slug = slug.replace(/[^\w-]+/g, '');
    $('#preview_url').html(MAIN_PATH + '/' + slug);

});
$(document).on('keyup', '#meta_description', function() {
    var data = $('#meta_description').val();
    var html = '<span>' + data.substr(0, 155) + '</span><span style="color:red">' + data.substr(155, 1000) +
        '</span>';
    $('#preview_description').html(html);

});
var $textarea = $("#content");


CKEDITOR.instances[$textarea.attr('name')].on('key', function(e) {
    var data = CKEDITOR.instances[$textarea.attr('name')].getData();
    data = data.replace(/(<([^>]+)>)/ig, "");
    $('#meta_description').val(data);
    var html = '<span>' + data.substr(0, 155) + '</span><span style="color:red">' + data.substr(155, 1000) +
        '</span>';
    $('#preview_description').html(html);
});
</script>
@endpush