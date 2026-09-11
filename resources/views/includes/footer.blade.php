<section id="subscribe">
  <div class="container pt-4 pb-4">
    <form method="post" action="{{ url('save-newsletter') }}">
      {{ csrf_field() }}
      <div class="row text-center align-items-center">
        <div class="col-md-5 col-12 pt-2">
          <h3 class="text-white text-center font-weight-bold">Subscribe to get latest updates</h3>
        </div>
        <div class="col-md-4 pt-2">
          <input type="email" name="email" data-validation="email" data-message="Please provide a valid email address" class="form-control p-2" placeholder="Enter your Email" required>
        </div>
        <div class="col-md-2 text-center pt-2">
          <button type="submit" class="btn btn-block p-2 text-uppercase font-weight-bold">Subscribe <?php if (!$detect->isMobile()): ?>Now<?php endif ?></button>
        </div>
      </div> 
    </form> 
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 about">
        <img src="{{ asset('images/agents-logo.png') }}" width="260" height="65" alt="Agents.com.pk - Travel Portal" class="mb-2" loading="lazy">
        <p class="mt-2">{{ !empty($setting->website_desc) ? $setting->website_desc : 'Agents.com.pk is Pakistan\'s dedicated platform for embassy contacts, visa guidelines, Umrah packages, flight tickets, and certified travel agents across Pakistan.' }}</p>
      </div>

      <div class="col-md-4 im-links">
        <h4 class="text-uppercase font-weight-bold">Important Links</h4>
        <div class="mt-3">
          <p><a href="{{ url('cheap-umrah-packages') }}">Umrah Packages</a></p>
          <p><a href="{{ route('flight') }}">Umrah Tickets</a></p>
          <p><a href="{{ route('umrah-hotels') }}">Umrah Hotels</a></p>
          <p><a href="{{ route('sasti-tickets') }}">Sasti Tickets</a></p>
          <p><a href="{{ url('new-umrah-policy') }}">Umrah Policy</a></p>
          <p><a href="{{ url('pakistan-visa-info') }}">Embassies in Pakistan</a></p>
          <hr style="border-color: rgba(255,255,255,0.1);">
          <p><a href="{{ route('about') }}">About Us</a></p>
          <p><a href="{{ url('blogs') }}">Blog</a></p>
          <p><a href="{{ route('converter') }}">Currency Converter</a></p> 
          <p><a href="{{ route('useful-links') }}">Useful Links</a></p> 
          <p><a href="{{ route('contact') }}">Contact Us</a></p>
        </div>
      </div>

      <div class="col-md-4">
        <h4 class="text-uppercase font-weight-bold">Follow Us</h4>
        <div class="mt-3">
          <p style="font-size: 14px; opacity: 0.85; line-height: 1.6;">Stay connected with us for real-time flight deals, verified Umrah packages, and embassy visa updates.</p>
          <div class="mt-3">
            <a href="https://www.facebook.com/profile.php?id=61575379107956" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn text-white font-weight-bold shadow-sm d-inline-flex align-items-center" 
               style="background-color: #1877F2; border: 1px solid #1877F2; border-radius: 6px; padding: 10px 20px; font-size: 14px;">
              <i class="fab fa-facebook-f mr-2" style="font-size: 16px;"></i> Follow us on Facebook
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom pt-4 pb-4 mt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
      <div class="row align-items-center">
        <?php if (!$detect->isMobile()): ?>
          <div class="col-md-6 text-left">
        <?php else: ?>
          <div class="col-md-6 text-center">
        <?php endif ?>
            Copyright &copy; <?php echo date('Y'); ?>. All Rights Reserved - <a href="{{ url('/') }}">Agents.com.pk</a>
          </div>
        <?php if (!$detect->isMobile()): ?>
          <div class="col-md-6 text-right">
        <?php else: ?>
          <div class="col-md-6 text-center mt-2">
        <?php endif ?>
            <a href="{{ route('privacy') }}">Privacy Policy</a> &nbsp;|&nbsp; <a href="{{ route('terms') }}">Terms &amp; Conditions</a>
          </div>
      </div>
    </div>
  </div>
</footer>
