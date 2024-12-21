<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Helpers\RouterOS;
use Illuminate\Http\Request;
use App\Http\Middleware\SessionMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use \RouterOS\Client;
use \RouterOS\Query;


function _md5($string){
    return md5(strlen($string).$string.strlen($string));
}

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/login-user',function(Request $request){
    $admins = $request->session()->get('users');
    if ($admins){
        return redirect('users');
    }
    return view("users/login");
});

Route::get('/users',function(){
    return view("users/users");
})->middleware(UserMiddleware::class);

Route::get('/login-admin',function(Request $request){
    $admins = $request->session()->get('admins');
    if ($admins){
        return redirect('admin');
    }
    return view("login");
});

Route::get('/admin',function(){
    return view("admin");
})->middleware(AdminMiddleware::class);

Route::get('/admin-data',function(){
    return view("admin-data");
})->middleware(AdminMiddleware::class);

Route::get('/admin-user',function(){
    return view("admin-user");
})->middleware(AdminMiddleware::class);

Route::get('/login-mikrotik',function(Request $request){
    // if ($request->session()->has('ip')) {
    //     return redirect('/mikrotik-dashboard');
    // }

    $data = array('ip' => $request->session()->get('ip'),
                'username'=>$request->session()->get('username'),
                'password'=>$request->session()->get('password'),
                'port'=>$request->session()->get('port'));

    return view("login-mikrotik",$data);
})->middleware(AdminMiddleware::class);

Route::post('/admin-load-data-map', [AdminController::class, 'loadDataMap'])->middleware(AdminMiddleware::class);

Route::post('/user-add-coordinate', [UserController::class, 'addCoordinate']);

Route::post('/admin-api-add-user', [AdminController::class, 'addUser'])->middleware(AdminMiddleware::class);

Route::post('/admin-load-all-data-map', [AdminController::class, 'loadAllDataMap'])->middleware(AdminMiddleware::class);

Route::post('/user-load-all-data-map', [UserController::class, 'loadAllData'])->middleware(UserMiddleware::class);

Route::post('/admin-load-all-data-user', [AdminController::class, 'loadAllUser'])->middleware(AdminMiddleware::class);

Route::post('/admin-api-delete-tracking', [AdminController::class, 'deleteTracking'])->middleware(SessionMiddleware::class);

Route::post('/admin-api-delete-user', [AdminController::class, 'deleteUser'])->middleware(AdminMiddleware::class);


Route::post('/api-login-user-android', [UserController::class, 'loginUserAndroid']);


Route::post('/api-login-admin', [AdminController::class, 'loginAdmin']);

Route::post('/api-login-users', [UserController::class, 'loginUserWeb']);

Route::get('/mikrotik-dashboard', function (Request $request) {
    $datetime =  now();

    $data = array('ip' => $request->session()->get('ip'),
                    'datetime'=>$datetime,
                    'username'=>$request->session()->get('username'),
                    'password'=>$request->session()->get('password'),
                    'port'=>$request->session()->get('port'));
   
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

Route::post('/api-load-cpu', function (Request $request) {

    $ip = $request->session()->get('ip');
    $username = $request->session()->get('username');
    $password = $request->session()->get('password');
    $port = $request->session()->get('port');
    $port = (int) $port;

    $client = new Client([
        'host' => $ip,
        'user' => $username,
        'pass' => $password,
        'port' => $port,
    ]);

    $query =(new Query('/system/resource/print'));

    $response = $client->query($query)->read();
    echo json_encode($response);

})->middleware(SessionMiddleware::class);

Route::post('/api-load-date', function (Request $request) {

    $ip = $request->session()->get('ip');
    $username = $request->session()->get('username');
    $password = $request->session()->get('password');
    $port = $request->session()->get('port');
    $port = (int) $port;

    $client = new Client([
        'host' => $ip,
        'user' => $username,
        'pass' => $password,
        'port' => $port,
    ]);

    $query =(new Query('/system/clock/print'));

    $response = $client->query($query)->read();
    echo json_encode($response);

})->middleware(SessionMiddleware::class);

Route::post('/api-load-interface', function (Request $request) {

        $ip = $request->session()->get('ip');
        $username = $request->session()->get('username');
        $password = $request->session()->get('password');
        $port = $request->session()->get('port');
        $port = (int) $port;

        $client = new Client([
            'host' => $ip,
            'user' => $username,
            'pass' => $password,
            'port' => $port,
        ]);

        $query =(new Query('/interface/print'));

        $response = $client->query($query)->read();
        echo json_encode($response);
  
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


            $ftx = $getinterfacetraffic[0]['tx-bits-per-second'];
            $frx = $getinterfacetraffic[0]['rx-bits-per-second'];

            $data = array('tx'=>$ftx,'rx'=>$frx);
            
            $API->disconnect();

            echo json_encode($data);
    }
})->middleware(SessionMiddleware::class);

Route::get('/logout-mikrotik', function (Request $request) {
    
    return redirect('/login-mikrotik');
});

Route::get('/logout-app-admin', function (Request $request) {
    $request->session()->forget('admins');
    return redirect('/login-admin');
});

Route::get('/logout-app-user', function (Request $request) {
    $request->session()->forget('users');
    $request->session()->forget('id_user');
    return redirect('/login-user');
});

Route::get('/login-mikrotik-user',function(Request $request){
    // if ($request->session()->has('ip_user')) {
    //     return redirect('/users-mikrotik-dashboard');
    // }
    $data = array('ip' => $request->session()->get('ip_user'),
                    'username'=>$request->session()->get('username_user'),
                    'password'=>$request->session()->get('password_user'),
                    'port'=>$request->session()->get('port_user'));
    return view("users.login-user-mikrotik",$data);
});

Route::get('/users-mikrotik-dashboard',function(Request $request){
    $datetime =  now();
    $data = array('ip' => $request->session()->get('ip_user'),
                    'datetime'=>$datetime,
                    'username'=>$request->session()->get('username_user'),
                    'password'=>$request->session()->get('password_user'),
                    'port'=>$request->session()->get('port_user'));

    return view("users/dashboard-mikrotik-user",$data);
})->middleware(UserMiddleware::class);

Route::post('/api-login-mikrotik-user', function (Request $request) {
    $ip = $request->input('ip');
    $username = $request->input('username');
    $password = $request->input('password');
    $port = $request->input('port');

    $API = new RouterOS();

    $API->debug = false;

    $data['result'] = false;
    if ($API->connect($ip, $username, $password, $port)) {
        $data['result'] = true;
        session(['ip_user' => $ip]);
        session(['username_user' => $username]);
        session(['password_user' => $password]);
        session(['port_user' => $port]);
    }
    echo json_encode($data);
    
});

Route::get('/logout-mikrotik-user', function (Request $request) {
    
    return redirect('/login-mikrotik-user');
});


Route::post('/api-load-cpu-user', function (Request $request) {

    $ip = $request->session()->get('ip_user');
    $username = $request->session()->get('username_user');
    $password = $request->session()->get('password_user');
    $port = $request->session()->get('port_user');
    $port = (int) $port;

    $client = new Client([
        'host' => $ip,
        'user' => $username,
        'pass' => $password,
        'port' => $port,
    ]);

    $query =(new Query('/system/resource/print'));

    $response = $client->query($query)->read();
    echo json_encode($response);

})->middleware(UserMiddleware::class);

Route::post('/api-load-date-user', function (Request $request) {

    $ip = $request->session()->get('ip_user');
    $username = $request->session()->get('username_user');
    $password = $request->session()->get('password_user');
    $port = $request->session()->get('port_user');
    $port = (int) $port;

    $client = new Client([
        'host' => $ip,
        'user' => $username,
        'pass' => $password,
        'port' => $port,
    ]);

    $query =(new Query('/system/clock/print'));

    $response = $client->query($query)->read();
    echo json_encode($response);

})->middleware(UserMiddleware::class);

Route::post('/api-load-interface-user', function (Request $request) {

        $ip = $request->session()->get('ip_user');
        $username = $request->session()->get('username_user');
        $password = $request->session()->get('password_user');
        $port = $request->session()->get('port_user');
        $port = (int) $port;

        $client = new Client([
            'host' => $ip,
            'user' => $username,
            'pass' => $password,
            'port' => $port,
        ]);

        $query =(new Query('/interface/print'));

        $response = $client->query($query)->read();
        echo json_encode($response);
  
})->middleware(UserMiddleware::class);

Route::post('api-load-traffic-user',function(Request $request){
    $API = new RouterOS();

    $API->debug = false;

    $ip = $request->session()->get('ip_user');
    $username = $request->session()->get('username_user');
    $password = $request->session()->get('password_user');
    $port =$request->session()->get('port_user');
    $ethernet = $request->input('ethernet');

    if ($API->connect($ip, $username, $password, $port)) {
        $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array(
            "interface" => $ethernet,
            "once" => "",
            ));


            $ftx = $getinterfacetraffic[0]['tx-bits-per-second'];
            $frx = $getinterfacetraffic[0]['rx-bits-per-second'];

            $data = array('tx'=>$ftx,'rx'=>$frx);
            
            $API->disconnect();

            echo json_encode($data);
    }
})->middleware(UserMiddleware::class);
