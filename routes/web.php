<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/automailer', function () {
    return view('automailer');
})->name('automailer');


// Main Controller
Route::get('/view_tablet', 'TabletController@view_tablet')->name('view_tablet');
Route::post('/add_tablet', 'TabletController@add_tablet')->name('add_tablet');
Route::get('/view_change_request', 'TabletController@view_change_request')->name('view_change_request');
Route::get('/get_tablet_by_id', 'TabletController@get_tablet_by_id')->name('get_tablet_by_id');
Route::get('/download_file/{id}', 'TabletController@download_file')->name('download_file');

Route::get('/get_data', 'TabletController@get_data')->name('get_data');
Route::get('/send_mail_for_testing', 'TabletController@send_mail_for_testing')->name('send_mail_for_testing');//BY CDP

Route::post('/tablet_select_approver', 'TabletController@tablet_select_approver')->name('tablet_select_approver');
Route::post('/tablet_approved_disapproved', 'TabletController@tablet_approved_disapproved')->name('tablet_approved_disapproved');

// RapidX Controller
Route::get('/get_rapidx_users', 'RapidXUserController@get_rapidx_users');
Route::get('/get_section', 'RapidXUserController@get_section');
Route::get('/get_programmer', 'RapidXUserController@get_programmer');
Route::get('/get_cbo_rapidx_users', 'RapidXUserController@get_cbo_rapidx_users')->name('get_cbo_rapidx_users');

// Import Controller
Route::post('/import_tablet', 'ImportController@import_tablet');


// Export Tablet Controller
Route::get('/export_tablet_data/{month}/{year}', 'ExportTabletController@export_tablet_data');

// Scanning Controller
Route::get('/scanning_check_data', 'ScanningController@scanning_check_data');
