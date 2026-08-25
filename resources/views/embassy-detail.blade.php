@extends('layouts.master')
@section('content')
<section id="content" class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="embassy-search mt-5 mb-5">
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

            @php
            $city = str_replace('Pakistan Embassy in ','',$detail->title);
            @endphp
            <h2 style="font-weight: bold" class="text-capitalize">{{ strtolower($detail->title) }}</h2>
            @if(!empty($detail->country->country))
              <div class="row">
                <div class="col-md-3">
                    <p class="text-capitalize"><strong> Country :</strong></p>
                </div>
                <div class="col-md-9">
                    <p>{{$detail->country->country}}</p>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-3">
                    <p class="text-capitalize"><strong> Address :</strong></p>
                </div>
                <div class="col-md-9">
                    <p>{{$detail->address}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p class="text-capitalize"><strong> Contact Numbers :</strong></p>
                </div>
                <div class="col-md-9">
                    <p>{{$detail->phone}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p class="text-capitalize"><strong> Fax Number :</strong></p>
                </div>
                <div class="col-md-6">
                    <p>{{$detail->fax}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p class="text-capitalize"><strong> Email :</strong></p>
                </div>
                <div class="col-md-9">
                    <p class="text-capitalize">{{$detail->email}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p class="text-capitalize"><strong> Website :</strong></p>
                </div>
                <div class="col-md-9">
                    <p class="text-capitalize">{{$detail->website}}</p>
                </div>
            </div>


            <p style="text-align: justify;">If you are looking for information about Pakistan embassy in {{$city}} you
                are on right place. Here are Agents.com.pk you can get important information about Pakistan embassy in
                {{$city}} including address, phone number, fax, website, contact email and other available information.
                Our team or experts try their level best to provide you information about Pakistan embassy in {{$city}}
                if you found any mistake or incorrect details you can contact us to make a correction. Pakistan embassy
                in {{$city}} also assists in visa requirements and processing. You can get necessary information about
                visa requirements, visa application form, visa fees and other important details on office website.</p>

            <?php if (!$detect->isMobile()): ?>
            <div style="width: 100%;">
                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:120px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <?php endif ?>

        </div>
</section>

@endsection