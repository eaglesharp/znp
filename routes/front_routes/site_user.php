<?php

use Illuminate\Support\Facades\Route;





/* * ******** UserController ************ */



Route::get('my-profile', 'UserController@myProfile')->name('my.profile');



Route::put('my-profile', 'UserController@updateMyProfile')->name('my.profile');



Route::get('delete-resume/{id}','UserController@deleteresume')->name('delete.resume');



Route::get('view-public-profile/{id}', 'UserController@viewPublicProfile')->name('view.public.profile');



Route::post('update-front-profile-summary/{id}', 'UserController@updateProfileSummary')->name('update.front.profile.summary');



Route::post('update-immediate-available-status', 'UserController@updateImmediateAvailableStatus')->name('update.immediate.available.status');



Route::get('add-to-favourite-company/{company_slug}', 'UserController@addToFavouriteCompany')->name('add.to.favourite.company');



Route::get('remove-from-favourite-company/{company_slug}', 'UserController@removeFromFavouriteCompany')->name('remove.from.favourite.company');



Route::get('my-followings', 'UserController@myFollowings')->name('my.followings');



/* Route::get('my-messages', 'UserController@myMessages')->name('my.messages'); */



Route::get('my-messages', 'Job\SeekerSendController@all_messages')->name('my.messages');



Route::get('seeker-append-messages', 'Job\SeekerSendController@append_messages')->name('seeker-append-messages');



Route::get('seeker-append-only-messages', 'Job\SeekerSendController@appendonly_messages')->name('seeker-append-only-message');



Route::post('seeker-submit-messages', 'Job\SeekerSendController@submitnew_message')->name('seeker.submit-message');







Route::post('update-compensation/{id}','UserController@updateProfileCompensation')->name('update.compensation');  



Route::post('update-details/{id}','UserController@updateProfileDetails')->name('update.details'); 







Route::get('verify-emails/{id}','UserController@verifyusers')->name('verify.emails');  





Route::delete('front-delete-interview', 'UserController@deleteinterview')->name('front.delete.interview');









Route::post('store-video-interview/{id}','UserController@videointerview')->name('store.video.interview');  







Route::post('update-video-interview/{id}','UserController@updatevideointerview')->name('update.video.interview');







Route::post('store.night.interview/{id}','UserController@nightinterview')->name('store.night.interview');







Route::post('update.night.interview/{id}','UserController@nightinterviewupdate')->name('update.night.interview');







Route::get('applicant-message-detail/{id}', 'UserController@applicantMessageDetail')->name('applicant.message.detail');



/* * *********************************** */



Route::post('show-front-profile-cvs/{id}', 'UserController@showProfileCvs')->name('show.front.profile.cvs');



Route::post('get-front-profile-cv-form/{id}', 'UserController@getFrontProfileCvForm')->name('get.front.profile.cv.form');



Route::post('store-front-profile-cv/{id}', 'UserController@storeProfileCv')->name('store.front.profile.cv');



Route::get('get-front-profile-user-info', 'UserController@getuserinfo')->name('get.user.info');



Route::post('get-front-profile-cv-edit-form/{user_id}', 'UserController@getFrontProfileCvEditForm')->name('get.front.profile.cv.edit.form');



Route::post('update-front-profile-cv/{id}/{user_id}', 'UserController@updateFrontProfileCv')->name('update.front.profile.cv');



Route::delete('delete-front-profile-cv', 'UserController@deleteProfileCv')->name('delete.front.profile.cv');



/* * *********************************** */



Route::post('show-front-profile-projects/{id}', 'UserController@showFrontProfileProjects')->name('show.front.profile.projects');



Route::post('show-applicant-profile-projects/{id}', 'UserController@showApplicantProfileProjects')->name('show.applicant.profile.projects');



Route::post('upload-front-project-temp-image', 'UserController@uploadProjectTempImage')->name('upload.front.project.temp.image');



Route::post('get-front-profile-project-form/{id}', 'UserController@getFrontProfileProjectForm')->name('get.front.profile.project.form');



Route::post('store-front-profile-projects/{id}', 'UserController@storeFrontProfileProject')->name('store.front.profile.projects');



Route::post('get-front-profile-project-edit-form1/{user_id}', 'UserController@getFrontProfileProjectEditForm')->name('get.front.profile.project.edit.form1');



Route::put('update-front-profile-projects/{id}', 'UserController@updateFrontProfileProject')->name('update.front.profile.projects');



Route::delete('delete-front-profile-project', 'UserController@deleteProfileProject')->name('delete.front.profile.project');



/* * *********************************** */



Route::post('show-front-profile-experience/{id}', 'UserController@showFrontProfileExperience')->name('show.front.profile.experience');



Route::post('show-applicant-profile-experience/{id}', 'UserController@showApplicantProfileExperience')->name('show.applicant.profile.experience');



Route::post('get-front-profile-experience-form/{id}', 'UserController@getFrontProfileExperienceForm')->name('get.front.profile.experience.form');



Route::post('store-front-profile-experience/{id}', 'UserController@storeFrontProfileExperience')->name('store.front.profile.experience');



Route::post('get-front-profile-experience-edit-form/{id}', 'UserController@getFrontProfileExperienceEditForm')->name('get.front.profile.experience.edit.form');



Route::put('update-front-profile-experience/{profile_experience_id}/{user_id}', 'UserController@updateFrontProfileExperience')->name('update.front.profile.experience');



Route::delete('delete-front-profile-experience', 'UserController@deleteProfileExperience')->name('delete.front.profile.experience');



/* * *********************************** */



Route::post('show-front-profile-education/{id}', 'UserController@showFrontProfileEducation')->name('show.front.profile.education');



Route::post('show-applicant-profile-education/{id}', 'UserController@showApplicantProfileEducation')->name('show.applicant.profile.education');



Route::post('get-front-profile-education-form/{id}', 'UserController@getFrontProfileEducationForm')->name('get.front.profile.education.form');



Route::post('store-front-profile-education/{id}', 'UserController@storeFrontProfileEducation')->name('store.front.profile.education');



Route::post('get-front-profile-education-edit-form/{id}', 'UserController@getFrontProfileEducationEditForm')->name('get.front.profile.education.edit.form');



Route::put('update-front-profile-education/{user_id}', 'UserController@updateFrontProfileEducation')->name('update.front.profile.education');



Route::delete('delete-front-profile-education', 'UserController@deleteProfileEducation')->name('delete.front.profile.education');



/* * *********************************** */



Route::post('show-front-profile-skills/{id}', 'UserController@showProfileSkills')->name('show.front.profile.skills');



Route::post('show-applicant-profile-skills/{id}', 'UserController@showApplicantProfileSkills')->name('show.applicant.profile.skills');



Route::post('get-front-profile-skill-form/{id}', 'UserController@getFrontProfileSkillForm')->name('get.front.profile.skill.form');



Route::post('store-front-profile-skill/{id}', 'UserController@storeFrontProfileSkills')->name('store.front.profile.skill');



Route::post('get-front-profile-skill-edit-form/{id}', 'UserController@getFrontProfileSkillEditForm')->name('get.front.profile.skill.edit.form');



Route::put('update-front-profile-skill/{skill_id}/{user_id}', 'UserController@updateFrontProfileSkill')->name('update.front.profile.skill');



Route::delete('delete-profile-itskill', 'UserController@deleteProfileitSkills')->name('delete.profile.itskill');



/* * *********************************** */



Route::post('show-front-profile-languages/{id}', 'UserController@showProfileLanguage')->name('show.front.profile.languages');



Route::post('show-applicant-profile-languages/{id}', 'UserController@showApplicantProfileLanguages')->name('show.applicant.profile.languages');



Route::post('get-front-profile-language-form/{id}', 'UserController@getFrontProfileLanguageForm')->name('get.front.profile.language.form');



Route::post('store-language-profile/{id}', 'UserController@storeProfileLanguagefront')->name('store.language.profile');



Route::post('update-language-front-profile/{id}', 'UserController@updateFrontProfileLanguage')->name('update.language.front.profile');



Route::post('get-front-profile-language-edit-form/{id}', 'UserController@getFrontProfileLanguageEditForm')->name('get.front.profile.language.edit.form');



Route::put('update-front-profile-language/{language_id}/{user_id}', 'UserController@updateFrontProfileLanguage1')->name('update.front.profile.language'); 



Route::delete('delete-front-profile-language', 'UserController@deleteProfileLanguage')->name('delete.front.profile.language');



Route::post('update-front-profile-np/{id}','UserController@storefrontnp')->name('update.front.profile.np');

Route::post('job-update-front-profile-np/{id}','UserController@jobstorefrontnp')->name('job.update.front.profile.np');




















/*************************************/



Route::post('get-front-itskill-data/{id}','UserController@edititskill')->name('get.front.itskill.data');     







Route::post('update-front-profile-skill/{id}','UserController@updateitskill')->name('update.front.profile.skill');







Route::post('get-front-video-edit-form/{id}', 'UserController@getFrontVideoEditForm')->name('get.front.video.edit.form');







Route::post('get-front-night-edit-form/{id}', 'UserController@getFrontnightEditForm')->name('get.front.night.edit.form');







Route::post('store-user-front-summary/{id}','UserController@storesummary')->name('store.user.front.summary');







Route::get('my-alerts', 'UserController@myAlerts')->name('my-alerts');



Route::get('delete-alert/{id}', 'UserController@delete_alert')->name('delete-alert');







Route::post('store-front-previous-company/{id}','UserController@storefrontpreviouscompany')->name('store.front.previous.company');  



Route::post('store-current-front-company-form/{id}','UserController@storecurrentcompany')->name('store.current.front.company.form'); 



Route::post('store-front-certificate/{id}','UserController@storefrontcertificates')->name('store.front.certificate');



Route::delete('delete-front-certificate-detail', 'UserController@deletecertificates')->name('delete.front.certificate.detail');


Route::post('get-front-certificate-edit-form/{id}','UserController@getfrontcertificateEditForm')->name('get.front.certificate.edit.form');


Route::post('update-front-certificate/{id}','UserController@updatefrontcertificates')->name('update.front.certificate');  



// Route::delete('delete-front-current-company','UserController@deletefrontcompany')->name('delete.front.current.company'); 







Route::post('get-front-current-company-edit-form/{id}','UserController@getcurrentcompanyeditform')->name('get.front.current.company.edit.form'); 



Route::post('get-front-previous-company-edit-form/{id}','UserController@getpreviouscompanyeditform')->name('get.front.previous.company.edit.form');







Route::post('update-current-front-company-form/{id}','UserController@updatecurrentcompany')->name('update.current.front.company.form'); 







Route::post('update-front-previous-company/{id}','UserController@updatepreviouscompany')->name('update.front.previous.company');



Route::post('update-front-offers/{id}','UserController@frontupdateoffers')->name('update.front.offers'); 











Route::post('get-front-skill-search/{id}','userController@getautocompletesearch')->name('get.front.skill.search');    







Route::post('store-front-key-skill/{id}','UserController@storefrontkeyskills')->name('store.front.key.skill');







Route::post('get-front-keyskill-data/{id}','UserController@keyskillfront')->name('get.front.keyskill.data');







Route::post('update-front-key-skill/{id}','UserController@updatefrontkeyskills')->name('update.front.key.skill');











Route::post('store-front-gap/{id}','UserController@storefrontgap')->name('store.front.gap');







Route::post('home-search1','UserController@homesearch1')->name('home.search1');











Route::get('change_password','UserController@changePassword');



Route::post('update_password/{id}','UserController@updatePassword');







// User Listing



Route::get('user_list','UserController@userListing');











Route::post('image-store','UserController@imagestore')->name('image.store');





// Payment Integration Routes 



// Route::post('razorpaypayment', [RazorpayController::class, 'payment'])->name('payment');



// Route::get('razor',function(){

//     return view('razor');


// });

Route::post('paysuccess', 'CheckoutController@stripePaySuccess')->name('paysucess');

Route::get('razor-thank-you', 'RazorpayController@RazorThankYou');

Route::get('razor-payment-failure', 'RazorpayController@paymentfailure');

Route::get('payment-page','CheckoutController@paymentpage')->name('payment.page')->middleware('auth');

Route::post('stripe-form/submit', 'CheckoutController@xpressubmit')->name('stripeSubmit');

Route::get('stripe-response', 'CheckoutController@xpressresponse')->name('stripeResponse');

Route::get('thank-you', 'CheckoutController@StripeThankYou');



Route::get('layoff-payment-page','CheckoutController@stripelayoffpaymentpage')->name('layoff-payment.page');

Route::post('layoffstripe-form/submit', 'CheckoutController@layoffsubmit')->name('layoffstripeSubmit');

Route::post('layoffpaysuccess', 'CheckoutController@stripePaylayoffPaySuccess')->name('layoffpaysuccess');

Route::get('layoffstripe-response', 'CheckoutController@layoffresponse')->name('layoffstripeResponse');

Route::get('/search-companies', 'ActionController@searchcompanies');

Route::get('stripe-form', 'StripeController@form')->name('stripeForm');

Route::post('/check-email', 'ActionController@checkEmail');

Route::get('/search-university', 'ActionController@searchuniversity');

Route::get('/search-skills', 'ActionController@searchskills');


// Route::post('store-front-accomplishment/{id}','UserController@storefrontaccomplishments')->name('store.front.accomplishment');
Route::post('store-front-accomplishment/{id}','UserController@storefrontaccomplishments')->name('store.front.accomplishment');

Route::delete('delete-front-accomplishment-detail', 'UserController@deleteaccomplishments')->name('delete.front.accomplishment.detail');

Route::post('get-front-accomplishment-edit-form/{id}','UserController@getfrontaccomplishmentEditForm')->name('get.front.accomplishment.edit.form');

Route::post('update-front-accomplishment/{id}','UserController@updatefrontaccomplishments')->name('update.front.accomplishment');  




Route::post('store-white-paper','UserController@storewhitepaper')->name('store-white-paper');    



