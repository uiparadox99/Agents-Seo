@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Page Content
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div>
                            <form method="post" action="{{ route('admin.save-page') }}">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ isset($detail)&&!is_null($detail)?$detail->id:'' }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Page</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="page" class="form-control">
                                                <option value="">Select</option>
                                                <option value="contact"
                                                    {{ isset($detail)&& $detail->page == 'contact' ?'selected':'' }}>
                                                    Contact</option>
                                                <option value="about"
                                                    {{ isset($detail)&& $detail->page == 'about' ?'selected':'' }}>About
                                                </option>
                                                <option value="privacy"
                                                    {{ isset($detail)&& $detail->page == 'privacy' ?'selected':'' }}>
                                                    Privacy Policy </option>
                                                <option value="terms"
                                                    {{ isset($detail)&& $detail->page == 'terms' ?'selected':'' }}>Terms
                                                    & Condition</option>
                                                <option value="spam"
                                                    {{ isset($detail)&& $detail->page == 'spam' ?'selected':'' }}>Anti
                                                    spam Policy</option>
                                                <option value="dmca"
                                                    {{ isset($detail)&& $detail->page == 'dmca' ?'selected':'' }}>DMCA
                                                </option>
                                                <option value="converter"
                                                    {{ isset($detail)&& $detail->page == 'converter' ?'selected':'' }}>
                                                    Currency Converter</option>


                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1 col-md-offset-2">
                                            <label for="">Content</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea class="form-control editor" placeholder="Content"
                                                name="content">{{ isset($detail)&&!is_null($detail)?$detail->content:'' }}</textarea>
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

@endpush