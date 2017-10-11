<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// Route::group(['middleware' => ['web']], function () {
//     //
// });

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //dashboard
    Route::get('/home', 'Dashboard@index');
    Route::get('/', 'Dashboard@index');

    //customer
    // Route::get('/', 'Bills@index');
    Route::get('/customer', 'Customer@index');
    Route::post('/add-customer', 'Customer@add');
    Route::post('/edit-customer', 'Customer@edit');
    Route::get('/delete-customer/{id}', 'Customer@delete');
    Route::post('/customer-detail', 'Customer@get_customer_detail_by_id');
    Route::get('/customer-report/{id}', 'Customer@report');

    //staff
    Route::get('/staff', 'Staff@index');
    Route::post('/add-staff', 'Staff@add');
    Route::get('/staff-report/{id}', 'Staff@report');

    //items
    Route::get('/item', 'Items@index');
    Route::post('/add-item', 'Items@add');
    Route::post('/edit-item', 'Items@edit');
    Route::get('/delete-item/{id}', 'Items@delete');
    // Route::get('/item-report/{slug}', 'Items@report');
    Route::post('/item-detail','Items@itemDetails');

    //vehicles
    Route::get('/vehicles', 'Vehicles@index');
    Route::post('/add-vehicles', 'Vehicles@add');
    Route::post('/edit-vehicles', 'Vehicles@edit');
    Route::get('/delete-vehicles/{id}', 'Vehicles@delete');
    Route::get('/vehicles-report/{vehiclesNumber}', 'Vehicles@report');

    // bills
     Route::get('/bill', 'Bills@index');
     // Route::post('/bill-add', 'Bills@add');
     Route::get('/bill-view/{id}', 'Bills@view');
     Route::get('/bill-list', 'Bills@bill_list');
     Route::get('/bill-delete/{id}', 'Bills@delete');
     Route::get('/bill-edit/{id}', 'Bills@edit');
     Route::post('/bill-edit-process', 'Bills@edit_process');

     /*bill new*/
    Route::post('/bill-store', 'Bills@store');
    // Route::get('/exits-bill-view', 'Bills@bill_view');
    // Route::get('/entry-bill-view', 'Bills@bill_view');
    // Route::get('/cashonly-bill-view', 'Bills@bill_view');

   //units
    Route::get('/units', 'Units@index');
    Route::post('/add-units', 'Units@add');
    Route::post('/edit-units', 'Units@edit');
    Route::get('/delete-units/{id}', 'Units@delete');
});
