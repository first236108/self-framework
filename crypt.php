<?php
header('content-type:text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*');
define('BASEDIR', dirname(__FILE__));
include_once(BASEDIR."/lib/Ssl.class.php");

try {
    $uid=0;
    $goodsId=0;
    $crypt_str='';
    $data=[
        ['succ'=>0,'msg'=>'参数错误'],
        ['succ'=>1,'msg'=>'加密完成','crpty_str'=>&$crypt_str],
        ['succ'=>1,'msg'=>'解密完成','rid'=>&$rid,'uid'=>&$uid,'goodsId'=>&$goodsId]
    ];
    date_default_timezone_set('PRC');
    $file  = BASEDIR."/log/crypt_log.txt";
    $content=json_encode($_POST).date('Y:m:d h:i:s',time()).PHP_EOL;
    file_put_contents($file, $content,FILE_APPEND);

    if (!isset($_POST['type'])){
        echo json_encode($data[0]);exit;
    }

    switch ($_POST['type']){
        case 'encrypt':

            if (isset($_POST['rid']) && isset($_POST['uid']) && isset($_POST['goodsId'])){
                $ssl = new Ssl();
                $crypt_str=$ssl->encrypt($_POST['rid'].','.$_POST['uid'].','.$_POST['goodsId']);
                echo json_encode($data[1]);
            }else{
                echo json_encode($data[0]);exit;
            }
            break;

        case 'decrypt':

            if (isset($_POST['str'])){
                $ssl = new Ssl();
                $result=$ssl->decrypt($_POST['str']);
                $result=explode(',',$result);
                $rid=$result[0];
                $uid=$result[1];
                $goodsId=$result[2];
                echo json_encode($data[2]);
            }else{
                echo json_encode($data[0]);exit;
            }
            break;
        default:
            echo '非法请求';exit;
    }


}catch(Exception $e){
    echo "Failed: " . $e->getMessage();
}
