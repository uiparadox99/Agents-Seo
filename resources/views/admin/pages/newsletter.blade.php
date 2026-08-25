@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            NewsLetter

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
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsletter as $s)
                                <tr>
                                    <td>{{ $s->email }}</td>
                                    <td width="8%">{{ date('d-M-Y',strtotime($s->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {!! $newsletter->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
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