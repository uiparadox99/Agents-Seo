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
            <hr>
            @if(!empty($content->image))
            <img src="{{ url('storage/uploads/schengen/'.$content->image) }}" style="width: 100%;" alt="{{$content->image_alt}}">
            <div class="clearfix"><br></div>
            @endif

            @if(!empty($content->content1))
            {!! renderHTML($content->content1) !!}
            @endif
            @if(!empty($content->countries))
            @php
            $schengencountry = explode(',', $content->countries);
            @endphp

            <ul style="padding: 0;list-style: none;margin-bottom: 10px;border:1px solid ;" class="schengen-list">

                @foreach($schengencountry as $c)

                <li style="width: 25%;float: left;t">{{$c}}</li>

                @endforeach
                <div class="clearfix"></div>

            </ul>

            @endif
            @if(!empty($content->content2))
            {!! renderHTML($content->content2) !!}
            @endif
        </div>

    </div>
</section>
@endsection