@extends('layouts.master')
@section('content')
<section id="content" class="container mt-4 mb-5">
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
            <h1 class="mb-3 font-weight-bold" style="font-size: 26px;">Contact Us</h1>

            @if(!empty($content))
            <div class="mb-4">
                {!! renderHTML($content->content) !!}
            </div>
            @endif

            <div class="card p-4 shadow-sm" style="border-radius: 8px; border: 1px solid #e0e0e0;">
                <h3 class="mb-4 font-weight-bold" style="font-size: 20px;">Send Us a Message</h3>
                <form method="post" class="contact-form" action="{{ url('save-contact') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact-name" class="font-weight-bold">Your Name <span class="text-danger">*</span></label>
                            <input type="text" id="contact-name" name="name" data-validation="required" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact-email" class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" id="contact-email" name="email" class="form-control" data-validation="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact-phone" class="font-weight-bold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="contact-phone" name="phone" data-validation="required" class="form-control" placeholder="Enter your phone or mobile" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact-subject" class="font-weight-bold">Subject <span class="text-danger">*</span></label>
                            <input type="text" id="contact-subject" name="subject" data-validation="required" class="form-control" placeholder="Message subject" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact-message" class="font-weight-bold">Message <span class="text-danger">*</span></label>
                        <textarea id="contact-message" name="message" rows="5" data-validation="required" class="form-control" placeholder="How can we help you?" required></textarea>
                    </div>
                    @if(config('captcha.sitekey'))
                    <div class="form-group">
                        {!! NoCaptcha::display() !!}
                        <div class="capchtavalidation"></div>
                        @if (isset($errors) && $errors->has('g-recaptcha-response'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                        @endif
                    </div>
                    @endif
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-warning text-white font-weight-bold px-4 py-2">Submit Message</button>
                    </div>
                </form>
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
            "@type": "ContactPage",
            "@id": "https://agents.com.pk/contact-us#webpage",
            "url": "https://agents.com.pk/contact-us",
            "name": "Contact Us | Agents.com.pk",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "description": "Get in touch with Agents.com.pk support team for travel agency listing inquiries, embassy data updates, and customer support."
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
                    "name": "Contact Us",
                    "item": "https://agents.com.pk/contact-us"
                }
            ]
        }
    ]
}
</script>
@endpush