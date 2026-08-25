@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add City
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations"
                                action="{{ route('admin.save-city') }}">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="city" class="form-control" required=""
                                                value="{{ isset($detail)&&!is_null($detail)?$detail->name:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>Country</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="country" class="form-control select2" required="">
                                                <option value="">Select</option>
                                                @foreach($countries as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ isset($detail)&& $detail->countries_id == $sec->id ?'selected':'' }}>
                                                    {{ $sec->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>For Embassy ?</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="type" class="" value="embassy"
                                                {{ isset($detail)&& $detail->type == 'embassy' ?'checked':'' }}>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>Show in Umrah Ticket ?</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="airport" class="" value="1"
                                            {{ isset($detail)&& $detail->airport == '1' ?'checked':'' }}>
                                        </div>
                                        
                                    </div>
                                </div>
                                   <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label> Show in Sasti Tickets ?</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="sasti_ticket" class="" value="1"
                                            {{ isset($detail)&& $detail->sasti_ticket == '1' ?'checked':'' }}>
                                        </div>
                                        
                                    </div>
                                </div>

                                    <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label> Via Location ?</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="via" class="" value="1"
                                            {{ isset($detail)&& $detail->via == '1' ?'checked':'' }}>
                                        </div>
                                        
                                    </div>
                                </div>
                                   <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label> Umrah Hotels ?</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="hotels" class="" value="1"
                                            {{ isset($detail)&& $detail->hotels == '1' ?'checked':'' }}>
                                        </div>
                                        
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>Jobs ?</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="jobs" class="" value="1"
                                            {{ isset($detail)&& $detail->jobs == '1' ?'checked':'' }}>
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