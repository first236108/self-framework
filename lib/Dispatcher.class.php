<?php

class Dispatcher{
            private $route = NULL;
            private $action;
            private $method;
            private $params = array();
            public function __construct($route){
                $this->route = $route;
                $this->action = $route->getAction();
                $this->method = $route->getMethod();
                $this->params = $route->getParams();
            }
            public function dispatch(){
                //加载action类,method方法
                if(empty($this->action))
                    $this->action="Index";
                if(empty($this->method))
                    $this->method = "index";
                if(!file_exists($this->action."Action.php"))
                    echo "{$this->action}Action not found!";
                else{
                    require($this->action."Action.php");
                    $className = $this->action."Action";
                    $action = new $className();
                    $method = $this->method;
                    if(!method_exists($action,$this->method))
                        echo "{$method}() not found";
                    else
                    $action->$method($this->params);
                 }
             }
        }