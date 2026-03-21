<?php

/* * ******  Country Start ********** */
Route::get('list-countries', array_merge(['uses' => 'Admin\CountryController@indexCountries'], $all_users))->name('list.countries');
Route::get('create-country', array_merge(['uses' => 'Admin\CountryController@createCountry'], $all_users))->name('create.country');
Route::post('store-country', array_merge(['uses' => 'Admin\CountryController@storeCountry'], $all_users))->name('store.country');
Route::get('edit-country/{id}', array_merge(['uses' => 'Admin\CountryController@editCountry'], $all_users))->name('edit.country');
Route::put('update-country/{id}', array_merge(['uses' => 'Admin\CountryController@updateCountry'], $all_users))->name('update.country');
Route::delete('delete-country', array_merge(['uses' => 'Admin\CountryController@deleteCountry'], $all_users))->name('delete.country');
Route::get('fetch-countries', array_merge(['uses' => 'Admin\CountryController@fetchCountriesData'], $all_users))->name('fetch.data.countries');
Route::put('make-active-country', array_merge(['uses' => 'Admin\CountryController@makeActiveCountry'], $all_users))->name('make.active.country');
Route::put('make-not-active-country', array_merge(['uses' => 'Admin\CountryController@makeNotActiveCountry'], $all_users))->name('make.not.active.country');
Route::get('sort-countries', array_merge(['uses' => 'Admin\CountryController@sortCountries'], $all_users))->name('sort.countries');
Route::get('country-sort-data', array_merge(['uses' => 'Admin\CountryController@countrySortData'], $all_users))->name('country.sort.data');
Route::put('country-sort-update', array_merge(['uses' => 'Admin\CountryController@countrySortUpdate'], $all_users))->name('country.sort.update');
/* * ****** End Country ********** */

Route::get('list-locations', array_merge(['uses' => 'Admin\CountryController@indexLocations'], $all_users))->name('list.locations');
Route::post('create-location', array_merge(['uses' => 'Admin\CountryController@createlocation'], $all_users))->name('create.location');
Route::get('edit-location/{id}', array_merge(['uses' => 'Admin\CountryController@editlocation'], $all_users))->name('edit.location');
Route::get('delete-location/{id}', array_merge(['uses' => 'Admin\CountryController@deletelocation'], $all_users))->name('delete.location');

Route::get('create-category-location', array_merge(['uses' => 'Admin\CountryController@indexcategoryLocations'], $all_users))->name('create.category.location');
Route::post('create-category-location', array_merge(['uses' => 'Admin\CountryController@createcategoryLocations'], $all_users))->name('location.category.create');
Route::get('category-edit-location/{id}', array_merge(['uses' => 'Admin\CountryController@editcategorylocation'], $all_users))->name('edit.category.location');
Route::get('category-delete-location/{id}', array_merge(['uses' => 'Admin\CountryController@deletecategorylocation'], $all_users))->name('delete.category.location');