<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Visa;
use App\QuickLink;
use App\Content;
use App\Page;
use App\Contact;
use App\VisasPolicy;
use App\Airlines;
use App\Packages;
use App\PackagePrice;
use App\Fares;
use App\Blogs;
use App\RelatedSites;
use App\Cities;
use App\AgentCity;
use App\Agents;
use App\Schengen;
use App\TourPackages;
use App\Embassy;
use App\UsefullLinks;
use App\NewsLetter;
use \Validator;
use Mail;
use Session;
use DB;
use Carbon\Carbon;
use Input;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        
        /*$data['countries'] = Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);*/
    $expiresAt = Carbon::now()->endOfDay();
        $data['visas']  = Cache::remember('home-visas', $expiresAt, function () {
                         return Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->where('countries.is_home','1')->get(['countries.country','visas.country_name', 'visas.slug']);
                         });

//         SELECT v.`slug`, c.`country`, s.`title`
// FROM quick_links AS ql 
// JOIN countries AS c ON ql.`countries_id` = c.`id` 
// JOIN sections AS s ON ql.`sections_id` = s.`id` 
// JOIN visas AS v ON (v.countries_id = ql.`countries_id` AND v.sections_id = ql.sections_id)

       /* $data["quick_links_req"] = QuickLink::select("visas.slug", "visas.country_name", "countries.country", "sections.title")
        ->join("countries", "countries.id", "=", "quick_links.countries_id")
        ->join("sections", "sections.id", "=", "quick_links.sections_id")
        ->join("visas", function($q){
            $q->on("visas.countries_id", "=", "quick_links.countries_id");
            $q->on("visas.sections_id", "=", "quick_links.sections_id");
        })->where("sections.title", "Visa Requirements")->get();

        $data["quick_links_fee"] = QuickLink::select("visas.slug", "visas.country_name", "countries.country", "sections.title")
        ->join("countries", "countries.id", "=", "quick_links.countries_id")
        ->join("sections", "sections.id", "=", "quick_links.sections_id")
        ->join("visas", function($q){
            $q->on("visas.countries_id", "=", "quick_links.countries_id");
            $q->on("visas.sections_id", "=", "quick_links.sections_id");
        })->where("sections.title", "Visa Fees")->get();

        $data["quick_links_pro"] = QuickLink::select("visas.slug", "visas.country_name", "countries.country", "sections.title")
        ->join("countries", "countries.id", "=", "quick_links.countries_id")
        ->join("sections", "sections.id", "=", "quick_links.sections_id")
        ->join("visas", function($q){
            $q->on("visas.countries_id", "=", "quick_links.countries_id");
            $q->on("visas.sections_id", "=", "quick_links.sections_id");
        })->where("sections.title", "Visa Processing Time")->get();*/
     
      $data['embassies'] = Cache::remember('home-embassies', $expiresAt, function () {
                              return  Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
                           });

        $data['airlines']    = Cache::remember('home-airlines', $expiresAt, function () {
                                  return  Airlines::all();
                              });

        $data['packages']    = Cache::remember('home-packages', $expiresAt, function () {
                                   return Packages::whereNull('agents_id')->orderBy('id','DESC')->take(5)->get();
                               });

        $data['big']    =   Cache::remember('home-big', $expiresAt, function () {
                               return Blogs::where('is_featured',1)->orderBy('id','DESC')->first();
                            });
        $data['midum']    = 
        Cache::remember('home-midum', $expiresAt, function () {
          return Blogs::where('is_featured',1)->orderBy('id','DESC')->skip(1)->first();
        });
        $data['small']    = Cache::remember('home-small', $expiresAt, function () {
          return Blogs::where('is_featured',1)->orderBy('id','DESC')->skip(2)->first();
            });
        $data['left']    = Cache::remember('home-left', $expiresAt, function () { 
                          return Blogs::where('is_featured',1)->orderBy('id','DESC')->skip(3)->first();
                           });
  
        return view("index", $data);
    }

    public function getViasa(Request $req, $country, $slug)
    {

        $fullPath =  $req->url();
        $url = basename($fullPath);
        // dd($fullPath);
        if(strpos($fullPath, "index.php")){
            return redirect()->to(str_replace("index.php/", "", $fullPath));
        }

        $slug = str_replace('-for-pakistani-nationals','', $slug);
        $data['visa']       = Visa::where('country_name', $country)->get();
        $data['content']    = Visa::where('slug', $slug)->where('country_name', $country)->first();
        if(is_null($data['content'])){
          return redirect()->to('/');   
      }

      $sectionArr = array(2,3,4,5,6,7,8,24,29);
      if(in_array($data['content']->sections_id, $sectionArr) && preg_match('/(-for-pakistani-nationals)/', $url) == 0){
        return redirect()->to($country."/".$url."-for-pakistani-nationals");
    }elseif (!in_array($data['content']->sections_id, $sectionArr) && preg_match('/(-for-pakistani-nationals)/', $url) == 1){
        $r_url = str_replace('-for-pakistani-nationals','', $url);
        return redirect()->to($country."/".$r_url);
    }


    $data['custom_content'] = '';
    if (!is_null($data['content'])) {
        $data['custom_content']    = Content::where('section_id',$data['content']->sections_id)->first();
    }

    if (!empty($data['custom_content'])) {
        $data['extra_content'] = str_replace('[country]', $country, $data['custom_content']->content);
    }
    $data['slug']       = $slug;
    $data['country']    = $country;
    $data['embassies'] = Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
    if (!empty($data['content'])) {
      $country_id = $data['content']->countries_id;
      $data['embassy_page'] = Embassy::where('countries_id',$country_id)->first();
  }
  return view('visas', $data);
}
public function getCountry(){
    $q = request()->input('query');
    $data = Country::join('visas','visas.countries_id', '=', 'countries.id')->where('countries.country','LIKE','%'.$q.'%')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
    $countryResult = array();
    if ($data->count() > 0) {
        foreach ($data as $value) {
            $name = $value->country;
            $slug = $value->country;
            if ($slug == 'UAE (Dubai)') {
                $slug = 'UAE';
            }
            $countryResult[] = array("name" => $value->country, "slug" => url(str_slug($slug)."/".$value->slug));
        }

    }
    return response()->json($countryResult);


}
public function runSitemap()
{
  $arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

   $url1 = file_get_contents(url('/').'/generate-agents-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-airline-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-blogs-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-cities-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-packages-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-sitemap-process.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-travel-news-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-job-sitemap.php', false, stream_context_create($arrContextOptions));
   $url1 = file_get_contents(url('/').'/generate-embassies-sitemap.php', false, stream_context_create($arrContextOptions));

   Session::flash("success-msg", "Site Maps Updated Successfully");
   return redirect()->to('/');
}
public function privacy(Request $request)
{
//         if (!empty($request->importAgents)) {

//     $agents = Agents::whereDate('created_at', '2025-11-24')->get();

//     foreach ($agents as $agent) {

//         // Assign cleaned values
//         $agent->mobile = str_replace('-','', $agent->mobile);
//         $agent->phone  = str_replace('-','', $agent->phone);
//         $agent->save();
//     }
// }
//     if (!empty($request->importAgents)) {

//     $agents = Agents::whereDate('created_at', '2025-11-24')->get();

//     foreach ($agents as $agent) {

//         $phones = explode(',', $agent->phone);

//         $newMobiles = [];
//         $newPhones = [];

//         foreach ($phones as $p) {
//             $p = trim($p);

//             if (substr($p, 0, 2) === '03') {
//                 // mobile number
//                 $newMobiles[] = $p;
//             } else {
//                 // landline or other
//                 $newPhones[] = $p;
//             }
//         }

//         // Assign cleaned values
//         $agent->mobile = implode(',', $newMobiles);
//         $agent->phone  = implode(',', $newPhones);
//         $agent->active = 1;
//         $agent->save();
//     }
// }
    //  if(!empty($request->importAgents)){
    //         $file = base_path('Bureau of emigration - Sheet1 (1).csv');

    // if (!file_exists($file)) {
    //     return "CSV file not found!";
    // }

    // $rows = array_map('str_getcsv', file($file));
    // $header = array_map('trim', array_shift($rows)); // first row as header

    // foreach ($rows as $row) {

    //     $data = array_combine($header, $row);

    //     if (!$data) continue;

    //     // --------------------------
    //     // 1) CLEAN BASIC FIELDS
    //     // --------------------------
    //     $licence = trim($data['Licence No.']);
    //     $agentName = trim($data['Proprietor Name']);
    //     $businessName = trim($data['Licence Title']);
    //     $expiry = trim($data['Expiry Date']);
    //     $headOffice = trim($data['OEP Head Office']);
    //     $branchOffice = trim($data['Branch Office(s)']);

    //     // Combine address
    //     $address = $headOffice;
    //     if (!empty($branchOffice)) {
    //         $address .= " | Branch: " . $branchOffice;
    //     }

    //     // --------------------------
    //     // 2) EXTRACT PHONE NUMBERS
    //     // --------------------------
    //     preg_match_all('/(\+?\d[\d\-\s]{7,})/', $address, $phonesMatches);
    //     $phones = implode(", ", $phonesMatches[0] ?? []);

    //     // Remove phones from address text
    //     $cleanAddress = trim(preg_replace('/\+?\d[\d\-\s]{7,}/', '', $address));

    //     // --------------------------
    //     // 3) AUTO-DETECT CITY USING agent_cities TABLE
    //     // --------------------------
    //     $city = \DB::table('agent_cities')->get();

    //     $detectedCityId = null;

    //     foreach ($city as $c) {
    //         if (
    //             str_contains(strtolower($cleanAddress), strtolower($c->name)) ||
    //             str_contains(strtolower($cleanAddress), strtolower($c->slug))
    //         ) {
    //             $detectedCityId = $c->id;
    //             break;
    //         }
    //     }

    //     // --------------------------
    //     // 4) SKIP DUPLICATES
    //     // --------------------------
    //     if (\App\Agents::where('dsl_license', $licence)->exists()) {
    //         continue;
    //     }

    //     // --------------------------
    //     // 5) CREATE SLUG
    //     // --------------------------
    //     $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $businessName));

    //     // --------------------------
    //     // 6) SAVE VIA ELOQUENT
    //     // --------------------------
    //     // dd($detectedCityId);
    //     \App\Agents::create([
    //         'slug'           => $slug,
    //         'business_name'  => $businessName,
    //         'agent_name'     => $agentName,
    //         'address'        => $cleanAddress,
    //         'phone'          => $phones,
    //         'dsl_license'    => $licence,
    //         'dsl_expairy'    => $expiry,
    //         'agent_type_id'  => 3,
    //         'cities_id'      => $detectedCityId,
    //         'active'         => 1,
    //     ]);
    // }
    // dd('hogya');
    //     }
    $data['content'] = Page::where('page','privacy')->first();
    return view('privacy',$data);
}
public function about()
{
    $data['content'] = Page::where('page','about')->first();
    return view('about',$data);
}
public function terms(Request $request)
{
   
    $data['content'] = Page::where('page','terms')->first();
    return view('terms',$data);
}
public function anti()
{
    $data['content'] = Page::where('page','spam')->first();
    return view('anti-spam',$data);
}
public function dmca()
{
    $data['content'] = Page::where('page','dmca')->first();
    return view('dmca',$data);
}
public function usefulLinks()
{
    $data['links'] = UsefullLinks::where('active',1)->get();
    return view('links',$data);
}
public function converter()
{
    $data['content'] = Page::where('page','converter')->first();
    return view('converter',$data);
}

public function contact()
{
    $data['content'] = Page::where('page','contact')->first();
    return view('contact',$data);
}
public function visaPolicy()
{
    $data['content'] = VisasPolicy::where('id','1')->first();
    return view('visa-policy',$data);

}
public function umrahPolicy()
{
    $data['content'] = VisasPolicy::where('id','2')->first();
    if (is_null( $data['content'])) {
       return redirect()->to('/');
    }
    $data['meta_title'] = $data['content']->meta_title;
    $data['meta_description'] = $data['content']->meta_description;
    return view('umrah-policy-2019',$data);

}
public function advirtise()
{
    return view('advertise');

}

public function airlines()
{
    $data['airlines'] = Airlines::all();

    return view("airlines", $data);
    } //
    public function schengen()
    {
        $data['content'] = Schengen::where('id','1')->first();
        return view('schengen',$data);

    }
    public function saveContact()
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'phone' => 'required',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", "Missing required field");
            return redirect()->back();
        }
        $name    = Input::has("name")?Input::get("name"):"";
        $email   = Input::has("email")?Input::get("email"):"";
        $phone   = Input::has("phone")?Input::get("phone"):"";
        $subject   = Input::has("subject")?Input::get("subject"):"";
        $message1 = Input::has("message")?Input::get("message"):"";

        // $contact = new Contact;
        // $contact->name = $name;
        // $contact->email = $email;
        // $contact->phone = $phone;
        // $contact->subject = $subject;
        // $contact->message = $message1;

        // $saved = $contact->save();



            $data = [
                "email"=>$email,
                "name"=>$name,
                "subject"=>$subject,
                "msg"=>$message1,
                "phone"=>$phone,
            ];

            $myemail = "info@agents.com.pk";

            // Mail::send('emails.contact-us', $data , function ($message) use ($myemail) {
            //     $message->subject('You have a new inquiry');
            //     $message->from('noreply@agents.com.pk', 'Agents PK');
            //     $message->to($myemail, 'New inquirey');
            // });

            // Mail::send('emails.thankyou', $data , function ($message) use ($email, $name) {
            //     $message->subject('Thanks you for contacting us');
            //     $message->from('noreply@agents.com.pk', 'Agents PK');
            //     $message->to($email, $name);

            // });


            Session::flash("success-msg", "Thanks For Feedback.");
            return redirect()->back();
       
    }
    public function airlineDetail($slug)
    {
        $data['detail'] = Airlines::where('slug',$slug)->first();
        if (is_null($data['detail'])) {
         return redirect()->to('/');
     }
     $id = $data['detail']->id;
     $data['meta_title'] = $data['detail']->meta_title;
     $data['meta_description'] = $data['detail']->meta_description;
     $data['fares'] = Fares::where('airlines_id',$id)->get();
     $data['relatedArlines'] = Airlines::where('slug','!=',$slug)->take(10)->get();
     return view('airline-detail',$data);

 }
 public function umrahDetail($slug,Request $r)
 {
    $data['detail'] = Packages::where('slug',$slug)->where('active',1)->first();
    $data['packages_related'] = Packages::where('slug','!=',$slug)->get();
    $data['saudi_links']       = Visa::where('countries_id','190')->take('12')->get();

    if (!empty( $data['detail'])) {
       $id = $data['detail']->id;
       $data['meta_title'] = $data['detail']->meta_title;
       $data['meta_description'] = $data['detail']->meta_description;
       $data['prices'] = PackagePrice::where('umrah_packages_id',$id)->get();
       if (is_null($data['detail']->agents_id)) {
        $name = str_replace('Umrah Packages From ','',$data['detail']->name);
         $today =  date("d-M-Y", strtotime("today"));
            $data['from']       =  Cities::join('countries','cities.countries_id','countries.id')->where('countries.country','Pakistan')->where('cities.airport',1)->orderBy('cities.name','ASC')->get();
         $city = Cities::where('name','LIKE','%'.$name.'%')->first();
         if (!empty($city)) {
         
        $name = $city->name;
         }else{
           $name = null;
         }
  
        $package = Packages::leftjoin('packages_price','packages_price.umrah_packages_id','umrah_packages.id')
           ->join('show_package','show_package.agents_id','umrah_packages.agents_id')
           ->join('agents','agents.id','umrah_packages.agents_id')
           ->join('agent_cities','agent_cities.id','agents.cities_id')
           ->where('show_package.expire','>=',$today)
           ->where('agent_cities.name',$name)
           ->whereNotNull('umrah_packages.agents_id')
           ->where('umrah_packages.active',1);
        if (!empty($r->airline)) {
            $package = $package->where('packages_price.airlines_id',$r->airline);
        }
        if (!empty($r->day)) {
          $package = $package->where('packages_price.nights',$r->day);
        }
        if (!empty($r->stars)) {
          $package = $package->where('packages_price.stars',$r->stars);
        }
         if (!empty($r->from)) {
          $package = $package->where('packages_price.from',$r->from);
        }
        if (!empty($r->only)) {
          if ($r->only == 1) {
           $package = $package->whereNull('packages_price.from');
           $package = $package->whereNotNull('packages_price.nights');
         }elseif($r->only == 2){

           $package = $package->whereNull('packages_price.nights');
           $package = $package->whereNull('packages_price.stars');
         }

       }elseif(!is_null($r->only) && $r->only == 0){
      
        $package = $package->whereNotNull('packages_price.from');
        $package = $package->whereNotNull('packages_price.nights');
      }
        $data['agentsPackages'] = $package->groupBy('umrah_packages.name')->select('umrah_packages.*','agents.business_name as business_name','packages_price.price as price')->get();
        $data['packages'] = Packages::orderBy('id','DESC')->whereNull('agents_id')->get();
          $data['airlines'] = Airlines::orderBy('name','ASC')->get();
       
       }
       if($r->ajax()){
        $agentsPackages = $data['agentsPackages'];
          $view = view('partials.agent-packages',compact('agentsPackages'))->render();
        return response()->json(['html'=>$view]);
       }else{

       return view('package-detail',$data);
       }

   }else{
      $data['detail'] = Embassy::where('slug',$slug)->first();
      if(!empty($data['detail'])){
          $country = $data['detail']->countries_id;
          $data['visa']       = Visa::where('countries_id', $country)->where('sections_id','1')->first();
          $data['meta_title'] = $data['detail']->meta_title;
          $data['meta_description'] = $data['detail']->meta_description;
          $data['leftotherembassies'] = Embassy::take(35)->get();
          $data['otherembassies'] = Embassy::skip(35)->take(35)->get();
          $data['fiftyotherembassies'] = Embassy::skip(70)->take(100)->get();

          $data['embassies'] = Embassy::join('countries','countries.id','embassy_pages.countries_id')->orderBy('countries.country')->get();
          return view('embassy-detail',$data);
      }
  }

  return redirect()->to('/');


}
public function umrahList()
{
 
    $data['slug'] = null;
    $data['packages'] = Packages::select('umrah_packages.*','umrah_packages.id  as umrahId','airlines.name as airline')->leftjoin('airlines','airlines.id','airlines_id')->whereRaw(
    "STR_TO_DATE(departure_date, '%d-%m-%Y') >= CURDATE()"
)->where('umrah_packages.active','1')->groupBy('umrah_packages.id')->orderBy('umrah_packages.id','DESC')->get();

    //  $data['packages'] = Packages::orderBy('id','DESC')->whereNull('agents_id')->get();
    return view('umrah-packages',$data);

}
public function tourPackages(Request $r)
{
    $packages = TourPackages::leftjoin('tour_packages_prices','tour_packages_prices.tour_packages_id','tour_packages.id')->where('active','1');
    if(!empty($r->country)){
        $packages = $packages->where('country',$r->country);
    }
    if(!empty($r->city)){
        $packages = $packages->where('tour_packages_prices.city',$r->city);
    }
    $data['packages'] = $packages->groupBy('tour_packages.id')->select('tour_packages.*')->get();

    $data['countries'] = Country::orderBy('country', 'ASC')->get();
    $data['from'] = Cities::join('countries', 'cities.countries_id', 'countries.id')->where('countries.country', 'Pakistan')->where('cities.airport', 1)->select('cities.*')->orderBy('cities.name', 'ASC')->get();
    //  $data['packages'] = Packages::orderBy('id','DESC')->whereNull('agents_id')->get();
    return view('tour-packages',$data);

}
public function tourPackageDetail($slug)
{
    $data['detail'] = TourPackages::where('slug',$slug)->first();
    //  $data['packages'] = Packages::orderBy('id','DESC')->whereNull('agents_id')->get();
    return view('tour-packages-detail',$data);

}

public function packagesByCities($slug)
{
    $city = AgentCity::where('slug',$slug)->first();
    $data['packages'] = Packages::select('umrah_packages.*','airlines.name as airline_name')->leftjoin('airlines','airlines.id','airlines_id')->leftjoin('agents','agents.id','umrah_packages.agents_id')->where('umrah_packages.active','1')->where('from','LIKE','%'.$slug.'%')->orderBy('umrah_packages.id','DESC')->get();
    //  $data['packages'] = Packages::orderBy('id','DESC')->whereNull('agents_id')->get();
     $data['slug'] = $slug;
    return view('umrah-packages',$data);

}

public function hajjPolicy()
{
    return view('hajj-policy');

}
public function pakistanVisa()
{
   $data['embassies'] = Embassy::join('countries','countries.id','embassy_pages.countries_id')->orderBy('countries.country')->get();
   return view('pakistan-visa',$data);
}
public function saveNewsletter(Request $req)
{
    $validator = Validator::make(Input::all(), [
        'email' => 'required',
    ]);

    if ($validator->fails()) {
        Session::flash("error-msg", "Missing required field");
        return redirect()->back();
    }

    $email = $req->email;
    $already = NewsLetter::where('email',$req->email)->first();
    if (!empty($already)) {
        Session::flash("error-msg", "Already Subscribed.");
        return redirect()->back();
    }

    $contact = new NewsLetter;
    $contact->email = $req->email;
    $saved = $contact->save();
    if ($saved){
        $data = array();
        // Mail::send('emails.newsletter', $data ,  function ($message) use ($email) {
        //     $message->subject('Thank for subscribe to our news letter');
        //     $message->from('noreply@visas.com.pk', 'Visas PK');
        //     $message->to($email);

        // });
        Session::flash("success-msg", "Thanks For Subscribe.");
        return redirect()->back();
    }else{

        Session::flash("error-msg", "Something went wrong. Try again.");
        return redirect()->back();

    }
}
public function homeSlider(){
    return view('homeSlider');
}
public function middleHome(){
    return view('middleHome');
}
public function bottomHome(){
    return view('bottomHome');
}
public function searchEmbassy(){
    return view('searchEmbassy');
}
public function umrahPackages(){
    return view('umrahPackages');
}
public function righSideEmbassy(){
    return view('righSideEmbassy');
}
public function leftSideCommon(){
    return view('leftSideCommon');
}
public function popularEmbassies(){
    return view('popularEmbassies');
}
public function sideBarEmbassy(){
    return view('sideBarEmbassy');
}
public function sponsored(){
    return view('sponsored');
}
public function menu()
{
    $data = array(
        [
            "name" => 'New Visa Policy',
            "link" => 'highlights-of-pakistans-new-visa-policy'
        ],
        [
            "name" => 'Visa Info',
            "link" => 'pakistan-visa-info'
        ],
        [
            "name" => 'Hajj Policy',
            "link" => 'government-lists-salient-features-of-2019-hajj-policy'
        ],
        [
            "name" => 'Umrah Packages',
            "link" => 'cheap-umrah-packages'
        ],
        [
            "name" => 'Airlines',
            "link" => 'airlines'
        ],
        [
            "name" => 'Latest News',
            "link" => 'blogs'
        ],
        [
            "name" => 'Advertise with us',
            "link" => 'advertise-with-us'
        ]
    );  
    return response()->json($data);
}
public function search(Request $r)
{
    if (!$r->has("q")) {
        return redirect()->to("/");
    }
    $data['embassies'] = Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
    $data['visas'] = Visa::where('title','LIKE','%'.$r->q.'%')->orWhere('keywords','LIKE','%'.$r->q.'%')->get();
    return view('search',$data);

}
public function searchByAlpha($q)
{
    // $data['embassies'] = Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
    $data['embassies'] = Country::join('visas','visas.countries_id', '=', 'countries.id')->groupBy('visas.countries_id')->orderBy('visas.country_name','ASC')->get(['countries.country','visas.country_name', 'visas.slug']);
    $data['visas'] = Visa::where('sections_id',1)->where('title','LIKE',$q.'%')->get();
    $data['meta_title'] = 'Embassies & Consulates in Islamabad, Pakistan | '.ucfirst($q);
    return view('search',$data);

}
public function blogs(Request $r)
{
    $blog = Blogs::whereNotNull('id');
    if (!empty($r->q)) {
        $blog = $blog->where('title','LIKE','%'.$r->q.'%');
    }
    $data['blogs'] = $blog->paginate(10);
    return view('blogs',$data);

}
public function blogDetail($slug)
{
     $data['detail'] = Blogs::where('slug',$slug)->first();
     $data['meta_title'] = $data['detail']->meta_title;
       $data['meta_description'] = $data['detail']->meta_desc;
    return view('blog-detail',$data);

}
public function RelatedSites()
{
    $data['relatedSites'] = RelatedSites::all();
   return view('related-sites',$data);
}
public function success(){
    return view("register-success");
}
public function importCustomFile(Request $request)
{
    set_time_limit(0);
ini_set('memory_limit', '-1');
    $request->validate([
        'file' => 'required|mimes:csv,txt,json'
    ]);

    $extension = $request->file('file')->getClientOriginalExtension();

    $rows = [];

    /*
    |------------------------------------------------------------------
    | HANDLE CSV FILE
    |------------------------------------------------------------------
    */
    if ($extension == 'csv' || $extension == 'txt') {

        $file = fopen($request->file('file'), 'r');

        // Skip header
        fgetcsv($file);

        while (($row = fgetcsv($file, 10000, ",")) !== false) {

            $rows[] = [
                'title'             => trim($row[0] ?? ''),
                'salary'            => trim($row[2] ?? ''),
                'place_of_duty'     => trim($row[3] ?? ''),
                'grant_date'        => trim($row[4] ?? ''),
                'permission'        => trim($row[5] ?? ''),
                'foreign_employer'  => trim(explode(',', trim($row[6] ?? ''))[1] ?? ''),
                'city_name'         => trim(explode('/', trim(explode(',', trim($row[6] ?? ''))[0] ?? ''))[1] ?? ''),
                'country_name'      => trim(explode(',', trim($row[3] ?? ''))[1] ?? ''),
                'oep'               => trim(explode('/', trim(explode(',', trim($row[6] ?? ''))[0] ?? ''))[0] ?? ''),
                'agent_name'        => trim(explode(',', trim($row[6] ?? ''))[1] ?? ''),
            ];
        }

        fclose($file);
    }

    /*
    |------------------------------------------------------------------
    | HANDLE JSON FILE
    |------------------------------------------------------------------
    */
    elseif ($extension == 'json') {

        $jsonData = file_get_contents($request->file('file')->getRealPath());

        $jsonRows = json_decode($jsonData, true);

        foreach ($jsonRows as $item) {

            $oepDetails = $item['oep_details'] ?? '';

            $oepParts = explode(',', $oepDetails);

            $firstPart = trim($oepParts[0] ?? '');
            $agentName = trim($oepParts[1] ?? '');

            $oepCity = explode('/', $firstPart);

            $oep = trim($oepCity[0] ?? '');
            $cityName = trim($oepCity[1] ?? '');

            $countryName = trim(explode(',', $item['place_of_duty'] ?? '')[1] ?? '');

            $rows[] = [
                'title'             => trim($item['job_title'] ?? ''),
                'salary'            => trim($item['salary'] ?? ''),
                'place_of_duty'     => trim($item['place_of_duty'] ?? ''),
                'grant_date'        => trim($item['grant_date'] ?? ''),
                'permission'        => trim($item['permission_no'] ?? ''),
                'foreign_employer'  => $agentName,
                'city_name'         => $cityName,
                'country_name'      => $countryName,
                'oep'               => $oep,
                'agent_name'        => $agentName,
            ];
        }
    }

    /*
    |------------------------------------------------------------------
    | PROCESS IMPORT
    |------------------------------------------------------------------
    */
    foreach ($rows as $raw) {

        $formattedDate = date(
            'Y-m-d',
            strtotime(str_replace('/', '-', $raw['grant_date']))
        );

        // ===========================
        // DUPLICATE CHECK
        // ===========================
        $isDuplicate = DB::table('foreign_jobs')
            ->whereRaw("title = CONVERT(? USING latin1)", [$raw['title']])
            ->whereRaw("salary = CONVERT(? USING latin1)", [$raw['salary']])
            ->whereRaw("place_of_duty = CONVERT(? USING latin1)", [$raw['place_of_duty']])
            ->where('grant_date', $formattedDate)
            ->whereRaw("permission = CONVERT(? USING latin1)", [$raw['permission']])
            ->whereRaw("foreign_employer = CONVERT(? USING latin1)", [$raw['foreign_employer']])
            ->whereRaw("oep = CONVERT(? USING latin1)", [$raw['oep']])
            ->exists();

        if ($isDuplicate) {
            continue;
        }

        // ===========================
        // FIND MATCHING AGENT
        // ===========================
        $agent = DB::table('agents')
            ->where('business_name', 'LIKE', "%{$raw['agent_name']}%")
            ->first();

        $agent_id = $agent->id ?? null;

        // ===========================
        // FIND MATCHING COUNTRY
        // ===========================
        $country = DB::table('countries')
            ->where('country', 'LIKE', "%{$raw['country_name']}%")
            ->first();

        $country_id = $country->id ?? null;

        // ===========================
        // FIND MATCHING CITY
        // ===========================
        $city = DB::table('agent_cities')
            ->where('name', 'LIKE', "%{$raw['city_name']}%")
            ->first();

        $city_id = $city->id ?? null;

        // ===========================
        // INSERT
        // ===========================
        $submitData = [
            'title'             => $raw['title'],
            'salary'            => $raw['salary'],
            'place_of_duty'     => $raw['place_of_duty'],
            'oep'               => $raw['oep'],
            'foreign_employer'  => $raw['foreign_employer'],
            'grant_date'        => $formattedDate,
            'permission'        => $raw['permission'],

            'city'              => $raw['city_name'],
            'country'           => $raw['country_name'],

            'agents_id'         => $agent_id,
            'agent_cities_id'   => $city_id,
            'countries_id'      => $country_id,

            'created_at'        => now(),
            'updated_at'        => now(),
        ];
        DB::table('foreign_jobs')->insert($submitData);
    }

    return back()->with(
        'success',
        'Import completed successfully.'
    );
}
}
