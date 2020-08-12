<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/payment', function () {
    return view('pages.payment');
});

Route::get('/admin/notifications', function () {
    return view('pages.notifications');
})->name('notifications');

Route::get('/user/mark-all-read/', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['message'=>'marked as read'],200);
});


Route::get('/admin/auth/notifications', 'UserController@getNotifications');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('admin/category', 'CategoryController');

Route::resource('admin/room', 'RoomController');

Route::resource('role', 'RoleController');

Route::resource('user', 'UserController');

Route::resource('booking', 'BookingController');


Route::resource('permission', 'PermissionController');

Route::resource('admin/category', 'CategoryController');

Route::get('/admin/password/change', 'UserController@getPassword')->name('password.change');

Route::post('/admin/password/change', 'UserController@postPassword')->name('password.change');


Route::get('/role/create', 'RoleController@createRole')->name('role.createRole');

Route::get('/permission/create', 'PermissionController@createPermission')->name('permission.createPermission');

Route::get('/getPermission', 'PermissionController@getAllPermissions');

Route::get('getRole/{id}', 'RoleController@getAllRole');

Route::post('/saveRole', 'RoleController@store');

Route::put('/editRole/{id}', 'RoleController@update');







/////////////////axois routes

Route::get('/get/categories', 'CategoryController@getIndex');

Route::post('/post/categories', 'CategoryController@postIndex');

Route::put('/put/categories/{id}', 'CategoryController@update');

Route::delete('/delete/categories/{id}', 'CategoryController@destroy');



Route::get('/get/room', 'RoomController@getIndex');

Route::get('/get/room/search/{search}', 'RoomController@search');

Route::post('/post/room', 'RoomController@store');

Route::get('/get/room/available', 'RoomController@getAvailable');

Route::put('/put/room/{id}', 'RoomController@update');

Route::delete('/delete/room/{id}', 'RoomController@destroy');



Route::get('/get/user', 'UserController@getIndex');

Route::get('/get/user/customer', 'UserController@getCustomer');

Route::get('/get/user/admin', 'UserController@getAdmin');

Route::get('/get/user/search/{search}', 'UserController@search');


Route::get('/get/booking', 'BookingController@getIndex');


