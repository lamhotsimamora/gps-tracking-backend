<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Helpers\RouterOS;
use Illuminate\Http\Request;
use App\Http\Middleware\SessionMiddleware;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin',function(){
    return view("admin");
});

Route::get('/admin-data',function(){
    return view("admin-data");
});

Route::get('/login-mikrotik',function(){
    return view("login-mikrotik");
});

Route::post('/admin-load-data-map', [AdminController::class, 'loadDataMap']);

Route::post('/user-add-coordinate', [UserController::class, 'addCoordinate']);

Route::post('/admin-load-all-data-map', [AdminController::class, 'loadAllDataMap']);

Route::post('/admin-api-delete-tracking', [AdminController::class, 'deleteTracking']);

Route::get('/mikrotik-dashboard', function (Request $request) {
    $data = array('ip' => $request->session()->get('ip'));
    return view('mikrotik-dashboard', $data);
})->middleware(SessionMiddleware::class);

Route::post('/api-login-mikrotik', function (Request $request) {
    $ip = $request->input('ip');
    $username = $request->input('username');
    $password = $request->input('password');
    $port = $request->input('port');

    $API = new RouterOS();

    $API->debug = false;

    $data['result'] = false;
    if ($API->connect($ip, $username, $password, $port)) {
        $data['result'] = true;
        session(['ip' => $ip]);
        session(['username' => $username]);
        session(['password' => $password]);
        session(['port' => $port]);
    }
    echo json_encode($data);
    
});

Route::post('/api-load-interface', function (Request $request) {
  
    $API = new RouterOS();

    $API->debug = false;

    $ip = $request->session()->get('ip');
    $username = $request->session()->get('username');
    $password = $request->session()->get('password');
    $port =$request->session()->get('port');

    if ($API->connect($ip, $username, $password, $port)) {
            $API->write('/interface/print');

            $READ = $API->read(false);
            $ARRAY = $API->parseResponse($READ);

            echo json_encode($ARRAY);

            $API->disconnect();
    }
    
});