<?php


$siteAuthor 	= "Agents.com.pk" ;
$siteAbstract 	= "";

$country 	= isset($country)?$country:null;
$meta_title 	= isset($meta_title)?$meta_title:null;
$meta_description 	= isset($meta_description)?$meta_description:null;
$urlslug	= isset($slug)?$slug:null;
$slug 		= str_replace('-for-pakistani-nationals','', $urlslug);
$airline    = str_replace('-', ' ', Request::segment(count(Request::segments())));
$airlinef   = ucfirst($airline); 
$airline    = str_replace('fares','', $airlinef); 

$pageTitle 	= str_replace('-for-pakistani-nationals','', app("request")->url());
switch ($pageTitle)
{

	case (!empty($meta_title)):

	$title              = $meta_title;
	$Meta_Title = $meta_title;
	$MetaKeywords = $meta_title;
	$Meta_Description = $meta_description;
	$MetaContent = $meta_description;
	break;
	case url('/'):

	$title              = "Embassies and Consulates In Pakistan - Travel & Visa Guide";
	$Meta_Title = "Embassies and Consulates In Pakistan - Travel & Visa Guide";
	$MetaKeywords = "Embassies and Consulates In Pakistan - Travel & Visa Guide" ;
	$Meta_Description = "Get info about foreign embassies in Pakistan, along with their address and phone numbers as well as umrah packages, travel agents, air tickets & visa guide.";
	$MetaContent = "Get info about foreign embassies in Pakistan, along with their address and phone numbers as well as umrah packages, travel agents, air tickets & visa guide.";
	break;
	case url($country.'/'.$slug):
	if(!empty($slug)){
		$titles = getTitles($country);

		$title              = !is_null($content->meta_title) && !empty($content->meta_title)?$content->meta_title:$content->title;
		$MetaContent        = $content->content;
		$MetaKeywords       = $content->keywords;
		$Meta_Title         = $content->meta_title;
		$Meta_Description   = $content->meta_desc;

	}
	break;
	case (request()->is("highlights-of-pakistans-new-visa-policy")):
	$title            = "Pakistans New Visa Policy - Highlights of New Visa Regime";
	$Meta_Title       = "Pakistans New Visa Policy - Highlights of New Visa Regime";
	$MetaKeywords     = "Pakistans New Visa Policy - Highlights of New Visa Regime" ;
	$Meta_Description = "Here is a comprehensive list of foreign embassies in, Islamabad, Pakistan along with their physical addresses, contact numbers and websites. Get your required details today...";
	$MetaContent      = "Here is a comprehensive list of foreign embassies in, Islamabad, Pakistan along with their physical addresses, contact numbers and websites. Get your required details today...";
	break;
	case (request()->is("cheap-umrah-packages-2019")):
	$title            = "Cheap Umrah Packages 2019 - Economy Umrah Packages";
	$Meta_Title       = "Cheap Umrah Packages 2019 - Economy Umrah Packages";
	$MetaKeywords     = "Cheap Umrah Packages 2019 - Economy Umrah Packages" ;
	$Meta_Description = "Economy Umrah Packages Pakistan, Cheap Umrah packages 2019, Budgeted Umrah packages with accommodation and with low price.";
	$MetaContent      = "Economy Umrah Packages Pakistan, Cheap Umrah packages 2019, Budgeted Umrah packages with accommodation and with low price.";
	break;
	case (!empty($airlinef)):
	$title            =  $airlinef ;
	$Meta_Title       =  $airlinef ;
	$MetaKeywords     =  $airlinef ;
	$Meta_Description = "Here is a comprehensive list of foreign embassies in, Islamabad, Pakistan along with their physical addresses, contact numbers and websites. Get your required details today...";
	$MetaContent      = "Here is a comprehensive list of foreign embassies in, Islamabad, Pakistan along with their physical addresses, contact numbers and websites. Get your required details today...";
	break;
	default:
	$title              = "Foreign Embassies in Islamabad, Pakistan - Address & Contact Details";
	$Meta_Title = "Foreign Embassies in Islamabad, Pakistan - Address & Contact Details";
	$MetaKeywords = "Foreign Embassies in Islamabad, Pakistan - Address & Contact Details" ;
	$Meta_Description = "Here is a comprehensive list of foreign embassies in, Islamabad, Pakistan along with their physical addresses, contact numbers and websites. Get your required details today...";
	$MetaContent = "Here is a comprehensive list of foreign embassies in, Islamabad, Pakistan along with their physical addresses, contact numbers and websites. Get your required details today...";
	break;
}


function getTitles($country){
	$title = array(
		"1" =>  ucwords(str_replace('-', ' ', $country))." Embassy in Islamabad, Pakistan - Address & Phone Number",
		"2" => ucwords(str_replace('-', ' ', $country))." Visa Requirements - Documents Required for ".ucwords(str_replace('-', ' ', $country))." Visa",
		"3" => ucwords(str_replace('-', ' ', $country))." Visa Types - Visit, Work, Student, Business, Transit Visa",
		"4" => ucwords(str_replace('-', ' ', $country))." Visa Validity For Pakistani citizens - Tourist Vs Work Visa Duration",
		"5" => ucwords(str_replace('-', ' ', $country))." Visa Fees For Pakistani Citizens - Visit, Work, Student, Business Visa Fees",
		"6" => ucwords(str_replace('-', ' ', $country))." Visa Duration - Visit, Work, Student, Transit Visa Duration",
		"7" => ucwords(str_replace('-', ' ', $country))." Visa Processing Time - Visit, Work, Student, Transit Visa Processing",
		"8" => ucwords(str_replace('-', ' ', $country))." Visa Application Form - Visit, Work, Student, Transit Visa Form",
		"9" => "How to Apply ".ucwords(str_replace('-', ' ', $country))." Visa - Apply For Visit, Work, Student, Transit Visa",
		"10" => "After Issuance of ".ucwords(str_replace('-', ' ', $country))." Visa - Things to Do After Getting ".ucwords(str_replace('-', ' ', $country))." Visa",
		"11" => "Before you Fly to ".ucwords(str_replace('-', ' ', $country))." - Things To Remember About ".ucwords(str_replace('-', ' ', $country)),
		"12" => ucwords(str_replace('-', ' ', $country))." International Airports - List Of All Major Airports In ".ucwords(str_replace('-', ' ', $country)),
		"13" => ucwords(str_replace('-', ' ', $country))." Travel Guide & Information - ".ucwords(str_replace('-', ' ', $country))." Tourism Official Website",
		"14" => ucwords(str_replace('-', ' ', $country))." Custom Rules - ".ucwords(str_replace('-', ' ', $country))." Customs & Revenue Department",
		"15" => "Things To Do In ".ucwords(str_replace('-', ' ', $country))." - Interesting Facts About ".ucwords(str_replace('-', ' ', $country)),
		"16" => "National Language in ".ucwords(str_replace('-', ' ', $country))." - Common Languages in ".ucwords(str_replace('-', ' ', $country)),
		"17" => ucwords(str_replace('-', ' ', $country))." Public Holidays - Public Holidays & Celebrations in 2018 & 2019",
		"18" => ucwords(str_replace('-', ' ', $country))." currency - ".ucwords(str_replace('-', ' ', $country))." Currency Rate To Pakistani Rupee",
		"19" => ucwords(str_replace('-', ' ', $country))." Nightlife - Bars & Night Clubs In ".ucwords(str_replace('-', ' ', $country))." - Fun Activities",
		"20" => ucwords(str_replace('-', ' ', $country))." Weather - Weather Forecast In ".ucwords(str_replace('-', ' ', $country))." - Current Weather in ".ucwords(str_replace('-', ' ', $country)),
		"21" => "Popular Foods in ".ucwords(str_replace('-', ' ', $country))." - Top Drinks, Foods, Desserts & Dishes in ".ucwords(str_replace('-', ' ', $country)),
		"22" => "Government of ".ucwords(str_replace('-', ' ', $country))." - ".ucwords(str_replace('-', ' ', $country))." Government History & Facts",
		"23" => "General Information about ".ucwords(str_replace('-', ' ', $country))." - History & Facts About ".ucwords(str_replace('-', ' ', $country)),
		"24" => "Travel Insurance for ".ucwords(str_replace('-', ' ', $country))." - Facts about ".ucwords(str_replace('-', ' ', $country))." Travel Insurance",
		"25" => "Hotel Booking For ".ucwords(str_replace('-', ' ', $country))." - Best & Cheap ".ucwords(str_replace('-', ' ', $country))." Hotels In 2018/2019",
		"26" => "Ticket Price For ".ucwords(str_replace('-', ' ', $country))." - Cheap Flights To ".ucwords(str_replace('-', ' ', $country))." From Pakistan",
		"27" => "Car Hire In ".ucwords(str_replace('-', ' ', $country))." - Best Car Rentals with Cheap Prices in ".ucwords(str_replace('-', ' ', $country)),
		"28" => "Tour Packages For ".ucwords(str_replace('-', ' ', $country))." - Cheap Holiday Packages ".ucwords(str_replace('-', ' ', $country)),
		"29" => "Help To Get ".ucwords(str_replace('-', ' ', $country))." Visa - ".ucwords(str_replace('-', ' ', $country))." Visa Fees, Application For Pakistanis"
	);
return $title;
}

?>

<title>{!! $title !!}</title>

<meta name="Keywords" content="{!! $MetaKeywords !!}"/>
<meta name="description" content="{!! $Meta_Description !!}"/>
<meta property="og:title" content="{!! renderHTML($Meta_Title) !!}" />
