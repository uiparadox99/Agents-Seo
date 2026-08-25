@extends('layouts.master')
@section('content')
    @include('includes.slider')
    <section id="content" class="container">
        @if ($packages->count() > 0)
            <section id="packages">
                <div class="title text-center p-3">
                    <h1>Tour Packages From Pakistan</h1>
                </div>
                <div class="box" style="height: auto;background: #f0f0f0;padding:24px;border-radius:15px">
                    <form method="get" action="">
                        <h4>Search for Pacakges</h4>
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label for="">Country</label>
                                <select class="form-control " name="country">
                                    <option value="">Country</option>
                                    @foreach ($countries as $a)
                                        <option value="{{ $a->country }}"
                                            {{ request()->has('country') && request()->get('country') == $a->country ? 'selected' : '' }}>
                                            {{ $a->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 form-group">
                                <label>Departure City</label>
                                <select class="form-control " name="city">
                                    <option value="">City</option>
                                    @foreach ($from as $a)
                                        <option value="{{ $a->name }}"
                                            {{ request()->has('city') && request()->get('city') == $a->name ? 'selected' : '' }}>
                                            {{ $a->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="btn-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="packages pt-3 ">
                    <div class="row">
                        @foreach ($packages as $key => $p)
                            <div class="col-md-4">
                                <a href="{{ url('tour-packages/' . $p->slug) }}" style="color: unset;text-decoration:none">
                                    <div class="box p-2 detail" style="height: auto;background:#f1f1f1;border-radius:12px;">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <img src="{{ url('storage/uploads/packages/mobile/' . $p->image) }}"
                                                    alt="{{ !empty($p->image_alt) ? $p->image_alt : $p->name }}"
                                                    class="box-img w-100"
                                                    style="height: auto;object-fit:contain;padding:0;background:none">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="mt-2">
                                                    <span style="text-transform: capitalize;">{{ substr($p->title,'0','22') }}..</span>
                                                </h5>
                                                <h6><i class="fas fa-map-marker-alt" style="color:#f58220"></i>
                                                    {{ $p->country }} </h6>
                                                <h6 style="color:#f58220">Rs {{ $p->price }} <small>(Starting
                                                        price)</small></h6>

                                                <p><b>Nights:</b> {{ $p->nights }} | <b>Days:</b> {{ $p->days }} |
                                                    <b>Seats:</b> {{ $p->seats }}</p>
                                            </div>
                                        </div>




                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div> <ins class="adsbygoogle" style="display:inline-block;width:100%;height:82px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </section>
        @endif




    </section>
@endsection
