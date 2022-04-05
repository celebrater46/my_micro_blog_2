<?php

namespace my_micro_blog\classes;

class State
{
    public $mmb_category;
    public $mmb_month;

    function __construct(){
        $this->mmb_category = isset($_GET["mmb_category"]) ? (int)$_GET["mmb_category"] : -1;
        $this->mmb_month = isset($_GET["mmb_month"]) ? (int)$_GET["mmb_month"] : -1;
    }

    // $array = ["hoge" => 1, "fuga" => 2 ... ]
    function get_new_url_parameters($array, $additional){
        $parameters = [
            "mmb_category" => $this->mmb_category,
            "mmb_month" => $this->mmb_month
        ];
        foreach ($array as $key => $num){
            $parameters[$key] = $num;
        }
        return "mmb_category=" . $parameters["mmb_category"]. "&mmb_month=" . $parameters["mmb_month"]. $additional;
    }

    function get_url_parameters($additional){
        return "mmb_category=" . $this->mmb_category . "&mmb_month=" . $this->mmb_month . $additional;
    }
}