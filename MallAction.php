<?php
include_once(BASEDIR."/lib/transmit.php");
class MallAction{
    public function get_goods_detail()
    {
        if (IS_POST) {
            $url = "scsj/rest/goods/getGoodsDetail.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST,0,1);
        }
    }

    public function generate_order()
    {
        if (IS_POST) {
            $url = "scsj/rest/order/generateOrder.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST);
        }
    }

    public function get_shop_goods_evaluate_page()
    {
        if (IS_POST) {
            $url = "scsj/rest/goods/getShopGoodsEvaluatePage.shtml";
            $transtor=new Transmit();
            $transtor->comm_curl($url,$_POST);
        }
    }
}