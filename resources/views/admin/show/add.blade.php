@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Allow Package
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" class="has-callback-validations"
                                action="{{ route('admin.save-show-package') }}">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                               
                    
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label>Agent</label>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <select name="agent" class="form-control select2" data-validation="required">
                                                <option value="">Select</option>
                                                @foreach($agents as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ isset($detail)&& $detail->agents_id == $sec->id ?'selected':'' }}>
                                                    {{ $sec->business_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                      
                         
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Expire</label>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <input type="text" name="expire" autocomplete="off" id="out_bound_date" class="form-control datepicker" data-validation="required" value="{{ isset($detail)&&!is_null($detail)?$detail->expire:'' }}">
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
$('#out_bound_date').datepicker( {
               format: "d-M-yyyy", 
               autoclose: true,
               startDate: new Date(),
           })
</script>
@endpush