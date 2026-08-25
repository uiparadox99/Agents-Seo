@extends('layouts.master')
@section('content')
@include('includes.slider')
<!-- <section id="slider">
    <div class="bg-overlay" style="height: 100%">
        <div class="container">
            <?php if (!$detect->isMobile()): ?>
            <div class="search text-center" style="padding: 50px;">
                <?php else: ?>
                <div class="search text-center" style="padding: 10px;">
                    <?php endif ?>
                    <h1>Search For Latest Travel News</h1>
                    <form id="searchForm" method="get" action="{{url('travel-news')}}">
                        <div class="input-group input-group-lg  mb-3">
                            <input type="text" class="form-control"
                                value="{{!empty(request()->get('q'))?request()->get('q'):''}}" autocomplete="off"
                                name="q" placeholder="Search">
                            <div class="input-group-append" id="submitSearch" style="cursor: pointer;">
                                <span class="input-group-text">@if(!$detect->isMobile()) <i class="fa fa-search" style="margin-right: 10px"></i>
                                 Search @else <i class="fa fa-search" ></i>  @endif</span>
                            </div>
                        </div>
                    </form>
                    <?php if (!$detect->isMobile()): ?>
                    <div style="height: 87px;">
                        <ins class="adsbygoogle" style="display:inline-block;width:680px;height:82px"
                            data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        <div class="clearfix"></div>
                    </div>
                    <?php endif ?>

                </div>

            </div>

        </div>
</section> -->
<!-- <section id="content" class="container">
    <div class="row">
        <div class="col-md-3 col-pd">
            <?php if (!$detect->isMobile()): ?>
            <ins class="adsbygoogle" style="display:inline-block;width:280px;height:600px"
                data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

            <br>
            <div class="sticky"> -->
                <!--  <div style="width: 100% !important;margin: 10px 0;" class="converter ">
           <div style=""><h4>Currency Converter</h4><script type="text/javascript" src="//www.exchangeratewidget.com/converter.php?l=en&f=USD&t=PKR&a=1&d=FFFFFF&n=FFFFFF&o=000000&v=1"></script></div>
         </div> -->
                <!-- <ins class="adsbygoogle" style="display:inline-block;width:280px;height:250px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="3145814347"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <?php endif ?>
        </div>
        <div class="col-md-9 ">
            <br>
               <div class="embassy-search" >
      <form method="get" action="{{url('travel-news')}}">
                
           
                    <div class="row">
                        <div class="col-md-5" style="vertical-align: middle;padding-top: 5px;">
                            <h5>Search News By Airline <i class="fa fa-arrow-right" style="margin-left: 10px;"></i></h5>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2" name="airline"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="{{url('travel-news')}}">Select </option>
                                @foreach ($airlines as $d)

                                <option value="{{url('travel-news?airline='.$d->id)}}" {{request()->has('airline') && request()->get('airline') == $d->id?'selected':''}}>{{$d->name}}</option>
                                @endforeach
                            </select>
                        </div>
                       
                    </div>
                     </form>
                </div>
                <br>
                        <div class="embassy-search" >
            <form method="get" action="{{url('travel-news')}}">
                
           
                    <div class="row">
                        <div class="col-md-4" style="vertical-align: middle;padding-top: 5px;">
                            <h5>Search News by Title  
                        </div>
                       
                         <div class="col-md-6" style="">
                           <input type="text" name="q" class="form-control" placeholder="Search Updates" value="{{request()->has('q')?request()->get('q'):''}}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                    </div>
                     </form>
                </div>
                <br>
            @if($news->count() > 0)
            <div class="row">
                @foreach ($news as $d)
                <div class="col-md-6">
                    <a href="{{url('travel-news/'.$d->slug)}}" class="blog-link">
                          @if(!request()->has('q'))
                        <div class="visas-blogs-box">
                            @if(!empty($d->image))
                            <img src="{{url('storage/uploads/travelnews/'.$d->image)}}" style="width: 100%;height:200px;object-fit:contain;"  alt="{{!empty($d->image_alt)?$d->image_alt:$d->title}}">
                            @else
                            <img src="{{url('images/blgosplaceolder.png')}}" style="width: 100%;">
                            @endif
                          @else
                        <div class="visas-blogs-box" style="    height: 90px;">
                            @endif
                            
                            <div class="blog-detail">


                                <h3>{{$d->title}}</h3>
                                   @if(!request()->has('q'))
                                <p class="number-style">
                                @if(!empty($d->date))
                                     {{date('d M Y',strtotime($d->date))}}
                                     @endif
                                </p>
                                <p> {{ strip_tags(str_limit($d->content,200)) }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center">
                {!! $news->appends(request()->except('page'))->links() !!}
            </div>
            @else
            <p class="text-center" style="    margin: 59px 0;
    background: #070c39;  color: white;"><strong>No Record Found</strong></p>
            @endif
        </div> -->


        <!--    <div class="col-md-2 col-pd">
   <div>
     <ins class="adsbygoogle"
     style="display:inline-block;width:280px;height:600px"
     data-ad-client="ca-pub-9682339330195266"
     data-ad-slot="3145814347"></ins>
     <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
     </script>
   </div>
 
 </div> -->
    </div>
</section>
@endsection
@push('script')
<script>
$(document).ready(function() {
    $('#country').typeahead({
        minLength: 0,
        showHintOnFocus: true,
        autoSelect: false,
        source: function(query, result) {
            $.ajax({
                url: "{{url('get-country')}}",
                data: 'query=' + query,
                dataType: "json",
                type: "GET",
                success: function(data) {
                    return result(data);
                }
            });
        },

        afterSelect: function(args) {
            window.location.href = args.slug;
        }
    });
});
</script> @endpush