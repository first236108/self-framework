<?php
include_once(BASEDIR."/lib/transmit.php");
class LoginAction{
    public function get_code()
    {
        if (IS_POST){
            $url="scsj/rest/appuser/getCode.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST);
        }
    }
}