<?php

include '../app/Helpers/RouterOS.php';

if (isset($_POST)) {
    
    $ip = $_POST['ip'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $port = $_POST['port'];

    $API = new App\Helpers\RouterOS();

    $API->debug = false;

    if ($API->connect($ip, $username, $password,$port)) {
        $API->write('/interface/print');

        $READ = $API->read(false);
        $ARRAY = $API->parseResponse($READ);

        echo json_encode($ARRAY);

        $API->disconnect();
    }
}
