@extends('layouts.master')
@section('content')
@include('includes.slider')
<section id="content" class="container">
    <div class="about-padding">
        <div class="row">
            <div class="col-md-3 col-pd">
                <?php if (!$detect->isMobile()): ?>
                <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <?php endif ?>
            </div>
            <div class="col-md-9 col-pd">
                @if(!empty($content))
                    {!! renderHTML($content->content) !!}
                @else
                    <h1>About Agents.com.pk</h1>
                    <p>Agents.com.pk is a trusted travel portal in Pakistan providing embassy information, visa requirements, and connecting travelers with certified travel agents.</p>
                @endif
            </div>
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
            "@type": "AboutPage",
            "@id": "https://agents.com.pk/about-us#webpage",
            "url": "https://agents.com.pk/about-us",
            "name": "About Us | Agents.com.pk",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "description": "Learn about Agents.com.pk, Pakistan's leading directory for foreign embassy contacts, visa guidelines, and verified travel agents."
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
                    "name": "About Us",
                    "item": "https://agents.com.pk/about-us"
                }
            ]
        },
        {
            "@type": "FAQPage",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "What information can I find about embassies on this site?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You can find official addresses, contact numbers, email addresses, websites, and visa requirement details for foreign embassies and consulates located in Pakistan."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is the difference between an Embassy and a Consulate?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "An Embassy is the main representative diplomatic mission of a foreign country typically located in Islamabad and headed by an Ambassador. A Consulate is a regional diplomatic office located in major cities."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Does Agents.com.pk only provide embassy information?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "No, in addition to embassy and visa details, Agents.com.pk connects travelers with certified travel agents for Umrah packages, flight tickets, hotel reservations, and tour packages."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How do I contact a travel agent through Agents.com.pk?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You can browse the travel agents directory on Agents.com.pk, select an agency in your city, and contact them directly using their verified contact details."
                    }
                }
            ]
        }
    ]
}
</script>
@endpush