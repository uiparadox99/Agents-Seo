@extends('layouts.master')
@section('content')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
            <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

            <br>
            <div class="sticky">
                <div style="width: 100% !important;margin: 10px 0;" class="converter ">
                    <div style="">
                        <h4>Currency Converter</h4>
                        <script type="text/javascript"
                            src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1">
                        </script>
                    </div>
                </div>
                <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <?php endif ?>
        </div>
        <div class="col-md-9">

            <h2 style="font-weight: bold">{{ $content->heading }}</h2>
            <p><strong>Issue Date : </strong> {{ $content->policy_date }}</p>
            <img src="{{ url('images/passport.jpg') }}" style="width: 100%;margin-bottom: 10px;" alt="{{$content->image_alt}}">
            <br>

            @if(!empty($content->image))
            <img src="{{ url('storage/uploads/policy/'.$content->image) }}" style="width: 100%;">
            <div class="clearfix"><br></div>
            @endif

            @if(!empty($content))
            {!! renderHTML($content->content) !!}
            @endif
        </div>

    </div>
</section>
@endsection