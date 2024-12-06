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

Route::get('/login-mikrotik',function(Request $request){
    if ($request->session()->has('ip')) {
        return redirect('/mikrotik-dashboard');
    }
    return view("login-mikrotik");
});

Route::post('/admin-load-data-map', [AdminController::class, 'loadDataMap']);

Route::post('/user-add-coordinate', [UserController::class, 'addCoordinate']);

Route::post('/admin-load-all-data-map', [AdminController::class, 'loadAllDataMap']);

Route::post('/admin-api-delete-tracking', [AdminController::class, 'deleteTracking']);

Route::get('/mikrotik-dashboard', function (Request $request) {
    $datetime =  now();

    $data = array('ip' => $request->session()->get('ip'),'datetime'=>$datetime);
   
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

Route::get('/time',function(){
    return date('Y:m:d').' '.date('H:i');
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
    
})->middleware(SessionMiddleware::class);

Route::post('api-load-traffic',function(Request $request){
    $API = new RouterOS();

    $API->debug = false;

    $ip = $request->session()->get('ip');
    $username = $request->session()->get('username');
    $password = $request->session()->get('password');
    $port =$request->session()->get('port');
    $ethernet = $request->input('ethernet');

    if ($API->connect($ip, $username, $password, $port)) {
        $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array(
            "interface" => $ethernet,
            "once" => "",
            ));

            $rows = array(); $rows2 = array();

            $ftx = $getinterfacetraffic[0]['tx-bits-per-second'];
            $frx = $getinterfacetraffic[0]['rx-bits-per-second'];

            $data = array('tx'=>$ftx,'rx'=>$frx);
            
            $API->disconnect();

            echo json_encode($data);
    }
})->middleware(SessionMiddleware::class);

Route::get('/logout-mikrotik', function () {
    session()->flush();
    return redirect('/login-mikrotik');
});
