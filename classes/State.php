<?php

namespace my_micro_blog\classes;

class State
{
    public $mmb_category;
    public $mmb_month;
    public $mmb_day;

    function __construct(){
        $this->mmb_category = isset($_GET["mmb_category"]) ? (int)$_GET["mmb_category"] : null;
        $this->mmb_month = isset($_GET["mmb_month"]) ? (int)$_GET["mmb_month"] : null;
        $this->mmb_day = isset($_GET["mmb_day"]) ? (int)$_GET["mmb_day"] : null;
    }

    // $array = ["hoge" => 1, "fuga" => 2 ... ]
    function get_new_url_parameters($array, $additional){
        $parameters = [
            "mmb_category" => $this->mmb_category,
            "mmb_month" => $this->mmb_month,
            "mmb_day" => $this->mmb_day
        ];
        foreach ($array as $key => $num){
            $parameters[$key] = $num;
        }
        $category = $parameters["mmb_category"] === null ? "" : "mmb_category=" . $parameters["mmb_category"];
        $month = $parameters["mmb_month"] === null ? "" : "&mmb_month=" . $parameters["mmb_month"];
        $day = $parameters["mmb_day"] === null ? "" : "&mmb_day=" . $parameters["mmb_day"];
        return $category . $month . $day . $additional;
//        return "mmb_category=" . $parameters["mmb_category"]. "&mmb_month=" . $parameters["mmb_month"]. $additional;
    }

    function get_url_parameters($additional){
        $category = $this->mmb_category === null ? "" : "mmb_category=" . $this->mmb_category;
        $month = $this->mmb_month === null ? "" : "&mmb_month=" . $this->mmb_month;
        $day = $this->mmb_day === null ? "" : "&mmb_day=" . $this->mmb_day;
        return $category . $month . $day . $additional;
    }
}