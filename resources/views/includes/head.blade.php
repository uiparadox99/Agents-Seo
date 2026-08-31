<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
<link rel="canonical" href="{{ url()->current() }}" />

<meta name="geo.region" content="PK" />
<meta name="geo.placename" content="Pakistan" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="google-adsense-account" content="ca-pub-9682339330195266">

<!-- Favicon -->
<link rel="icon" href="{{ asset('images/agents-icon.png') }}" type="image/x-icon">
<link rel="apple-touch-icon" href="{{ asset('images/agents-icon.png') }}">

<!-- DNS Prefetch & Preconnect for Performance -->
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="dns-prefetch" href="https://pagead2.googlesyndication.com">
<link rel="dns-prefetch" href="https://www.googletagmanager.com">

<!-- Core Stylesheets -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toaster/toaster.css') }}">
<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('css/flag-icon.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" />

<!-- Structured Data: Organization & WebSite (JSON-LD) -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Organization",
            "@id": "https://agents.com.pk/#organization",
            "name": "Agents.com.pk",
            "url": "https://agents.com.pk/",
            "logo": {
                "@type": "ImageObject",
                "@id": "https://agents.com.pk/#logo",
                "url": "{{ asset('images/agents-logo.png') }}",
                "caption": "Agents.com.pk"
            },
            "sameAs": [
                "https://www.facebook.com/Agents.com.pk"
            ],
            "contactPoint": [
                {
                    "@type": "ContactPoint",
                    "telephone": "+447344321378",
                    "contactType": "Customer Support",
                    "areaServed": "PK",
                    "availableLanguage": ["English", "Urdu"]
                }
            ]
        },
        {
            "@type": "WebSite",
            "@id": "https://agents.com.pk/#website",
            "url": "https://agents.com.pk/",
            "name": "Agents.com.pk",
            "description": "Pakistan's leading portal for foreign embassy information, visa requirements, verified travel agents, and Umrah packages.",
            "publisher": {
                "@id": "https://agents.com.pk/#organization"
            },
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "https://agents.com.pk/travel-agents-in-pakistan?agentbar={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            },
            "inLanguage": "en-PK"
        }
    ]
}
</script>

@stack('schema')

@if(request()->getHost() != 'localhost' && request()->getHost() != '127.0.0.1')
<!-- Google Adsense -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9682339330195266" crossorigin="anonymous"></script>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EQ9Z1VT5PZ"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-EQ9Z1VT5PZ');
</script>
<meta name="google-site-verification" content="mHubaITRhgviftrQQzEfqkO3D40Djjp5U01ecr6n_vU" />
@endif

@stack("style")