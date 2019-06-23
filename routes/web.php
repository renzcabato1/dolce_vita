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

Route::get('/',  'UserController@login');

Auth::routes();
Route::group( ['middleware' => 'auth'], function()
{
Route::get('/',  'UserController@login');
Route::get('/home', 'UserController@login');
Route::get('/profile', 'UserController@view_profile');
Route::post('/change-password','UserController@change_password');
Route::post('/new-hmo','ClientController@new_client');
Route::post('/new-car','CareceiptController@new_car');
Route::post('/edit-hmo/{id}','ClientController@edit_client');
Route::post('/new-user','UserController@new_user');
Route::get('/hmo', 'ClientController@clients_view');
Route::get('/user-accounts', 'UserController@view_users');
Route::get('/soa-report','ClientController@view_soa');
Route::get('/soa-pdf/{id}','PaymentController@view_soa_pdf');
Route::get('/ca-receipt','CareceiptController@view_ca_receipt');
Route::get('/car-pdf/{id}','CareceiptController@car_pdf');
Route::post('/edit-car/{id}','CareceiptController@save_edit_car');
Route::get('/soa','PaymentController@soa');
Route::get('/print-soa-pdf','PaymentController@print_all_soa');
Route::post('/generate-soa','PaymentController@generate_soa');
Route::post('/edit-soa/{id}','PaymentController@save_edit_soa');
Route::post('/add-payment/{id}','PaymentController@add_payment');
Route::post('/edit-payment/{id}','PaymentController@save_edit_payment');
Route::get('/summary-report','PaymentController@summary_report');
Route::get('/obr-report','PaymentController@obr_report');
Route::get('/obr-report-pdf','PaymentController@obr_report_pdf');
Route::get('/payment-report','PaymentController@payment_report_pdf');
Route::get('/disbursement-report','PaymentController@disbursement_report');
Route::get('/payment','PaymentController@payment_show');
Route::get('/get-client-infor','PaymentController@client_view_infor');
Route::get('/delete-payment/{payment_id}','PaymentController@delete_payment');
Route::post('add-payment','PaymentController@new_payment');
Route::get('/ledger','LedgerController@view_ledger');
Route::get('/disbursement','DisbursementController@disbursement');
Route::post('add-disbursement','DisbursementController@new_disbursement');
Route::get('/delete-disbursement/{id}','DisbursementController@delete_disbursement');
Route::get('/disbursement-report-a','DisbursementController@disbursement_a');
Route::get('/disbursement-report-a-b','PaymentController@disbursement_report_a_b');
});