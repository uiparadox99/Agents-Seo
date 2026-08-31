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

if (!empty($meta_title)) {
    $title = $meta_title;
    $metaDesc = !empty($meta_description) ? $meta_description : $meta_title;
    $metaKeywords = $meta_title;
} elseif (isset($blog) && is_object($blog)) {
    $title = !empty($blog->meta_title) ? $blog->meta_title : $blog->title . " | Agents.com.pk Blog";
    $metaDesc = !empty($blog->meta_description) ? $blog->meta_description : str_limit(strip_tags($blog->content ?? ''), 160);
    $metaKeywords = !empty($blog->keywords) ? $blog->keywords : $blog->title;
    $ogImage = !empty($blog->image) ? asset('uploads/blogs/' . $blog->image) : $defaultImage;
    $ogType = "article";
} elseif (isset($agent) && is_object($agent)) {
    $title = ($agent->business_name ?? 'Travel Agent') . " - Travel Agent in " . ($agent->city->name ?? 'Pakistan') . " | Agents.com.pk";
    $metaDesc = "Contact " . ($agent->business_name ?? 'Travel Agent') . " in " . ($agent->city->name ?? 'Pakistan') . ". Find phone number, address, Umrah packages, flight tickets, and visa services.";
    $metaKeywords = ($agent->business_name ?? '') . ", travel agent " . ($agent->city->name ?? '') . ", Umrah agent";
    $ogImage = !empty($agent->logo) ? asset('uploads/agents/' . $agent->logo) : $defaultImage;
} elseif (isset($content) && is_object($content) && !empty($country) && !empty($cleanSlug)) {
    $title = !empty($content->meta_title) ? $content->meta_title : ($content->title ?? ucwords(str_replace('-', ' ', $country)) . " Embassy & Visa Guide");
    $metaDesc = !empty($content->meta_desc) ? $content->meta_desc : str_limit(strip_tags($content->content ?? ''), 160);
    $metaKeywords = !empty($content->keywords) ? $content->keywords : $title;
} elseif (request()->is('/') || $currentUrl == url('/')) {
    $title = "Embassies and Consulates in Pakistan - Travel & Visa Guide | Agents.com.pk";
    $metaDesc = "Find verified foreign embassies in Pakistan with addresses, phone numbers, visa requirements, Umrah packages, cheap air tickets, and trusted travel agents.";
    $metaKeywords = "Embassies in Pakistan, Visa Requirements, Travel Agents Pakistan, Umrah Packages, Flight Tickets";
} elseif (request()->is('travel-agents-in-pakistan') || request()->is('travel-agents-in-*')) {
    $citySegment = request()->segment(1);
    $cityName = str_replace('travel-agents-in-', '', $citySegment);
    $cityName = ($cityName !== 'travel-agents-in-pakistan') ? ucwords(str_replace('-', ' ', $cityName)) : 'Pakistan';
    $title = "Top Verified Travel Agents in {$cityName} - Umrah & Tour Packages | Agents.com.pk";
    $metaDesc = "Find verified travel agents and tour operators in {$cityName}. Compare Umrah packages, flight ticket deals, visa assistance, and customer reviews.";
    $metaKeywords = "Travel Agents {$cityName}, Umrah Packages {$cityName}, Tour Operators Pakistan";
} elseif (request()->is('cheap-umrah-packages*') || request()->is('umrah-packages*')) {
    $title = "Cheap Umrah Packages from Pakistan - Economy & 5-Star Deals | Agents.com.pk";
    $metaDesc = "Compare latest budget and luxury Umrah packages from certified travel agents across Pakistan. Complete packages with visa, flights, and hotels in Makkah and Madinah.";
    $metaKeywords = "Cheap Umrah Packages, Economy Umrah Deals, Umrah Packages Pakistan, Umrah Visa";
} elseif (request()->is('sasti-tickets*')) {
    $title = "Sasti Tickets - Cheap Flights & Airfare Deals in Pakistan | Agents.com.pk";
    $metaDesc = "Book cheap flights and domestic/international airline tickets from Pakistan. Compare low-cost airfares and special airline offers.";
    $metaKeywords = "Sasti Tickets, Cheap Flights Pakistan, Airline Tickets, Airfare Deals";
} elseif (request()->is('umrah-hotels*')) {
    $title = "Umrah Hotels in Makkah & Madinah - Best Rates | Agents.com.pk";
    $metaDesc = "Find top-rated Umrah hotels in Makkah and Madinah close to Haram. Compare hotel prices, distances, and amenities.";
    $metaKeywords = "Umrah Hotels, Makkah Hotels, Madinah Hotels, Haram Distance Hotels";
} elseif (request()->is('about-us') || request()->is('about')) {
    $title = "About Us - Pakistan's Leading Travel & Embassy Portal | Agents.com.pk";
    $metaDesc = "Learn about Agents.com.pk, Pakistan's trusted platform for foreign embassy information, visa requirements, certified travel agents, and Umrah packages.";
    $metaKeywords = "About Agents.com.pk, Embassy Information Pakistan, Travel Portal";
} elseif (request()->is('contact-us') || request()->is('contact')) {
    $title = "Contact Us - Agents.com.pk Support & Inquiries";
    $metaDesc = "Get in touch with Agents.com.pk team for business inquiries, listing your travel agency, advertisement, or support.";
    $metaKeywords = "Contact Agents.com.pk, Travel Agency Listing Support, Customer Care";
} elseif (request()->is('privacy-policy') || request()->is('terms-conditions')) {
    $title = "Privacy Policy & Terms of Service | Agents.com.pk";
    $metaDesc = "Review the Privacy Policy, data protection guidelines, and Terms of Use for Agents.com.pk.";
    $metaKeywords = "Privacy Policy, Terms of Service, Agents.com.pk Terms";
} elseif (request()->is('blogs') || request()->is('blog')) {
    $title = "Travel & Visa Blog - Latest Updates, Guides & News | Agents.com.pk";
    $metaDesc = "Read expert travel guides, latest visa updates, airline circulars, and Umrah guidelines on the Agents.com.pk blog.";
    $metaKeywords = "Travel Blog Pakistan, Visa Updates, Umrah Guide, Travel News";
} else {
    $title = "Foreign Embassies in Islamabad, Pakistan - Address & Contact Details | Agents.com.pk";
    $metaDesc = "Comprehensive directory of foreign embassies and consulates in Islamabad, Pakistan including contact numbers, official addresses, and visa guides.";
    $metaKeywords = "Foreign Embassies Islamabad, Consulates in Pakistan, Visa Guidance";
}

// Clean sanitized output strings
$cleanTitle = e(strip_tags($title));
$cleanDesc  = e(strip_tags($metaDesc));
$cleanKeywords = e(strip_tags($metaKeywords));
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
