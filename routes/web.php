<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;



 

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

Route::view('coming-soon', 'coming');



$real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'front_routes' . DIRECTORY_SEPARATOR;
Route::get('/jobs-page', 'Job\JobController@jobsPage')->name('jobs.page');



/* * ******** IndexController ************ */


Route::get('/', 'IndexController@index')->name('index');

// Route::get('/', function () {
//   return redirect('/jobs');
// });

Route::get('/find-talent', 'IndexController@index');


Route::post('set-locale', 'IndexController@setLocale')->name('set.locale');



/* * ******** HomeController ************ */



// Route::get('home', 'HomeController@index')->name('home')->middleware('verified');



/* * ******** TypeAheadController ******* */



Route::get('typeahead-currency_codes', 'TypeAheadController@typeAheadCurrencyCodes')->name('typeahead.currency_codes');



/* * ******** FaqController ******* */



Route::get('faq', 'FaqController@index')->name('faq');



/* * ******** CronController ******* */



Route::get('check-package-validity', 'CronController@checkPackageValidity');



/* * ******** Verification ******* */



Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');



Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');



Route::get('company-email-verification/error', 'Company\Auth\RegisterController@getVerificationError')->name('company.email-verification.error');



Route::get('company-email-verification/check/{token}', 'Company\Auth\RegisterController@getVerification')->name('company.email-verification.check');



/* * ***************************** */



// Sociallite Start



// OAuth Routes



Route::get('login/jobseeker/{provider}', 'Auth\LoginController@redirectToProvider');



Route::get('login/jobseeker/{provider}/callback', 'Auth\LoginController@handleProviderCallback');



Route::get('login/employer/{provider}', 'Company\Auth\LoginController@redirectToProvider');



Route::get('login/employer/{provider}/callback', 'Company\Auth\LoginController@handleProviderCallback');



// Sociallite End



/* * ***************************** */



Route::post('tinymce-image_upload-front', 'TinyMceController@uploadImage')->name('tinymce.image_upload.front');







Route::get('cronjob/send-alerts', 'AlertCronController@index')->name('send-alerts');







Route::post('subscribe-newsletter', 'SubscriptionController@getSubscription')->name('subscribe.newsletter');



Route::get('/employer-login', 'Company\Auth\LoginController@showEmployerLoginForm')->name('employer.login');

Route::get('/employer-register', 'Company\Auth\RegisterController@showRegistrationForm')->name('company.register.page');

/* * ******** OrderController ************ */



include_once($real_path . 'order.php');



/* * ******** CmsController ************ */



include_once($real_path . 'cms.php');



/* * ******** JobController ************ */


include_once($real_path . 'job.php');



/* * ******** ContactController ************ */



include_once($real_path . 'contact.php');



/* * ******** CompanyController ************ */



include_once($real_path . 'company.php');



/* * ******** AjaxController ************ */



include_once($real_path . 'ajax.php');



/* * ******** UserController ************ */



include_once($real_path . 'site_user.php');



/* * ******** User Auth ************ */



Auth::routes(['verify' => true]);

// Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('resend-verification/{id}', 'Auth\VerificationController@resend')->name('verification.resend');


Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')
    ->middleware(['signed'])->name('verification.verify');

// Route::post('/email/resend', [VerificationController::class, 'resend'])
//     ->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

/* * ******** Company Auth ************ */



include_once($real_path . 'company_auth.php');



/* * ******** Admin Auth ************ */



include_once($real_path . 'admin_auth.php');









Route::get('blog', 'BlogController@index')->name('blogs');



Route::get('blog/search', 'BlogController@search')->name('blog-search');



Route::get('blog/{slug}', 'BlogController@details')->name('blog-detail');



Route::get('/blog/category/{blog}', 'BlogController@categories')->name('blog-category');



Route::get('/company-change-message-status', 'CompanyMessagesController@change_message_status')->name('company-change-message-status');

Route::get('/seeker-change-message-status', 'Job\SeekerSendController@change_message_status')->name('seeker-change-message-status');



Route::get('/sitemap', 'SitemapController@index');



Route::get('/sitemap/companies', 'SitemapController@companies');



Route::get('get', 'PriceController@get');





Route::get('pricing', 'PriceController@indexPrice')->name('pricing');



Route::get('about-us', 'PriceController@indexwhyus')->name('about-us'); 



Route::get('contact-us', 'ContactController@indexcontact')->name('contact-us');







Route::get('plan', 'PriceController@indexplan')->name('plan');



Route::post('employer', 'Company\Auth\RegisterController@storeEnquiry')->name('employer');

Route::get('company-redirect/{id}', 'PriceController@companyredirect')->name('company.redirect');



Route::get('tests', 'PriceController@getRouteList')->name('tests');









Route::get('/clear-cache', function () {
     



  $exitCode = Artisan::call('config:clear');



  $exitCode = Artisan::call('cache:clear');



  $exitCode = Artisan::call('config:cache');

dd(config('mail'));

  return 'DONE'; //Return anything



});







Route::view('/map', 'plugin');




Route::view('/job-new', 'job.job-new');






Route::post('gety', 'AjaxController@filterEducation')->name('gety');



Route::post('get-front-gety', 'AjaxController@filterEducation1')->name('get.front.gety');







Route::post('getspecs', 'AjaxController@filterSpecs')->name('getspecs');









Route::post('email-verify-user/{id}', 'UserController@emailverifyuser')->name('email.verify.user');




Route::post('email-verify-users/{id}', 'UserController@verxifyphone')->name('email.verify.users');



Route::get('phone-verifys/{id}', 'UserController@verifyphoneuser')->name('phone.verifys');



Route::post('verify-otp/{id}', 'UserController@verifyotp')->name('verify.otp');







Route::post('bulk-education', 'UserController@bulkeducation')->name('bulk.education');



// Route::get('/autocomplete', 'UserController@index');

Route::post('/autocomplete/fetch', 'UserController@fetch')->name('autocomplete.fetch');



Route::post('/autocomplete/fetch/admin', 'AjaxController@fetchadmin')->name('autocomplete.fetch.admin');





Route::post('welcome-search', 'IndexController@welcomepagesearch')->name('welcome.search');



Route::get('candidate-terms-and-conditons', function () {

  return view('termsandconditions');

});


Route::get('terms-and-conditons', function () {

  return view('termsandconditions');

});

Route::get('privacy-policy', function () {

  return view('privacyandpolicy');

});

Route::get('employer-terms-and-conditions', function () {

  return view('employer_terms');

});



Route::get('/verified', function () {
  return view('verified');


});

Route::get('dynamic', function () {
  return view('dynamic');
});



// Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify');

Route::get('account/verify/{token}', 'UserController@verifyAccount')->name('user.verify');


// Route::get('/jobs',function()
// {
//   return view('job.index')->name('jobs');
// });

// Route::get('company/register', 'Company\Auth\RegisterController@showRegistrationForm')->name('company.register.pageister');
// Route::get('company/register/page','Company\Auth\RegisterController@showRegistrationForm')->name('company-reg');

Route::view('expired', 'errors.419');

Route::post('searchcandidates', 'ActionController@searchresumes')->name('searchcandidates');

Route::post('get-user-data', 'ActionController@getuserdata')->name('get-user-data');


Route::get('autocomplete/search', 'ActionController@getskills')->name('autocomplete');

Route::get('autocomplete/search-location', 'ActionController@searchlocations')->name('search-location');

Route::get('autocomplete/search-location-job', 'ActionController@searchlocationsforprofile')->name('search-location-job');


//My Profile
Route::get('autocomplete/search-location-job2', 'ActionController@searchlocationsforprofile')->name('search-location-job2');

//Jobs Related Location Route
Route::get('autocomplete/search-location-job1', 'ActionController@searchlocationsforljob')->name('search-location-job1');


Route::get('autocomplete/skillsposition', 'ActionController@searchskillsposition')->name('skillsposition');

Route::get('autocomplete/cvlocations', 'ActionController@searchcvlocations')->name('cvlocations');
Route::get('autocomplete/cvskills', 'ActionController@searchcvskills')->name('cvskills');



Route::post('check', 'ActionController@test');

Route::post('newsletter', 'ActionController@newsletter')->name('newsletter');

Route::get('/employer-logout', 'LogoutController@Logout')->name('logoutcompany');
Route::get('/user-logout', 'LogoutController@Logout')->name('logoutuser');

Route::get('/invoice-test', 'CheckoutController@InvoiceTest');


Route::view('newletter-thankyou', 'thankyoud');