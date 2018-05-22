<?php
use Library\Route;

Route::get('/', 'Index::index');

//Route::group(['middleware'], function (){
//    Route::get('/', 'Index::index');
//    Route::get('/', 'Index::index');
//    Route::group([], function (){
//        Route::get('/', 'Index::index')->middleware(['middleware']);
//        Route::get('/', 'Index::index')->validate(['validate']);
//    });
//});