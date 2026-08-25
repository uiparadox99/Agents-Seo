@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Related Site
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations"
                                action="{{ route('admin.save-related') }}" enctype="multipart/form-data" id="myModal">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Title</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="title" name="title" class="form-control" required=""
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->title:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Link</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="title" name="link" class="form-control" required=""
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->link:'' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Flag</label>
                                        </div>
                                        @if(isset($detail)&&!is_null($detail->logo))
                                        <div class="col-sm-3">
                                            <input type="file" name="logo" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <img src="{{ url('storage/uploads/related/'.$detail->logo) }}" width="30%">
                                        </div>

                                        @else
                                        <div class="col-sm-6">
                                            <input type="file" name="logo" class="form-control" value="">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!--    <div class="form-group">
                          <div class="row">
                             <div class="col-md-1 col-md-offset-2">
                                <label>Description</label>
                            </div>
                            <div class="col-sm-6">
                              <textarea class="editor form-control" id="content" name="description">{{ isset($detail)&&!is_null($detail)?$detail->description:'' }}</textarea>
                          </div>
                                                  </div>
                         
                         
                                              </div> -->

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