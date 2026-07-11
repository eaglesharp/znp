<?php

use Illuminate\Support\Facades\Route;


Route::get('company-packages', 'Company\CompanyController@resume_search_packages')->name('company.packages');

// Route::post('employer-enquiry', 'PriceController@storeEnquiry')->name('employer.enquiry');



Route::get('unlocked-profile/{id}', 'Company\CompanyController@viewPublicProfile')->name('candidate.profile1');
Route::get('click-profile/{id}', 'Company\CompanyController@clickProfile')->name('candidate.click-profile');

Route::get('unlocked-resume/{id}', 'Company\CompanyController@viewPublicProfile2')->name('candidate.profile2');


 
// Route::get('download-resumes/{id}', 'Company\CompanyController@resumes')->name('download.resume');
 Route::get('download-candidate-resum/{id}', 'Company\CompanyController@resumes')->name('download.resume');

Route::get('download-invoice/{id}', 'Company\CompanyController@invoice')->name('download.invoice');

Route::get('unlocked-resumes', 'Company\CompanyController@unlocked_users')->name('unlocked-resumes');

Route::get('unlock/{user}', 'Company\CompanyController@unlock')->name('company.unlock');

Route::get('employer-home', 'Company\CompanyController@index')->name('company.home');

Route::get('companies', 'Company\CompaniesController@company_listing')->name('company.listing');

Route::get('company-profile', 'Company\CompanyController@companyProfile')->name('company.profile');



Route::get('collections', 'Company\CompanyController@collections')->name('company.collections');

Route::get('addcollections', 'Company\CompanyController@addcollections')->name('company.addcollections');

Route::get('editcollection/{id}', 'Company\CompanyController@editcollection')->name('edit.collection');

Route::post('store-collection', 'Company\CompanyController@storecollection')->name('store.collection');

Route::post('update-collection', 'Company\CompanyController@updatecollection')->name('update.collection');

Route::get('go-to-delete-modal/{id}', 'Company\CompanyController@gotodeletemodal')->name('delete_modal.collection');

Route::get('delete-collection/{delete_id}', 'Company\CompanyController@deletecollection')->name('delete.collection');

Route::get('folder_listing','Company\CompanyController@listingFolder')->name('folder.listing');



Route::get('collectionsbulkmail/{id}', 'Company\CompanyController@collectionsbulkmail')->name('company.collectionsbulkmail');

Route::post('sendbulkemail', 'Company\CompanyController@sendbulkemail');



Route::get('cv-search','Company\CompanyController@candidateListing')->name('cv-search'); 



Route::put('update-company-profile', 'Company\CompanyController@updateCompanyProfile')->name('update.company.profile');

Route::get('posted-jobs', 'Company\CompanyController@postedJobs')->name('posted.jobs');

Route::get('company/{slug}', 'Company\CompanyController@companyDetail')->name('company.detail');

Route::post('contact-company-message-send', 'Company\CompanyController@sendContactForm')->name('contact.company.message.send');

Route::post('contact-applicant-message-send', 'Company\CompanyController@sendApplicantContactForm')->name('contact.applicant.message.send');

Route::get('list-applied-users/{job_id}', 'Company\CompanyController@listAppliedUsers')->name('list.applied.users');

Route::get('list-favourite-applied-users/{job_id}', 'Company\CompanyController@listFavouriteAppliedUsers')->name('list.favourite.applied.users');

Route::get('add-to-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@addToFavouriteApplicant')->name('add.to.favourite.applicant');

Route::get('remove-from-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@removeFromFavouriteApplicant')->name('remove.from.favourite.applicant');

Route::get('applicant-profile/{application_id}', 'Company\CompanyController@applicantProfile')->name('applicant.profile');

Route::get('user-profile/{id}', 'Company\CompanyController@userProfile')->name('user.profile');

Route::get('company-followers', 'Company\CompanyController@companyFollowers')->name('company.followers');

/* Route::get('company-messages', 'Company\CompanyController@companyMessages')->name('company.messages'); */

Route::post('submit-message-seeker', 'CompanyMessagesController@submitnew_message_seeker')->name('submit-message-seeker');

Route::post('addtocollection', 'Company\CompanyController@addtocollection')->name('add-to-collection');

Route::post('emails-store','Company\CompanyController@emailsend')->name('emails.store');



Route::get('company-messages', 'CompanyMessagesController@all_messages')->name('company.messages');

Route::get('append-messages', 'CompanyMessagesController@append_messages')->name('append-message');

Route::get('append-only-messages', 'CompanyMessagesController@appendonly_messages')->name('append-only-message');

Route::post('company-submit-messages', 'CompanyMessagesController@submit_message')->name('company.submit-message');

Route::get('company-message-detail/{id}', 'Company\CompanyController@companyMessageDetail')->name('company.message.detail');



Route::post('candidate-list-search','Company\CompanyController@candidatelistsearch')->name('candidate.list.search.page');



// OLD employer dashboard (legacy company_dashboard view — KYC, CV quota, etc.)
// Route::get('employer-dashboard','Company\CompanyController@employerdashboard')->name('employer.dashboard');
Route::get('employer-dashboard-legacy', 'Company\CompanyController@employerdashboard')->name('employer.dashboard.legacy');

/* ── ZNP Employer Dashboard ── */
Route::get('employer-dashboard', 'Company\CompanyController@employerDashboardNew')->name('employer.dashboard');

// Route::get('employer-dashboard-page', 'Company\CompanyController@employerDashboardNew')->name('employer.dashboard.page');

Route::get('employer-job-pricing', 'Company\CompanyController@jobPricingZNP')->name('employer.job.pricing');

Route::get('employer/checkout/{slug}', 'ZnpStripeCheckoutController@checkout')->name('employer.znp.checkout');
Route::get('employer/checkout/success', 'ZnpStripeCheckoutController@success')->name('employer.znp.checkout.success');

/* ── ZNP Post a Job + applicants pipeline ── */
Route::get('post-job', 'Company\CompanyController@postJobZNP')->name('employer.post.job.page');
Route::post('post-job', 'Company\CompanyController@storeJobZNP')->name('employer.post.job.store');

Route::get('post-job/{id}/edit', 'Company\CompanyController@editJobZNP')->name('employer.post.job.edit')->where('id', '[0-9]+');
Route::post('post-job/{id}/edit', 'Company\CompanyController@updateJobZNP')->name('employer.post.job.update')->where('id', '[0-9]+');

Route::get('post-job/{id}/applicants', 'Company\CompanyController@applicantsZNP')->name('employer.post.job.applicants')->where('id', '[0-9]+');
Route::post('post-job/{id}/help-support', 'Company\CompanyController@submitHelpSupportZNP')->name('employer.help.support')->where('id', '[0-9]+');
Route::post('post-job/{id}/retire', 'Company\ApplicantPipelineController@retireJob')->name('employer.post.job.retire')->where('id', '[0-9]+');
Route::post('post-job/{id}/applicants/{app}/shortlist', 'Company\ApplicantPipelineController@shortlist')->name('employer.applicant.shortlist')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/note', 'Company\ApplicantPipelineController@note')->name('employer.applicant.note')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/feedback', 'Company\ApplicantPipelineController@feedback')->name('employer.applicant.feedback')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/reject', 'Company\ApplicantPipelineController@reject')->name('employer.applicant.reject')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/report', 'Company\ApplicantPipelineController@report')->name('employer.applicant.report')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/offer', 'Company\ApplicantPipelineController@offer')->name('employer.applicant.offer')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/view-cv', 'Company\ApplicantPipelineController@viewCv')->name('employer.applicant.viewcv')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::post('post-job/{id}/applicants/{app}/download-cv', 'Company\ApplicantPipelineController@downloadCv')->name('employer.applicant.downloadcv')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
Route::get('post-job/{id}/applicants-email/templates', 'Company\ApplicantPipelineController@emailTemplates')->name('employer.applicant.email.templates')->where('id', '[0-9]+');
Route::post('post-job/{id}/applicants-email/send', 'Company\ApplicantPipelineController@sendEmail')->name('employer.applicant.email.send')->where('id', '[0-9]+');

// Route::get('post-job-page', 'Company\CompanyController@postJobZNP')->name('employer.post.job.page');
// Route::post('post-job-page', 'Company\CompanyController@storeJobZNP')->name('employer.post.job.store');
// Route::get('post-job-page/{id}/edit', 'Company\CompanyController@editJobZNP')->name('employer.post.job.edit')->where('id', '[0-9]+');
// Route::post('post-job-page/{id}/edit', 'Company\CompanyController@updateJobZNP')->name('employer.post.job.update')->where('id', '[0-9]+');
// Route::get('post-job-page/{id}/applicants', 'Company\CompanyController@applicantsZNP')->name('employer.post.job.applicants')->where('id', '[0-9]+');
// Route::post('post-job-page/{id}/help-support', 'Company\CompanyController@submitHelpSupportZNP')->name('employer.help.support')->where('id', '[0-9]+');
// Route::post('post-job-page/{id}/retire', 'Company\ApplicantPipelineController@retireJob')->name('employer.post.job.retire')->where('id', '[0-9]+');
// Route::post('post-job-page/{id}/applicants/{app}/shortlist', 'Company\ApplicantPipelineController@shortlist')->name('employer.applicant.shortlist')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/note', 'Company\ApplicantPipelineController@note')->name('employer.applicant.note')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/feedback', 'Company\ApplicantPipelineController@feedback')->name('employer.applicant.feedback')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/reject', 'Company\ApplicantPipelineController@reject')->name('employer.applicant.reject')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/report', 'Company\ApplicantPipelineController@report')->name('employer.applicant.report')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/offer', 'Company\ApplicantPipelineController@offer')->name('employer.applicant.offer')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/view-cv', 'Company\ApplicantPipelineController@viewCv')->name('employer.applicant.viewcv')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::post('post-job-page/{id}/applicants/{app}/download-cv', 'Company\ApplicantPipelineController@downloadCv')->name('employer.applicant.downloadcv')->where(['id' => '[0-9]+', 'app' => '[0-9]+']);
// Route::get('post-job-page/{id}/applicants-email/templates', 'Company\ApplicantPipelineController@emailTemplates')->name('employer.applicant.email.templates')->where('id', '[0-9]+');
// Route::post('post-job-page/{id}/applicants-email/send', 'Company\ApplicantPipelineController@sendEmail')->name('employer.applicant.email.send')->where('id', '[0-9]+');



Route::post('home-search','Company\CompanyController@homesearch')->name('home.search');



Route::post('home-search1','Company\CompanyController@homesearch1')->name('home.search1');



//Candidate List



Route::post('search','Company\CompanyController@search')->name('search');

Route::any('candidate-filter1-search','Company\CompanyController@candidatesearch')->name('candidate.filter1.search');

Route::any('candidate-filter2-search','Company\CompanyController@filter2search')->name('candidate.filter2.search');



//Unlocked Users



Route::post('unlocked-search','Company\CompanyController@search1')->name('unlocked.search');



Route::any('candidate-unlocked-filter','Company\CompanyController@unlockedfiltersearch1')->name('candidate.unlocked.filter.page');



Route::any('candidate-unlocked-filter1','Company\CompanyController@unlockedfiltersearch2')->name('candidate.unlocked.filter1.page');


//Bulk Users



Route::post('bulk-search','Company\CompanyController@search2')->name('bulk.search');



Route::any('candidate-bulk-filter','Company\CompanyController@bulkfiltersearch1')->name('candidate.bulk.filter.page');

Route::any('candidate-draft-filter','Company\CompanyController@draftfiltersearch1')->name('candidate.draft.filter.page');

Route::any('candidate-bulk-filter2','Company\CompanyController@bulkfiltersearch2')->name('candidate.bulk.filter2.page');

Route::any('candidate-draft-subfilter','Company\CompanyController@draftsubfiltersearch')->name('candidate.draft.subfilter');




// Change Password

Route::get('change-company-password','Company\CompanyController@changeCompanyPassword');

Route::post('update_com_password/{id}','Company\CompanyController@updateCompanyPassword');

Route::post('get-template','Company\CompanyController@gettemplate')->name('get.template');

// Add resumes to folder

Route::post('add_resumes','Company\CompanyController@addResumes');
Route::post('add_bulkresumes','Company\CompanyController@addBulkResumes');

Route::post('update-collection', 'Company\CompanyController@updatecollection')->name('update.collection');
Route::post('sendbulkemail', 'Company\CompanyController@sendbulkemail')->name('email.sendbulkemail');


Route::post('ajax-load-send','Company\CompanyController@ajax11')->name('ajax.load.send');

//Employer Pricing page payment

Route::get('employer/payment','CheckoutController@employerpaymentpage')->name('employer.payment');

Route::post('employer-payment', 'CheckoutController@employersubmit')->name('employer.submit');

Route::get('employer-stripe-response/{id}', 'CheckoutController@employerresponse')->name('employerstripeResponse');


//Buy Single CV Option

Route::get('employer/buy-cv/{id}','CheckoutController@employerbuycv')->name('employer.buy.cv');

Route::post('employer-buy-cv', 'CheckoutController@employerbuycvsubmit')->name('employer.submit.buy.cv');

Route::get('view-applicant-profile/{id}', 'CheckoutController@cvpurchasestripeResponse')->name('view-applicant-profile');


//Buy Video Interview

Route::get('employer/buy-interview/{id}','CheckoutController@employerbuyinterview')->name('employer.buy.interview');

Route::post('employer-buy-interview', 'CheckoutController@employerbuyinterviewsubmit')->name('employer.submit.buy.interview');




Route::get('employer-payment-history','Company\CompanyController@paymenthistory')->name('front.payment.history');

Route::get('update-profile','Company\CompanyController@updateprofilesection')->name('update.profile');


Route::post('employer-image-store','Company\CompanyController@imagestore')->name('image.store');


Route::post('update-front-companyprofile','Company\CompanyController@updatefrontcompany');

// BUlk Sms Send

Route::post('bulk-sms-send','Company\CompanyController@bulksms')->name('bulk-sms-send');

Route::post('draft-store','Company\CompanyController@storedraft')->name('draft.store');

Route::post('get-template-data','Company\CompanyController@gettemplatedata')->name('get.template-data');  

Route::delete('delete-template', 'Company\CompanyController@deletetemplate')->name('delete.template');

Route::post('store-template-data','Company\CompanyController@storetemplatedata')->name('store.template-data'); 

Route::post('update-template-data','Company\CompanyController@updatetemplatedata')->name('update.template-data'); 

Route::get('draft','Company\CompanyController@draft')->name('draft'); 

Route::get('email-templates','Company\CompanyController@emailtemplates')->name('email-templates'); 

Route::post('save-search','Company\CompanyController@save_search')->name('save-search');

Route::get('saved-search','Company\CompanyController@saved_search')->name('saved-search');

Route::get('delete-saved-search/{id}','Company\CompanyController@delete_saved_search')->name('delete-saved-search');

Route::get('search-now/{id}','Company\CompanyController@searchnow')->name('search-now');


Route::get('verify-company-email/{id}','Company\CompanyController@verifyemail')->name('verify.company.email');  

Route::post('company-email-verify/{id}','Company\CompanyController@companyemailverify')->name('company.email.verify');

Route::get('companyaccount/verify/{token}', 'Company\CompanyController@verifyAccount')->name('company.verify');

Route::view('companyverified','companyverified');

Route::post('reportcv','Company\CompanyController@reportcv');
Route::post('kyc-documents','Company\CompanyController@kycdocuments');




Route::view('postjob-listing','company.postjob-listing');

Route::view('job-details','user.job-details');


Route::view('view-applicant','company.view-applicant');

Route::post('clear-filter1','Company\CompanyController@clearfilter1search')->name('clear-filter1');
Route::post('clear-filter2','Company\CompanyController@clearfilter2search')->name('clear-filter2');













