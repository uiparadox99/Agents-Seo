@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-3">
                @include('includes.user-sidebar')
            </div>

            <div class="col-md-9 agent-main-box">
                <h3>Business Promotions

                    @if ($promotions->count() < 3)
                        <a href="{{ url('agent-add-promotion?type=' . request()->get('type')) }}" class="btn btn-primary"
                            style="float: right;">Add Promotion</a>
                    @endif
                </h3>

                <div class="row">
                    @if ($promotions->count() > 0)
                        @foreach ($promotions as $r)
                            <div class="col-md-4 image-box-col">
                                <div class="image-box" data-id="{{ $r->id }}">
                                    <h6>{{ $r->name }}</h6>
                                    <div>



                                        @if ($r->active == 1 || $count < 5)
                                            <form id="submitactive" method="post" action="{{ url('promotion-gallery') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $r->id }}">
                                                <label style="width: 100%;color: #f58220;font-weight: 700;">Active /
                                                    Inactive &nbsp;<input type="checkbox" name="active" value="1"
                                                        onclick="submit() " style="    transform: scale(1.5);"
                                                        {{ $r->active == 1 ? 'checked' : '' }}> <a
                                                        href="{{ url($r->id.'-edit-promotion?type=' . request()->get('type')) }}"
                                                        style="float:right">Edit</a></label>
                                            </form>
                                        @endif
                                    </div>
                                    @if ($r->admin_approved != 1)
                                        <p class="text-danger">Not Approved</p>
                                    @endif
                                    <img src="{{ url('storage/uploads/agents/' . $r->image) }}"
                                        style="width: 100%;height:200px;object-fit:contain">
                                    <div class="social-share mt-3">
                                        <b>Share this on:</b>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('storage/uploads/agents/' . $r->image)) }}"
                                            target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url('storage/uploads/agents/' . $r->image)) }}"
                                            target="_blank" class="btn btn-info btn-sm">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                        <a href="https://wa.me/?text=Check this out: {{ urlencode(url('storage/uploads/agents/' . $r->image)) }}"
                                            target="_blank" class="btn btn-success btn-sm">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="content-box-agent">
                            <p class="no-record">No Promotion Added</p>
                        </div>
                    @endif
                </div>
                {!! $promotions->links() !!}

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        function submit() {
            $('#submitactive').submit();
        }

        function addToHome(pointer) {

            var $this = $(pointer);
            var tr = $this.closest('tr');
            var id = tr.data('id');

            if ($this.is(':checked')) {
                var is_home = 1;
            } else {
                var is_home = 0;
            }

            $this.prop("disabled", true);
            $this.val("Processing..");

            $.ajax({
                url: SITE_PATH + '/active-review',
                type: 'GET',
                data: {
                    is_home: is_home,
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.notify) {
                        $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
                    } else {
                        $(".top" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
                    }
                },
                error: function() {

                },
                complete: function() {
                    $this.prop("disabled", false);
                }
            });
        }
    </script>
@endpush
