@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Contact Requests

        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contact as $s)
                                <tr>
                                    <td width="8%">{{ date('d-M-Y',strtotime($s->created_at)) }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>{{ $s->phone }}</td>
                                    <td>{{ $s->subject }}</td>
                                    <td>
                                        {{ $s->message }}
                                    </td>
                                    <td width="8%"><a href="{{url('admin/reply/'.$s->id)}}"
                                            class="btn btn-primary btn-sm btn-xs "><i class="fa fa-send"></i></a> <a
                                            href="{{ url('admin/delete-contact/'.$s->id) }}"
                                            class="btn btn-danger btn-sm btn-xs"
                                            onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                class="fa fa-trash"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {!! $contact->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('admin/send-reply') }}" method="POST" enctype="multipart/form-data" id="myModal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title" id="addManagementLabel">Reply to Customer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="" id="id">
                    <input type="hidden" name="email" value="" id="email">
                    <p><strong>Question : </strong> <span id="message"></span></p>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 form-control-label">Answer<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea type="text" rows="5" required="" class="form-control" id="description"
                                name="reply" placeholder="Answer"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>
            </form>
        </div><!-- /.modal-content-->
    </div><!-- /.modal-dialog -->
</div>
@endsection
@push('script')
<script type="text/javascript">
$(document).ready(function() {
    $('.contactdatatables').DataTable({
        "order": [
            [0, "ASC"]
        ]
    });

    $(".jsEventRecord").click(function() {
        var $this = $(this);
        $("form", "#myModal").get(0).reset();
        if ($this.data("record")) {
            var data = $this.data("record");
            $("#id").val(data.id);
            $("#email").val(data.email);
            $("#message").html(data.message);
        }
    });

});
</script>
@endpush