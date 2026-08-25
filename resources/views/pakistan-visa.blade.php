@extends('layouts.master')
@section('content')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="links">
           
                <div class="embassy-search mt-4 mb-3">
                    <div class="row">
                        <div class="col-md-5" style="vertical-align: middle;padding-top: 5px;">
                            <h5>Select Embassy <i class="fa fa-arrow-right" style="margin-left: 10px;"></i></h5>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2 text-capitalize"
                                onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="">Select </option>
                                @foreach ($embassies as $d)

                                <option value="{{ url($d->slug) }}">
                                    {{strtolower($d->title)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="row" style="margin-right: -5px;margin-left: -5px;">
                       @foreach ($embassies as $d)
                     <div class="col-md-4 " style="padding-left:5px;padding-right:5px;margin-bottom:5px;">

                        <a href="{{url($d->slug)}}" class="text-capitalize city-link"><h5 class="mb-0">{{strtolower($d->title)}}</h5></a>
                    </div>
                    @endforeach
                </div>
              
            </div>
        </div>


        <div class="col-md-2 col-pd">
            <div>
                <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

        </div>
    </div>
</section>
@endsection
@push('script')
<script type="text/javascript">
$('.select2').select2();
</script>
@endpush