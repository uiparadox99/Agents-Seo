@extends('layouts.master')
@section('content')

<section id="content" class="container">
    <div class="row">
     
        <div class="col-md-12">

            <h2 style="font-weight: bold" class="mt-4">{{ ucfirst($detail->name) }} <a class="btn btn-primary float-right" href="{{!empty($detail->url)?url($detail->url):''}}" rel="nofollow" target="_blank" >Check Offical Link</a></h2>
            <div class="row" style="padding: 10px 0">
                <div class="col-md-7">
                    <h4 class="number-style"><!-- {{date('d M Y',strtotime($detail->created_at))}} -->
                    @if(!empty($detail->created_at))
                                     {{date('d M Y',strtotime($detail->created_at))}}
                                     @endif
                    </h4>
                </div>
                <div class="col-md-5">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{request()->url()}}"
                        class="btn btn-sm btn-primary" target="_blank "
                        style="    background-color: #2f5b9d;border: none;">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook</a>

                    <a href="https://twitter.com/share?url={{request()->url()}}r&amp;text={{ ucfirst($detail->title) }}"
                        class="btn btn-sm btn-primary" target="_blank"
                        style="    background-color: #38bff1;border: none;">
                        <i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a>

                    <a href="https://wa.me/?text={{ ucfirst($detail->name) }} {{request()->url()}}"
                        class="btn btn-sm btn-primary" target="_blank"
                        style="    background-color: #25D366;border: medium;">
                        <i class="fab fa-whatsapp" aria-hidden="true" style=""></i> WhatsApp</a>
                </div>
            </div>

            @if(!empty($detail->image))
            <img src="{{url('storage/uploads/agents/'.$detail->image)}}" class="mb-3"  width="100%" alt="{{!empty($detail->image_alt)?$detail->image_alt:$detail->title}}">
            @endif

            {!! $detail->description !!}
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