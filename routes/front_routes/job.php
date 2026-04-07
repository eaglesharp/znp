<?php

Route::get('apply/{slug}', 'Job\JobController@applyJob')->name('apply.job');
Route::post('apply/{slug}', 'Job\JobController@postApplyJob')->name('post.apply.job');

Route::get('add-to-favourite-job/{job_slug}', 'Job\JobController@addToFavouriteJob')->name('add.to.favourite');
Route::get('remove-from-favourite-job/{job_slug}', 'Job\JobController@removeFromFavouriteJob')->name('remove.from.favourite');
Route::get('my-favourite-jobs', 'Job\JobController@myFavouriteJobs')->name('my.favourite.jobs');





Route::get('job-seekers', 'Job\JobSeekerController@jobSeekersBySearch')->name('job.seeker.list');


Route::post('submit-message', 'Job\SeekerSendController@submit_message')->name('submit-message');

Route::get('subscribe-alert', 'SubscriptionController@submitAlert')->name('subscribe.alert');


//Employer Module

Route::view('post-job','company.job.post-job');

Route::post('store-front-job', 'Job\JobPublishController@storeFrontJob')->name('store.front.job');

Route::get('edit-front-job/{id}', 'Job\JobPublishController@editFrontJob')->name('edit.front.job');

Route::get('clone-front-job/{id}', 'Job\JobPublishController@cloneFrontJob')->name('clone.front.job');

Route::post('clone-front-job/{id}', 'Job\JobPublishController@clonestoreFrontJob')->name('clone.front.job');

Route::put('update-front-job/{id}', 'Job\JobPublishController@updateFrontJob')->name('update.front.job');

Route::delete('delete-front-job', 'Job\JobPublishController@deleteJob')->name('delete.front.job');

Route::get('my-jobs','Job\JobPublishController@myFrontJob')->name('my-jobs');

Route::get('make-active-job','Job\JobPublishController@makeActiveJob')->name('make.active.job');

Route::get('view-applicants-list/{id}', 'Job\JobPublishController@viewApplicants')->name('view.applicants.list');
Route::get('view-applicants-profile/{job_id}/{id}', 'Job\JobPublishController@viewApplicantProfile')->name('view.applicant.profile');



//User module  

Route::get('jobs', 'Job\JobController@jobs')->name('job.list');

Route::get('jobs-page', 'Job\JobController@jobsPage')->name('jobs.page');
Route::get('jobs-autocomplete', 'Job\JobController@jobsAutocomplete')->name('jobs.autocomplete');

Route::get('job/{slug}', 'Job\JobController@jobDetail')->name('job.detail');
Route::get('job-detail/{slug}', 'Job\JobController@jobDetailZnp')->name('job.detail.znp');

Route::post('applyjob', 'Job\JobController@postApplyJob')->name('post.apply.job');

Route::view('applied-jobs', 'Job\JobController@jobs')->name('job.list');

Route::get('my-job-applications', 'Job\JobController@myJobApplications')->name('my.job.applications');


