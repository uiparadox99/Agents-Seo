@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Reply
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form action="{{ url('admin/send-reply') }}" class="col-md-8 col-md-offset-2" method="POST"
                                enctype="multipart/form-data" id="myModal">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$detail->id}}" id="id">
                                <input type="hidden" name="email" value="{{$detail->email}}" id="email">
                                <p><strong>Question : </strong> <span id="message">{{$detail->message}}</span></p>
                                <div class="form-group  ">
                                    <label for="description" class="form-control-label">Answer<span
                                            class="text-danger">*</span></label>
                                    <textarea type="text" rows="5" required="" class="form-control" id="description"
                                        name="reply" placeholder="Answer">{{$detail->reply}}</textarea>
                                </div>
                                <button type="submit" name="update"
                                    class="btn btn-primary waves-effect waves-light">Send</button>
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