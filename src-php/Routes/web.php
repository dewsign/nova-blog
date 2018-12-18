<?php

/**
 * Blog Routes
 */
Route::middleware('web')->prefix('blog')->name('blog.')->group(function () {
    Route::get('/', 'Dewsign\NovaBlog\Http\Controllers\BlogController@index')->name('index');
    Route::get('{category}', 'Dewsign\NovaBlog\Http\Controllers\BlogController@list')->name('list');
    Route::get('{category}/{article}', 'Dewsign\NovaBlog\Http\Controllers\BlogController@show')->name('show');
});
