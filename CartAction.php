<?php
include_once(BASEDIR."/lib/transmit.php");
class CartAction{
    public function my_cart_list()
    {
        if (IS_POST) {
            $url="scsj/rest/cart/myCartList.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }

    public function add_to_cart()
    {
        if (IS_POST) {
            $url="scsj/rest/cart/addToCart.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }
}