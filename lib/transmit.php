<?php
class Transmit{
    private $base_url;
    private $key;
    private $plat;
    private $v;

    public function __construct() {
        $config = require("./config.php");
        $this->base_url = $config['BASE_URL'];
        $this->key = 'shangchaoshijie';
        $this->plat = 'H5';
        $this->v = '1.0';
    }

    public function comm_curl($url,$arr,$echo=0,$tk=0)
    {
        $url=$this->base_url.$url;
        $data['key'] = $this->key;
        $data['timestamp'] = $this->getMillisecond();
        $data['plat'] = $this->plat;
        $data['v'] = $this->v;
        if ($tk){
            $temp=$arr['tk'];
            unset($arr['tk']);
        }
        $data['data'] = json_encode($arr);
        $str = $this->key . "timestamp" . $data['timestamp'] . "plat" . $this->plat . "v" . $this->v . "data" . $data['data'] . $this->key;
        $data['sign'] = md5($str);
        if ($tk){
            $data['tk']=$temp;
        }
        return $this->http_post($url, http_build_query($data),$echo);
    }

    public function http_post($url,$post_data,$echo){
        $curl = curl_init();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_POST, 1 );
        curl_setopt($curl,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);
        if ($echo){
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        }
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            $info=curl_getinfo($curl);
            date_default_timezone_set('PRC');
            $file  = "./log/curl_log.txt";
            file_put_contents($file, json_encode($info).PHP_EOL,FILE_APPEND);
        }
        curl_close($curl);
        return $result;
    }

    public function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }
}