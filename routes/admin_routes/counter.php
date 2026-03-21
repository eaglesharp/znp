<?php


Route::get('counter', array_merge(['uses' => 'Admin\CounterController@indexcounter'], $all_users))->name('counter');

?>