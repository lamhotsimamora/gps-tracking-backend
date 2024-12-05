<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin',function(){
    return view("admin");
});

Route::get('/admin-data',function(){
    return view("admin-data");
});

Route::post('/admin-load-data-map', [AdminController::class, 'loadDataMap']);

Route::post('/user-add-coordinate', [UserController::class, 'addCoordinate']);

Route::post('/admin-load-all-data-map', [AdminController::class, 'loadAllDataMap']);


Route::post('/admin-api-delete-tracking', [AdminController::class, 'deleteTracking']);