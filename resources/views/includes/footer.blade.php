<section id="subscribe">
  <div class="container pt-4 pb-4">
    <form method="post" action="{{url('save-newsletter')}}">
      {{csrf_field()}}
      <div class="row text-center">

        <div class="col-md-5 col-12 pt-2">
          <h3 class="text-white text-center">Subscribe to get latest updates</h3>
        </div>
        <div class="col-md-4   pt-2">

          <input type="text" name="email" data-validation="email" data-message="You haven not prpoovide"  class="form-control p-2" placeholder="Enter your Email" name="">
        </div>
        <div class="col-md-2 text-center  pt-2">
          <button type="submit" class="btn  btn-block p-2 text-uppercase" >Subscribe  <?php if (!$detect->isMobile()): ?>Now<?php  endif ?></button>
        </div>
      </div> 
    </form> 
  </div>
</section>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 about">
        <img src="{{url('images/agents-logo.png')}}" width="300">
   <!--      <img  src="{{ url('images/logo.png') }}" alt="Agents.com.pk" title="Agents.com.pk" width="60%" class="mb-3"> -->
        <p class="mt-2">{{ !is_null($setting->website_desc)?$setting->website_desc:'' }} </p>
         @if(is_null($app))
        <!-- <a href="https://play.google.com/store/apps/details?id=www.Agents.com.pk" class="btn btn-primary mb-2" style="background: #007bff">
            <div class="row">
                <div class="col-md-3 col-3">
                    <img src="{{url('images/play.png')}}" width="40px">
                    <i class="fa fa-google-play" style="margin-top: 4px;font-size: 36px;"></i>
                </div>
                <div class="col-md-9 col-9" style="padding-left: 0;">
                    Available on the
                    <br> <strong>Play Store</strong>
                </div>
            </div>
        </a> -->
        @endif
              <!--  <div class="row">
                  <div class="col-1 pt-2">
                      <i class="fa fa-map-marker"></i>
                  </div>
                  <div class="col-10">
                      <h5 class="mb-0">Office Address</h5>
                      <p>Lorem ipsum dolor sit amet</p>
                  </div>
              </div>
               <div class="row">
                   <div class="col-1 pt-3">
                       <i class="fa fa-phone"></i>
                   </div>
                   <div class="col-10">
                       <h5 class="mb-0">Contact us</h5>
                       <p>Lorem ipsum dolor sit amet</p>
                   </div>
                 </div> -->
               </div>
           <!-- <div class="col-md-2 usefull">
            <h4 class="text-uppercase">USEFUL Links</h4>
            <ul class="pl-0 ml-0 mt-4">
                <li><a href="{{ route('privacy') }}"><i class="fa fa-circle mr-2"></i>Privacy Policy / Terms & Condition</a></li>
                <li><a href="{{ route('converter') }}"><i class="fa fa-circle mr-2"></i>Currency Converter</a></li>
            </ul>
          </div> -->

          <div class="col-md-3 im-links">
            <h4 class="text-uppercase">Important Links</h4>
            <div class="mt-4">
           <!--    <p><a href="{{ url('pakistan-visa-info') }}">Pakistan Embassy in World</a></p>
           <p><a href="{{ url('highlights-of-pakistans-new-visa-policy') }}">Pakistan Visa on Arrival </a></p>
           <p><a href="{{ route('schengen') }}">Schengen Visa </a></p>
           <hr> -->
          <!--     <p><a href="{{ url('travel-agents-in-pakistan') }}">Travel Agents in Pakistan</a></p> -->
              <p><a href="{{ url('cheap-umrah-packages') }}">Umrah Packages </a></p>
              <p><a href="{{ route('flight') }}">Umrah Tickets </a></p>
              {{-- <p><a href="{{ route('umrah-hotels') }}">Umrah Hotels </a></p> --}}
              <p><a href="{{ route('sasti-tickets') }}">Sasti Tickets </a></p>
              <p><a href="{{ url('new-umrah-policy') }}">Umrah Policy</a></p>
              <p><a href="{{ url('pakistan-visa-info') }}">Embassies in Pakistan</a></p>
              <!-- <p><a href="{{ url('new-umrah-policy-2019') }}">Umrah Policy 2019 </a></p> -->
             <hr>
             <p><a href="{{ route('about') }}">About Us</a></p>
             <p><a href="{{url('blogs')}}">Blog </a></p>
             <!--<p><a href="{{ url('government-lists-salient-features-of-2019-hajj-policy') }}">Pakistan Hajj Policy </a></p>-->
                         
             <p><a href="{{ route('converter') }}">Currency Converter</a></p> 
              <p><a href="{{ route('useful-links') }}">Useful Links</a></p> 
             
                          
                         
             <!-- <p><a href="{{ route('contact') }}">Contact Us </a></p> -->
             <hr>
             <!-- <p><a href="{{route('advertise')}}">Advertise With Us</a></p> -->
            
          

            </div>
          </div>
          <div class="col-md-5">
            <!--<h4 class="text-uppercase">Follow us</h4>-->
            <div class="mt-4 ">
             <?php if (!$detect->isMobile()): ?>
               <!--  <div class="fb-page" data-href="https://www.facebook.com/Agents.com.pk/" data-width="450" data-height="600" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/Agents.com.pk/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Agents.com.pk/">VISA information</a></blockquote></div> -->
               <div class="fb-page" 
               data-tabs="timeline"
               data-href="https://www.facebook.com/Agents.com.pk"
               data-width="450" data-height="300"></div>
               <?php else: ?>
                 <div class="fb-page" data-href="https://www.facebook.com/Agents.com.pk/" data-width="250" data-height="600" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/Agents.com.pk/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Agents.com.pk/">VISA information</a></blockquote></div>
               <?php endif ?>

               <!--  <div class="col-3 pr-0">
                   <img src="https://via.placeholder.com/150" width="100%">
               </div>
               <div class="col-9">
                   <p class="m-0">Lorem ipsum dolor </p>
                   <p class="m-0 text-orange">2 days ago</p>
               </div>
               <div class="col-12">
                   <hr>
               </div>
               <div class="col-3 pr-0">
                   <img src="https://via.placeholder.com/150" width="100%">
               </div>
               <div class="col-9">
                   <p class="m-0">Lorem ipsum dolor </p>
                   <p class="m-0 text-orange">2 days ago</p>
                 </div> -->
               </div>
             </div>

           </div>
           <div class="footer-bottom pt-4 pb-4 mt-3">
            <div class="row">
              <?php if (!$detect->isMobile()): ?>
                <div class="col-md-6 text-left">
                  <?php else: ?>
                    <div class="col-md-6 text-center">
                    <?php endif ?>
                    <!--  Foreign Embassies in Islamabad, Pakistan - Address & Contact Details.  -->Copyright © <?php echo date('Y') ?>. All Right Reserved - <a href="{{url('/')}}">Agents.com.pk</a>
                  </div>
                  <?php if (!$detect->isMobile()): ?>
                    <div class="col-md-6 text-right">
                      <?php else: ?>
                        <div class="col-md-6 text-center">
                        <?php endif ?>
                        <a href="{{ route('privacy') }}">Privacy Policy /Terms & conditions</a>

                      </div>
                    </div>
                  </div>
                </div>
              </footer>
