<?php

/* * ******  Job Start ********** */
Route::get('list-jobs', array_merge(['uses' => 'Admin\JobController@indexJobs'], $all_users))->name('list.jobs');
Route::get('bulk-jobs-upload', array_merge(['uses' => 'Admin\JobController@bulkJobsUpload'], $all_users))->name('bulk.jobs.upload');
Route::get('bulk-jobs-template', array_merge(['uses' => 'Admin\JobController@downloadJobsTemplate'], $all_users))->name('bulk.jobs.template');
Route::post('bulk-jobs-import', array_merge(['uses' => 'Admin\JobController@bulkJobsImport'], $all_users))->name('bulk.jobs.import');
Route::get('jobs-grid', array_merge(['uses' => 'Admin\JobController@jobsGrid'], $all_users))->name('jobs.grid');
Route::post('jobs-grid', array_merge(['uses' => 'Admin\JobController@storeJobsGrid'], $all_users))->name('jobs.grid.store');
Route::get('create-job', array_merge(['uses' => 'Admin\JobController@createJob'], $all_users))->name('create.job');
Route::post('store-job', array_merge(['uses' => 'Admin\JobController@storeJob'], $all_users))->name('store.job');
Route::get('edit-job/{id}', array_merge(['uses' => 'Admin\JobController@editJob'], $all_users))->name('edit.job');
Route::put('update-job/{id}', array_merge(['uses' => 'Admin\JobController@updateJob'], $all_users))->name('update.job');
Route::delete('delete-job', array_merge(['uses' => 'Admin\JobController@deleteJob'], $all_users))->name('delete.job');
Route::get('fetch-jobs', array_merge(['uses' => 'Admin\JobController@fetchJobsData'], $all_users))->name('fetch.data.jobs');
// Route::put('make-active-job', array_merge(['uses' => 'Admin\JobController@makeActiveJob'], $all_users))->name('make.active.job');
Route::put('make-not-active-job', array_merge(['uses' => 'Admin\JobController@makeNotActiveJob'], $all_users))->name('make.not.active.job');
Route::put('make-featured-job', array_merge(['uses' => 'Admin\JobController@makeFeaturedJob'], $all_users))->name('make.featured.job');
Route::put('make-not-featured-job', array_merge(['uses' => 'Admin\JobController@makeNotFeaturedJob'], $all_users))->name('make.not.featured.job');
/* * ****** End Job ********** */