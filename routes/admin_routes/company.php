<?php

/* * ******  Company Start ********** */
Route::get('list-companies', array_merge(['uses' => 'Admin\CompanyController@indexCompanies'], $all_users))->name('list.companies');
Route::get('list-employers', array_merge(['uses' => 'Admin\CompanyController@indexEmployer'], $all_users))->name('list.employers');

Route::get('create-company', array_merge(['uses' => 'Admin\CompanyController@createCompany'], $all_users))->name('create.company');
Route::post('store-company', array_merge(['uses' => 'Admin\CompanyController@storeCompany'], $all_users))->name('store.company');
Route::get('edit-company/{id}', array_merge(['uses' => 'Admin\CompanyController@editCompany'], $all_users))->name('edit.company');
Route::put('update-company/{id}', array_merge(['uses' => 'Admin\CompanyController@updateCompany'], $all_users))->name('update.company');
Route::delete('delete-company', array_merge(['uses' => 'Admin\CompanyController@deleteCompany'], $all_users))->name('delete.company');
// Route::delete('delete.enquiry', array_merge(['uses' => 'Admin\CompanyController@deleteEnquiry'], $all_users))->name('delete.enquiry');
Route::get('register-employer/{id}', array_merge(['uses' => 'Admin\CompanyController@registerEmployer'], $all_users))->name('register.employer');

Route::get('fetch-companies', array_merge(['uses' => 'Admin\CompanyController@fetchCompaniesData'], $all_users))->name('fetch.data.companies');
Route::put('make-active-company', array_merge(['uses' => 'Admin\CompanyController@makeActiveCompany'], $all_users))->name('make.active.company');
Route::put('make-not-active-company', array_merge(['uses' => 'Admin\CompanyController@makeNotActiveCompany'], $all_users))->name('make.not.active.company');
Route::put('make-featured-company', array_merge(['uses' => 'Admin\CompanyController@makeFeaturedCompany'], $all_users))->name('make.featured.company');
Route::put('make-not-featured-company', array_merge(['uses' => 'Admin\CompanyController@makeNotFeaturedCompany'], $all_users))->name('make.not.featured.company');

Route::post('adminsendbulkemail', array_merge(['uses' => 'Admin\CompanyController@sendbulkemail'], $all_users))->name('email.adminsendbulkemail');



// Route::delete('delete-enquiry', array_merge(['uses' => 'Admin\CompanyController@deleteEnquiry'], $all_users))->name('delete.enquiry');

Route::get('enquiry/{id}', array_merge(['uses' => 'Admin\CompanyController@deleteEnquiry'], $all_users))->name('enquiry');

Route::get('employer-payment-history',array_merge(['uses' => 'Admin\CompanyController@employerpaymenthistory'], $all_users))->name('employer.payment.history');

Route::get('employer-payment-history-section',array_merge(['uses' => 'Admin\CompanyController@adminemployerpaymenthistory'], $all_users))->name('admin.employer.payment.history');

Route::post('change-invoice-status',array_merge(['uses' => 'Admin\CompanyController@changeStatus'], $all_users))->name('change.invoice.status');
/* * ****** End Company ********** */


Route::get('employer-activities',array_merge(['uses' => 'Admin\CompanyController@employeractivities'], $all_users))->name('employer.activities');

Route::post('get-company-data', 'ActionController@getcompanydata')->name('get-company-data');


Route::put('make-freeze-company', array_merge(['uses' => 'Admin\CompanyController@makeFreezeCompany'], $all_users))->name('make.freeze.company');
Route::put('make-not-freeze-company', array_merge(['uses' => 'Admin\CompanyController@makeNotFreezeCompany'], $all_users))->name('make.not.freeze.company');


Route::get('kyc-documents', array_merge(['uses' => 'Admin\CompanyController@kycdocuments'], $all_users))->name('kyc-documents.list');
Route::get('kyc-document-download/{filename}', array_merge(['uses' => 'Admin\CompanyController@kycdocumentdownload'], $all_users))->name('kyc-document-download');

Route::get('kyc-document-status/{id}', array_merge(['uses' => 'Admin\CompanyController@kycdocumentstatus'], $all_users))->name('kyc-document-status');
Route::get('kyc-document-status/{id}/{status}', array_merge(['uses' => 'Admin\CompanyController@kycdocumentstatus'], $all_users))->name('kyc-document-status');
 