@extends('layouts.master')
@section('content')
    @include('includes.slider')
    <section id="content" class="container pt-3">
        <section id="packages">
            <div class="title text-center p-3">
                <h1 style="font-size: 26px; font-weight: 700; color: #070c39; margin-bottom: 8px;">
                    Tour Packages from Pakistan — Domestic & International Holiday Deals
                </h1>
                <p class="text-muted" style="font-size: 15px; max-width: 900px; margin: 0 auto;">
                    Explore curated holiday trips, honeymoon tours, and group travel packages uploaded directly by certified travel agents across Pakistan. Compare real-time prices, hotel categories, and complete travel itineraries.
                </p>
            </div>

            <div class="box" style="height: auto;background: #f0f0f0;padding:24px;border-radius:15px">
                <form method="get" action="">
                    <h4 style="font-size: 18px; font-weight: 600; color: #070c39; margin-bottom: 15px;">Search for Tour Packages</h4>
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label for="country_filter"><b>Destination Country</b></label>
                            <select class="form-control" name="country" id="country_filter">
                                <option value="">All Countries</option>
                                @foreach ($countries as $a)
                                    <option value="{{ $a->country }}"
                                        {{ request()->has('country') && request()->get('country') == $a->country ? 'selected' : '' }}>
                                        {{ $a->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="city_filter"><b>Departure City</b></label>
                            <select class="form-control" name="city" id="city_filter">
                                <option value="">All Departure Cities</option>
                                @foreach ($from as $a)
                                    <option value="{{ $a->name }}"
                                        {{ request()->has('city') && request()->get('city') == $a->name ? 'selected' : '' }}>
                                        {{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="btn-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block" style="background-color: #f58220; border-color: #f58220;">Search Packages</button>
                        </div>
                    </div>
                </form>
            </div>

            @if ($packages->count() > 0)
                <div class="packages pt-4">
                    <div class="row">
                        @foreach ($packages as $key => $p)
                            <div class="col-md-4 mb-4">
                                <a href="{{ url('tour-packages/' . $p->slug) }}" style="color: unset;text-decoration:none">
                                    <div class="box p-2 detail h-100" style="background:#f9f9f9; border: 1px solid #e5e5e5; border-radius:12px; transition: transform 0.2s, box-shadow 0.2s;">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-4">
                                                <img src="{{ url('storage/uploads/packages/mobile/' . $p->image) }}"
                                                    alt="{{ !empty($p->image_alt) ? $p->image_alt : $p->title . ' Tour Package' }}"
                                                    class="box-img w-100"
                                                    style="height: 100px; object-fit: cover; border-radius: 8px;">
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <h5 class="mt-1" style="font-size: 15px; font-weight: 600; line-height: 1.3;">
                                                    <span style="text-transform: capitalize;">{{ substr($p->title, 0, 32) }}{{ strlen($p->title) > 32 ? '...' : '' }}</span>
                                                </h5>
                                                <h6 style="font-size: 13px; color: #555;"><i class="fas fa-map-marker-alt" style="color:#f58220"></i>
                                                    {{ $p->country }} </h6>
                                                <h6 style="color:#f58220; font-weight: 700; margin-bottom: 4px;">Rs {{ number_format((float) str_replace(',', '', $p->price)) }} <small style="color: #666; font-weight: 400;">(Starting price)</small></h6>

                                                <p class="mb-0" style="font-size: 12px; color: #666;">
                                                    <b>Nights:</b> {{ $p->nights }} | <b>Days:</b> {{ $p->days }} | <b>Seats:</b> {{ $p->seats }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center mt-4 p-4" style="border-radius: 10px;">
                    <h5>No Tour Packages Found Matching Your Criteria</h5>
                    <p class="mb-2 text-muted">Try choosing a different destination country or departure city, or clear your filters to view all available deals.</p>
                    <a href="{{ url('tour-packages') }}" class="btn btn-sm btn-outline-primary mt-2">View All Tour Packages</a>
                </div>
            @endif

            <div class="my-3">
                <ins class="adsbygoogle" style="display:inline-block;width:100%;height:82px"
                    data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

            <!-- Rich Informational Content Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="content-guide p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                        <h2 style="font-size: 22px; font-weight: 700; color: #070c39; margin-bottom: 15px;">
                            Discover Pakistan's Premier Holiday & Tour Package Marketplace
                        </h2>
                        <p style="font-size: 14px; line-height: 1.8; color: #444;">
                            Planning a family vacation, a romantic honeymoon, or a corporate getaway from Pakistan? On <strong>Agents.com.pk</strong>, certified travel agents and licensed tour operators list comprehensive domestic and international tour packages with upfront pricing, verified itineraries, and complete inclusion breakdowns. Instead of contacting dozens of agents individually, you can compare packages side-by-side and connect directly with the provider offering the best value.
                        </p>

                        <div class="row mt-4">
                            <div class="col-md-4 mb-3">
                                <div class="p-3 h-100" style="background: #f8f9fa; border-top: 4px solid #f58220; border-radius: 6px;">
                                    <h3 style="font-size: 16px; font-weight: 600; color: #070c39; margin-bottom: 8px;">
                                        <i class="fas fa-mountain text-warning mr-1"></i> Northern Pakistan Tours
                                    </h3>
                                    <p style="font-size: 13px; line-height: 1.7; color: #555; margin-bottom: 0;">
                                        Explore the breathtaking natural wonders of Gilgit-Baltistan and Khyber Pakhtunkhwa. Discover curated itineraries for Hunza Valley, Skardu, Deosai Plains, Swat Valley, Naran Kaghan, Fairy Meadows, and Neelum Valley Azad Kashmir with private 4x4 transport and premium valley-view hotels.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 h-100" style="background: #f8f9fa; border-top: 4px solid #070c39; border-radius: 6px;">
                                    <h3 style="font-size: 16px; font-weight: 600; color: #070c39; margin-bottom: 8px;">
                                        <i class="fas fa-globe-asia text-primary mr-1"></i> International Holiday Trips
                                    </h3>
                                    <p style="font-size: 13px; line-height: 1.7; color: #555; margin-bottom: 0;">
                                        Browse all-inclusive international holidays to Dubai, Azerbaijan (Baku), Turkey (Istanbul & Cappadocia), Malaysia, Thailand, Egypt, and Europe. Packages typically feature return airline tickets, luxury hotel accommodations, daily breakfast, and city sightseeing excursions.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 h-100" style="background: #f8f9fa; border-top: 4px solid #28a745; border-radius: 6px;">
                                    <h3 style="font-size: 16px; font-weight: 600; color: #070c39; margin-bottom: 8px;">
                                        <i class="fas fa-kaaba text-success mr-1"></i> Umrah & Ziyarat Packages
                                    </h3>
                                    <p style="font-size: 13px; line-height: 1.7; color: #555; margin-bottom: 0;">
                                        In addition to leisure travel, find economy and 5-star Umrah packages with hotels close to Haram in Makkah and Madinah, as well as spiritual Ziyarat packages to Iraq and Iran with expert religious guidance.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <h3 class="mt-4" style="font-size: 18px; font-weight: 700; color: #070c39;">
                            What Is Typically Included in a Tour Package?
                        </h3>
                        <p style="font-size: 14px; line-height: 1.8; color: #444;">
                            Each tour package page provides a comprehensive breakdown of inclusions and exclusions. Standard packages generally cover:
                        </p>
                        <ul style="font-size: 14px; line-height: 1.8; color: #444; padding-left: 20px;">
                            <li><strong>Air Transportation:</strong> Return international or domestic flights with confirmed baggage allowance (optional for land-only packages).</li>
                            <li><strong>Hotel Accommodations:</strong> Verified 3-star, 4-star, or 5-star hotel stays with flexible occupancy (single, double, triple, and quad sharing options).</li>
                            <li><strong>Transfers & Sightseeing:</strong> Airport pickup and drop-off, intercity travel, and guided sightseeing in air-conditioned vehicles.</li>
                            <li><strong>Meal Plans:</strong> Daily buffet breakfast, with half-board or full-board options available on select excursions.</li>
                            <li><strong>Visa Assistance:</strong> Professional tourist visa submission guidance, document verification, and voucher issuance for international trips.</li>
                        </ul>

                        <h3 class="mt-4" style="font-size: 18px; font-weight: 700; color: #070c39;">
                            How to Inquire and Book with Listed Agents
                        </h3>
                        <ol style="font-size: 14px; line-height: 1.8; color: #444; padding-left: 20px;">
                            <li><strong>Browse and Compare:</strong> Filter packages by destination country, departure city, and duration. Click on any package to view day-by-day itineraries and room pricing.</li>
                            <li><strong>Connect Directly:</strong> Call or WhatsApp the listing travel agency using the direct contact information displayed on the package page.</li>
                            <li><strong>Customize Your Itinerary:</strong> Discuss custom adjustments with the agent, such as adding flight connections, hotel upgrades, or private vehicles.</li>
                            <li><strong>Confirm & Travel:</strong> Finalize booking directly with the agent's verified business account, receive your official confirmation vouchers, and enjoy a hassle-free vacation.</li>
                        </ol>

                        <p style="font-size: 13.5px; color: #666; margin-top: 15px;">
                            Also looking for standalone flights? Check our <a href="{{ route('sasti-tickets') }}">Sasti Tickets</a> page or find certified <a href="{{ route('agents-in-pakistan') }}">Travel Agents in Pakistan</a>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <div class="faq-section p-4" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                        <div class="text-center mb-4">
                            <span class="badge badge-warning px-3 py-2 text-white" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; background: #f58220;">Frequently Asked Questions</span>
                            <h2 class="mt-2" style="color: #070c39; font-weight: 700; font-size: 24px;">Tour Packages FAQ</h2>
                            <p class="text-muted" style="font-size: 14px;">Answers to frequent inquiries regarding tour itineraries, inclusions, customizations, and booking policies.</p>
                        </div>

                        <div class="accordion" id="tourPackagesFaqAccordion">
                            <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <div class="card-header bg-white py-3" id="tpHeadingOne" style="cursor: pointer;" data-toggle="collapse" data-target="#tpCollapseOne" aria-expanded="true" aria-controls="tpCollapseOne">
                                    <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                        <i class="fas fa-question-circle text-warning mr-2"></i> What is typically included in a tour package?
                                    </h3>
                                </div>
                                <div id="tpCollapseOne" class="collapse show" aria-labelledby="tpHeadingOne" data-parent="#tourPackagesFaqAccordion">
                                    <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                        Tour packages listed on Agents.com.pk generally include hotel accommodation, daily breakfast, airport transfers, and guided sightseeing. Many international packages also include return flight tickets and tourist visa processing support. You can check the exact inclusion table on each package's detail page.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <div class="card-header bg-white py-3" id="tpHeadingTwo" style="cursor: pointer;" data-toggle="collapse" data-target="#tpCollapseTwo" aria-expanded="false" aria-controls="tpCollapseTwo">
                                    <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                        <i class="fas fa-question-circle text-warning mr-2"></i> How do I compare tour packages from different travel agents?
                                    </h3>
                                </div>
                                <div id="tpCollapseTwo" class="collapse" aria-labelledby="tpHeadingTwo" data-parent="#tourPackagesFaqAccordion">
                                    <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                        You can filter by destination country and departure city to view all packages serving that route. Compare the number of days, hotel star ratings, room pricing, and included excursions. You can also view agent reviews and verification badges to choose the most reliable operator.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <div class="card-header bg-white py-3" id="tpHeadingThree" style="cursor: pointer;" data-toggle="collapse" data-target="#tpCollapseThree" aria-expanded="false" aria-controls="tpCollapseThree">
                                    <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                        <i class="fas fa-question-circle text-warning mr-2"></i> Can tour packages be customized for families or corporate groups?
                                    </h3>
                                </div>
                                <div id="tpCollapseThree" class="collapse" aria-labelledby="tpHeadingThree" data-parent="#tourPackagesFaqAccordion">
                                    <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                        Yes! Most listed travel agencies specialize in custom travel design. When you contact the agent, you can request extra nights, customized hotel selections, private vehicles instead of shared group coaches, or special corporate conference arrangements.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <div class="card-header bg-white py-3" id="tpHeadingFour" style="cursor: pointer;" data-toggle="collapse" data-target="#tpCollapseFour" aria-expanded="false" aria-controls="tpCollapseFour">
                                    <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                        <i class="fas fa-question-circle text-warning mr-2"></i> Is visa processing assistance included in international packages?
                                    </h3>
                                </div>
                                <div id="tpCollapseFour" class="collapse" aria-labelledby="tpHeadingFour" data-parent="#tourPackagesFaqAccordion">
                                    <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                        Many international packages (such as Dubai, Azerbaijan, Malaysia, and Thailand) include tourist visa application fees and file preparation. For destinations with strict visa requirements (e.g., Schengen or UK), agents provide file documentation and appointment booking guidance.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <div class="card-header bg-white py-3" id="tpHeadingFive" style="cursor: pointer;" data-toggle="collapse" data-target="#tpCollapseFive" aria-expanded="false" aria-controls="tpCollapseFive">
                                    <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                        <i class="fas fa-question-circle text-warning mr-2"></i> What are the payment terms and booking deposit requirements?
                                    </h3>
                                </div>
                                <div id="tpCollapseFive" class="collapse" aria-labelledby="tpHeadingFive" data-parent="#tourPackagesFaqAccordion">
                                    <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                        Typically, agents require an advance deposit (ranging between 25% and 50%) at the time of booking to secure flight tickets and hotel reservations. The remaining balance is payable before ticket issuance or departure. Confirm payment milestones directly with your selected agent.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2" style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <div class="card-header bg-white py-3" id="tpHeadingSix" style="cursor: pointer;" data-toggle="collapse" data-target="#tpCollapseSix" aria-expanded="false" aria-controls="tpCollapseSix">
                                    <h3 class="mb-0" style="font-size: 16px; font-weight: 600; color: #070c39;">
                                        <i class="fas fa-question-circle text-warning mr-2"></i> What is the cancellation and refund policy for tour packages?
                                    </h3>
                                </div>
                                <div id="tpCollapseSix" class="collapse" aria-labelledby="tpHeadingSix" data-parent="#tourPackagesFaqAccordion">
                                    <div class="card-body text-secondary" style="font-size: 14px; line-height: 1.7;">
                                        Cancellation policies vary depending on the airline ticket conditions and hotel cancellation deadlines. Non-refundable promotional flights or peak-season hotel blocks may have strict cancellation penalties. Be sure to request the agent's written cancellation policy prior to booking.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ request()->url() }}#webpage",
            "url": "{{ request()->url() }}",
            "name": "Tour Packages from Pakistan - Holiday Deals | Agents.com.pk",
            "isPartOf": {
                "@id": "https://agents.com.pk/#website"
            },
            "description": "Explore curated domestic and international tour packages from certified Pakistani travel agents. Compare prices, itineraries, and inclusions."
        },
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://agents.com.pk/"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Tour Packages",
                    "item": "https://agents.com.pk/tour-packages"
                }
            ]
        },
        {
            "@type": "FAQPage",
            "@id": "{{ request()->url() }}#faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "What is typically included in a tour package?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Tour packages listed on Agents.com.pk generally include hotel accommodation, daily breakfast, airport transfers, and guided sightseeing. Many international packages also include return flight tickets and tourist visa processing support. You can check the exact inclusion table on each package's detail page."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How do I compare tour packages from different travel agents?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You can filter by destination country and departure city to view all packages serving that route. Compare the number of days, hotel star ratings, room pricing, and included excursions. You can also view agent reviews and verification badges to choose the most reliable operator."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can tour packages be customized for families or corporate groups?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes! Most listed travel agencies specialize in custom travel design. When you contact the agent, you can request extra nights, customized hotel selections, private vehicles instead of shared group coaches, or special corporate conference arrangements."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is visa processing assistance included in international packages?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Many international packages (such as Dubai, Azerbaijan, Malaysia, and Thailand) include tourist visa application fees and file preparation. For destinations with strict visa requirements (e.g., Schengen or UK), agents provide file documentation and appointment booking guidance."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What are the payment terms and booking deposit requirements?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Typically, agents require an advance deposit (ranging between 25% and 50%) at the time of booking to secure flight tickets and hotel reservations. The remaining balance is payable before ticket issuance or departure. Confirm payment milestones directly with your selected agent."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What is the cancellation and refund policy for tour packages?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Cancellation policies vary depending on the airline ticket conditions and hotel cancellation deadlines. Non-refundable promotional flights or peak-season hotel blocks may have strict cancellation penalties. Be sure to request the agent's written cancellation policy prior to booking."
                    }
                }
            ]
        }
    ]
}
</script>
@endpush

