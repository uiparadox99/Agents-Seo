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

            <h1>About Visas</h1>
            @if(!empty($content))
            {!! renderHTML($content->content) !!}
            @endif
        </div>
        </div>
      


    </div>
</section>
@endsection