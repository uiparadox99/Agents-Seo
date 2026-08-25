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

        <div class="col-md-9 ">
            @if($airlines->count() > 0)
            <section id="packages" class="container">
                <div class="title text-center p-3">
                    <h1>Airlines </h1>
                    <div class="bar"><span></span><span></span><span></span></div>
                </div>
                <div class="packages pt-3 pr-4 pl-4">
                    <div class="row">
                        @foreach($airlines as $p)
                        <div class="col-md-6 pr-3 pl-2">
                            <div class="box ">
                                <a href="{{ url('airline/'.$p->slug) }}">

                                    <img src="{{url('storage/uploads/airline/'.$p->img)}}" class="box-img"
                                        style="object-fit: contain;" alt="{{$p->image_alt}}">
                                    <div class="layer " style="    width: 94%;">
                                    </div>
                                    <div class="p-2 text-center detail">
                                        <h3 class="m-0 p-0">{{$p->name}}</h3>
                                    </div>
                            </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div> <ins class="adsbygoogle" style="display:inline-block;width:100%;height:82px"
                        data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </section>
            @endif


        </div>
    </div>

    </div>
</section>
@endsection