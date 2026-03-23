<?php

Route::get('counter',  array_merge(['uses' => 'Admin\CounterController@indexcounter'],  $all_users))->name('counter');
Route::post('counter', array_merge(['uses' => 'Admin\CounterController@storecounter'],  $all_users))->name('store.counter');

?>