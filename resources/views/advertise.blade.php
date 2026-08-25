@extends('layouts.master')
@section('content')

<section class="advertise-header">
    <h1 class="heading">Advertise with us</h1>
</section>
<section id="advertise-body " class="mt-3 mb-3" s="">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- <div class="advertise-maps">
					<div class="heading">
						Leading Visas Site in Pakistan
					</div>
					
					<p>
						Agents.com.pk is the largest Visas website of the world, and the number 1 web site of Pakistan. (source Alexa)
						Advertise your brand at the premium spots on Agents.com.pk and drive additional traffic to your website. It also helps you widen your brand image to potential customer base.
					</p>
					<ul>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
					</ul>
					<img src="{{url('images/placeholder.png')}}" width="100%" style="float:right; width: 300px;margin-top:-150px">
				
					
				</div> -->
                <div class="advertise-maps mt-3">
                    <div class="heading" style="color: #f58220;">
                        Advertise with Agents.com.pk
                    </div>
                    <div class="adv-glance">
                        <p>If you are looking to promote your Travel Agency business or want to get more clients, then
                            Agents.com.pk is the best platform to advertise. Thousands of Pakistani travelers daily visit
                            our website to get updated visa requirements and Embassy information. </p>
                        <h4 style="color: #f58220;">
                            Its very Simple:
                        </h4>
                        <p>Select any Embassy page for your Travel Agency advertisment and advertise your services like
                            Air Tickets, Visa Processing, Tour Packages, Travel Insurance, Hotel Booking for that
                            country. When any visitor will come to that Embassy page he will get your Travel Agency
                            contact information so he will contact you for your services.</p>
                        <h4 style="color: #f58220;">
                            Why advertise on Agents.com.pk?
                        </h4>
                        <p>Every visitor to our website is a Future traveler & your future client so reserve your
                            advertisement place now. All Advertisement places on Embassy pages are on first come first
                            serve bases. Contact us for more information.</p>
                        <!-- <h5>Advertising options</h5>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li><a href="#displaybanner">Display Banners</a></li>
								<li><a href="#HomePagePopularSquare">Home page popular section</a></li>
								<li>Sitewide 125 x 125 pixels Square Banner (Home page popular section)</li>
								<li>Display banner 680 x 80 pixels Square Banner in middle</li>
								<li>Sitewide 125 x 125 pixels Square Banner (Home page ummrah packages section)</li>
								<li>Display banner 680 x 80 pixels at bottom of page</li>
								<li>......</li>
								<li>......</li>
								<li>......</li>
							</ul>
							
							<h4 id="displaybanner">Display Banners (desktop and mobile)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<h5>Benefits</h5>
							<ul>
								<li>Visually appealing</li>
								<li>Create brand awareness</li>
								<li>Higher reach</li>
								<li>Look more professional</li>
								<li>Specific targeting</li>
								<li>Traceable</li>
							</ul> -->
                        <div style="" class="screen-box">
                            <h4 style="    color: #f58220;text-align: center;margin: 20px 0">Banner Advertisement</h4>
                            <img src="{{url('images/search.PNG')}}" width="100%">
                        </div>
                        <div class="text-center">
                            @if(!$detect->isMobile())
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                style="width: 50%;background-color: #070c39;  margin: 0px auto 50px auto;">Contact For
                                Details</button>
                            @endif
                        </div>
                        <!-- <hr width="50%" style="border-width: 7px;    margin: 52px auto 20px auto;border-color:#070c39"> -->

                        <!-- <ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on popular section home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul> -->
                        <div style="" class="screen-box">
                            <h4 style="color: #f58220;text-align: center;margin: 20px 0 0 0 ">Samll Box Advertisement
                            </h4>
                            <img src="{{url('images/china-center.PNG')}}" width="100%" style="
								border: 30px solid #f8f8f8;
								">
                        </div>
                        <div class="text-center">
                            @if(!$detect->isMobile())
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                style="width: 50%;background-color: #070c39;  margin: 0px auto 50px auto;">Contact For
                                Details</button>
                            @endif
                        </div>
                        <!-- <hr width="50%" style="border-width: 7px;    margin: 52px auto 20px auto;border-color:#070c39"> -->
                        <!-- <ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on popular section home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul> -->
                        <div style="" class="screen-box">
                            <h4 style="    color: #f58220;text-align: center;margin: 20px 0"">Large Box Advertisement</h4>
								<img src=" {{url('images/bottom-embassy.PNG')}}" width="100%">
                        </div>
                        @if($detect->isMobile())
                        <div class="text-center">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                style="width: 50%;background-color: #070c39;  margin: 0px auto 0px auto;">Contact For
                                Details</button>
                        </div>
                        @endif
                        <!-- <hr width="50%" style="border-width: 7px;    margin: 52px auto 20px auto;border-color:#070c39">
							<h4 style="    color: #f58220;">Display banner 680 x 80 pixels Square Banner (desktop and mobile)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p> -->
                        <!-- <ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on popular section home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul> -->
                        <!-- 	<div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;text-align: center;">
							<img src="{{url('images/mobile.PNG')}}" width="30%">
						</div> -->
                        <!-- <div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/home-slider.jpg')}}" width="100%" >
							</div>
							
							
							<h4>Sitewide 125 x 125 pixels Square Banner on home page popular section (desktop and mobile)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on popular section home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul>
							<div style="padding: 30px: background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/popular.jpg')}}" width="100%" style="
								border: 30px solid #f8f8f8;
								">
							</div>
							
							<h4>Display banner 680 x 80 pixels Square Banner (desktop and mobile)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on popular section home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul>
							<div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/middle.jpg')}}" width="100%">
							</div>
							
							
							<h4>Sitewide 125 x 125 pixels Square Banner on home page ummrah packages section (desktop and mobile)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on ummrah packages section home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul>
							
							<div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/packages.jpg')}}" width="100%">
							</div>
							
							
							<h4>Display banner 680 x 80 pixels at bottom of page</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on bottom of home page</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul>
							<div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/bottom.jpg')}}" width="100%">
							</div>
							
							<h4>Side Sitewide 280 x 600 Vertical Banner (desktop only)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on all  embassy page or pakistan embassy page etc</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul>
							<div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/verticle.jpg')}}" width="100%">
							</div>
							
							
							<h4>Side Sitewide 125 x 125 Square Banner (desktop and mobile)</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas.</p>
							<ul>
								<li>$150/month USD (Or Equivalent in PKR)</li>
								<li>Displayed on all embassy page or pakistan embassy page etc</li>
								<li>Non-rotating for maximum exposure.</li>
								<li>Flash banners are not allowed. Please use animated GIF banners.</li>
								<li>No nudity; visas is a family-friendly web site.</li>
								<li>New advertisers appear below already existing ads. This system is in place to reward advertisers that maintain regular advertising.</li>
							</ul>
							<div style="padding: 30px; background-color: #f8f8f8; margin-bottom:30px;">
								<img src="{{url('images/promotions/rightsidebar.jpg')}}" width="100%">
							</div> -->

                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <!-- 	<div class="col-md-3 pl-0">
			<div class="aside-links">
	<div class="heading">
		<i class="fa fa-bullhorn"></i> Advertise
	</div>
	<div class="category" data-toggle="collapse" data-target="#demo" >Banner Advertising <i class="fa fa-angle-down" style="float: right;"></i></div>
	<div id="demo" class="collapse">
		<ul class="banner-advertising expand" data-nt="banner-advertising" style="display: block;list-style: none;">
			<li><a href="https://www.Agents.com.pk/home-page-slider">Home Page Slider</a></li>
			<li><a href="https://www.Agents.com.pk/middle-of-home-page">Middle of Home Page</a></li>
			<li><a href="https://www.Agents.com.pk/bottom-of-home-page">Bottom of Home Page</a></li>
			<li><a href="https://www.Agents.com.pk/search-of-every-embassy-page">Search of every Embassy Page</a></li>
		</ul>
	</div>
	<div class="category" data-toggle="collapse" data-target="#demo2" >Box Advertising <i class="fa fa-angle-down" style="float: right;"></i></div>
	<div id="demo2" class="collapse">
		<ul class="banner-advertising expand" data-nt="banner-advertising" style="display: block;list-style: none;">
			<li><a href="https://www.Agents.com.pk/popular-embassies">In Popular Embassies</a></li>
			<li><a href="https://www.Agents.com.pk/umrah-packages">In Umrah Packages</a></li>
			<li><a href="https://www.Agents.com.pk/right-side-bar-of-every-embassy-page">Right Side bar of Every Embassy Page</a></li>
			<li><a href="https://www.Agents.com.pk/left-side-bar-of-common-pages">Left Side bar of Common Pages</a></li>
		</ul>
	</div>
	<div class="category" data-toggle="collapse" data-target="#demo3" >Vertical Banner Advertising <i class="fa fa-angle-down" style="float: right;"></i></div>
	<div id="demo3" class="collapse">
		<ul class="banner-advertising expand" data-nt="banner-advertising" style="display: block;list-style: none;">
			<li><a href="https://www.Agents.com.pk/side-bar-of-every-embassy-page">Side bar of Every Embassy Page</a></li>
		</ul>
	</div>
	<div class="category" onclick="window.location='https://www.Agents.com.pk/sponsored'" >Sponsored Content</div>
</div>		</div> -->
        </div>
    </div>
</section>
</section>
@endsection