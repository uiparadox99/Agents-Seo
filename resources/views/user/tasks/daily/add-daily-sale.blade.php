@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
         
            <h2 style="text-align: center;">Daily Sale Entry</h2>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-sm-12">
                <div class="row">
                 <div class="col-md-6 offset-md-3 form-group">
                  <label class="control-label">Select Sale Type</label>
                  <select class="form-control" name="sale_type" id="sale_type">
                    <option value="tickets">Tickets</option>
                    <option value="visas">Visas</option>
                    <option value="hotels">Hotels</option>
                    <option value="packages">Packages</option>
                    <option value="umrah">Umrah</option>
                    <option value="travel-insurance">Travel Insurance</option>
                    <option value="others">Others (Re-issue / Seat Allocation)</option>
                  </select>
                </div>
              </div>
              <div class="tickets-section">
                 @include('user.tasks.partials.tickets-form')
              </div>
              <div class="hotels-section" style="display: none;">
                 @include('user.tasks.partials.hotel-sale-form')
              </div>
               <div class="visa-section" style="display: none;">
                 @include('user.tasks.partials.visa-sale-form')
              </div>
               <div class="package-section" style="display: none;">
                 @include('user.tasks.partials.tour-package-form')
              </div>
               <div class="umrah-section" style="display: none;">
                 @include('user.tasks.partials.umrah-sale-form')
              </div>
                <div class="travel-insurance-section" style="display: none;">
                 @include('user.tasks.partials.travel-insurance-form')
              </div>
               <div class="others-section" style="display: none;">
                 @include('user.tasks.partials.other-sales-form')
              </div>
                  
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
  $(document).on('change', '#sale_type', function(){
    var $this = $(this);
    var data = $this.val();
    if (data === 'hotels') {
      $('.tickets-section').hide('slow');
      $('.visa-section').hide('slow');
      $('.package-section').hide('slow');
      $('.umrah-section').hide('slow');
      $('.travel-insurance-section').hide('slow');
      $('.others-section').hide('slow');
      $('.hotels-section').show('slow');
    }else if(data === 'visas'){
         $('.tickets-section').hide('slow');
      $('.hotels-section').hide('slow');
      $('.package-section').hide('slow');
      $('.umrah-section').hide('slow');
      $('.others-section').hide('slow');
      $('.travel-insurance-section').hide('slow');
      $('.visa-section').show('slow');
    }else if(data === 'packages'){
         $('.tickets-section').hide('slow');
      $('.visa-section').hide('slow');
      $('.hotels-section').hide('slow');
      $('.umrah-section').hide('slow');
      $('.travel-insurance-section').hide('slow');
      $('.others-section').hide('slow');
      $('.package-section').show('slow');
    }else if(data === 'umrah'){
         $('.tickets-section').hide('slow');
      $('.visa-section').hide('slow');
      $('.hotels-section').hide('slow');
      $('.package-section').hide('slow');
      $('.travel-insurance-section').hide('slow');
      $('.others-section').hide('slow');
      $('.umrah-section').show('slow');

     }else if(data === 'travel-insurance'){
         $('.tickets-section').hide('slow');
      $('.visa-section').hide('slow');
      $('.hotels-section').hide('slow');
      $('.package-section').hide('slow');
      $('.umrah-section').hide('slow');
      $('.others-section').hide('slow');
      $('.travel-insurance-section').show('slow');
    }else if(data === 'others'){
         $('.tickets-section').hide('slow');
      $('.visa-section').hide('slow');
      $('.hotels-section').hide('slow');
      $('.package-section').hide('slow');
      $('.umrah-section').hide('slow');
      $('.travel-insurance-section').hide('slow');
      $('.others-section').show('slow');
    
    }else{
      $('.hotels-section').hide('slow');
       $('.visa-section').hide('slow');
       $('.umrah-section').hide('slow');
       $('.package-section').hide('slow');
       $('.travel-insurance-section').hide('slow');
       $('.others-section').hide('slow');
         $('.tickets-section').show('slow');
    }
  });
</script>
@endpush
