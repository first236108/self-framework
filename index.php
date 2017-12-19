<?php
define('IS_POST', $_SERVER['REQUEST_METHOD']=='POST'? TRUE:FALSE);
define('BASEDIR', dirname(__FILE__));
include_once(BASEDIR."/lib/Route.class.php");
include_once(BASEDIR."/lib/Dispatcher.class.php");

try{
    $route = new Route();
    $dis = new Dispatcher($route);
    $dis->dispatch();
}catch(Exception $e){
    echo "Failed: " . $e->getMessage();
}