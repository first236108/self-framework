<?php
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
    date_default_timezone_set('PRC');
    $file  = BASEDIR."/log/paylog.txt";
    $content=$_GET['params'].date('Y:m:d h:i:s').PHP_EOL;
    file_put_contents($file, $content,FILE_APPEND);

    $param=json_decode(base64_decode($_GET['params']),true);
    $pay_sn=$param['orders_no'];
    $goodsId=$param['goodsId'];
    $price=isset($param['price']) ? $param['price'] :0;


    if (strlen($pay_sn)!=18){
        header("Location:http://t.scsj.net.cn/hot/product.html?goodsId=$goodsId");
    }

    for ($i=0;$i<3;$i++){
        $result=$_DB->getValue("select order_state from shop_order where pay_sn=$pay_sn");
        if ($result==20){
            header("Location: http://t.scsj.net.cn/hot/paySuccess.html");
            exit;
        }else{
            time_sleep_until(time()+1);
        }
    }

    header("Location: http://t.scsj.net.cn/hot/pay.html?flag=1&goodsId=$goodsId&paySn=$pay_sn&price=$price");
    exit;

    //header("Location:http://t.scsj.net.cn/hot/product.html?goodsId=$goodsId");

}catch(Exception $e){
    echo "Failed: " . $e->getMessage();
}