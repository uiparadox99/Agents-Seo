<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/studio', function () {
    return view('vue-pages');
  });
  Route::get('/studio/tools', function () {
    return view('vue-pages');
  });
  Route::get('/studio/design', function () {
    return view('vue-pages');
  });
  Route::get('/studio/design/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('/studio/meme-generator', function () {
    return view('vue-pages');
  });
  Route::get('/studio/meme-templates', function () {
    return view('vue-pages');
  });
  Route::get('/studio/poster-maker', function () {
    return view('vue-pages');
  });
  Route::get('/studio/poster-templates', function () {
    return view('vue-pages');
  });
  Route::get('/studio/poster-templates/{type}/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('/studio/business-cards-generator/{slug}', function () {
    return view('vue-pages');
  });
  
  Route::get('/studio/meme-templates/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('/studio/logo-maker', function () {
    return view('vue-pages');
  });
  Route::get('/studio/logo-templates', function () {
    return view('vue-pages');
  });
  Route::get('/studio/resume-builder', function () {
    return view('vue-pages');
  });
  Route::get('/studio/resume-templates', function () {
    return view('vue-pages');
  });
  Route::get('studio/playground/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('studio/playground/{slug}/{id}', function () {
    return view('vue-pages');
  });
  Route::get('studio/final-service-book', function () {
    return view('vue-pages');
  });
  Route::get('studio/template/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('studio/service-order-detail/{id}', function () {
    return view('vue-pages');
  });
  Route::get('studio/user-creation-detail/{id}', function () {
    return view('vue-pages');
  });
  Route::get('studio/oss/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('studio/highlight/{slug}', function () {
    return view('vue-pages');
  });
  Route::get('/studio/upload-template', function () {
    return view('vue-pages');
  });
Route::get('/', 'AgentController@agents')->name('home');
Route::get('search', 'HomeController@search')->name('search');

Route::get('search-embassy-in-islamabad/{q}', 'HomeController@searchByAlpha')->name('search-embassy');
Route::get('blogs', 'HomeController@blogs')->name('blogs');
Route::get('blog/{slug}', 'HomeController@blogDetail')->name('blog-detail');

Route::get('storage/uploads/{folder}/{file}', function ($folder, $file) {
    $paths = [
        public_path("storage/uploads/{$folder}/{$file}"),
        base_path("storage/uploads/{$folder}/{$file}"),
        storage_path("app/public/uploads/{$folder}/{$file}"),
        public_path("uploads/{$folder}/{$file}"),
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            return response()->file($path);
        }
    }

    abort(404);
})->where('file', '.*')->name('storage.uploads');

Route::get('execute-sitemaps', 'HomeController@runSitemap')->name('execute-sitemaps');

Route::get('generate-agent-codes', 'AgentController@AgentCodesScript')->name('generate-agent-codes');

Route::get('import-foreign-jobs', 'HomeController@importForeignJobs');

Route::get('useful-links', 'HomeController@usefulLinks')->name('useful-links');
Route::post('import-workers',  'HomeController@importCustomFile');
Route::get('pakistan-visa-info', 'HomeController@pakistanVisa')->name('pakistan-visa-info');
Route::get('terms-conditions', 'HomeController@terms')->name('terms');
Route::get('privacy-policy', 'HomeController@privacy')->name('privacy');
Route::get('about-us', 'HomeController@about')->name('about');
Route::get('contact-us', 'HomeController@contact')->name('contact');
Route::post('save-contact', 'HomeController@saveContact')->name('save-contact');
Route::get('currency-converter', 'HomeController@converter')->name('converter');
Route::get('airlines', 'HomeController@airlines')->name('airlines');
Route::get('anti-spam-policy', 'HomeController@anti')->name('anti-spam');
Route::get('dmca-notes', 'HomeController@dmca')->name('dmca-notes');
Route::get('advertise-with-us', 'HomeController@advirtise')->name('advertise');
Route::get('menu', 'HomeController@menu')->name('menu');
Route::get('account-activation/{token}', ['as'=>'account-activation', 'uses'=>'Auth\RegisterController@activate']);
Route::get('home-page-slider', 'HomeController@homeSlider')->name('home-page-slider');
Route::get('middle-of-home-page', 'HomeController@middleHome')->name('middle-of-home-page');
Route::get('bottom-of-home-page', 'HomeController@bottomHome')->name('bottom-of-home-page');
Route::get('search-of-every-embassy-page', 'HomeController@searchEmbassy')->name('search-of-every-embassy-page');
Route::get('/success', 'HomeController@success')->name('success');
Route::get('umrah-packages', 'HomeController@umrahPackages')->name('umrah-packages');
Route::get('right-side-bar-of-every-embassy-page', 'HomeController@righSideEmbassy')->name('right-side-bar-of-every-embassy-page');
Route::get('left-side-bar-of-common-pages', 'HomeController@leftSideCommon')->name('left-side-bar-of-common-pages');
Route::get('sponsored', 'HomeController@sponsored')->name('sponsored');
Route::get('popular-embassies', 'HomeController@popularEmbassies')->name('popular-embassies');
Route::get('side-bar-of-every-embassy-page', 'HomeController@sideBarEmbassy')->name('side-bar-of-every-embassy-page');

Route::get('airline/{slug}', 'HomeController@airlineDetail')->name('airline/{slug}');
Route::get('claim-business/{slug}', 'AgentController@claimBusiness')->name('claim-business');
Route::get('cheap-umrah-packages', 'HomeController@umrahList')->name('umrah-packages');
Route::get('tour-packages', 'HomeController@tourPackages')->name('tour-packages');
Route::get('tour-packages/{slug}', 'HomeController@tourPackageDetail')->name('tour-package-detail');
Route::get('umrah-packages-from-{slug}', 'HomeController@packagesByCities')->name('umrah-packages-by-cities');
Route::get('/delete-gallery/{id}', 'User\HomeController@deleteGallery')->name('delete-gallery');
Route::get('/delete-promotion/{id}', 'User\HomeController@deletePromotion')->name('delete-promotion');
Route::post('save-newsletter', 'HomeController@saveNewsletter')->name('save-newsletter');
Route::get('agent/{slug}', 'AgentController@AgentDetail')->name('agent');

Route::get('highlights-of-pakistans-new-visa-policy', 'HomeController@visaPolicy')->name('visa-policy');
Route::get('new-umrah-policy-2019', 'HomeController@umrahPolicy2019')->name('new-umrah-policy-2019');
Route::get('new-umrah-policy', 'HomeController@umrahPolicy')->name('new-umrah-policy');
Route::get('information-about-schengen-visa', 'HomeController@schengen')->name('schengen');


Route::get('travel-news', 'TravelNewsController@travelNews')->name('travel-news');
Route::get('travel-news/{slug}', 'TravelNewsController@travelNewsDetail')->name('travel-news-detail');

Route::get('airline-circulars', 'AirlineUpdatesController@airlineUpdates')->name('airline-updates');
Route::get('airline-updates/{slug}', 'AirlineUpdatesController@airlineUpdatesDetail')->name('airline-updates-detail');
Route::get('airline-special-offers', 'AirlineUpdatesController@specialOffers')->name('airline-special-offers');
Route::get('airline-special-offer/{slug}', 'AirlineUpdatesController@speciaofferDetail')->name('airline-special-offer-detail');

Route::get('government-lists-salient-features-of-2019-hajj-policy', 'HomeController@hajjPolicy')->name('hajj-policy');
Route::get('get-country', 'HomeController@getCountry')->name('get-country');
Route::get('removerelated', 'HomeController@RelatedSites')->name('related');
// Route::get('travel-agents-in-pakistan/{slug}', 'AgentController@cities')->name('agents-by-city');
Route::get('travel-agents-in-pakistan', 'AgentController@agents')->name('agents-in-pakistan');
Route::get('travel-agents-in-{slug}', 'AgentController@agentCity')->name('agents-detail');

Route::get('jobs-in-{slug}', 'AgentController@jobCity')->name('jobs');
Route::get('airline-jobs', 'AgentController@jobCity')->name('jobsAll');
Route::get('travel-airline-jobs', 'AgentController@jobs')->name('travel-jobs');

Route::get('agent-jobs-in-{slug}', 'AgentController@agentJobCity')->name('agentJobs');
Route::get('agent-jobs', 'AgentController@agentJobCity')->name('agentJobsAll');
Route::get('travel-agent-jobs', 'AgentController@agentJobs')->name('travel-agent-jobs');

Route::get('foreign-jobs', 'AgentController@foreignJobs')->name('foreign-jobs');

Route::get('get-agents', 'AgentController@getAgents')->name('get-agents');
Route::get('edit-job/{id}', 'User\JobsController@editJob')->name('edit-job');
Route::get('cities', 'AgentController@cities')->name('cities');
Route::post('save-applicant', 'AgentController@saveApplicant')->name('save-applicant');
Route::post('save-review', 'AgentController@SaveReview')->name('save-review');
Route::get('/applicant/{slug}', 'AgentController@applicant')->name('applicant')->middleware('auth');
Route::get('applicant-thanks', 'AgentController@applicantThanks')->name('applicant-thanks');
Route::get('applicant-activation/{token}', 'AgentController@activateApplicant')->name('applicant-activation');

Route::get('cheap-umrah-flights-from-pakistan', 'FlightController@flightListing')->name('flight');
Route::get('{code}/umrah-tickets', 'FlightController@flightListing')->name('umrah-tickets');


Route::get('sasti-tickets', 'SastiTicketsController@index')->name('sasti-tickets');
Route::get('{code}/sasti-tickets', 'SastiTicketsController@index')->name('agent-site-tickets');

Route::get('umrah-hotels', 'UmrahHotelsController@index')->name('umrah-hotels');
Route::get('{code}/umrah-hotels', 'UmrahHotelsController@index')->name('agent-umrah-hotels');

Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.email');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');




// Route::get('make-slugs', 'AgentController@makeSlugs')->name('makeslugs');
Route::get('phone-number', 'AgentController@phoneNumber')->name('phoneNumber');

Route::get('active-review', 'AgentController@activeReview')->name('user.active-review');
Route::post('save-claim-business', 'AgentController@saveClaimedBusiness')->name('user.save-claim-business');

Auth::routes();
Route::post('/promotion-gallery', 'User\HomeController@activePromotions')->name('user.promotion-gallery');

Route::group(['middleware' => 'auth'], function () {
Route::get('preview-business/{slug}', 'AgentController@previewBusiness')->name('preview');

Route::get('/home', 'User\HomeController@index')->name('home');
Route::get('/profile', 'User\HomeController@profile')->name('profile');
Route::get('{slug}-reviews', 'User\HomeController@reviews')->name('reviews');
Route::get('{slug}-add-gallery', 'User\HomeController@addGallery')->name('add-gallery');
Route::get('{slug}-gallery', 'User\HomeController@agentGallery')->name('gallery');
Route::post('/save-gallery', 'User\HomeController@saveGallery')->name('user.save-gallery');
Route::post('/active-gallery', 'User\HomeController@activeGallery')->name('user.active-gallery');


Route::get('{slug}-promotions', 'User\HomeController@agentPromotions')->name('promotions');
Route::get('{slug}-add-promotion', 'User\HomeController@addPromotion')->name('add-promotion');
Route::get('{id}-edit-promotion', 'User\HomeController@editPromotion')->name('agent-edit-promotion');
Route::post('/save-promotion', 'User\HomeController@savePromotion')->name('user.save-promotion');

Route::get('/change-password', 'User\HomeController@changePassword')->name('change-password');
Route::post('/save-change-password', 'User\HomeController@saveChangePassword')->name('user.save-change-password');
Route::get('/add-business', 'User\HomeController@addBusiness')->name('user.add-business');
Route::get('user/edit-business/{id}', 'User\HomeController@editBusiness')->name('edit-business');
Route::post('/save-business', 'User\HomeController@saveBusiness')->name('user.save-business');

Route::get('{slug}-subscriptions', 'User\SubscriptionController@subsription')->name('subsription');
Route::get('/add-subscription', 'User\SubscriptionController@addSubsription')->name('add-subsription');
Route::post('/save-subscription', 'User\SubscriptionController@saveSubscription')->name('user.save-subscription');
Route::get('/renew-subscription', 'User\SubscriptionController@renewSubsription')->name('renew-subsription');
Route::get('/upgrade-subscription', 'User\SubscriptionController@updagradeSubsription')->name('upgrade-subsription');

Route::get('{slug}-requests', 'User\JobsController@requests')->name('requests');

Route::get('manage-{slug}-jobs', 'User\JobsController@jobs')->name('jobs');
Route::get('{slug}-add-job', 'User\JobsController@addJob')->name('add-job');
    Route::get('/job-active', 'User\JobsController@jobActive')->name('admin.job-active');
Route::post('/save-job', 'User\JobsController@saveJob')->name('user.save-job');

Route::get('manage-agent-foreign-jobs', 'User\JobsController@foreignJobs')->name('foreign-jobs');
Route::get('agent-add-foreign-job', 'User\JobsController@addforeignJob')->name('add-foreign-job');
    Route::get('/foreign-job-active', 'User\JobsController@jobforeignActive')->name('admin.foreign-job-active');
    Route::get('agent-edit-foreign-job-{id}', 'User\JobsController@editforeignJob')->name('edit-foreign-job');
Route::post('/save-foreign-job', 'User\JobsController@saveforeignJob')->name('user.save-foreign-job');

Route::get('agent-flights', 'User\FlightController@index')->name('user.agent-flights');
Route::get('agent-add-flight', 'User\FlightController@addflight')->name('user.add-flight');
Route::get('agent-edit-flight-{id}', 'User\FlightController@editflight')->name('user.edit-flight');
Route::post('save-flight', 'User\FlightController@save')->name('user.save-flight');
 Route::get('/agent-flight-active', 'User\FlightController@flightActive')->name('admin.agent-flight-active');


Route::get('agent-sasti-tickets', 'User\SastiTicketsController@index')->name('user.agent-sasti-tickets');
Route::get('agent-add-sasti-ticket', 'User\SastiTicketsController@addTickets')->name('user.add-sasti-ticket');
Route::get('agent-edit-sasti-ticket-{id}', 'User\SastiTicketsController@editTickets')->name('user.edit-sasti-ticket');
Route::post('save-sasti-ticket', 'User\SastiTicketsController@save')->name('user.save-sasti-ticket');
 Route::get('/agent-sasti-ticket-active', 'User\SastiTicketsController@ticketsActive')->name('admin.agent-sasti-ticket-active');


Route::get('agent-umrah-hotels', 'User\UmrahHotelController@index')->name('user.agent-umrah-hotels');
Route::get('load-hotels', 'User\UmrahHotelController@loadHotels')->name('user.load-hotels');
Route::get('agent-add-umrah-hotel', 'User\UmrahHotelController@addHotel')->name('user.add-umrah-hotel');
Route::get('agent-edit-umrah-hotel-{id}', 'User\UmrahHotelController@editHotel')->name('user.edit-umrah-hotel');
Route::post('save-umrah-hotel', 'User\UmrahHotelController@save')->name('user.save-umrah-hotel');
 Route::get('/agent-umrah-hotel-active', 'User\UmrahHotelController@hotelActive')->name('admin.agent-umrah-hotel-active');


 Route::get('/agent-package-active', 'User\PackagesController@PackageActive')->name('admin.agent-package-active');

Route::get('agent-packages', 'User\PackagesController@getPackages')->name('user.packages');
Route::get('agent-add-package', 'User\PackagesController@addPackages')->name('user.add-package');
Route::get('agent-edit-package-{id}', 'User\PackagesController@editPackages')->name('user.edit-packages');
Route::post('save-package', 'User\PackagesController@savePackages')->name('user.save-packages');
 Route::get('/agent-package-active', 'User\PackagesController@packageActive')->name('admin.agent-package-active');

 Route::get('agent-tour-packages', 'User\TourPackagesController@getPackages')->name('user.tour-packages');
Route::get('agent-add-tour-package', 'User\TourPackagesController@addPackages')->name('user.add-tour-package');
Route::get('agent-edit-tour-package-{id}', 'User\TourPackagesController@editPackages')->name('user.edit-tour-packages');
Route::post('agent-save-tour-package', 'User\TourPackagesController@savePackages')->name('user.save-tour-packages');
 Route::get('/agent-tour-package-active', 'User\TourPackagesController@packageActive')->name('admin.agent-tour-package-active');
 
 
  Route::get('/agent-hajj-package-active', 'User\HajjPackagesController@PackageActive')->name('admin.agent-hajj-package-active');

Route::get('agent-hajj-packages', 'User\HajjPackagesController@getPackages')->name('user.hajj-packages');
Route::get('agent-add-hajj-package', 'User\HajjPackagesController@addPackages')->name('user.add-hajj-package');
Route::get('agent-edit-hajj-package-{id}', 'User\HajjPackagesController@editPackages')->name('user.edit-hajj-package');
Route::post('save-hajj-package', 'User\HajjPackagesController@savePackages')->name('user.save-hajj-package');
 Route::get('/agent-hajj-package-active', 'User\HajjPackagesController@packageActive')->name('admin.agent-hajj-package-active');


    Route::get('/manage-tasks', 'Tasks\TaskController@index')->name('manage-tasks');
    Route::get('/add-task', 'Tasks\TaskController@showAddForm')->name('add-task');
    Route::get('/edit-task/{id}', 'Tasks\TaskController@showEditForm')->name('edit-task');
    Route::get('/task-detail/{id}', 'Tasks\TaskController@taskDetail')->name('task-detail');
    Route::post('/save-task', 'Tasks\TaskController@save')->name('save-task');
    Route::get('/add-attachment/{id}', 'Tasks\TaskController@addAttachment')->name('add-attachment');
    Route::post('/save-attachment', 'Tasks\TaskController@saveAttachment')->name('save-attachment');
    Route::post('/task-status', 'Tasks\TaskController@taskStatus')->name('task-status');

    //tickets
    Route::get('/manage-tickets', 'Tasks\TicketController@index')->name('manage-tickets');
    Route::get('/add-ticket', 'Tasks\TicketController@showAddForm')->name('add-ticket');
    Route::post('/save-ticket', 'Tasks\TicketController@saveTicket')->name('save-ticket');
    Route::get('/edit-ticket/{id}', 'Tasks\TicketController@showEditForm')->name('edit-ticket');



     //Daily Sales
    Route::get('/manage-sales', 'Tasks\DailySaleController@index')->name('manage-sales');
    Route::get('/add-entry', 'Tasks\DailySaleController@showAddForm')->name('add-entry');



    //suppliers
    Route::get('/manage-suppliers', 'Tasks\SupplierController@index')->name('manage-suppliers');
    Route::get('/edit-supplier/{id}', 'Tasks\SupplierController@showEditForm')->name('edit-supplier');
    Route::get('/add-supplier', 'Tasks\SupplierController@showAddForm')->name('add-supplier');
    Route::post('/save-supplier', 'Tasks\SupplierController@saveSupplier')->name('save-supplier');
    Route::get('/edit-supplier/{id}', 'Tasks\SupplierController@showEditForm');
    Route::get('/supplier-transactions/{id}', 'Tasks\SupplierController@supplierTransactions')->name('supplier-transactions');
    Route::get('/add-supplier-amount/{id}', 'Tasks\SupplierController@showAddAmountForm')->name('add-supplier-amount');
    Route::post('/save-supplier-amount', 'Tasks\SupplierController@saveAmount')->name('save-supplier-amount');
    Route::get('/deduct-supplier-amount/{id}', 'Tasks\SupplierController@showDeductAmountForm')->name('deduct-supplier-amount');
    Route::post('/save-deduct-supplier-amount', 'Tasks\SupplierController@deductAmount')->name('save-deduct-supplier-amount');

    //parties
    Route::get('/manage-parties', 'Tasks\PartyController@index')->name('manage-parties');
    Route::get('/add-party', 'Tasks\PartyController@showAddForm')->name('add-party');
    Route::post('/save-party', 'Tasks\PartyController@saveParty')->name('save-party');
    Route::get('/edit-party/{id}', 'Tasks\PartyController@showEditForm');
    Route::get('/detail-party/{id}', 'Tasks\PartyController@detail');
    Route::get('/delete-attachement/{id}', 'Tasks\PartyController@deleteAttachemnt');
    Route::get('/party-transactions/{id}', 'Tasks\PartyController@partyTransactions')->name('party-transactions');
    Route::get('/add-party-amount/{id}', 'Tasks\PartyController@showAddAmountForm')->name('add-party-amount');
    Route::post('/save-party-amount', 'Tasks\PartyController@saveAmount')->name('save-party-amount');
    Route::get('/deduct-party-amount/{id}', 'Tasks\PartyController@showDeductAmountForm')->name('deduct-party-amount');
    Route::post('/save-deduct-party-amount', 'Tasks\PartyController@deductAmount')->name('save-deduct-party-amount');

    //account category
    Route::get('/manage-accounts-categories', 'Tasks\AccountCategoryController@index')->name('manage-accounts-categories');
    Route::get('/add-account-category', 'Tasks\AccountCategoryController@showAddForm')->name('add-account-category');
    Route::post('/save-account-category', 'Tasks\AccountCategoryController@save')->name('save-account-category');
    Route::get('/edit-account-category/{id}', 'Tasks\AccountCategoryController@showEditForm')->name('edit-account-category');


    //flights
    // Route::get('/manage-flights', 'Tasks\FlightController@index')->name('manage-flights');
    // Route::get('/add-flights', 'Tasks\FlightController@showAddForm')->name('add-flight');
    // Route::post('/save-flight', 'Tasks\FlightController@save')->name('save-flight');
    // Route::get('/edit-flight/{id}', 'Tasks\FlightController@showEditForm')->name('edit-flight');

    //Airlines
    Route::get('/manage-airlines', 'Tasks\AirlineController@index')->name('manage-airlines');
    Route::get('/add-airlines', 'Tasks\AirlineController@showAddForm')->name('add-airline');
    Route::post('/save-airline', 'Tasks\AirlineController@saveAirline')->name('save-airline');
    Route::get('/edit-airline/{id}', 'Tasks\AirlineController@showEditForm')->name('edit-airline');
    Route::get('/edit-employee/{id}', 'Tasks\EmployeeController@showEditForm')->name('edit-employee');

    Route::post('/status-updater-ajax', 'Tasks\AjaxController@statusUpdater')->name('status-updater-ajax');
    Route::post('/validation-pnr-ajax', 'Tasks\AjaxController@validatePNR')->name('validation-pnr-ajax');

    Route::get('/transactions', 'Tasks\TransactionController@index')->name('transactions');

    //Room Types
    Route::get('/manage-room-type', 'Tasks\RoomTypesController@index')->name('manage-room-type');
    Route::get('/add-room-type', 'Tasks\RoomTypesController@showAddForm')->name('add-room-type');
    Route::post('/save-room-type', 'Tasks\RoomTypesController@saveForm')->name('save-room-type');
    Route::get('/edit-room-type/{id}', 'Tasks\RoomTypesController@showEditForm')->name('edit-room-type');

    //visa Types
    Route::get('/manage-visa-type', 'Tasks\VisaTypesController@index')->name('manage-visa-type');
    Route::get('/add-visa-type', 'Tasks\VisaTypesController@showAddForm')->name('add-visa-type');
    Route::post('/save-visa-type', 'Tasks\VisaTypesController@saveForm')->name('save-visa-type');
    Route::get('/edit-visa-type/{id}', 'Tasks\VisaTypesController@showEditForm')->name('edit-visa-type');

    //Hotel Sale
    Route::get('/manage-hotel-sale', 'Tasks\HotelSaleController@index')->name('manage-hotel-sale');
    Route::get('/add-hotel-sale', 'Tasks\HotelSaleController@showAddForm')->name('add-hotel-sale');
    Route::post('/save-hotel-sale', 'Tasks\HotelSaleController@saveForm')->name('save-hotel-sale');
    Route::get('/edit-hotel-sale/{id}', 'Tasks\HotelSaleController@showEditForm')->name('edit-hotel-sale');

    //Other Sale
    Route::get('/manage-other-sale', 'Tasks\OtherSaleController@index')->name('manage-other-sale');
    Route::get('/add-other-sale', 'Tasks\OtherSaleController@showAddForm')->name('add-other-sale');
    Route::post('/save-other-sale', 'Tasks\OtherSaleController@saveForm')->name('save-other-sale');
    Route::get('/edit-other-sale/{id}', 'Tasks\OtherSaleController@showEditForm')->name('edit-other-sale');

    //Tour Packages
    Route::get('/manage-tour-package', 'Tasks\TourPackageController@index')->name('manage-tour-package');
    Route::get('/add-tour-package', 'Tasks\TourPackageController@showAddForm')->name('add-tour-package');
    Route::post('/save-tour-package', 'Tasks\TourPackageController@saveForm')->name('save-tour-package');
    Route::get('/edit-tour-package/{id}', 'Tasks\TourPackageController@showEditForm')->name('edit-tour-package');

    //Travel Insurance
    Route::get('/manage-travel-insurance', 'Tasks\TravelInsuranceController@index')->name('manage-travel-insurance');
    Route::get('/add-travel-insurance', 'Tasks\TravelInsuranceController@showAddForm')->name('add-travel-insurance');
    Route::post('/save-travel-insurance', 'Tasks\TravelInsuranceController@saveForm')->name('save-travel-insurance');
    Route::get('/edit-travel-insurance/{id}', 'Tasks\TravelInsuranceController@showEditForm')->name('edit-travel-insurance');

    //Umrah Sale
    Route::get('/manage-umrah-sale', 'Tasks\UmrahSaleController@index')->name('manage-umrah-sale');
    Route::get('/add-umrah-sale', 'Tasks\UmrahSaleController@showAddForm')->name('add-umrah-sale');
    Route::post('/save-umrah-sale', 'Tasks\UmrahSaleController@saveForm')->name('save-umrah-sale');
    Route::get('/edit-umrah-sale/{id}', 'Tasks\UmrahSaleController@showEditForm')->name('edit-umrah-sale');

    //Visa Sale
    Route::get('/manage-visa-sale', 'Tasks\VisaSaleController@index')->name('manage-visa-sale');
    Route::get('/add-visa-sale', 'Tasks\VisaSaleController@showAddForm')->name('add-visa-sale');
    Route::post('/save-visa-sale', 'Tasks\VisaSaleController@saveForm')->name('save-visa-sale');
    Route::get('/edit-visa-sale/{id}', 'Tasks\VisaSaleController@showEditForm')->name('edit-visa-sale');

    Route::get('/daily-logs', 'Tasks\DailySaleController@logs')->name('daily-logs');
    
    
     Route::get('/manage-invoices', 'Tasks\InvoiceController@index')->name('manage-invoices');
    Route::get('/generate-invoice', 'Tasks\InvoiceController@generate')->name('generate-invoice');
    Route::get('/edit-invoice/{id}', 'Tasks\InvoiceController@edit')->name('edit-invoice');
    Route::get('tasks-download-invoice','Tasks\InvoiceController@downloadInvoice')->name('download-invoice');
    Route::post('/save-invoice', 'Tasks\InvoiceController@save')->name('save-invoice');

});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');



    // Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    // Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
    // Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    // Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/home', 'Admin\GeneralController@home')->name('admin.home');
   
    Route::get('/manage-custom-content', 'Admin\ContentController@manageContent')->name('admin.manage-custom-content');
    Route::get('/add-content', 'Admin\ContentController@addContent')->name('admin.add-content');
    Route::get('/edit-content/{id}', 'Admin\ContentController@editContent')->name('admin.edit-content');
    Route::get('/delete-content/{id}', 'Admin\ContentController@deleteContent')->name('admin.delete-content');
    Route::get('/delete-price/{id}', 'Admin\ContentController@deletePrice')->name('admin.delete-price');
    Route::post('/save-content', 'Admin\ContentController@saveContent')->name('admin.save-content');
    Route::get('/add-section', 'Admin\SectionController@addSectionForm')->name('admin.add-section');
    Route::get('/manage-section', 'Admin\SectionController@manageSection')->name('admin.manage-section');
    Route::post('/save-section', 'Admin\SectionController@saveSection')->name('admin.save-section');
    Route::get('/edit-section/{id}', 'Admin\SectionController@editSection')->name('admin.edit-section');
    Route::get('/manage-home-sidebar', 'Admin\GeneralController@manageHomeSidebar')->name('admin.manage-home-sidebar');
    Route::get('/save-home-sidebar', 'Admin\GeneralController@saveHomeSidebar')->name('admin.save-home-sidebar');
    Route::get('/manage-visas', 'Admin\VisaController@manageVisas')->name('admin.manage-visas');
    Route::get('/save-home-countries', 'Admin\GeneralController@saveHomecountries')->name('admin.save-home-countries');
    Route::get('/main-meta', 'Admin\GeneralController@mainMeta')->name('admin.main-meta');
    Route::post('/save-meta', 'Admin\GeneralController@saveMeta')->name('admin.save-meta');
    Route::get('/add-meta', 'Admin\GeneralController@addMeta')->name('admin.add-meta');
    Route::get('/edit-meta/{id}', 'Admin\GeneralController@editMeta')->name('admin.edit-meta');

    Route::get('/delete-visa', 'Admin\VisaController@deleteVisaSection')->name('admin.delete-visa');

    Route::get('/add-visa', 'Admin\VisaController@addVisa')->name('admin.add-visa');
    Route::post('/save-visa', 'Admin\VisaController@saveVisa')->name('admin.save-visa');
    Route::get('/edit-visa/{id}', 'Admin\VisaController@editVisa')->name('admin.edit-visa');
    Route::get('/delete-visa/{id}', 'Admin\VisaController@deleteVisa')->name('admin.delete-visa');
    Route::post('/update-visa', 'Admin\VisaController@updateVisa')->name('admin.update-visa');
    Route::get('/add-quick-links', 'Admin\ContentController@addQuickLinks')->name('admin.add-quick-links');
    Route::get('/manage-quick-links', 'Admin\ContentController@manageQuickLinks')->name('admin.manage-quick-links');
    Route::post('/save-quick-links', 'Admin\ContentController@saveQuickLinks')->name('admin.save-quick-links');
    Route::get('/delete-quick-links/{id}', 'Admin\ContentController@deleteQuickLinks')->name('admin.delete-quick-links');
    Route::post('/update-quick-links/{id}', 'Admin\ContentController@updateQuickLinks')->name('admin.update-quick-links');

    Route::get('/manage-page', 'Admin\ContentController@managePage')->name('admin.manage-page');
    Route::get('/add-page', 'Admin\ContentController@addPage')->name('admin.add-page');
    Route::post('/save-page', 'Admin\ContentController@savePage')->name('admin.save-page');
    Route::get('/edit-page/{id}', 'Admin\ContentController@editPage')->name('admin.edit-page');
    
        Route::get('/manage-hotels', 'Admin\ContentController@manageHotel')->name('admin.manage-hotels');
    Route::get('/add-hotel', 'Admin\ContentController@addHotel')->name('admin.add-hotel');
    Route::post('/save-hotel', 'Admin\ContentController@saveHotel')->name('admin.save-hotel');
    Route::get('/edit-hotel/{id}', 'Admin\ContentController@editHotel')->name('admin.edit-hotel');
    
    Route::get('/manage-links', 'Admin\ContentController@manageLinks')->name('admin.manage-links');
    Route::get('/add-link', 'Admin\ContentController@addLinks')->name('admin.add-link');
    Route::post('/save-link', 'Admin\ContentController@saveLinks')->name('admin.save-link');
    Route::get('/edit-link/{id}', 'Admin\ContentController@editLinks')->name('admin.edit-link');

    Route::get('/newsletter', 'Admin\GeneralController@newsLetter')->name('admin.newsletter');

    Route::get('/contact', 'Admin\GeneralController@contact')->name('admin.contact');
    Route::get('/delete-contact/{id}', 'Admin\GeneralController@deleteContact')->name('admin.delete-contact');

    Route::get('/visa-policy/{id}', 'Admin\ContentController@getPolicy')->name('admin.visa-policy');
    Route::post('/save-visa-policy', 'Admin\ContentController@savePolicy')->name('admin.save-visa-policy');

    Route::get('/umrah-policy-2019/{id}', 'Admin\ContentController@getUmrahPolicy2019')->name('admin.umrah-policy-2019');
    Route::post('/save-umrah-policy-2019', 'Admin\ContentController@saveUmrahPolicy2019')->name('admin.save-umrah-policy-2019');



    Route::get('/schengen/{id}', 'Admin\ContentController@getSchengen')->name('admin.schengen');
    Route::post('/save-schengen', 'Admin\ContentController@saveSchengen')->name('admin.save-schengen');

    Route::get('/cities', 'Admin\FlyingController@getCity')->name('admin.cities');
    Route::get('/add-cities', 'Admin\FlyingController@addCity')->name('admin.add-cities');
    Route::get('/edit-city/{id}', 'Admin\FlyingController@editCity')->name('admin.edit-city');
    Route::post('/save-city', 'Admin\FlyingController@saveCity')->name('admin.save-city');

    Route::get('/airline', 'Admin\FlyingController@getAirline')->name('admin.airline');
    Route::get('/add-airline', 'Admin\FlyingController@addAirline')->name('admin.add-airline');
    Route::get('/edit-airline/{id}', 'Admin\FlyingController@editAirline')->name('admin.edit-airline');
    Route::post('/save-airline', 'Admin\FlyingController@saveAirline')->name('admin.save-airline');

    Route::get('/add-fares/{id}', 'Admin\FlyingController@addFares')->name('admin.add-fares');
    Route::post('/save-fares', 'Admin\FlyingController@saveFares')->name('admin.save-fares');

    Route::get('/packages', 'Admin\FlyingController@getPackages')->name('admin.packages');
    Route::get('/add-packages', 'Admin\FlyingController@addPackages')->name('admin.add-packages');
    Route::get('/edit-packages/{id}', 'Admin\FlyingController@editPackages')->name('admin.edit-packages');
    Route::get('/delete-package/{id}', 'Admin\FlyingController@deletePackage')->name('admin.delete-package');
    Route::post('/save-packages', 'Admin\FlyingController@savePackages')->name('admin.save-packages');

    Route::get('/load-agents', 'Admin\FlyingController@loadAgents')->name('admin.load-agents');

    Route::get('/images', 'Admin\GeneralController@getImages')->name('admin.images');
    Route::get('/add-image', 'Admin\GeneralController@addImages')->name('admin.add-image');
    Route::get('/edit-image/{id}', 'Admin\GeneralController@editImages')->name('admin.edit-image');
    Route::post('/save-image', 'Admin\GeneralController@saveImages')->name('admin.save-image');

    Route::get('/reply/{id}', 'Admin\GeneralController@reply')->name('admin.reply');
    Route::post('/send-reply', 'Admin\GeneralController@sendReply')->name('admin.send-reply');

    Route::get('/embassy', 'Admin\FlyingController@getEmbassy')->name('admin.embassy');
    Route::get('/add-embassy', 'Admin\FlyingController@addEmbassy')->name('admin.add-embassy');
    Route::get('/edit-embassy/{id}', 'Admin\FlyingController@editEmbassy')->name('admin.edit-embassy');
    Route::post('/save-embassy', 'Admin\FlyingController@saveEmbassy')->name('admin.save-embassy');

    Route::get('/general-settings', 'Admin\SettingController@generalSettings')->name('admin.general-settings');
    Route::post('/general-settings', 'Admin\SettingController@saveGeneralSettings')->name('save.general-settings');

    Route::get('/assign-embassy', 'Admin\SettingController@assignEmbassy')->name('admin.assign-embassy');
    Route::post('/assign', 'Admin\SettingController@saveAssign')->name('admin.assign');

    Route::get('/save-featured-blog', 'Admin\BlogsController@SaveFeatured')->name('admin.save-featured-blog');

    Route::get('/blogs', 'Admin\BlogsController@index')->name('admin.blogs');
    Route::get('/add-blog', 'Admin\BlogsController@addBlog')->name('admin.add-blog');
    Route::get('/edit-blog/{id}', 'Admin\BlogsController@editBlog')->name('admin.edit-blog');
    Route::post('/save-blog', 'Admin\BlogsController@saveBlog')->name('admin.save-blog');

    Route::get('/travel-news', 'Admin\TravelNewsController@index')->name('admin.travel-news');
    Route::get('/add-travel-news', 'Admin\TravelNewsController@addTravelNews')->name('admin.add-travel-news');
    Route::get('/edit-travel-news/{id}', 'Admin\TravelNewsController@editTravelNews')->name('admin.edit-travel-news');
    Route::post('/save-travel-news', 'Admin\TravelNewsController@saveTravelNews')->name('admin.save-travel-news');

    Route::get('/airline-updates', 'Admin\AirlineUpdatesController@index')->name('admin.airline-updates');
    Route::get('/add-airline-updates', 'Admin\AirlineUpdatesController@addAirlineUpdates')->name('admin.add-airline-udpates');
    Route::get('/edit-airline-updates/{id}', 'Admin\AirlineUpdatesController@editAirlineUpdates')->name('admin.edit-airlines-updates');
    Route::post('/save-airline-updates', 'Admin\AirlineUpdatesController@saveAirlineUpdates')->name('admin.save-airline-updates');

    Route::get('/blogs-categories', 'Admin\BlogsController@indexCategories')->name('admin.blogs-categories');
    Route::get('/add-blog-category', 'Admin\BlogsController@addBlogCategory')->name('admin.add-blog-category');
    Route::get('/edit-blog-category/{id}', 'Admin\BlogsController@editBlogCategory')->name('admin.edit-blog-category');
    Route::post('/save-blog-category', 'Admin\BlogsController@saveBlogCategory')->name('admin.save-blog-category');

    Route::get('/related', 'Admin\RelatedController@related')->name('admin.related');
    Route::get('/add-related', 'Admin\RelatedController@addRelated')->name('admin.add-related');
    Route::get('/edit-related/{id}', 'Admin\RelatedController@editRelated')->name('admin.edit-related');
    Route::get('/delete-related/{id}', 'Admin\RelatedController@deleteRelated')->name('admin.delete-related');
    Route::post('/save-related', 'Admin\RelatedController@save')->name('admin.save-related');


    Route::get('/agents', 'Admin\AgentController@agent')->name('admin.agent');
    Route::get('/add-agent', 'Admin\AgentController@addAgent')->name('admin.add-agent');
    Route::get('/edit-agent/{id}', 'Admin\AgentController@editAgent')->name('admin.edit-agent');
    Route::get('/delete-agent/{id}', 'Admin\AgentController@deleteagent')->name('admin.delete-agent');
    Route::post('/save-agent', 'Admin\AgentController@saveAgent')->name('admin.save-agent');

    Route::get('/foreign-agents', 'Admin\AgentController@agent')->name('admin.foreign-agent');
    Route::get('/add-foreign-agent', 'Admin\AgentController@addAgent')->name('admin.add-foreign-agent');
    Route::get('/edit-foreign-agent/{id}', 'Admin\AgentController@editAgent')->name('admin.edit-foreign-agent');
    
    Route::get('/agent-types', 'Admin\AgentController@agentType')->name('admin.agent-types');
    Route::get('/add-type', 'Admin\AgentController@addType')->name('admin.add-type');
    Route::get('/edit-type/{id}', 'Admin\AgentController@editType')->name('admin.edit-type');
    Route::get('/delete-type/{id}', 'Admin\AgentController@deleteType')->name('admin.delete-agent-type');
    Route::post('/save-type', 'Admin\AgentController@saveType')->name('admin.save-type');

    Route::get('/agent-cities', 'Admin\AgentController@agentCities')->name('admin.agent-cities');
    Route::get('/add-agent-city', 'Admin\AgentController@addCity')->name('admin.add-agent-city');
    Route::get('/edit-agent-city/{id}', 'Admin\AgentController@editCity')->name('admin.edit-agent-city');
    Route::post('/save-agent-city', 'Admin\AgentController@saveCity')->name('admin.save-agent-city');
    Route::get('/save-home-listing', 'Admin\AgentController@saveHomeListing')->name('admin.save-home-listing');
    Route::get('/save-home-listing-number', 'Admin\AgentController@saveHomeListingNumber')->name('admin.save-home-listing-number');
    Route::get("unset-business-number/{id}", "Admin\AgentController@businessUnsetNumber")->name("unset-business-number");

    Route::get('/add-job', 'Admin\AgentController@addJob')->name('admin.add-jobs');
    Route::get('/edit-job/{id}', 'Admin\AgentController@editJob')->name('admin.edit-jobs');
    Route::post('/save-job', 'Admin\AgentController@saveJob')->name('admin.save-jobs');
    Route::get('/manage-jobs', 'Admin\AgentController@manageJobs')->name('admin.manage-jobs');
    Route::get('/jobs-applicants', 'Admin\AgentController@applicants')->name('admin.jobs-applicants');

    Route::get('/job-categories', 'Admin\AgentController@jobCategories')->name('admin.job-categories');
    Route::get('/add-job-category', 'Admin\AgentController@addJobCategory')->name('admin.add-job-category');
    Route::get('/edit-job-category/{id}', 'Admin\AgentController@editJobCategory')->name('admin.edit-job-category');
    Route::post('/save-job-category', 'Admin\AgentController@saveJobCategory')->name('admin.save-job-category');
    
        Route::get('/job-designations', 'Admin\AgentController@jobDesignations')->name('admin.job-designations');
    Route::get('/add-job-designation', 'Admin\AgentController@addJobDesignation')->name('admin.add-job-designation');
    Route::get('/edit-job-designation/{id}', 'Admin\AgentController@editJobDesignation')->name('admin.edit-job-designation');
    Route::post('/save-job-designation', 'Admin\AgentController@saveJobDesignation')->name('admin.save-job-designation');
    
     Route::get('/ticket-filters', 'Admin\AgentController@ticketFilters')->name('admin.ticket-filters');
    Route::get('/add-ticket-filters', 'Admin\AgentController@addTicketFilter')->name('admin.add-ticket-filters');
    Route::get('/edit-ticket-filters/{id}', 'Admin\AgentController@editTicketFilter')->name('admin.edit-ticket-filters');
    Route::post('/save-ticket-filters', 'Admin\AgentController@saveTicketFilter')->name('admin.save-ticket-filters');
    
    Route::get('/job-experiences', 'Admin\AgentController@jobExperience')->name('admin.job-experiences');
    Route::get('/add-job-experience', 'Admin\AgentController@addJobExperience')->name('admin.add-job-experience');
    Route::get('/edit-job-experience/{id}', 'Admin\AgentController@editJobExperience')->name('admin.edit-job-experience');
    Route::post('/save-job-experience', 'Admin\AgentController@saveJobExperience')->name('admin.save-job-experience');

    Route::get('/dts-verified', 'Admin\AgentController@dtsVerified')->name('admin.dts-verified');
    Route::get('/applicant-approved', 'Admin\AgentController@applicantApproved')->name('admin.applicant-approved');

    Route::get('/agent-subscriptions/{?id}', 'Admin\AgentController@agentSubscription')->name('admin.agent-subscriptions');

    Route::get('/agent-reviews', 'Admin\AgentController@agentReviews')->name('admin.agent-reviews');

    Route::get('/agent-promotions', 'Admin\AgentController@agentPromotions')->name('admin.agent-promotions');
    Route::get('/approve-promotion', 'Admin\AgentController@approvePromotion')->name('admin.approve-promotion');

    Route::get('/agent-gallery', 'Admin\AgentController@agentGallery')->name('admin.agent-gallery');
    Route::get('/agent-images-approve', 'Admin\AgentController@imageApprove')->name('admin.agent-images-approve');
    Route::get('/approve-gallery', 'Admin\AgentController@approveGallery')->name('admin.approve-gallery');
    // Route::get('/add-subscription/{?id}', 'Admin\AgentController@addSubscription')->name('admin.add-subscription');
    // Route::get('/edit-subscription/{id}', 'Admin\AgentController@editSubscription')->name('admin.edit-subscription');
    // Route::get('/delete-subscription/{id}', 'Admin\AgentController@deleteSubscription')->name('admin.delete-subscription');
    // Route::post('/save-subscription', 'Admin\AgentController@saveSubscription')->name('admin.save-subscription');

    Route::get('/subscriber-detail', ['as'=>'admin.subscriber-detail', 'uses'=>'Admin\PlansController@subscriptionDetail']);
    Route::get('/invoices/{id}', ['as'=>'admin.invoices', 'uses'=>'Admin\PlansController@showInvoices']);

    Route::get('/manage-plans', ['as'=>'admin.manage-plans', 'uses'=>'Admin\PlansController@managePlans']);
    Route::get('/plan/{id?}', ['as'=>'admin.plan', 'uses'=>'Admin\PlansController@showPlan']);
    Route::post('/plan/{id?}', ['as'=>'admin.plan', 'uses'=>'Admin\PlansController@savePlan']);

    Route::get('/manage-subscription', ['as'=>'admin.manage-subscription', 'uses'=>'Admin\PlansController@showSubscription']);
    Route::get('/subscriber/{id?}/{action}', ['as'=>'admin.subscriber', 'uses'=>'Admin\PlansController@showSubscriberForm']);
    Route::post('/save-subscription/{id?}/{action}', ['as'=>'admin.save-subscription', 'uses'=>'Admin\PlansController@saveSubscription']);

    Route::get('/manage-permissions', ['as'=>'admin.manage-permission', 'uses'=>'Admin\PlansController@managePermissions']);
    Route::get('/permission/{id?}', ['as'=>'admin.permission', 'uses'=>'Admin\PlansController@showPermission']);
    Route::post('/permission/{id?}', ['as'=>'admin.permission', 'uses'=>'Admin\PlansController@savePermission']);
    
    // Manage, Add and Edit Price
    Route::get('/manage-price', ['as'=>'admin.manage-price', 'uses'=>'Admin\PlansController@managePlansPriceDiscount']);
    Route::get('/price/{id?}', ['as'=>'admin.price', 'uses'=>'Admin\PlansController@showPrice']);
    Route::post('/price/{id?}', ['as'=>'admin.price', 'uses'=>'Admin\PlansController@savePrice']);

       // Manage, Add and Edit Permissions
    Route::get('/manage-plan-permissions/{id?}', ['as'=>'admin.permissions', 'uses'=>'Admin\PlansController@showPlanPermissions']);
    Route::post('/save-plan-permissions/{id?}', ['as'=>'admin.permissions', 'uses'=>'Admin\PlansController@savePlanPermissions']);

    Route::get('/manage-flights', 'Admin\FlightController@index')->name('admin.manage-flights');
Route::get('/add-flight', 'Admin\FlightController@addflight')->name('admin.add-flight');
Route::get('/edit-flight-{id}', 'Admin\FlightController@editflight')->name('admin.edit-flight');
Route::post('/save-flight', 'Admin\FlightController@save')->name('admin.save-flight');
  Route::get('/flight-active', 'Admin\FlightController@flightActive')->name('admin.flight-active');


    Route::get('/manage-sasti-tickets', 'Admin\SastiTicketsController@index')->name('admin.manage-sasti-tickets');
      Route::get('/sasti-ticket-active', 'Admin\SastiTicketsController@ticketActive')->name('admin.sasti-ticket-active');

  Route::get('/allow-packages', 'Admin\ShowPackageController@index')->name('admin.show-packages');
    Route::get('/add-show-package', 'Admin\ShowPackageController@add')->name('admin.add-show-package');
    Route::get('/edit-show-package/{id}', 'Admin\ShowPackageController@edit')->name('admin.edit-show-package');
    Route::post('/save-show-package', 'Admin\ShowPackageController@save')->name('admin.save-show-package');
    
    Route::post('/save-verified', 'Admin\ShowPackageController@saveverified')->name('admin.save-verified');

    Route::post('/save-disallow-package', 'Admin\ShowPackageController@delete')->name('admin.save-disallow-package');

Route::get('/get-agents', 'Admin\AgentController@getAgents')->name('get-agents');

    
});

Route::group([], function(){
    Route::get('/{country}/{slug}', 'HomeController@getViasa')->name('visas');
});
Route::get('{slug}', 'HomeController@umrahDetail')->name('{slug}');
