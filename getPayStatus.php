<?php
header('content-type:text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*');
define('BASEDIR', dirname(__FILE__));
include_once(BASEDIR."/lib/DB.class.php");
error_reporting(E_ALL^E_WARNING^E_NOTICE);
$dbset = array(
    'dsn'       => 'mysql:host=rdsproxy56.rdsprwt7mveezzq.rds.bj.baidubce.com;dbname=scsj',
    'name'      => 'scsj_proxy_root',
    'password'  => 'eccbd73df5ff4848aab5fd29069f5530',
);

$_DB =new DB($dbset);

try{
    $pay_sn=$_GET['orders_no'];
    $goodsId=$_GET['goodsId'];
    $price= $_GET['price'];
    $result=$_DB->getValue("select order_state from shop_order where pay_sn=$pay_sn");
    if ($result==20){
        echo json_encode(['succ'=>1]);
        exit;
    }
    echo json_encode(['succ'=>0]);

}catch(Exception $e){
    echo "Failed: " . $e->getMessage();
}