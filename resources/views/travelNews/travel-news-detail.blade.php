@extends('layouts.master')
@section('content')

<!-- <section id="content" class="container">
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


            <h2 style="font-weight: bold">{{ ucfirst($detail->title) }} </h2>
            @if(!empty($detail->image))
            <img src="{{url('storage/uploads/travelnews/'.$detail->image)}}"  width="100%" alt="{{!empty($detail->image_alt)?$detail->image_alt:$detail->title}}">
            @else
            <img src="{{url('images/blgosplaceolder.png')}}" style="width: 100%;">
            @endif
            <div class="row" style="padding: 10px 0">
                <div class="col-md-7">
                    <h4 class="number-style">--> <!-- {{date('d M Y',strtotime($detail->created_at))}} 
                    @if(!empty($detail->date))
                                     {{date('d M Y',strtotime($detail->date))}}
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

                    <a href="https://wa.me/?text={{ ucfirst($detail->title) }} {{request()->url()}}"
                        class="btn btn-sm btn-primary" target="_blank"
                        style="    background-color: #25D366;border: medium;">
                        <i class="fab fa-whatsapp" aria-hidden="true" style=""></i> WhatsApp</a>
                </div>
            </div>

            {!! $detail->content !!}

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
</section> -->

@endsection