<?php
include_once(BASEDIR."/lib/transmit.php");
class MyAction{
    public function get_default_address()
    {
        if (IS_POST) {
            $url = "scsj/rest/appuser/address/getMyDefaultAddress.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }

    public function edit_address()
    {
        if (IS_POST) {
            $url = "scsj/rest/appuser/address/editAddress.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }

    public function add_address()
    {
        if (IS_POST) {
            $url = "scsj/rest/appuser/address/addAddress.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }

    public function phone_register()
    {
        if (IS_POST) {
            $url = "scsj/rest/appuser/phoneRegister.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }

    public function order_pay()
    {
        $url = "scsj/rest/order/pay.shtml";
        $transtor=new Transmit();
        $transtor->comm_curl($url,$_POST);
    }
}