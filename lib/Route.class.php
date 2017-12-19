<?php

class Route
{
    private $action;
    private $method;
    private $params = [];

    public function __construct()
    {
        $this->parseURL();
    }

    public function __get($name)
    {
        return $name;
    }

    //URL解析
    public function parseURL()
    {
        $str1 = $_SERVER['PHP_SELF'];
        $str2 = $_SERVER['SCRIPT_NAME'];
        $len = strlen($str2);
        $des = substr($str1, $len + 1, strlen($str1));
        $config = require("./config.php");
        if ($suffix = $config['HTML_URL_SUFFIX'])
            $des = substr($des, 0, strlen($des) - strlen($suffix));
        //分别取出action,method,id,1
        $arr = explode("/", $des);
        $this->action = array_shift($arr);
        $this->method = array_shift($arr);
        $this->params = [];  //参数数组params[参数名称]=参数值
        for ($i = 0; $i < count($arr); $i = $i + 2) {
            $this->params[$arr[$i]] = $arr[$i + 1];
        }
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }
}