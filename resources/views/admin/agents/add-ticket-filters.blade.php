@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Ticket Filter Preset
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form enctype="multipart/form-data" method="post" class="has-callback-validations"
                                action="{{ url('admin/save-ticket-filters') }}">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                               

                                @if(isset($detail)&&!is_null($detail) && !empty($detail->image))
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Image</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="file" name="image" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <img src="{{url('storage/uploads/jobs/'.$detail->image)}}"
                                                style="width: 100%;height: 100px;">
                                        </div>
                                    </div>
                                </div>
                                @else

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Image</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="image" class="form-control"  value="">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">From</label>
                                        </div>
                                        <div class="col-sm-6">
                                        <select name="from_city" class="form-control">
                                            <option value="">From</option>
                                            @foreach($from as $c)
                                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->from_city ==
                                                $c->name?'selected':''}}>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">To</label>
                                        </div>
                                        <div class="col-sm-6">
                                        <select name="to_city" class="form-control" required>
                                            <option value="">To</option>
                                            @foreach($to as $c)
                                            <option value="{{$c->name}}" {{isset($detail) && !is_null($detail) && $detail->to_city ==
                                                $c->name?'selected':''}}>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        </div>
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
@endpush