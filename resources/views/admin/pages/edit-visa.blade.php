@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Visa - {{ $country->country }}
        </h1>
    </section>
    <div id="response">

    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form method="post" action="{{ route('admin.update-visa') }}" id="visaForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-xs-6 col-xs-offset-3">
                                    <input type="hidden" id="country_name" name="country_name">
                                    <select class="form-control" id="visa_country"
                                    onchange="GetCountryName(this, 'country_name');" name="country">
                                    <option value="{{ $country->id }}" selected>{{ $country->country }}</option>
                                </select>
                            </div>

                            <div class="form-group col-xs-2" id="submit">
                                <input type="submit" name="submit" id="checksave" style="position: fixed;
                                right: 36px;" value="Save" class="btn btn-success">
                            </div>
                        </div>

                        <div class="outer-box">
                            <div class="panel-group">
                                @foreach($sections as $s)
                                <?php if (isset($visa[$s->id])): ?>

                                    @php
                                    $sId = $visa[$s->id]->id;
                                    $isRight = $visa[$s->id]->is_right == 1?'checked':'';
                                    $isLeft = $visa[$s->id]->is_right == 0?'checked':'';
                                    $isOpen = $s->open == 1?'in':'';
                                    $sTitle = $visa[$s->id]->title;
                                    $type = Auth()->guard('admin')->user()->type;
                                    $isWriter = $type == 'content-writer'?'readonly':'';

                                    @endphp

                                    <input type="hidden" name="id[]" value="{{ $sId }}">
                                    <div class="panel panel-default edit-panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#s{{ $sId }}">
                                                    {{ $sTitle }}
                                                </a>
                                                <div class="pull-right" data-delete="{{$visa[$s->id]->id}}">
                                                    <label><input type="radio" name="position[{{ $sId }}]" value="0"
                                                        {{ $isLeft }}> Left Sidebar &nbsp;&nbsp;</label>
                                                        <label><input type="radio" name="position[{{ $sId }}]" value="1"
                                                            {{ $isRight }}> Right Sidebar</label>
                                                            @if(auth()->guard('admin')->user()->type == 'admin')

                                                            @if(empty($visa[$s->id]->deleted_at))
                                                            <a href="javascript:;" id="delete"
                                                            class="btn btn-sm btn-xs btn-danger"
                                                            onclick="visaDelete(this)">Delete</a>
                                                            @else
                                                            <a href="javascript:;" id="restore"
                                                            class="btn btn-sm btn-xs btn-primary"
                                                            onclick="visaRestore(this)">Restore</a>
                                                            @endif
                                                            @endif
                                                        </div>
                                                        <!--                   <div class="clearfix"></div> -->
                                                    </h4>
                                                </div>
                                                <div id="s{{ $sId }}" class="panel-collapse collapse {{ $isOpen }}">
                                                    <div class="panel-body">

                                                        <?php if ($type == 'admin'): ?>
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
                                                        <?php endif ?>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <label>Keywords</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" placeholder="Keywords"
                                                                    {{ $isWriter }}
                                                                    name="keywords[{{ $sId }}]">{{ $visa[$s->id]->keywords }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php if ($type != 'content-writer'): ?>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label>Meta Title</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" name="meta_title[{{ $sId }}]"
                                                                        class="form-control"
                                                                        value="{!! renderHTML($visa[$s->id]->meta_title) !!}"
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
                                                                        name="meta_desc[{{ $sId }}]">{{ $visa[$s->id]->meta_desc }}</textarea>
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
                                                                        name="tags[{{ $sId }}]">{{ $visa[$s->id]->tags }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif ?>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <label>Content</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control editor"
                                                                    placeholder="Content"
                                                                    name="content[{{ $sId }}]">{!! $visa[$s->id]->content !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php elseif(auth()->guard('admin')->user()->type == 'admin'): ?>
                                            @php
                                            $sId = $s->id;
                                            $sTitle = $s->title;
                                            @endphp
                                            <input type="hidden" name="new_id[]" value="{{ $sId }}">
                                            <div class="panel panel-default edit-panel">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" href="#s{{ $sId }}">
                                                            {{ $sTitle }}
                                                        </a>
                                                        <div class="pull-right">
                                                            <label><input type="radio" name="new_position[{{ $sId }}]"
                                                                value="0" checked> Left Sidebar &nbsp;&nbsp;</label>
                                                                <label><input type="radio" name="new_position[{{ $sId }}]"
                                                                    value="1"> Right Sidebar</label>
                                                                </div>
                                                            </h4>
                                                        </div>
                                                        <div id="s{{ $sId }}"
                                                        class="panel-collapse collapse {{ $s->open == 1?'in':'' }}">
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label>Title</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" data-title="{{ $sTitle }}"
                                                                        name="new_title[{{ $sId }}]"
                                                                        class="form-control new_visa_title"
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
                                                                        name="new_keywords[{{ $sId }}]"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label>Meta Title</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" name="new_meta_title[{{ $sId }}]"
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
                                                                        <textarea class="form-control"
                                                                        placeholder="Meta Description"
                                                                        name="new_meta_desc[{{ $sId }}]"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label>Optimized Keywords</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control"
                                                                        placeholder="Optimized Keywords"
                                                                        name="new_tags[{{ $sId }}]"></textarea>
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
                                                                        name="new_content[{{ $sId }}]"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
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
        function fromsubmit() {
            $.ajax({
                url: '{{ route('admin.update-visa') }}',
                type: 'post',
                data: $('#visaForm').serialize(),
                success: function(result) {
                    toastr["success"]("Saved");
                }

            });

        }
        setInterval(fromsubmit, 60000);
        $(function() {
            $('#visa_country option:selected').trigger('change');
        });

        function GetCountryName(element, target) {
            var country_name = $(element).find(":selected").text();
            if (country_name != "Select Country") {
                $("#country_name").val(country_name);

                $('.new_visa_title').each(function(i, v) {
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
    <script type="text/javascript">
        function visaDelete(pointer) {
            confirm('Are you sure ?');
            var $this = $(pointer);
            var tr = $this.closest('div');
            var id = tr.data('delete');


            $.ajax({
                url: SITE_PATH + '/delete-visa',
                type: 'GET',
                data: {
                    delete: 'yes',
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    location.reload();
                },
                error: function() {

                },
                complete: function() {
                    $this.prop("disabled", false);
                }
            });
        }

        function visaRestore(pointer) {

            var $this = $(pointer);
            var tr = $this.closest('div');
            var id = tr.data('delete');

            $.ajax({
                url: SITE_PATH + '/delete-visa',
                type: 'GET',
                data: {
                    delete: 'no',
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    location.reload();
                },
                error: function() {

                },
                complete: function() {
                    $this.prop("disabled", false);
                }
            });
        };
    </script>

    @endpush