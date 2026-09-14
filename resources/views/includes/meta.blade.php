<?php

$siteAuthor = "Agents.com.pk";
$siteName   = "Agents.com.pk";
$defaultImage = asset('images/agents-logo.png');

$currentUrl = request()->url();
$country    = $country ?? null;
$meta_title = $meta_title ?? null;
$meta_description = $meta_description ?? null;
$urlslug    = $slug ?? null;
$cleanSlug  = $urlslug ? str_replace('-for-pakistani-nationals', '', $urlslug) : null;

// Determine title, description, keywords, image, and OG type
$title = "";
$metaDesc = "";
$metaKeywords = "";
$ogImage = $defaultImage;
$ogType = "website";

$blogObj = (isset($blog) && is_object($blog)) ? $blog : ((isset($detail) && is_object($detail) && (request()->is('blog/*') || request()->is('blog'))) ? $detail : null);

if ($blogObj) {
    $title = !empty($blogObj->meta_title) ? $blogObj->meta_title : ($blogObj->title . " | Agents.com.pk Blog");
    $metaDesc = !empty($blogObj->meta_desc) ? $blogObj->meta_desc : (!empty($blogObj->meta_description) ? $blogObj->meta_description : str_limit(strip_tags($blogObj->content ?? ''), 160));
    $metaKeywords = !empty($blogObj->keywords) ? $blogObj->keywords : $blogObj->title;
    $ogImage = isset($blogObj->image_url) ? $blogObj->image_url : (!empty($blogObj->image) ? asset('storage/uploads/blogs/' . $blogObj->image) : asset('images/blog-default.jpg'));
    $ogType = "article";
} elseif (!empty($meta_title)) {
    $title = $meta_title;
    $metaDesc = !empty($meta_description) ? $meta_description : $meta_title;
    $metaKeywords = $meta_title;
} elseif (isset($agent) && is_object($agent)) {
    $title = ($agent->business_name ?? 'Travel Agent') . " - Travel Agent in " . ($agent->city->name ?? 'Pakistan') . " | Agents.com.pk";
    $metaDesc = "Contact " . ($agent->business_name ?? 'Travel Agent') . " in " . ($agent->city->name ?? 'Pakistan') . ". Find phone number, address, Umrah packages, flight tickets, and visa services.";
    $metaKeywords = ($agent->business_name ?? '') . ", travel agent " . ($agent->city->name ?? '') . ", Umrah agent";
    $ogImage = !empty($agent->logo) ? asset('uploads/agents/' . $agent->logo) : $defaultImage;
} elseif (isset($content) && is_object($content) && !empty($country) && !empty($cleanSlug)) {
    $title = !empty($content->meta_title) ? $content->meta_title : ($content->title ?? ucwords(str_replace('-', ' ', $country)) . " Embassy & Visa Guide");
    $metaDesc = !empty($content->meta_desc) ? $content->meta_desc : str_limit(strip_tags($content->content ?? ''), 160);
    $metaKeywords = !empty($content->keywords) ? $content->keywords : $title;
} elseif (isset($agentDetail) && is_object($agentDetail) && request()->is('*/sasti-tickets*')) {
    $agentBiz = $agentDetail->business_name ?? 'Travel Agent';
    $title = str_limit($agentBiz . ' — Sasti Tickets & Cheap Flights | Agents.com.pk', 60);
    $metaDesc = str_limit('Browse cheap flight tickets and air deals by ' . $agentBiz . '. Compare fares and book directly with this verified travel agent.', 155);
    $metaKeywords = $agentBiz . ', Sasti Tickets, Cheap Flights, Air Tickets';
    $ogImage = !empty($agentDetail->logo) ? asset('uploads/agents/' . $agentDetail->logo) : $defaultImage;
} elseif (isset($agentDetail) && is_object($agentDetail) && request()->is('*/umrah-hotels*')) {
    $agentBiz = $agentDetail->business_name ?? 'Travel Agent';
    $title = str_limit($agentBiz . ' — Umrah Hotels in Makkah & Madinah | Agents.com.pk', 60);
    $metaDesc = str_limit('Browse Makkah and Madinah Umrah hotel deals by ' . $agentBiz . '. Best rates near Haram for groups and individuals.', 155);
    $metaKeywords = $agentBiz . ', Umrah Hotels, Makkah Hotels, Madinah Hotels';
    $ogImage = !empty($agentDetail->logo) ? asset('uploads/agents/' . $agentDetail->logo) : $defaultImage;
} elseif (isset($agentDetail) && is_object($agentDetail) && request()->is('*/umrah-tickets*')) {
    $agentBiz = $agentDetail->business_name ?? 'Travel Agent';
    $title = str_limit($agentBiz . ' — Umrah Flights & Group Seats | Agents.com.pk', 60);
    $metaDesc = str_limit('View Umrah flight fares and group seat availability from ' . $agentBiz . '. Cheap Umrah tickets to Jeddah & Madinah.', 155);
    $metaKeywords = $agentBiz . ', Umrah Tickets, Umrah Flights, Group Fares';
    $ogImage = !empty($agentDetail->logo) ? asset('uploads/agents/' . $agentDetail->logo) : $defaultImage;
} elseif (request()->is('/') || $currentUrl == url('/')) {
    $title = "Pakistan's Premier Travel Marketplace — Cheap Tickets, Tours & Verified Agents | Agents.com.pk";
    $metaDesc = "Compare wholesale flight fares, Umrah packages, and holiday deals uploaded directly by certified travel agents across Pakistan.";
    $metaKeywords = "Travel Agents Pakistan, Sasti Tickets, Cheap Flights, Umrah Packages, Tour Packages Pakistan, Travel Marketplace";
} elseif (request()->is('sasti-tickets*')) {
    $title = "Sasti Tickets — Cheap Flights from Verified Agents | Agents.com.pk";
    $metaDesc = "Compare live cheap domestic and international airfares uploaded directly by certified travel agents across Pakistan.";
    $metaKeywords = "Sasti Tickets, Cheap Flights Pakistan, Airline Tickets, Airfare Deals, Cheap Air Tickets, Umrah Flights";
} elseif (request()->is('tour-packages/*') && isset($detail) && is_object($detail)) {
    $pkgTitle = !empty($detail->title) ? $detail->title : 'Tour Package';
    $title = str_limit($pkgTitle, 42) . " | Agents.com.pk";
    $metaDesc = str_limit("Book " . $pkgTitle . " from certified Pakistani travel agents. Starting from Rs " . ($detail->price ?? '0') . " for " . ($detail->days ?? '1') . " days. View itinerary and inclusions.", 155);
    $metaKeywords = $pkgTitle . ", Tour Packages Pakistan, Holiday Deals";
    if (!empty($detail->image)) {
        $ogImage = asset('storage/uploads/packages/' . $detail->image);
    }
} elseif (request()->is('tour-packages*')) {
    $title = "Tour Packages — Holiday Deals from Verified Agents | Agents.com.pk";
    $metaDesc = "Compare domestic and international tour packages with hotels and transport listed directly by certified travel agents across Pakistan.";
    $metaKeywords = "Tour Packages Pakistan, Holiday Packages, Northern Areas Tour, International Tour Packages, Dubai Tours, Turkey Packages";
} elseif (request()->is('travel-agents-in-pakistan') || request()->is('travel-agents-in-*')) {
    $citySegment = request()->segment(1);
    $cityName = str_replace('travel-agents-in-', '', $citySegment);
    $cityName = ($cityName !== 'travel-agents-in-pakistan') ? ucwords(str_replace('-', ' ', $cityName)) : 'Pakistan';
    $title = "Verified Travel Agents in {$cityName} — Tickets & Tours | Agents.com.pk";
    $metaDesc = "Find and contact certified travel agents in {$cityName} for wholesale flight fares, Umrah packages, and holiday tour deals.";
    $metaKeywords = "Travel Agents {$cityName}, Umrah Packages {$cityName}, Tour Operators Pakistan";
} elseif (request()->is('cheap-umrah-packages*') || request()->is('umrah-packages*')) {
    $title = "Cheap Umrah Packages — Hotel & Visa by Verified Agents | Agents.com.pk";
    $metaDesc = "Compare all-inclusive Umrah packages with hotels, visas, and transfers listed directly by certified travel agents across Pakistan.";
    $metaKeywords = "Cheap Umrah Packages, Economy Umrah Deals, Umrah Packages Pakistan, Umrah Visa";
} elseif (request()->is('cheap-umrah-flights-from-pakistan*')) {
    $title = "Cheap Umrah Flights — Group Fares by Verified Agents | Agents.com.pk";
    $metaDesc = "Compare live seat allocations and cheap Umrah group flight fares to Saudi Arabia uploaded directly by verified travel agents across Pakistan.";
    $metaKeywords = "Cheap Umrah Flights, Jeddah Flights, Madinah Air Tickets, Umrah Airfare Pakistan";
} elseif (request()->is('umrah-hotels*') || request()->is('*/umrah-hotels*')) {
    $title = "Umrah Hotels Near Haram Makkah & Madinah — Rates & Deals | Agents.com.pk";
    $metaDesc = "Compare verified 3-star, 4-star, and 5-star Umrah hotels in Makkah and Madinah near Haram. Check real-time room rates (Double, Triple, Quad) from verified Pakistani travel agents.";
    $metaKeywords = "Umrah Hotels, Makkah Hotels Near Haram, Madinah Hotels Near Masjid Nabawi, 5 Star Umrah Hotels, Cheap Umrah Hotels, Clock Tower Hotels Makkah, Umrah Hotel Booking Pakistan";
} elseif (request()->is('about-us') || request()->is('about')) {
    $title = "About Us — Pakistan's Verified Travel Marketplace | Agents.com.pk";
    $metaDesc = "Learn how Agents.com.pk connects travelers directly with certified travel agents across Pakistan for cheap flights and Umrah packages.";
    $metaKeywords = "About Agents.com.pk, Travel Marketplace Pakistan, Travel Portal";
} elseif (request()->is('contact-us') || request()->is('contact')) {
    $title = "Contact Us — Support for Travelers & Travel Agents | Agents.com.pk";
    $metaDesc = "Contact the Agents.com.pk team for traveler assistance, agency verification, or listing ticket and tour package deals across Pakistan.";
    $metaKeywords = "Contact Agents.com.pk, Travel Agency Listing Support, Customer Care";
} elseif (request()->is('privacy-policy') || request()->is('terms-conditions')) {
    $title = "Privacy Policy & Terms of Service | Agents.com.pk";
    $metaDesc = "Review the Privacy Policy, data protection guidelines, and Terms of Use for Agents.com.pk.";
    $metaKeywords = "Privacy Policy, Terms of Service, Agents.com.pk Terms";
} elseif (request()->is('blogs') || request()->is('blog')) {
    $title = "Travel Blog — Guides, Umrah Advice & Visa Tips | Agents.com.pk";
    $metaDesc = "Read expert travel guides, Umrah tips, visa procedures, and flight advice curated by certified travel professionals across Pakistan.";
    $metaKeywords = "Travel Blog Pakistan, Visa Updates, Umrah Guide, Travel News";
} elseif (request()->is('airlines') || request()->is('airline/*')) {
    $title = "Airlines in Pakistan — Flight Routes & Deals | Agents.com.pk";
    $metaDesc = "Explore domestic and international airlines operating in Pakistan with flight schedules, baggage policies, and verified agent fares.";
    $metaKeywords = "Airlines in Pakistan, Flight Schedules, Air Tickets Pakistan";
} elseif (request()->is('airline-circulars*') || request()->is('airline-updates*') || request()->is('airline-special-offers*')) {
    $title = "Airline Circulars & Special Offers | Agents.com.pk";
    $metaDesc = "Stay updated with latest airline circulars, operational notices, and special flight discount offers in Pakistan.";
    $metaKeywords = "Airline Circulars, Flight Offers, Travel Advisories Pakistan";
} elseif (request()->is('travel-news*')) {
    $title = "Pakistan Travel News & Aviation Updates | Agents.com.pk";
    $metaDesc = "Get real-time news on Pakistan tourism, airline developments, international travel guidelines, and visa policies.";
    $metaKeywords = "Pakistan Travel News, Aviation News, Tourism Pakistan";
} elseif (request()->is('cities')) {
    $title = "Travel Agents by City in Pakistan — Directory | Agents.com.pk";
    $metaDesc = "Browse certified travel agents across Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Peshawar, and other cities in Pakistan.";
    $metaKeywords = "Travel Agents Directory, Agents by City Pakistan";
} else {
    $title = "Pakistan's Premier Travel Marketplace — Cheap Tickets & Tours | Agents.com.pk";
    $metaDesc = "Compare wholesale flight fares, Umrah packages, and holiday deals uploaded directly by certified travel agents across Pakistan.";
    $metaKeywords = "Travel Agents Pakistan, Cheap Flights, Umrah Packages, Tour Packages";
}

// Clean sanitized output strings
$cleanTitle = trim(preg_replace('/\s+/', ' ', strip_tags($title)));
$cleanDesc  = trim(preg_replace('/\s+/', ' ', strip_tags($metaDesc)));
$cleanKeywords = trim(preg_replace('/\s+/', ' ', strip_tags($metaKeywords)));
?>

<title>{{ $cleanTitle }}</title>

<meta name="description" content="{{ $cleanDesc }}" />
<meta name="keywords" content="{{ $cleanKeywords }}" />
<meta name="author" content="{{ $siteAuthor }}" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType }}" />
<meta property="og:site_name" content="{{ $siteName }}" />
<meta property="og:url" content="{{ $currentUrl }}" />
<meta property="og:title" content="{{ $cleanTitle }}" />
<meta property="og:description" content="{{ $cleanDesc }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:locale" content="en_PK" />

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ $currentUrl }}" />
<meta name="twitter:title" content="{{ $cleanTitle }}" />
<meta name="twitter:description" content="{{ $cleanDesc }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />
