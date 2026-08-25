@extends('layouts.master')
@section('content')
<section id="content" class="container">
    <div class="row">
        <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
                <ins class="adsbygoogle"
                style="display:inline-block;width:280px;height:600px"
                data-ad-client="ca-pub-9682339330195266"
                data-ad-slot="3145814347"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>

                <br>
                <div class="sticky">
                    <div style="width: 100% !important;margin: 10px 0;" class="converter ">
                        <div style=""><h4>Currency Converter</h4><script type="text/javascript" src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1"></script></div>
                    </div>
                    <ins class="adsbygoogle"
                    style="display:inline-block;width:280px;height:250px"
                    data-ad-client="ca-pub-9682339330195266"
                    data-ad-slot="3145814347"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            <?php endif ?>
        </div>
        <div class="col-md-9 ">

            <div style="display: none;">{{ $detail->custom_content }}</div>
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-weight: bold">{{ $detail->name }}</h2>
                    @if($fares->count() > 0)
                    <span class="text-danger" style="font-weight:bolder;font-size:20px;text-align:center;">Note : These prices are estimated for accurate pricing please <a href="{{url('contact-us')}}" style="text-decoration:underline;">contact us</a></span>
                    <table class="table table-bordered table-striped">
                        <thead style="background-color: #070c39;color: #fff;">
                            <tr>
                                <th>#</th>
                                <th>Destination</th>
                                <th>One Way</th>
                                <th>Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $x=0 @endphp
                            @foreach($fares as $f)
                            @php $x++ @endphp
                            <tr>
                                <td>{{$x}}</td>
                                <td><span class="text-capitalize">{{$f->from}}</span> - <span class="text-capitalize">{{$f->to}}</span></td>
                                <td>{{$f->price}}</td>
                                <td>{{$f->return}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    @endif
                    <!-- <h6 style="margin-bottom: 0;"><strong>Country : </strong> {{ $detail->countries->country }}</h6> -->
                    {!! renderHTML($detail->content) !!}
                </div>
                <div class="col-md-4">
                    <img src="{{ url('storage/uploads/airline/'.$detail->img) }}" width="100%">
                    <hr>

                    <h4>Other Airlines</h4>
                    <hr>
                    @foreach($relatedArlines as $r)
                    <div class="text-center">
                        <a href="{{ url('airline/'.$r->slug) }}"><img src="{{ url('storage/uploads/airline/'.$r->img) }}" style="width: 200px;
                        height: 60px;object-fit:contain" ></a>
                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
            
        </div>

    </div>
</section>
@endsection
