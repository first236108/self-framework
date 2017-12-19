<?php
header('Access-Control-Allow-Origin:*');
define('BASEDIR', dirname(__FILE__));
require_once BASEDIR."/lib/jssdk.php";
error_reporting(E_ALL^E_WARNING^E_NOTICE);
try{
    $url = urldecode($_POST['url']);
    if($url=filter_var($_POST['url'],FILTER_VALIDATE_URL)){
        $jssdk = new JSSDK("wxd61e5ed1a5c7b8b5", "cdcb1b56897754fb0459ba962bd01bba",$url);
        $signPackage = $jssdk->GetSignPackage();
        //unset($signPackage['rawString'],$signPackage['url']);
        echo json_encode($signPackage);exit;
    }

    echo "参数错误";exit;

}catch(Exception $e){
    echo "Failed: " . $e->getMessage();
}