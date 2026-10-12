@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Product Reviews
            <small>Moderate customer reviews submitted for packages</small>
        </h1>
    </section>

    <section class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="pull-left">
                            <a href="{{ url('admin/product-reviews') }}" class="btn btn-sm {{ !request()->has('status') ? 'btn-primary' : 'btn-default' }}">
                                All ({{ $totalCount }})
                            </a>
                            <a href="{{ url('admin/product-reviews?status=pending') }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-default' }}">
                                Pending Approval ({{ $pendingCount }})
                            </a>
                            <a href="{{ url('admin/product-reviews?status=approved') }}" class="btn btn-sm {{ request('status') === 'approved' ? 'btn-success' : 'btn-default' }}">
                                Approved ({{ $approvedCount }})
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Product Type</th>
                                    <th>Package Name</th>
                                    <th>Customer Name</th>
                                    <th style="width: 80px;">Rating</th>
                                    <th>Comment</th>
                                    <th style="width: 110px;">Date</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $r)
                                <tr data-id="{{ $r->id }}">
                                    <td>{{ $r->id }}</td>
                                    <td>
                                        <span class="label {{ $r->product_type === 'package' ? 'label-primary' : 'label-info' }}">
                                            {{ $r->product_type === 'package' ? 'Umrah Package' : 'Tour Package' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($r->product_type === 'package' && $r->package)
                                            <a href="{{ url('umrah-packages/' . $r->package->slug) }}" target="_blank">
                                                {{ $r->package->name }}
                                            </a>
                                        @elseif($r->product_type === 'tour' && $r->tourPackage)
                                            <a href="{{ url('tour-packages/' . $r->tourPackage->slug) }}" target="_blank">
                                                {{ $r->tourPackage->title }}
                                            </a>
                                        @else
                                            <span class="text-muted">Package #{{ $r->product_id }}</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $r->name }}</strong></td>
                                    <td>
                                        <span style="color: #f39c12; font-weight: bold;">
                                            {{ $r->rating }} / 5 <i class="fa fa-star"></i>
                                        </span>
                                    </td>
                                    <td style="max-width: 300px; word-break: break-word;">
                                        {{ $r->comment }}
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($r->created_at)->setTimezone('Asia/Karachi')->format('d-M-Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <label class="label {{ $r->approved ? 'label-success' : 'label-warning' }}" id="status-label-{{ $r->id }}">
                                            {{ $r->approved ? 'Approved' : 'Pending' }}
                                        </label>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-xs {{ $r->approved ? 'btn-default' : 'btn-success' }}" 
                                            onclick="toggleProductReview({{ $r->id }}, this)" 
                                            id="btn-toggle-{{ $r->id }}">
                                            <i class="fa {{ $r->approved ? 'fa-times' : 'fa-check' }}"></i>
                                            {{ $r->approved ? 'Unapprove' : 'Approve' }}
                                        </button>
                                        <form action="{{ route('admin.product-reviews.destroy', $r->id) }}" method="POST" style="display:inline-block;" 
                                            onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted" style="padding: 30px;">
                                        No product reviews found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pull-right">
                            {{ $reviews->appends(request()->query())->links() }}
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
function toggleProductReview(id, btn) {
    var $btn = $(btn);
    $btn.prop('disabled', true);

    $.ajax({
        url: "{{ route('admin.product-reviews.toggle') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            id: id
        },
        dataType: 'JSON',
        success: function(res) {
            if (res.notify) {
                var label = $('#status-label-' + id);
                if (res.approved == 1) {
                    label.removeClass('label-warning').addClass('label-success').text('Approved');
                    $btn.removeClass('btn-success').addClass('btn-default').html('<i class="fa fa-times"></i> Unapprove');
                } else {
                    label.removeClass('label-success').addClass('label-warning').text('Pending');
                    $btn.removeClass('btn-default').addClass('btn-success').html('<i class="fa fa-check"></i> Approve');
                }
            } else {
                alert(res.msg || 'Action failed');
            }
        },
        error: function() {
            alert('An error occurred while updating the review status.');
        },
        complete: function() {
            $btn.prop('disabled', false);
        }
    });
}
</script>
@endpush
