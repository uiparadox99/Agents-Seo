@extends('layouts.master')
@section('content')
<!-- <section id="slider">
  <div class="bg-overlay" style="height: 100%">
    <div class="container">
     <?php if (!$detect->isMobile()): ?>
      <div class="search text-center" style="padding: 50px;">
       <?php else: ?>
         <div class="search text-center" style="padding: 10px;">
         <?php endif ?>
         <h1>Select Embassy in Islamabad</h1>
         <form id="searchForm" method="get" action="{{url('search')}}">
           <div class="input-group input-group-lg  mb-3">
            <input type="text" class="form-control"  value="{{!empty(request()->get('q'))?request()->get('q'):''}}" id="country" autocomplete="off" name="q" placeholder="Enter Country Name">
            <div class="input-group-append" id="submitSearch" style="cursor: pointer;">
             <span class="input-group-text"><i class="fa fa-search" style="margin-right: 10px"></i> Search</span>
           </div>
         </div>
       </form>
       <?php if (!$detect->isMobile()): ?>
         <div style="height: 87px;">
           <ins class="adsbygoogle" style="display:inline-block;width:680px;height:82px" data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
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
<section id="content" class="container">
    <div class="row">
        <!-- <div class="col-md-3 col-pd">
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
       </div> -->
        <div class="col-md-12 ">
            <div class="row">


                @if($relatedSites->count() > 0)
                @foreach ($relatedSites as $d)
                <div class="col-md-3">


                    <a href="{{$d->link}}" class="related-link" target="_blank">
                        <div class="visas-listing-box">

                            @if(!empty($d->logo))
                            <img src="{{url('storage/uploads/related/'.$d->logo)}}" style="width: 100%; height: 100px;
    margin-bottom: 9px;object-fit: contain;">

                            @endif


                            <h3 class="text-center">{{$d->title}}</h3>


                        </div>
                    </a></div>
                @endforeach
                <div class="text-center">

                </div>
                @else
            </div>
            <p class="text-center" style="    margin: 59px 0;
    background: #070c39;  color: white;"><strong>No Record Found</strong></p>
            @endif
        </div>


        <!--   <div class="col-md-2 col-pd">
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