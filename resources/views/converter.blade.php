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
            <?php endif ?>
        </div>
        <div class="col-md-9 ">
            <div class="row">
                <div class="col-md-6">
                    <div style="width: 100% !important;margin: 10px 0;" class="converter">
                        <div style="">
                            <h4>Currency Converter</h4>
                            <script type="text/javascript"
                                src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1">
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding: 15px">
                    @if(!empty($content))
                    {!! renderHTML($content->content) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection