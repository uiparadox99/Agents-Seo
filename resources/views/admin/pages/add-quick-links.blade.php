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
                    <form method="post" action="{{ route('admin.save-quick-links') }}" enctype="multipart/form-data">
                        <div class="box-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <br>
                                        <center><a href="javascript:;" class="btn btn-success btn-sm" id="addMore"><i
                                                    class="fa fa-plus"></i></a></center>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Section</label>
                                        <select name="sections_id[]" class="form-control">
                                            <option value="">Select Section</option>
                                            @foreach($sections as $s)
                                            <option value="{{ $s->id }}">{{ $s->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <select name="country_id[]" class="form-control">
                                            <option value="">Select Section</option>
                                            @foreach($country as $s)
                                            <option value="{{ $s->id }}">{{ $s->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="addMoreContent"></div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" name="submit" class="btn btn-success" value="Save Record">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push("script")
<script>
$(function() {
    $("#addMore").click(function(e) {
        e.preventDefault();
        var html = `<div class="row"><div class="col-md-1">
                <div class="form-group">
                  <br>
                  <center><button class="btn btn-danger btn-sm remove"><i class="fa fa-times"></i></button></center>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Section</label>
                  <select name="sections_id[]" class="form-control">
                    <option value="">Select Section</option>
                    @foreach($sections as $s)
                      <option value="{{ $s->id }}">{{ $s->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Country</label>
                  <select name="country_id[]" class="form-control">
                    <option value="">Select Section</option>
                    @foreach($country as $s)
                      <option value="{{ $s->id }}">{{ $s->country }}</option>
                    @endforeach
                  </select>
                </div>
              </div></div>`;
        $("#addMoreContent").append(html);
    });

    $(document).on("click", ".remove", function(e) {
        e.preventDefault();
        $(this).parent().parent().parent().parent().remove();
    })
})
</script>
@endpush