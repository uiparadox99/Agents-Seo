@extends('layouts.master')
@section('content')
<section id="content" class="container">
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
        <div class="col-md-6 col-pd">
            <h2>Terms & Conditions</h2>
            @if(!empty($content))
            {!! renderHTML($content->content) !!}
            @endif
        </div>
    </div>
</section>
@endsection