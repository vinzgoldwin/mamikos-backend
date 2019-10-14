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


Route::get('/owner/all', 'OwnerController@index'); //route to show all owner_user data
Route::get('/owner/{id}', 'OwnerController@show'); //route to show specific owner_user data
Route::post('/create-owner', 'OwnerController@store'); //route to create owner
Route::put('/update-owner/{id}', 'OwnerController@update'); //route to update owner profile
Route::post('/create-kost', 'OwnerController@store_Kost'); //route to create a kost using owner email password for authentication
Route::put('/update-kost/{id}', 'OwnerController@update_kost'); //route to update a kost using owner email password for authentication
Route::delete('delete-kost/{id}', 'OwnerController@delete_kost'); //route to delete a kost using owner email password for authentication

Route::get('/customer/all', 'CustomerController@index'); //route to show all customer_user data
Route::get('/customer/{id}', 'CustomerController@show'); //route to show specific customer_user data
Route::get('/customer/kost', 'CustomerController@show_kost'); //route to show all kost
Route::post('/create-customer', 'CustomerController@store'); //route to create customer
Route::get('/customer/search-city', 'CustomerController@filter_city'); //route to search kost based on city
Route::get('/customer/search-kost-name', 'CustomerController@filter_name');  //route to search kost based on kost_name
Route::get('/customer/search-price', 'CustomerController@filter_price'); //route to search kost based on price
Route::get('/customer/sort-price', 'CustomerController@sort_price'); //route to sort all kost from lowest price to highest
Route::get('/customer/kost/{id}', 'CustomerController@show_kost_room'); //route to show a kost and show its avail_room_count(charge 5 credit from customer)


// Route::put('update-customer/{id}', 'CustomerController@update');
// Route::delete('delete-customer/{id}', 'CustomerController@delete');

// Route::get('kost', 'KostController@index');
// Route::get('kost/{id}', 'KostController@show');
// Route::post('create-kost', 'KostController@store');
// Route::put('update-kost/{id}', 'KostController@update');
// Route::delete('delete-kost/{id}', 'KostController@delete');


