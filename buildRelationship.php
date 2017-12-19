<?php
header('content-type:text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*');
define('BASEDIR', dirname(__FILE__));
include_once(BASEDIR."/lib/DB.class.php");
include_once(BASEDIR."/lib/function.php");

try{
    $data=[
        ['succ'=>0,'msg'=>'参数错误'],
        ['succ'=>1,'msg'=>'自已分享给自己'],
        ['succ'=>2,'msg'=>'10级内不允许循环分享','rid'=>0],
        ['succ'=>3,'msg'=>'已存在分享关系','rid'=>&$already],
        ['succ'=>3,'msg'=>'已创建分享关系','rid'=>&$result],
        ['succ'=>4,'msg'=>'无润分享'],
        ['succ'=>5,'msg'=>'验证失败']
    ];
    date_default_timezone_set('PRC');
    $file  = BASEDIR."/log/log.txt";
    $content=json_encode($_POST).date('Y:m:d h:i:s',time()).PHP_EOL;
    file_put_contents($file, $content,FILE_APPEND);
    /**判断 uid goods_id必传参数**/
    if (!isset($_POST['tk']) || !isset($_POST['rid']) || !isset($_POST['pid']) || !isset($_POST['uid']) || !isset($_POST['goodsId'])){
        echo json_encode($data[0]);exit;
    }else{
        $tk=$_POST['tk'];
        $rid=$_POST['rid'];
        $uid=$_POST['uid'];
        $pid=$_POST['pid'];
        $goods_id=$_POST['goodsId'];
    }

    /**判断URL不包含上级**/
    if ($pid==0) {
        echo json_encode($data[5]);exit;
    }

    /**判断自已分享自己**/
    if ($pid==$uid){
        echo json_encode($data[1]);exit;
    }

    /**验证登陆tk**/
    $redis = new Redis();
    $redis->connect('118.190.113.210', 7480,1000);
    $redis->auth('JAI&D*^}>BS.m%9d');
    $redis->select(0);
    if ($tk != substr($redis->get("htk#".$uid),7)){
        echo json_encode($data[6]);exit;
    };

    /**实例化数据库tk**/
    $dbset = array(
        'dsn'       => 'mysql:host=rdsproxy56.rdsprwt7mveezzq.rds.bj.baidubce.com;dbname=scsj',
        'name'      => 'scsj_proxy_root',
        'password'  => 'eccbd73df5ff4848aab5fd29069f5530',
    );

    $_DB =new DB($dbset);

    if ($pid!=0){
        /**检查是否存在分享关系**/
        $flag = $_DB->getRow("select * from shop_share_relation where pid=$pid and uid=$uid and goods_id=$goods_id");
        if ($flag){
            $already=$flag['id'];
            echo json_encode($data[3]);exit;
        }else{
            /**检查10级内不允许循环分享**/
            $chk=$_DB->getValue("select checkCircle($pid,$uid,$goods_id,10);");
            if (!$chk){
                echo json_encode($data[2]);exit;
            }
        }
    }

    /**写入数据库，建立分享关系**/
    $result=$_DB->add('shop_share_relation',['rid'=>$rid,'pid'=>$pid,'uid'=>$uid,'goods_id'=>$goods_id]);
    echo json_encode($data[4]);

}catch(Exception $e){
    echo "Failed: " . $e->getMessage();
}