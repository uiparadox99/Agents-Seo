@extends('layouts.master')
@section('content')
<section id="content" class="container" style="padding-top: 25px; padding-bottom: 40px;">
    <div class="agents-city-section">
        <div class="text-center">
            <h1 style="font-weight: 700; font-size: 24px; margin-bottom: 18px; color: #070c39;">Search Travel Agents by City in Pakistan</h1>
        </div>
        <ul class="aplhabatic-list" aria-label="Alphabetical City Filter">
            @foreach(range('A', 'Z') as $char)
            <li class="{{ strtolower($char) == 'y' ? 'y-style-on-mobile' : '' }}">
                <a href="{{ url('travel-agents-in-pakistan/'.strtolower($char)) }}">{{ $char }}</a>
            </li>
            @endforeach
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="mt-4">
        <div class="row" style="margin-right: -5px; margin-left: -5px;">
            @if($cities->count() > 0)
                @foreach($cities as $c)
                <div class="col-md-2 col-6 mb-2" style="padding-left: 5px; padding-right: 5px;">
                    <a href="{{ url('travel-agents-in-'.str_slug($c->name)) }}" class="city-link text-capitalize font-weight-bold" style="color: #070c39 !important; background: #f8f9fa; padding: 10px; display: block; border-radius: 4px; text-align: center; border: 1px solid #e9ecef;">
                        {{ strtolower($c->name) }}
                    </a>
                </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <p class="text-center text-muted">No City Found</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "https://agents.com.pk/cities#webpage",
            "url": "https://agents.com.pk/cities",
            "name": "Travel Agents by City in Pakistan | Agents.com.pk",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "description": "Browse travel agents, tour operators, and Umrah agencies by city across all provinces of Pakistan."
        },
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://agents.com.pk/"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Cities",
                    "item": "https://agents.com.pk/cities"
                }
            ]
        }
    ]
}
</script>
@endpush