@extends('layouts.master')
@section('content')
<section id="content" class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
            <ins class="adsbygoogle" style="display:inline-block;width:280px;height:220px"
                data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            <?php endif ?>
        </div>
        <div class="col-md-9">
            <h1 class="font-weight-bold mb-3" style="font-size: 26px;">{{ ucfirst($detail->title) }}</h1>
            
            <div class="mb-3">
                <img src="{{ $detail->image_url }}" 
                     onerror="this.onerror=null;this.src='{{ asset('images/blog-default.jpg') }}';" 
                     class="img-fluid rounded" 
                     style="width: 100%; max-height: 480px; object-fit: cover;" 
                     alt="{{ !empty($detail->image_alt) ? $detail->image_alt : $detail->title }}" 
                     fetchpriority="high">
            </div>

            <div class="row align-items-center py-2 mb-3 border-bottom border-top">
                <div class="col-md-7">
                    <p class="text-muted mb-0 font-weight-bold">
                        <i class="far fa-calendar-alt mr-1"></i> {{ date('d M Y', strtotime($detail->created_at)) }} 
                        @if(!empty($detail->blogsCategory))
                            <span class="mx-2">&bull;</span> <i class="far fa-folder mr-1"></i> {{ $detail->blogsCategory->name }}
                        @endif
                    </p>
                </div>
                <div class="col-md-5 text-md-right mt-2 mt-md-0">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                        class="btn btn-sm text-white" target="_blank" rel="noopener noreferrer"
                        style="background-color: #2f5b9d;">
                        <i class="fab fa-facebook-f mr-1"></i> Facebook</a>

                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&amp;text={{ urlencode($detail->title) }}"
                        class="btn btn-sm text-white" target="_blank" rel="noopener noreferrer"
                        style="background-color: #1DA1F2;">
                        <i class="fab fa-twitter mr-1"></i> Twitter</a>

                    <a href="https://wa.me/?text={{ urlencode($detail->title . ' ' . request()->url()) }}"
                        class="btn btn-sm text-white" target="_blank" rel="noopener noreferrer"
                        style="background-color: #25D366;">
                        <i class="fab fa-whatsapp mr-1"></i> WhatsApp</a>
                </div>
            </div>

            <article class="blog-content entry-content" style="font-size: 16px; line-height: 1.8;">
                {!! $detail->content !!}
            </article>

            <?php if (!$detect->isMobile()): ?>
            <div class="mt-4" style="width: 100%;">
                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:120px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <?php endif ?>
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
            "@type": "BlogPosting",
            "@id": "{{ request()->url() }}#article",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "headline": "{{ addslashes($detail->title) }}",
            "description": "{{ addslashes(str_limit(strip_tags($detail->content ?? ''), 160)) }}",
            "url": "{{ request()->url() }}",
            "datePublished": "{{ date('c', strtotime($detail->created_at)) }}",
            "dateModified": "{{ date('c', strtotime($detail->updated_at ?? $detail->created_at)) }}",
            "mainEntityOfPage": "{{ request()->url() }}",
            "author": {
                "@type": "Organization",
                "name": "Agents.com.pk",
                "url": "https://agents.com.pk/"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Agents.com.pk",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('images/agents-logo.png') }}"
                }
            }
            @if(!empty($detail->image))
            ,
            "image": {
                "@type": "ImageObject",
                "url": "{{ url('storage/uploads/blogs/'.$detail->image) }}"
            }
            @endif
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
                    "name": "Blog",
                    "item": "https://agents.com.pk/blogs"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($detail->title) }}",
                    "item": "{{ request()->url() }}"
                }
            ]
        }
    ]
}
</script>
@endpush