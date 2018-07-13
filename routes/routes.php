<?php

/*
|--------------------------------------------------------------------------
| Widgets Routes
|--------------------------------------------------------------------------
|
| This file is where you may override any of the routes that are included
| with ...
|
*/

Route::group(['as' => 'widget.'], function () {
	
	  event('widget.routing', app('router'));
	  
	$namespacePrefix = '\\'.config('widgets.controllers.namespace').'\\';
	
	Route::get('widget',['uses'=> $namespacePrefix.'WidgetController@index'])->name('widget');
    Route::post('widget',['uses'=> $namespacePrefix.'WidgetController@update'])->name('widget');
    Route::post('widget/delete',['uses'=> $namespacePrefix.'WidgetController@delete'])->name('widget.delete');
    Route::post('widget/create',['uses'=> $namespacePrefix.'WidgetController@create'])->name('widget.create');
    Route::post('widget/sort',['uses'=> $namespacePrefix.'WidgetController@sort'])->name('widget.sort');
    Route::post('widget/drag',['uses'=> $namespacePrefix.'WidgetController@drag'])->name('widget.drag');
    Route::post('widget/fileUpload',['uses'=> $namespacePrefix.'WidgetController@fileUpload'])->name('widget.fileUpload');
    Route::delete('widget/fileDelete/{uuid}',['uses'=> $namespacePrefix.'WidgetController@fileDelete'])->name('widget.fileDelete');
});