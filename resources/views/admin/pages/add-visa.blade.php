@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Visa
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form method="post" action="{{ route('admin.save-visa') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="form-group col-xs-6 col-xs-offset-3">
                                        <input type="hidden" id="country_name" name="country_name">
                                        <select class="form-control" onchange="GetCountryName(this, 'country_name');"
                                            name="country">
                                            <option value="">Select Country</option>
                                            @foreach($country as $c)
                                            <option value="{{ $c->id }}">{{ $c->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-2" id="submit">
                                        <input type="submit" name="submit" value="Save" style=" position: fixed;
    right: 36px;" class="btn btn-success">
                                    </div>

                                </div>
                                <div class="outer-box">
                                    <div class="panel-group">
                                        @foreach($section as $s)
                                        @php
                                        $sId = $s->id;
                                        $sTitle = $s->title;
                                        @endphp
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#s{{ $sId }}">
                                                        {{ $sTitle }}
                                                    </a>
                                                    <div class="pull-right">
                                                        <label><input type="radio" name="position[{{ $sId }}]" value="0"
                                                                checked> Left Sidebar &nbsp;&nbsp;</label>
                                                        <label><input type="radio" name="position[{{ $sId }}]"
                                                                value="1"> Right Sidebar</label>
                                                    </div>
                                                </h4>
                                            </div>
                                            <div id="s{{ $sId }}"
                                                class="panel-collapse collapse {{ $s->open == 1?'in':'' }}">
                                                <div class="panel-body">
                                                    <input type="hidden" name="id[]" value="{{ $sId }}">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label>Title</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" data-title="{{ $sTitle }}"
                                                                    name="title[{{ $sId }}]"
                                                                    class="form-control visa_title"
                                                                    value="{{ $sTitle }}" placeholder="Title">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label>Keywords</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control" placeholder="Keywords"
                                                                    name="keywords[{{ $sId }}]"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label>Meta Title</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="meta_title[{{ $sId }}]"
                                                                    class="form-control" value=""
                                                                    placeholder="Meta Title">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label>Meta Description</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <textarea rows="5" class="form-control"
                                                                    placeholder="Meta Description"
                                                                    name="meta_desc[{{ $sId }}]"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label>Optimized Keywords</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <textarea rows="5" class="form-control"
                                                                    placeholder="Optimized Keywords"
                                                                    name="tags[{{ $sId }}]"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label>Content</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control editor"
                                                                    placeholder="Content"
                                                                    name="content[{{ $sId }}]"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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
function GetCountryName(element, target) {
    var country_name = $(element).find(":selected").text();
    if (country_name != "Select Country") {
        $("#country_name").val(country_name);

        $('.visa_title').each(function(i, v) {
            var old = $(v).data("title");
            var newValue = country_name + ' ' + old;
            $(v).val(newValue);
        });
    }
}

window.onscroll = function() {
    FixedBtn()
};

var header = document.getElementById("submit");
var sticky = header.offsetTop;

function FixedBtn() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
        header.classList.add("submit");
    } else {
        header.classList.remove("sticky");
        header.classList.remove("submit");
    }
}
</script>
@endpush