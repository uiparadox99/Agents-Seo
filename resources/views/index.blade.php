@extends('layouts.master') 
@section('content')
<section id="home-search-embassy-section">
    <div class="container">
        <div class="agents-city-section">
            <div class="text-center">
                <h1 style="font-weight: 700; font-size: 24px; margin-bottom: 18px; color: #070c39;">Select Foreign Embassy in Islamabad, Pakistan</h1>
            </div>
            <div class="form-group">
                <select class="form-control" aria-label="Select Foreign Embassy" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="" style="font-weight: 700">Select Embassy</option>
                    @foreach($embassies as $e)
                    <option value="{{ url(str_slug($e->country).'/'.$e->slug) }}">{{ $e->country }}</option>
                    @endforeach
                </select>
            </div>
            <ul class="aplhabatic-list" aria-label="Search Embassy by Letter">
                @foreach(range('A', 'Z') as $char)
                <li class="{{ strtolower($char) == 'y' ? 'y-style-on-mobile' : '' }}">
                    <a href="{{ url('search-embassy-in-islamabad/'.strtolower($char)) }}">{{ $char }}</a>
                </li>
                @endforeach
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</section>

@if($visas->count() > 0)
<section id="popular" class="container">
    <div class="title text-center p-3">
        <h2><b>Popular Embassies &amp; Visas</b></h2>
        <div class="bar"><span></span><span></span><span></span></div>
    </div>
    <div class="popular-content pr-2">
        <div class="row">
            @php $count = 0; @endphp 
            @foreach($visas as $key => $v) 
                @php $count++; @endphp 
                @if(!$detect->isMobile())
                    @if($count == 3 || $count == 6) 
                        <div class="col-md-4 pr-2 col-6">
                            <div>
                                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:247px"
                                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                                <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4 pr-2 col-6">
                        <a href="{{ url($v->country_name.'/'.$v->slug) }}">
                            <div class="popular-box mb-4">
                                <div style="padding: 10px 0">
                                    <img src="{{ asset('flags/4x3/'.strtolower(getCountryCode($v->country)).'.svg') }}"
                                         style="object-fit: contain; padding: 15px 0;" alt="{{ $v->country }} Visa Information" loading="lazy" decoding="async" width="120" height="90">
                                </div>
                                <div class="p-3 pl-4 pr-4 text-center bg-lightgrey" style="padding: 10px 0 !important">
                                    <h4>{{ $v->country }} Visa</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="col-md-4 pr-2 col-6">
                        <a href="{{ url($v->country_name.'/'.$v->slug) }}">
                            <div class="popular-box mb-4">
                                <img src="{{ asset('flags/4x3/'.strtolower(getCountryCode($v->country)).'.svg') }}"
                                     style="object-fit: contain; padding: 6px 0;" alt="{{ $v->country }} Visa Information" loading="lazy" decoding="async" width="100" height="75">
                                <div class="p-3 pl-4 pr-4 text-center bg-lightgrey">
                                    <h4>{{ $v->country }} Visa</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if($count == 4 || $count == 8 || $count == 12)
                        <div class="col-md-12 pr-2 col-12">
                            <div>
                                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:300px"
                                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                                <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

@if($packages->count() > 0)
<section id="packages" class="container">
    <div class="title text-center p-3">
        <h2><b>Featured Umrah Packages</b></h2>
        <div class="bar"><span></span><span></span><span></span></div>
    </div>

    <div class="packages pt-3 pr-3 pl-3">
        <div class="row">
            @foreach($packages as $key => $p) 
                @if($key == 2) 
                    <div class="col-md-4 pr-3 pl-2">
                        <div>
                            <ins class="adsbygoogle" style="display:inline-block;width:100%;height:{{ $detect->isMobile() ? '300px' : '250px' }}"
                                data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                    </div>
                @endif
                <div class="col-md-4 pr-3 pl-2">
                    <div class="box">
                        <a href="{{ url($p->slug) }}">
                            <div class="top-cut"></div>
                            <div class="ribbon ribbon-top-left"><span>Popular</span></div>
                            <div class="bottom-cut"></div>
                            <img src="{{ url('storage/uploads/packages/mobile/'.$p->image) }}" class="box-img" alt="{{ $p->image_alt ?? $p->name }}" loading="lazy" decoding="async">
                            <div class="layer"></div>
                            <div class="p-2 text-center detail">
                                <h3 class="m-0 p-0" style="font-size: 18px;"><small><i class="fa fa-map-marker-alt"></i></small>
                                    {{ str_replace('Umrah Packages', '', $p->name) }}</h3>
                                <p class="m-0 font-weight-bold text-muted">Umrah Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-3">
        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:{{ $detect->isMobile() ? '300px' : '82px' }}"
            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</section>
@endif 

@if($airlines->count() > 0)
<section id="flayer" class="container">
    <div class="title text-center p-3">
        <h2><b>Top Airlines &amp; Airfares</b></h2>
        <div class="bar"><span></span><span></span><span></span></div>
    </div>
    <div class="flayer-logos slider">
        @foreach($airlines as $a)
        <div class="slide">
            <div class="box">
                <a href="{{ url('airline/'.$a->slug) }}">
                    <img src="{{ url('storage/uploads/airline/'.$a->img) }}" alt="{{ $a->image_alt ?? $a->name }}" style="width:100%;" loading="lazy" decoding="async">
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif 

@if(!empty($big))
<section id="blog" class="container pt-3 pb-3">
    <div class="row">
        <div class="col-md-8 pr-0">
            <a href="{{ url('blog/'.$big->slug) }}">
                <div class="big" style="{{ !empty($big->image) ? 'background: url('.url('storage/uploads/blogs/'.$big->image).'); background-size: cover; background-repeat: no-repeat;' : '' }}">
                    <div class="big-overlay">
                        <div class="content">
                            <h3 class="text-uppercase font-weight-bold">{{ $big->title }}</h3>
                            <p>{{ date('d M Y', strtotime($big->created_at)) }}</p>
                            <div class="hr"></div>
                        </div>
                    </div>
                </div>
            </a>
            <div class="row">
                <div class="col-md-7 pr-0">
                    @if(!empty($midum))
                    <a href="{{ url('blog/'.$midum->slug) }}">
                        <div class="midum" style="{{ !empty($midum->image) ? 'background: url('.url('storage/uploads/blogs/'.$midum->image).'); background-size: cover; background-repeat: no-repeat;' : '' }}">
                            <div class="midum-overlay">
                                <div class="content">
                                    <h4 class="text-uppercase font-weight-bold" style="font-size: 16px;">{{ $midum->title }}</h4>
                                    <p>{{ date('d M Y', strtotime($midum->created_at)) }}</p>
                                    <div class="hr"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                </div>
                <div class="col-md-5 pl-0">
                    @if(!empty($small))
                    <a href="{{ url('blog/'.$small->slug) }}">
                        <div class="small" style="{{ !empty($small->image) ? 'background: url('.url('storage/uploads/blogs/'.$small->image).'); background-size: cover; background-repeat: no-repeat;' : '' }}">
                            <div class="small-overlay">
                                <div class="content">
                                    <h4 class="font-weight-bold" style="font-size: 16px;">{{ $small->title }}</h4>
                                    <p>{{ date('d M Y', strtotime($small->created_at)) }}</p>
                                    <div class="hr"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 pl-0">
            <div class="title pt-4 p-3 pl-4">
                <h2><b>Latest Travel Articles</b></h2>
                <div class="bar"><span></span><span></span><span></span></div>
            </div>
            <p class="pt-2 pl-4 pr-4 pb-4 text-muted">
                Looking for verified travel advice, embassy guidelines, and visa updates in Pakistan? Explore expert guides and travel news on Agents.com.pk.
            </p>
            @if(!empty($left))
            <a href="{{ url('blog/'.$left->slug) }}">
                <div class="left" style="{{ !empty($left->image) ? 'background: url('.url('storage/uploads/blogs/'.$left->image).'); background-size: cover; background-repeat: no-repeat;' : '' }}">
                    <div class="left-overlay">
                        <div class="content">
                            <h4 class="font-weight-bold">{{ $left->title }}</h4>
                            <p>{{ date('d M Y', strtotime($left->created_at)) }}</p>
                            <div class="hr"></div>
                        </div>
                    </div>
                </div>
            </a>
            @endif
        </div>
        <div class="col-md-12 pt-3 text-center">
            <a href="{{ url('blogs') }}" class="button text-white font-weight-bold">
                Read All Posts <i class="fa fa-angle-double-right"></i>
            </a>
        </div>
    </div>
</section>
@endif
@endsection

@push('script')
<script>
$(document).ready(function() {
    if ($('#country').length) {
        $('#country').typeahead({
            minLength: 0,
            showHintOnFocus: true,
            autoSelect: false,
            source: function(query, result) {
                $.ajax({
                    url: "{{ url('get-country') }}",
                    data: 'query=' + encodeURIComponent(query),
                    dataType: "json",
                    type: "GET",
                    success: function(data) {
                        return result(data);
                    }
                });
            },
            afterSelect: function(args) {
                if (args && args.slug) {
                    window.location.href = args.slug;
                }
            }
        });
    }
});
</script>
@endpush
